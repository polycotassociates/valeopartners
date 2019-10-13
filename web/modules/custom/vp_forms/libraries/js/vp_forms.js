(function ($, Drupal) {


  var myVar;

  function myFunction() {
    myVar = setTimeout(showPage, 3000);
  }
  
  function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("myDiv").style.display = "block";
  }

  //Overrides the default extractLastTerm found in core/misc/autocomplete.js
  Drupal.autocomplete.options.splitValues = [];

  // Allow a check all behavor for the Display Column checkbox selection
  // for the saved search type.
  //
  // See: https://stackoverflow.com/questions/9669005/jquery-toggle-select-all-checkboxes
  Drupal.behaviors.vpFormsCheckColumns = {
    attach: function (context, settings) {

      $('#edit-field-vp-search-display-columns-2705', context).click(function () {
        var checkedStatus = this.checked;
        $('#edit-field-vp-search-display-columns').find(':checkbox').each(function() {
          $(this).prop('checked', checkedStatus);
        });
      });

    }
  };

  // Copies values from Practice Area 1 to 2 and 3
  Drupal.behaviors.vpFormsCopyToPa2Pa3 = {
    attach: function (context, settings) {

      $(context).change( function () {

        var practice_areas = [];
          $( "#edit-field-vp-practice-area-1-target-id"  ).each(function() {
            practice_areas.push( $( this ).val());
          });

          $('#edit-field-vp-practice-area-2-target-id').val(practice_areas[0]).prop('selected', true);
          $('#edit-field-vp-practice-area-3-target-id').val(practice_areas[0]).prop('selected', true);

        });
    }
  };


  // Add the print-only class to the content block.
  Drupal.behaviors.addPrintClassToContent = {
    attach: function (context, settings) {
      // Add class to specific div.
      $( 'div#block-valeo-classic-content').addClass('print-only');
    }
  };


  // Resets the interface min/max dates to 4 digits intead of 2010-01-01
  Drupal.behaviors.vpMaxDateBehavior = {
    attach: function (context, settings) {

      // var params = getUrlParams();

      // console.log(params);

      // var grad_min = params['field_vp_graduation_value[min]'];
      // var grad_max = params['field_vp_graduation_value[max]'];
      // var grad_0 = params['field_vp_graduation_value[0]'];
      // var grad_1 = params['field_vp_graduation_value[1]'];
      // var bar_min = params['field_vp_bar_date_value[0]'];
      // var bar_max = params['field_vp_bar_date_value[1]'];
      // var fee_min = params['field_vp_filing_fee_dates_value[0]'];
      // var fee_max = params['field_vp_filing_fee_dates_value[1]'];
      // var fee_min = params['field_vp_filing_fee_dates_value[min]'];
      // var fee_max = params['field_vp_filing_fee_dates_value[max]'];


      // if (grad_min) {
      //   $( '#edit-field-vp-filing-fee-dates-value-min' ).val(grad_min);
      // }
      // if (grad_max) {
      //   $( '#edit-field-vp-filing-fee-dates-value-max' ).val(grad_max);
      // }
      // if (grad_0) {
      //   $( '#edit-field-vp-filing-fee-dates-value-min' ).val(grad_0);
      // }
      // if (grad_1) {
      //   $( '#edit-field-vp-filing-fee-dates-value-max' ).val(grad_1);
      // }


      // if (fee_min) {
      //   var fee_min_yr = fee_min.slice(0,4);
      //   $( '#edit-field-vp-filing-fee-dates-value-min' ).val(fee_min_yr);
      // }
      // if (fee_max) {
      //   var fee_max_yr = fee_max.slice(0,4);
      //   $( '#edit-field-vp-filing-fee-dates-value-max' ).val(fee_max_yr);
      // }

      // if (fee_min) {
      //   min_year = min_year.slice(0, 4);
      //   $( '#edit-field-vp-filing-fee-dates-value-min' ).val( min_year );
      // }

      // if (fee_max) {
      //   max_year = min_year.slice(0, 4);
      //   $( '#edit-field-vp-filing-fee-dates-value-max' ).val( max_year );
      // }

    }
  };

})(jQuery, Drupal);


/**
 * JavaScript Get URL Parameter
 *
 * From: https://www.kevinleary.net/javascript-get-url-parameters/
 *
 * @param String prop The specific URL parameter you want to retreive the value for
 * @return String|Object If prop is provided a string value is returned, otherwise an object of all properties is returned
 */
function getUrlParams( prop ) {
  var params = {};
  var search = decodeURIComponent( window.location.href.slice( window.location.href.indexOf( '?' ) + 1 ) );
  var definitions = search.split( '&' );

  definitions.forEach( function( val, key ) {
      var parts = val.split( '=', 2 );
      params[ parts[ 0 ] ] = parts[ 1 ];
  } );

  return ( prop && prop in params ) ? params[ prop ] : params;
}