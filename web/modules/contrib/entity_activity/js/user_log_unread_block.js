/**
 * @file
 * Attaches entity activity behaviors to the user log block.
 */

(function ($, Drupal, drupalSettings) {

  "use strict";

  Drupal.behaviors.user_log_unread_block = {
    attach: function (context, settings) {

      // Open the last unread logs.
      var user_log_block_counter = $('.js-user-log-block-counter');
      user_log_block_counter.each(function () {
        $(this).once('show-logs').on('click', function (e) {
          e.stopPropagation();
          var logs_content = $(this).next('.js-logs__content');
          if (logs_content.length) {
            logs_content.slideToggle(500).toggleClass('open');
          }
        });
      });

      $('.js-logs__content').on('click', function (e) {
        e.stopPropagation();
      });

      $('body').on('click', function () {
        $('.js-logs__content.open').slideToggle(500).toggleClass('open');
      });

    }
  };

})(jQuery, Drupal, drupalSettings);
