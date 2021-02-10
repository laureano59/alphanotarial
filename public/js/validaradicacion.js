/***********NOTE:Valida que la radicacion esté completa*************/
$("#validarradicacion").click(function(){
  if($("#radicacion").val() === undefined){
    location.href="/liquidacion";
  }else{
    var id_radica = $("#radicacion").val();
    var datos = {
        "id_radica": id_radica
    };
    var route = "/validarradicacion";
    var token = $("#token").val();
    var type = 'GET';
    __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 0){
        $("#msjrad1").html(info.mensaje);
        $("#msj-errorrad1").fadeIn();
        setTimeout(function() {
            $("#msj-errorrad1").fadeOut();
        }, 3000);
      }else if(info.validar == 1){
        $("#msjrad1").html(info.mensaje);
        $("#msj-errorrad1").fadeIn();
        setTimeout(function() {
            $("#msj-errorrad1").fadeOut();
        }, 4000);
      }else if(info.validar == 2){
        location.href="/liquidacion";
      }
    })
  }
});

/*********NOTE:Valida que la radicacion esté completa y liquidada********/
$("#validarfacturacion").click(function(){
  if($("#radicacion").val() === undefined){
    location.href="/tipofactura";
  }else{
    var id_radica = $("#radicacion").val();
    var datos = {
        "id_radica": id_radica
    };
    var route = "/validarfacturacion";
    var token = $("#token").val();
    var type = 'GET';
    __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 0){
        $("#msjrad1").html(info.mensaje);
        $("#msj-errorrad1").fadeIn();
        setTimeout(function() {
            $("#msj-errorrad1").fadeOut();
        }, 3000);
      }else if(info.validar == 1){
        $("#msjrad1").html(info.mensaje);
        $("#msj-errorrad1").fadeIn();
        setTimeout(function() {
            $("#msj-errorrad1").fadeOut();
        }, 4000);
      }else if(info.validar == 2){ //NOTE:Cuando la radicación no se ha liquidado
        $("#msjrad1").html(info.mensaje);
        $("#msj-errorrad1").fadeIn();
        setTimeout(function() {
            $("#msj-errorrad1").fadeOut();
        }, 4000);
      }else if(info.validar == 3){
        location.href="/tipofactura";
      }
    })
  }
});

/*********NOTE:Valida que la radicacion esté completa y liquidada********/
$("#buscar_fact").click(function(){
  if($("#radicacion").val() == ''){
    $("#msj").html("Por Favor escriba el número de radicación");
    $("#msj-error").fadeIn();
    setTimeout(function() {
        $("#msj-error").fadeOut();
    }, 3000);
  }else{
    var id_radica = $("#radicacion").val();
    var datos = {
        "id_radica": id_radica
    };
    var route = "/validarfacturacion";
    var token = $("#token").val();
    var type = 'GET';
    __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 0){
        $("#msj").html(info.mensaje);
        $("#msj-error").fadeIn();
        setTimeout(function() {
            $("#msj-error").fadeOut();
        }, 3000);
      }else if(info.validar == 1){
        $("#msj").html(info.mensaje);
        $("#msj-error").fadeIn();
        setTimeout(function() {
            $("#msj-error").fadeOut();
        }, 4000);
      }else if(info.validar == 2){ //NOTE:Cuando la radicación no se ha liquidado
        $("#msj").html(info.mensaje);
        $("#msj-error").fadeIn();
        setTimeout(function() {
            $("#msj-error").fadeOut();
        }, 4000);
      }else if(info.validar == 3){
        //Activa los botones
      }
    })
  }
});

/*********NOTE:Valida que la radicacion esté completa y liquidada********/
$("#factunica").click(function(){
  if($("#radicacion").val() == ''){
    $("#msj").html("Por Favor escriba el número de radicación");
    $("#msj-error").fadeIn();
    setTimeout(function() {
        $("#msj-error").fadeOut();
    }, 3000);
  }else{
    var id_radica = $("#radicacion").val();
    var opcion = 1;
    TipoFactura(id_radica, opcion);
  }
});

/*********NOTE:Valida que la radicacion esté completa y liquidada********/
$("#factdoble").click(function(){
  if($("#radicacion").val() == ''){
    $("#msj").html("Por Favor escriba el número de radicación");
    $("#msj-error").fadeIn();
    setTimeout(function() {
        $("#msj-error").fadeOut();
    }, 3000);
  }else{
    var id_radica = $("#radicacion").val();
    var opcion = 2;
    TipoFactura(id_radica, opcion);
  }
});

/*********NOTE:Valida que la radicacion esté completa y liquidada********/
$("#factmultiple").click(function(){
  if($("#radicacion").val() == ''){
    $("#msj").html("Por Favor escriba el número de radicación");
    $("#msj-error").fadeIn();
    setTimeout(function() {
        $("#msj-error").fadeOut();
    }, 3000);
  }else{
    var id_radica = $("#radicacion").val();
    var opcion = 3;
    TipoFactura(id_radica, opcion);
  }
});

function TipoFactura(id_radica, opcion){
  var datos = {
      "id_radica": id_radica,
      "opcion": opcion
  };
  var route = "/validarfacturacion";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 0){
      $("#msj").html(info.mensaje);
      $("#msj-error").fadeIn();
      setTimeout(function() {
          $("#msj-error").fadeOut();
      }, 3000);
    }else if(info.validar == 1){
      $("#msj").html(info.mensaje);
      $("#msj-error").fadeIn();
      setTimeout(function() {
          $("#msj-error").fadeOut();
      }, 4000);
    }else if(info.validar == 2){ //NOTE:Cuando la radicación no se ha liquidado
      $("#msj").html(info.mensaje);
      $("#msj-error").fadeIn();
      setTimeout(function() {
          $("#msj-error").fadeOut();
      }, 4000);
    }else if(info.validar == 3){
        location.href="/facturacion";
    }
  })
}
