$("#actualizar_cli").click(function(){
  var identificacion_cli, pmer_apellidocli, sgndo_apellidocli,
  pmer_nombrecli, sgndo_nombrecli, estadocivil, telefono_cli, direccion_cli,
  email_cli, empresa, ciudad, actidad_economica, opcion;
  opcion = 1;

  identificacion_cli = $("#identificacion_cli").val();
  pmer_apellidocli = $("#pmer_apellidocli").val();
  sgndo_apellidocli = $("#sgndo_apellidocli").val();
  pmer_nombrecli = $("#pmer_nombrecli").val();
  sgndo_nombrecli = $("#sgndo_nombrecli").val();
  estadocivil = $("#estadocivil option:selected").val();
  telefono_cli = $("#telefono_cli").val();
  direccion_cli = $("#direccion_cli").val();
  email_cli = $("#email_cli").val();
  empresa = $("#empresa").val();
  ciudad = $("#ciudad").val();
  actidad_economica = $("#actiecon option:selected").val(); 

  if(pmer_apellidocli != '' && pmer_nombrecli != '' && estadocivil != ''
  && telefono_cli != '' && direccion_cli != ''
  && email_cli != '' && ciudad != '' && actidad_economica != ''){

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
          "pmer_apellidocli": pmer_apellidocli,
          "sgndo_apellidocli": sgndo_apellidocli,
          "pmer_nombrecli": pmer_nombrecli,
          "sgndo_nombrecli": sgndo_nombrecli,
          "estadocivil": estadocivil,
          "telefono_cli": telefono_cli,
          "direccion_cli": direccion_cli,
          "email_cli": email_cli,
          "empresa": empresa,
          "autoreteiva": autoreteiva,
          "autoretertf": autoretertf,
          "autoreteica": autoreteica,
          "ciudad": ciudad,
          "actidad_economica": actidad_economica,
          "opcion": opcion
        };

        var route = "/clientes/"+identificacion_cli;
        var token = $("#token").val();
        var type = 'PUT';

        __ajax(route, token, type, datos)
        .done( function( info ){
          if(info.validar == 1){
            var mensaje = info.mensaje;
            $("#msj1").html(info.mensaje);
            $("#msj-error1").fadeIn();
            setTimeout(function() {
            $("#msj-error1").fadeOut();
            }, 3000);
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

$("#guardar_cli_empresa").click(function(){
  var identificacion_cli, telefono_cli, direccion_cli,
  email_cli, empresa, ciudad, opcion, actidad_economica;
  opcion = 2;

  identificacion_cli = $("#identificacion_cli").val();
  telefono_cli = $("#telefono_cli_empresa").val();
  direccion_cli = $("#direccion_cli_empresa").val();
  email_cli = $("#email_cli_empresa").val();
  empresa = $("#empresa").val();
  ciudad = $("#ciudad_empresa").val();
  actidad_economica = $("#actiecon option:selected").val();

  if(empresa != '' && telefono_cli != '' && direccion_cli != ''
  && email_cli != '' && ciudad != ''){

    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (regex.test($('#email_cli_empresa').val().trim())) {
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
          "telefono_cli": telefono_cli,
          "direccion_cli": direccion_cli,
          "email_cli": email_cli,
          "empresa": empresa,
          "autoreteiva": autoreteiva,
          "autoretertf": autoretertf,
          "autoreteica": autoreteica,
          "ciudad": ciudad,
          "actidad_economica": actidad_economica,
          "opcion": opcion
        };

        var route = "/clientes/"+identificacion_cli;
        var token = $("#token").val();
        var type = 'PUT';

        __ajax(route, token, type, datos)
        .done( function( info ){
          if(info.validar == 1){
            var mensaje = info.mensaje;
            $("#msj1").html(info.mensaje);
            $("#msj-error1").fadeIn();
            setTimeout(function() {
            $("#msj-error1").fadeOut();
            }, 3000);
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

 function validarEmail(input) {
            // Expresión regular que permite solo letras, números, puntos, guiones y @
            const regex = /[^a-zA-Z0-9@._-]/g;
            // Remueve los caracteres no permitidos del valor actual del campo
            input.value = input.value.replace(regex, '');
        }
