$(document).ready(function () {
  // confirm delete
  $(document.body).on('submit', '.js-confirm', function () {
    var $el = $(this)
    var text = $el.data('confirm') ? $el.data('confirm') : 'Are you sure you want to delete this item?'
    var c = confirm(text);
    return c;
  });

  // add selectize to select element
  $('.js-selectize').selectize({
    sortField: 'text'
  });

});
