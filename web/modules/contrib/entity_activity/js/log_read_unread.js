/**
 * @file
 * Attaches entity activity behaviors to the log entity read base field.
 */

(function ($, Drupal, drupalSettings) {

  "use strict";

  Drupal.behaviors.log_read_unread = {
    attach: function (context, settings) {

      var read_text = drupalSettings.entity_activity.log_read_unread.read;
      var unread_text = drupalSettings.entity_activity.log_read_unread.unread;
      var read_unread_action = $('.js-log-read-unread', context);

      Drupal.theme.responseMessage = function (message, status) {
        return '<div class="message message--' + status + '">' + message + '</div>';
      };

      Drupal.behaviors.log_read_unread.globalCounter = function (operation) {
        var counter = $('.js-log-unread-counter');
        if (counter.length) {
          counter.each(function () {
            var count = parseInt($(this).html());
            if (operation === 'read') {
              count = count - 1;
              if (count < 0) {
                count = 0;
              }
              $(this).html(count);
            }
            else if (operation === 'unread') {
              count = count + 1;
              $(this).html(count);
            }
          });
        }
      };

      Drupal.behaviors.log_read_unread.readUnreadDone = function (data) {
        if (data.response.success === true) {
          var element = $('#' + data.response.data.element_id);
          var parent = element.parents('.js-log');
          if (element.length && data.response.result.action === 'mark-unread') {
            element.addClass('unread').removeClass('read').html(unread_text);
            parent.addClass('unread').removeClass('read');
            $(Drupal.theme.responseMessage(Drupal.t('Marked as @status', {'@status': unread_text}), 'status')).appendTo(parent).fadeOut(5000);
            Drupal.behaviors.log_read_unread.globalCounter('unread');
          }
          else if (element.length && data.response.result.action === 'mark-read') {
            element.addClass('read').removeClass('unread').html(read_text);
            parent.addClass('read').removeClass('unread');
            $(Drupal.theme.responseMessage(Drupal.t('Marked as @status', {'@status': read_text}), 'status')).appendTo(parent).fadeOut(5000);
            Drupal.behaviors.log_read_unread.globalCounter('read');
          }
          else {
            $(Drupal.theme.responseMessage('An error occurred.', 'error')).appendTo(element).fadeOut(5000);
          }
        }
      };

      read_unread_action.once('read-unread-action').on('click', function () {
        var data = {
          entity_id: $(this).data('entity-id') || null,
          element_id: $(this).attr('id')
        };
        $.ajax('/ea/api/log/read', {
          'method': 'POST',
          'data': JSON.stringify(data),
          'dataType' : 'json',
          'contentType': 'application/json; charset=utf-8',
        }).done(Drupal.behaviors.log_read_unread.readUnreadDone);
      });

    }
  };

})(jQuery, Drupal, drupalSettings);
