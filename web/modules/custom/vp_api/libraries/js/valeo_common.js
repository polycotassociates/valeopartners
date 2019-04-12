(function ($, Drupal) {
alert("loaded");
    Drupal.behaviors.vpMaxDateBehavior = {
      attach: function (context, settings) {

        // Hide all the pressures.
        $( "div.obstacles").hide();

        // On click, reveal the related pressures.
        $('#edit-field-vp-filing-fee-dates-value-min', context).once('vpMaxDateBehavior').change(function (e) {
          e.preventDefault();
          alert("changed");
          $( "#edit-field-vp-filing-fee-dates-value-min").val('2020');


        });

      }
    };

  })(jQuery, Drupal);