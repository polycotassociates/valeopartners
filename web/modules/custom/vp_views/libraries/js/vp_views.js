(function ($, Drupal) {

  // Add the 'print-only' class to the content block.
  // Add 'print-no' class to areas to restrict.
  Drupal.behaviors.addPrintClassToContent = {
    attach: function (context, settings) {
      // Add class to specific div.
      $( 'div#block-valeo-classic-content').addClass('print-only');
      $( 'div.visually-hidden').addClass('print-no');
      $( 'div.view-filters').addClass('print-no');
    }
  };

})(jQuery, Drupal);

