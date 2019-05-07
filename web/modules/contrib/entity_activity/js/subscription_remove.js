/**
 * @file
 * Attaches entity activity behaviors to the subscribe_on extra field.
 */

(function ($, Drupal) {

  "use strict";

  Drupal.theme.responseMessage = function (message, status) {
    return '<div class="message message--' + status + '">' + message + '</div>';
  };

  Drupal.behaviors.subscription_remove = {
    attach: function (context) {
      var button = $('.subscription .js-subscription-remove', context);
      button.once('remove-action').on('click', function () {
        var data = {
          entity_id: $(this).data('entity-id') || null,
          element_id: $(this).parents('.js-subscription').attr('id') || null
        };
        $.ajax('/ea/api/subscription/remove', {
          'method': 'POST',
          'data': JSON.stringify(data),
          'dataType' : 'json',
          'contentType': 'application/json; charset=utf-8',
        }).done(Drupal.behaviors.subscription_remove.removeDone);
      });

    }
  };

  Drupal.behaviors.subscription_remove.removeDone = function (data) {
    if (data.response.success === true) {
      var element = $('#' + data.response.data.element_id);
      if (element.length && data.response.result.action === 'removal-done') {
        element.fadeOut(1000, function () {
          $(this).remove();
        })
      }
      else if (element.length && data.response.result.action === 'removal-cancelled') {
        $(Drupal.theme.responseMessage(data.status.message, 'warning')).appendTo(element).fadeOut(5000);
      }
      else {
        $(Drupal.theme.responseMessage('An error occurred.', 'error')).appendTo(element).fadeOut(5000);
      }
    }
  };

})(jQuery, Drupal);
