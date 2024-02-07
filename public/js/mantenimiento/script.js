$("#liberaradicacion").click(function(){
  $("#guyeditarcliente").fadeOut();
  $("#guyeditaracargode").fadeOut();
  $("#guyliberaradicacion").fadeIn();
  $("#radicacion").val('');
});

$("#liberarad").click(function(){
  var id_radica = $("#radicacion").val();
  var datos = {"id_radica": id_radica};
  var route = "/liberarradicacion";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == '0'){
      $("#msj1").html(info.mensaje);
      $("#msj-error1").fadeIn();
      setTimeout(function(){ $("#msj-error1").fadeOut(); }, 3000);
    }else if(info.validar == '1'){
      $("#msj1").html(info.mensaje);
      $("#msj-error1").fadeIn();
      setTimeout(function(){ $("#msj-error1").fadeOut(); }, 3000);
    }else if(info.validar == '7'){
      $("#msj2").html(info.mensaje);
      $("#msj-error2").fadeIn();
      setTimeout(function(){ $("#msj-error2").fadeOut(); }, 3000);
    }

  })
});


$("#editaracargode").click(function(){
  var prefijo = $("#prefijo").val();
  var num_fact = $("#num_fact").val();
  var datos = {
    "prefijo": prefijo,
    "num_fact": num_fact
  };

  var route = "/editar_acargo_de_factura";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == '1'){
      $("#msj7").html(info.mensaje);
      $("#msj-error7").fadeIn();
      setTimeout(function(){ $("#msj-error7").fadeOut(); }, 3000);
    }else if(info.validar == '7'){
      location.href='/factura_acargo_de';
    }else if(info.validar == '8'){
      $("#msj7").html(info.mensaje);
      $("#msj-error7").fadeIn();
    }
  })
});


$("#editarclientes").click(function(){
  $("#guyliberaradicacion").fadeOut();
  $("#guyeditaracargode").fadeOut();
  $("#guyeditarcliente").fadeIn();
  $("#identificacion_cli").val('');
});

$("#editar_a_cargo_de").click(function(){
  $("#guyliberaradicacion").fadeOut();
  $("#guyeditarcliente").fadeOut();
  $("#guyeditaracargode").fadeIn();

  $("#prefijo").val('');
  $("#num_fact").val('');
});


$("#editarclientebtn").click(function(){
  var identificacion_cli = $("#identificacion_cli").val();
  location.href='/clientes/' + identificacion_cli + '/edit';
});



$("#actualizar_fact").click(function(){
  var identificacion = $("#identificacion").val();
  var detalle = $("#detalle").val();

   var datos = {
    "identificacion": identificacion,
    "detalle": detalle
  };

  var route = "/editar_acargo_de";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == '1'){
      $("#msj1").html(info.mensaje);
      $("#msj-error1").fadeIn();
      setTimeout(function(){ $("#msj-error1").fadeOut(); }, 6000);
      location.href='/factura_acargo_de';
    }
  })
});
