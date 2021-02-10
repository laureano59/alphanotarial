/*************CALENDARIO*************/

jQuery(function($) {
  $('#id-disable-check').on('click', function() {
    var inp = $('#form-input-readonly').get(0);
    if (inp.hasAttribute('disabled')) {
      inp.setAttribute('readonly', 'true');
      inp.removeAttribute('disabled');
      inp.value = "This text field is readonly!";
    } else {
      inp.setAttribute('disabled', 'disabled');
      inp.removeAttribute('readonly');
      inp.value = "This text field is disabled!";
    }
  });

  $('#spinner1').ace_spinner({
      value: 0,
      min: 0,
      max: 200,
      step: 10,
      btn_up_class: 'btn-info',
      btn_down_class: 'btn-info'
    })

  //or change it into a date range picker
  $('.input-daterange').datepicker({
    autoclose: true
  });
});
