/**
 * @file
 * Attaches entity activity behaviors to the entity form.
 */

(function ($) {

  "use strict";

  Drupal.behaviors.entity_activity_fieldset_summaries = {
    attach: function (context) {

      String.prototype.trimToLength = function(m) {
        return (this.length > m)
          ? jQuery.trim(this).substring(0, m).split(" ").slice(0, -1).join(" ") + " (...)"
          : this;
      };

      $(context).find('[id^=edit-generators-]').once('generator-summary').each(function () {
        $(this).drupalSetSummary(function(context) {
          var id = $(context).attr('id');
          var status_id = id + '-status';
          var published_id = id + '-published';
          var operation_id = id + '-operation';
          var subscribed_on_id = id + '-subscribed-on';
          var use_cron_id = id + '-use-cron';
          var log_value_id = id + '-log-value';
          var options = [];
          if ($('input#' + status_id).is(':checked')) {

            // The operation.
            var operation = $('#' + operation_id).val();
            options.push(Drupal.t('<i>Operation</i>: @operation', {'@operation' : operation}));

            // The published option.
            if ($('input#' + published_id).is(':checked')) {
              options.push(Drupal.t('<i>Entity published only</i>: Yes'));
            }
            else {
              options.push(Drupal.t('<i>Entity published only</i>: No'));
            }

            // The subscribed on option.
            var subscribed_on = $('#' + subscribed_on_id).val();
            options.push(Drupal.t('<i>Subscribed on</i>: @subscribed_on', {'@subscribed_on' : subscribed_on}));

            // The use cron option.
            if ($('input#' + use_cron_id).is(':checked')) {
              options.push(Drupal.t('<i>Use cron</i>: Yes'));
            }
            else {
              options.push(Drupal.t('<i>Use cron</i>: No'));
            }

            // The log message trimmed if more than 150 characters.
            var log_value = $('#' + log_value_id).val().trimToLength(150);
            options.push(Drupal.t('<i>Log message</i>: @log_value', {'@log_value' : log_value}));
          }

          if (options.length > 0) {
            return Drupal.t('<b>Enabled</b><br />') + options.join('<br />');
          }
          else {
            return Drupal.t('Disabled');
          }

        });

      });

    }
  };
})(jQuery);
