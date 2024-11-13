$("#buscarporidentif").click(function() {
    $("#num_fact").html('');
    $("#abono").val('');
    var opcion, identificacion_cli, tipogrid;
    tipogrid = $("#tipogrid").val();
    opcion = 1;
    identificacion_cli = $("#identif").val();
    if (identificacion_cli != '') {
        var route = "/buscarbono";
        var token = $("#token").val();
        var type = 'GET';

        var datos = {
            "identificacion_cli": identificacion_cli,
            "opcion": opcion
        }

        __ajax(route, token, type, datos)
            .done(function(info) {
                var bono_data = info.bono_fact;
                CargarGridBonos(bono_data);
               
            })
    } else {
        alert("Aún no ha escrito el número de Documento que desea buscar");
    }
});

$("#buscarpornumfact").click(function() {
    $("#num_fact").html('');
    $("#abono").val('');
    var opcion, id_fact, tipogrid;
    opcion = 2;
    tipogrid = $("#tipogrid").val();
    id_fact = $("#idfact").val();
    if (id_fact != '') {
        var route = "/buscarbono";
        var token = $("#token").val();
        var type = 'GET';

        var datos = {
            "id_fact": id_fact,
            "opcion": opcion
        }

        __ajax(route, token, type, datos)
            .done(function(info) {
                var bono_data = info.bono_fact;
                CargarGridBonos(bono_data);
            })
    } else {
        alert("Aún no ha escrito el número de Factura que desea buscar");
    }
});

$("#GuardarAbono").click(function() {
    var abono, saldo, nuevosaldo, opcion, id_fact;
    id_fact = $("#id_fact_iden").val();
    saldo = parseInt($("#saldo_iden").val());
    abono = $("#abono").val();
      if (abono != '') {
        if (saldo >= abono) {
            nuevosaldo = saldo - abono;
            console.log(abono);
            console.log(saldo);
            console.log(nuevosaldo);
            var route = "/bonos/" + id_fact;
            var token = $("#token").val();
            var type = 'PUT';
            var datos = {
                "id_fact": id_fact,
                "abono": abono,
                "saldo": nuevosaldo
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    if (info.validar == 1) {
                         $("#msj1").html(info.mensaje);
                         $("#msj-error1").fadeIn();
                         setTimeout(function() {
                            $("#msj-error1").fadeOut();
                        }, 4000);
                       
                    }
                }) //AJAX Nuevo Saldo

        } else {
            alert("El abono a realizar debe ser menor o igual al saldo");
        }
    } else {
        alert("Debes asignar el valor del abono");
    }
});

function mayus(e) {
    e.value = e.value.toUpperCase();
}


$("#cargarbonos").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/cargarbonos";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var bonos = info.bonos;
    CargarBonos(bonos);

  })
});


$("#GenerarCuentaCobro").click(function(){

     var seleccionados = [];
     var itemSeleccionado = false;

    // Recorre cada item del data utilizando el mismo índice del checkbox
    for (var item in globalData) {
        var checkbox = document.getElementById('check_' + item);
        
        // Verifica si el checkbox existe y está seleccionado
        if (checkbox && checkbox.checked) {
            seleccionados.push(globalData[item]); // Agrega el objeto data[item] al array
            itemSeleccionado = true;
        }
    }

    if (!itemSeleccionado) {
        alert("Por favor, selecciona al menos un item.");
        return; // Salimos de la función si no hay elementos seleccionados
    }

    // Llama a una función para procesar los elementos seleccionados
    enviarSeleccionados(seleccionados);

    });

function enviarSeleccionados(seleccionados) {
    var datos = {
        "seleccionados": seleccionados
    };
  var route = "/cuentadecobro";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var validar = info.validar;
    if(validar == 1){
        var id_cce = info.id_cce;
        var url = "/cuentadecobropdf";
          $("<a>").attr("href", url).attr("target", "_blank")[0].click();

          CargarBonosAfter();

    }
  })
    
}

function CargarBonosAfter(){
     var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/cargarbonos";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var bonos = info.bonos;
    CargarBonos(bonos);

  })
}

