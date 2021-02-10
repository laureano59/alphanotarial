$("#liberaradicacion").click(function(){
  $("#guyeditarcliente").fadeOut();
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

$("#editarclientes").click(function(){
  $("#guyliberaradicacion").fadeOut();
  $("#guyeditarcliente").fadeIn();
  $("#identificacion_cli").val('');
});


$("#editarclientebtn").click(function(){
  var identificacion_cli = $("#identificacion_cli").val();
  location.href='/clientes/' + identificacion_cli + '/edit';
});
