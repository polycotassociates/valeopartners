(function ($, Drupal) {

  $( "#xlsModal" ).hide();

  Drupal.behaviors.vpXLSPopup = {
    attach: function (context, settings) {

      // On click, reveal the modal.
      $( '#export-xls-link', context).once('vpXLSPopup').click(function (e) {
        // e.preventDefault();
        // Open the xlsModal set in the Export Header.
        $( "#xlsModal" ).dialog({
          modal: false,
          show: { duration: 800 },
          position: { my: "top", at: "top"}
        });

      });

    }
  };

})(jQuery, Drupal);