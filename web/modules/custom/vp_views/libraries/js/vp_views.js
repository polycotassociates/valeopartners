(function ($, Drupal) {

  // Add the print-only class to the content block.
  Drupal.behaviors.addPrintClassToContent = {
    attach: function (context, settings) {
      // Add class to specific div.
      $( 'div#block-valeo-classic-content').addClass('print-only');
    }
  };

})(jQuery, Drupal);

