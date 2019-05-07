/**
 * @file
 * Attaches entity activity behaviors to the subscribe_on extra field.
 */

(function ($, Drupal) {

  "use strict";

  Drupal.subscribeOn = Drupal.subscribeOn || {};

  /**
   * Check if the current user have a subscription given an entity.
   */
  Drupal.subscribeOn.haveSubscription = function (subscribed_on) {
    subscribed_on.once('have-subscription').each(function (e) {
      var data = {
        entity_type: $(this).data('entity-type') || null,
        entity_id: $(this).data('entity-id') || null,
        langcode: $(this).data('langcode') || null,
        element_id: $(this).attr('id')
      };
      $.ajax('/ea/api/subscription', {
        'method': 'POST',
        'data': JSON.stringify(data),
        'dataType' : 'json',
        'contentType': 'application/json; charset=utf-8',
      }).done(Drupal.subscribeOn.subscribed);
    });
  };

  /**
   * Add relevant class on the subscribe_on component.
   *
   * If success is "true", user have already a subscription.
   *
   * @param {object} data
   *   The data retrieved from the haveSubscription endpoint.
   */
  Drupal.subscribeOn.subscribed = function (data) {
    if (data.response.success === true) {
      $('#' + data.response.data.element_id).addClass('subscribed');
    }
    else if (data.response.success === false) {
      $('#' + data.response.data.element_id).addClass('not-subscribed');
    }
  };

  /**
   * Add relevant class after a user has subscribed / un-subscribed on entity.
   *
   * If success is "true", the data.response.result.action have the action done
   * (subscribe-done or unsubscribe-done)
   *
   * @param {object} data
   *   The data retrieved from the addRemove endpoint.
   */
  Drupal.subscribeOn.isSubscribedOrNot = function (data) {
    if (data.response.success === true) {
      var element = $('#' + data.response.data.element_id);
      if (data.response.result.action === 'subscribe-done') {
        element.addClass('subscribed').removeClass('not-subscribed');
      }
      else if (data.response.result.action === 'unsubscribe-done') {
        element.addClass('not-subscribed').removeClass('subscribed');
      }
      else {
        element.addClass('error');
      }
    }
  };

  Drupal.behaviors.subscribe_on = {
    attach: function (context) {
      var subscribed_on = $('.js-subscribe-on', context);
      Drupal.subscribeOn.haveSubscription(subscribed_on);

      var subscribed_on_button = $('.js-subscribe-on button.action', context);
      subscribed_on_button.once('subscribe-action').on('click', function () {
        var data = {
          entity_type: $(this).parent('.js-subscribe-on').data('entity-type') || null,
          entity_id: $(this).parent('.js-subscribe-on').data('entity-id') || null,
          langcode: $(this).parent('.js-subscribe-on').data('langcode') || null,
          element_id: $(this).parent('.js-subscribe-on').attr('id')
        };
        $.ajax('/ea/api/subscription/add', {
          'method': 'POST',
          'data': JSON.stringify(data),
          'dataType' : 'json',
          'contentType': 'application/json; charset=utf-8',
        }).done(Drupal.subscribeOn.isSubscribedOrNot);
      });

    }
  };

})(jQuery, Drupal);
