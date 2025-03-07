$("#buscaractosradica").click(function() {
  $("#clientesprincipales").hide();
  $("#adicionales").hide();
  $('#veradicionales').hide();

    var id_radica = $("#radicacion").val();
    var periodo = $("#periodo").val();
    var datos = {
        "id_radica": id_radica,
        "periodo": periodo
    };
    var route = "/detalleradica";
    var token = $("#token").val();
    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'GET',
        dataType: 'json',
        data: datos,

        success: function(info) {
            if (info.validar == '1') {
              $("#ok").html('<i class="ace-icon fa fa-check green"></i>');
                var protocolista = info.protocolista;
                $("#id_proto").val(protocolista);
                var validar = info.actos;
                CargarActosCli(validar);
            } else if (info.validar == '0') {
              $("#ok").html('');
                $("#msj2").html(info.mensaje);
                $("#msj-error2").fadeIn();
                setTimeout(function() {
                    $("#msj-error2").fadeOut();
                }, 3000);
            }
        }

    });
});


function editaractoscliente(btn) {
  /********NOTE:Comprueba si La radicación está liquidada********/
  var id_radica = $("#radicacion").val();
  var route = "/mostrarliq";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {"id_radica": id_radica};
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validarliqd == '1') {//NOTE:Si la radicación ya está liquidada
      $("#msj3").html(info.mensaje);
      $("#msj-error3").fadeIn();
      setTimeout(function() {
          $("#msj-error3").fadeOut();
      }, 3000);
    } else if(info.validarliqd == '0'){//NOTE:Si la radicación No está liquidada
      var route = "/actosradica/" + btn.value + "/edit";
      $.get(route, function(res) {
          $("#id_act").val(res.id_acto);
          $("#cuant").val(res.cuantia);
          $("#catast").val(res.catastro);
          $("#tradi").val(res.tradicion);
          $("#id_actoperrad").val(res.id_actoperrad);
          $("#id_rad").val(res.id_radica);
          $("#matripref").val(res.prefijo_matricula_inmob);
          $("#matricu").val(res.matricula_inmob);
      });
      $('#modalactosradica').modal('toggle');
    }
  })
}

$("#actualizar").click(function() {
    var value, id_acto, cuantia, catastro, tradicion, datos, id_radica, 
    matripref, matricu;

    value = $("#id_actoperrad").val();
    id_acto = $("#id_act").val();
    cuantia = $("#cuant").val();
    catastro = $("#catast").val();
    tradicion = $("#tradi").val();
    matripref =  $("#matripref").val();
    matricu = $("#matricu").val();

    id_radica = $("#id_rad").val();
    datos = {
        "id_acto": id_acto,
        "cuantia": cuantia,
        "catastro": catastro,
        "tradicion": tradicion,
        "id_radica": id_radica,
        "matripref": matripref,
        "matricu": matricu
    };

    var route = "/actosradica/"+value;
    var token = $("#token").val();

    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'PUT',
        dataType: 'json',
        data: datos,
        success: function(info) {
            var validar = info.actos;
            CargarActosCli(validar);
            $('#modalactosradica').modal('toggle');
        }
    });
});

$("#cambiarestado1").click(function() {
  console.log('Estado1');
});

$("#cambiarestado2").click(function() {
  console.log('Estado2');
});

function eliminaractoscliente(btn) {
  /********NOTE:Comprueba si La radicación está liquidada********/
  var id_radica = $("#radicacion").val();
  var route = "/mostrarliq";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {"id_radica": id_radica};
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validarliqd == '1') {//NOTE:Si la radicación ya está liquidada
      $("#msj3").html(info.mensaje);
      $("#msj-error3").fadeIn();
      setTimeout(function() {
          $("#msj-error3").fadeOut();
      }, 3000);
    } else if(info.validarliqd == '0'){//NOTE:Si la radicación No está liquidada
      var route = "/actosradica/"+btn.value;
      var token = $("#token").val();
      $.ajax({
          url: route,
          headers: {
              'X-CSRF-TOKEN': token
          },
          type: 'DELETE',
          dataType: 'json',
          success: function(info) {
              var validar = info.actos;
              CargarActosCli(validar);
          }
      });
    }
  })
}
