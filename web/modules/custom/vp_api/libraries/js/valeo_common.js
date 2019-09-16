(function ($, Drupal) {

  $( "#xlsModal" ).hide();

  Drupal.behaviors.vpXLSPopup = {
    attach: function (context, settings) {

      // On click, reveal the modal.
      $( '#export-xls-link', context).once('vpXLSPopup').click(function (e) {
         var link = $(this).find("a[href]").attr('href');
         e.preventDefault();
        // Open the xlsModal set in the Export Header.
        $( "#xlsModal" ).dialog({
          modal: false,
          show: { duration: 800 },
          position: { my: "top", at: "top"},
          buttons: {
            "I accept": function() {
              window.location = link;
              $( this ).dialog( "close" );
          },
          }
        });

      });

    }
  };


  // Invoke the print dialog
  Drupal.behaviors.printThisPage = {
    attach: function (context, settings) {

      // On click, reveal the modal.
      $( '#print-this-page', context).once('printThisPage').click(function (e) {
        e.preventDefault();
        window.print();
     });

    }
  };

  // Invoke the print dialog
  Drupal.behaviors.addPrintClassToContent = {
    attach: function (context, settings) {
      // Add class to specific div.
      $( 'div#block-valeo-classic-content').addClass('print-only');
    }
  };


})(jQuery, Drupal);