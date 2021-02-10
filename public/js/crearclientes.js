$("#guardar-cli").click(function() {
    var identificacion_cli, pmer_apellidocli, sgndo_apellidocli,
    pmer_nombrecli, sgndo_nombrecli, estadocivil, telefono_cli, direccion_cli,
    email_cli, empresa, id_tipoident, ciudad;

    identificacion_cli = $("#identificacion").val();
    pmer_apellidocli = $("#pmer_apellidocli").val();
    sgndo_apellidocli = $("#sgndo_apellidocli").val();
    pmer_nombrecli = $("#pmer_nombrecli").val();
    sgndo_nombrecli = $("#sgndo_nombrecli").val();
    estadocivil = $("#estadocivil option:selected").val();
    telefono_cli = $("#telefono_cli").val();
    direccion_cli = $("#direccion_cli").val();
    email_cli = $("#email_cli").val();
    //id_tipoident = $("#tipo_documento").val();
    id_tipoident = $("#tipo_documento option:selected").val();
    empresa = $("#empresa").val();
    ciudad = $("#ciudad").val();

    if(identificacion_cli != '' && pmer_apellidocli != ''
    && pmer_nombrecli != '' && estadocivil != ''
    && telefono_cli != '' && direccion_cli != ''
    && email_cli != '' && id_tipoident != '' && ciudad != ''){

      var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

      if (regex.test($('#email_cli').val().trim())) {
        if(document.querySelector('input[name="autoreiva_natural"]:checked') && document.querySelector('input[name="autorertf_natural"]:checked') && document.querySelector('input[name="autoreica_natural"]:checked')) {
          var autoreteiva = $('input:radio[name=autoreiva_natural]:checked').val();
          if (autoreteiva == 'si') {
              autoreteiva = true;
          } else if (autoreteiva == 'no') {
              autoreteiva = false;
          }

          var autoretertf = $('input:radio[name=autorertf_natural]:checked').val();
          if (autoretertf == 'si') {
              autoretertf = true;
          } else if (autoretertf == 'no') {
              autoretertf = false;
          }

          var autoreteica = $('input:radio[name=autoreica_natural]:checked').val();
          if (autoreteica == 'si') {
              autoreteica = true;
          } else if (autoreteica == 'no') {
              autoreteica = false;
          }
          datos = {
            "identificacion_cli": identificacion_cli, "pmer_apellidocli": pmer_apellidocli,
            "sgndo_apellidocli": sgndo_apellidocli, "pmer_nombrecli": pmer_nombrecli,
            "sgndo_nombrecli": sgndo_nombrecli, "estadocivil": estadocivil, "telefono_cli": telefono_cli,
            "direccion_cli": direccion_cli, "email_cli": email_cli,
            "id_tipoident": id_tipoident, "empresa": empresa,
            "autoreteiva": autoreteiva,
            "autoretertf": autoretertf,
            "autoreteica": autoreteica,
            "ciudad": ciudad
          };
          var route = "/clientes";
          var token = $("#token").val();
          var type = 'POST';
          __ajax(route, token, type, datos)
          .done( function( info ){
            $("#modalcliente").modal('toggle');
            if($("#calidad").val() == 1){ //NOTE:Campo oculto en modal cliente
              $("#nombre_cli1").val(info.nombre);
            }else if($("#calidad").val() == 2){
              $("#nombre_cli2").val(info.nombre);
            }else if($("#calidad").val() == 3){
              $("#nombre_cli3").val(info.nombre);
            }
          })
        }else{
          alert("Falta seleccionar las opciones de autorretenedores");
        }
      } else {
          alert('El Email no es una dirección válida');
      }
    }else{
      alert("Todos los campos son obligatorios");
    }
});

$("#guardar-cli-empresa").click(function() {
    var identificacion_cli, empresa, digito_verif, telefono_cli, direccion_cli,
    email_cli, id_tipoident, ciudad;

    identificacion_cli = $("#identificacion_empresa").val();
    id_tipoident = $("#tipo_documento_empresa option:selected").val();
    digito_verif = $("#digito_verif").val();
    empresa = $("#empresa").val();
    telefono_cli = $("#telefono_cli_empresa").val();
    direccion_cli = $("#direccion_cli_empresa").val();
    email_cli = $("#email_cli_empresa").val();
    ciudad = $("#ciudad_empresa").val();

    if(identificacion_cli != '' && id_tipoident != ''
    && digito_verif != '' && empresa != '' && telefono_cli != ''
    && direccion_cli != '' && email_cli != '' && ciudad != ''){

      var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#email_cli_empresa').val().trim())) {
      if(document.querySelector('input[name="autoreiva"]:checked') && document.querySelector('input[name="autorertf"]:checked') && document.querySelector('input[name="autoreica"]:checked')) {
        var autoreteiva = $('input:radio[name=autoreiva]:checked').val();
        if (autoreteiva == 'si') {
            autoreteiva = true;
        } else if (autoreteiva == 'no') {
            autoreteiva = false;
        }

        var autoretertf = $('input:radio[name=autorertf]:checked').val();
        if (autoretertf == 'si') {
            autoretertf = true;
        } else if (autoretertf == 'no') {
            autoretertf = false;
        }

        var autoreteica = $('input:radio[name=autoreica]:checked').val();
        if (autoreteica == 'si') {
            autoreteica = true;
        } else if (autoreteica == 'no') {
            autoreteica = false;
        }

        datos = {
          "identificacion_cli": identificacion_cli, "id_tipoident": id_tipoident,
          "digito_verif": digito_verif, "empresa": empresa,
          "telefono_cli": telefono_cli, "direccion_cli": direccion_cli,
          "email_cli": email_cli,
          "autoreteiva": autoreteiva,
          "autoretertf": autoretertf,
          "autoreteica": autoreteica,
          "ciudad": ciudad
        };

      var route = "/clientes";
      var token = $("#token").val();
      var type = 'POST';

        __ajax(route, token, type, datos)
        .done( function( info ){
          $("#modalcliente-empresa").modal('toggle');
          if($("#calidad").val() == 1){ //NOTE:Campo oculto en modal cliente
            $("#nombre_cli1").val(info.nombre);
          }else if($("#calidad").val() == 2){
            $("#nombre_cli2").val(info.nombre);
          }else if($("#calidad").val() == 3){
            $("#nombre_cli3").val(info.nombre);
          }
        })
      }else{
        alert("Falta seleccionar las opciones de autorretenedores");
      }
    } else {
        alert('El Email no es una dirección válida');
    }

    }else{
      alert("Todos los campos son obligatorios");
    }
});

function mayus(e) {
    e.value = e.value.toUpperCase();
}
