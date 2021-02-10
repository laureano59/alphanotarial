$("#GuardarCambiosFecha").click(function(){
  var fecha_facturacion, fecha_numeracion, switch1, switch2, id, opcion;
  opcion = 1;
  id = 1;
  fecha_facturacion = $("#fecha_facturacion").val();
  fecha_numeracion = $("#fecha_numeracion").val();
  switch1 = $("#switch1").is(":checked");
  switch2 = $("#switch2").is(":checked");

  var route = "/notaria/" + id;
  var token = $("#token").val();
  var type = 'PUT';
  var datos = {
      "id": id,
      "fecha_fact": fecha_facturacion,
      "fecha_esc": fecha_numeracion,
      "fecha_fact_automatica": switch1,
      "fecha_esc_automatica": switch2,
      "opcion": opcion
  };

  __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
          $("#msj").html(info.mensaje);
          $("#msj-error").fadeIn();
          setTimeout(function() {
          $("#msj-error").fadeOut();
          }, 3000);
        }
      })
});

$("#GuardarCambiosFecha_Actas").click(function(){
  var fecha_acta, fecha_egreso, switch3, switch4, id, opcion;
  opcion = 2;
  id = 1;
  fecha_acta = $("#fecha_acta").val();
  fecha_egreso = $("#fecha_egreso").val();
  switch3 = $("#switch3").is(":checked");
  switch4 = $("#switch4").is(":checked");

  var route = "/notaria/" + id;
  var token = $("#token").val();
  var type = 'PUT';
  var datos = {
      "id": id,
      "fecha_acta": fecha_acta,
      "fecha_egreso": fecha_egreso,
      "fecha_acta_automatica": switch3,
      "fecha_egreso_automatica": switch4,
      "opcion": opcion
  };

  __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
          $("#msj1").html(info.mensaje);
          $("#msj-error1").fadeIn();
          setTimeout(function() {
          $("#msj-error1").fadeOut();
          }, 3000);
        }
      })
});


/*************CALENDARIO*************/
//datepicker plugin
//link
$('.date-picker1').datepicker({
  autoclose: true,
  todayHighlight: true
})
//show datepicker when clicking on the icon
.next().on(ace.click_event, function(){
  $(this).prev().focus();
});

$('.date-picker2').datepicker({
  autoclose: true,
  todayHighlight: true
})
//show datepicker when clicking on the icon
.next().on(ace.click_event, function(){
  $(this).prev().focus();
});
