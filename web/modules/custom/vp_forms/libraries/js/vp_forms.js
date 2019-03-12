(function ($, Drupal) {

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

})(jQuery, Drupal);