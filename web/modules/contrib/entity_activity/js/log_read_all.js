/**
 * @file
 * Attaches entity activity behaviors to the log entity read base field.
 */

(function ($, Drupal, drupalSettings) {

  "use strict";

  Drupal.behaviors.log_read_all = {
    attach: function (context, settings) {

      var read_text = drupalSettings.entity_activity.log_read_unread.read || Drupal.t('Read');
      var unread_text = drupalSettings.entity_activity.log_read_unread.unread || Drupal.t('Unread');
      var read_all_action = $('.js-log-read-all', context);

      Drupal.theme.responseMessage = function (message, status) {
        return '<div class="message message--' + status + '">' + message + '</div>';
      };

      Drupal.behaviors.log_read_all.updateGlobalCounter = function (count) {
        var counter = $('.js-log-unread-counter');
        count = parseInt(count);
        if (counter.length) {
          counter.each(function () {
            var total_unread = parseInt($(this).html());
            total_unread = total_unread - count;
            if (total_unread < 0) {
              total_unread = 0;
            }
            $(this).html(total_unread);
          });
        }
      };

      Drupal.behaviors.log_read_all.readAllDone = function (data) {
        var element = $('#' + data.response.data.element_id);

        // If max_log_used then all logs have not been marked, so we relaunch the
        // ajax request to mark as read remaining logs. In this request we have
        // the initial total of logs to be marked.
        if (data.response.success === true && data.response.result.max_log_used === true) {
          var original_data = {
            entity_id: data.response.data.entity_id,
            element_id: data.response.data.element_id,
            count: data.response.result.count,
            total: data.response.data.total
          };
          var progress_message = $('.ajax-progress .message');
          if (progress_message.length) {
            progress_message.html(Drupal.t('Processing @count / @total logs as @read. Please wait...', {'@read': read_text, '@count': data.response.result.count, '@total': data.response.data.total}));
          }
          $.ajax('/ea/api/log/readall', {
            'method': 'POST',
            'data': JSON.stringify(original_data),
            'dataType' : 'json',
            'contentType': 'application/json; charset=utf-8'
          }).done(Drupal.behaviors.log_read_all.readAllDone);
        }

        else if (data.response.success === true && data.response.result.action === 'mark-all-read') {
          $('.ajax-progress').remove();
          element.prop('disabled', false);

          Drupal.behaviors.log_read_all.updateGlobalCounter(data.response.result.count);
          $(Drupal.theme.responseMessage(Drupal.t('@count logs marked as @read.', {'@count': data.response.result.count, '@read': read_text}), 'status')).insertAfter(element).fadeOut(10000);

          $('.js-log-read-unread').each(function () {
            $(this).addClass('read').removeClass('unread').html(read_text);
          });
          $('.js-log').each(function () {
            $(this).addClass('read').removeClass('unread');
          });

        }
        else {
          $(Drupal.theme.responseMessage('An error occurred.', 'error')).appendTo(element).fadeOut(5000);
        }
      };

      read_all_action.once('read-all-action').on('click', function () {
        var data = {
          entity_id: $(this).data('entity-id') || null,
          element_id: $(this).attr('id')
        };
        var $this = $(this);
        $.ajax('/ea/api/log/readall', {
          'method': 'POST',
          'data': JSON.stringify(data),
          'dataType' : 'json',
          'contentType': 'application/json; charset=utf-8',
          'beforeSend': function () {
            $this.after(Drupal.theme.ajaxProgressThrobber(Drupal.t('Processing logs as @read. Please wait...', {'@read': read_text})));
            $this.prop('disabled', true);
          },
          'complete': function () {}
        }).done(Drupal.behaviors.log_read_all.readAllDone);
      });

    }
  };

})(jQuery, Drupal, drupalSettings);
