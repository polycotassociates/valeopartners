/**
 * @file
 * Attaches entity activity behaviors to the subscribe_on extra field.
 */

(function ($, Drupal) {

  "use strict";

  Drupal.theme.responseMessage = function (message, status) {
    return '<div class="message message--' + status + '">' + message + '</div>';
  };

  Drupal.behaviors.log_remove = {
    attach: function (context) {
      var button = $('.js-log .js-log-remove', context);
      button.once('remove-log-action').on('click', function () {
        var data = {
          entity_id: $(this).data('entity-id') || null,
          element_id: $(this).parents('.js-log').attr('id') || null
        };
        $.ajax('/ea/api/log/remove', {
          'method': 'POST',
          'data': JSON.stringify(data),
          'dataType' : 'json',
          'contentType': 'application/json; charset=utf-8',
        }).done(Drupal.behaviors.log_remove.removeDone);
      });

    }
  };

  Drupal.behaviors.log_remove.globalCounter = function () {
    var counter = $('.js-log-unread-counter');
    if (counter.length) {
      counter.each(function () {
        var count = parseInt($(this).html());
        count = count - 1;
        if (count < 0) {
          count = 0;
        }
        $(this).html(count);
      });
    }
  };

  Drupal.behaviors.log_remove.removeDone = function (data) {
    if (data.response.success === true) {
      var element = $('#' + data.response.data.element_id);
      if (element.length && data.response.result.action === 'removal-done') {
        element.fadeOut(1000, function () {
          $(this).remove();
        });
        // The log was unread. Update global counter if exists.
        if (data.response.result.unread === true) {
          Drupal.behaviors.log_remove.globalCounter();
        }
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
