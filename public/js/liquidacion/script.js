$("#buscar").click(function() {

  /********Comprueba si La radicación está liquidada********/
  var id_radica = $("#radicacion").val();
  var route = "/mostrarliq";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "id_radica": id_radica
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validarliqd == '1') {//Si la radicación ya está liquidada
      $("#botoncalcular").fadeOut();
      var derechos = info.derechos;
      CargarLiqDerechos(derechos);
      id_radica = $("#radicacion").val();
      datos = {
        "id_radica": id_radica
      };
      route = "/mostrarconcep";
      __ajax(route, token, type, datos)
      .done( function( info ){
        if(info.validarliqc == '1'){
          var conceptos = info.conceptos;
          CargarConceptosLiq(conceptos);
          id_radica = $("#radicacion").val();
          datos = {
            "id_radica": id_radica
          };
          route = "/mostrarrecaud";
          __ajax(route, token, type, datos)
          .done( function( info ){
            if(info.validarliqr == '1'){
              var recaudos = info.recaudos;
              CargarRecaudosLiq(recaudos);
            }
          })
        }
      })

    } else if(info.validarliqd == '0'){//si la radicación no se ha liquidado
      $("#botoncalcular").fadeIn();
      LimpiarConceptos();
      OcultarConcepto();
      $("#acto_concepto").html('');
      var id_radica = $("#radicacion").val();
      var datos = {
        "id_radica": id_radica
      };
      var route = "/derechos";
      var token = $("#token").val();
      var type = 'GET';
        __ajax(route, token, type, datos)//NOTE:Derechos Notariales
        .done( function( info ){
          if(info.validar == '1') {
            derechos = info.derechos;
            CargarDerechos(derechos);
            $("#totiva").val(info.iva);
            $("#totaliva").html(formatNumbderechos(info.iva));
            datos = {
              "actos": info.derechos
            };
            route = "/recaudos";
            token = $("#token").val();
            type = 'GET';
            __ajax(route, token, type, datos)//Recaudos
            .done( function( info ){
              if(info.validar == 5){
                alert(info.mensaje);
              }else if(info.validar == 1){
               CargarRecaudos(info);
              //console.table(info);
             }
             
           })

          } else if(info.validar == '0') {
            $("#msj").html(info.mensaje);
            $("#msj-error").fadeIn();
            setTimeout(function() {
              $("#msj-error").fadeOut();
            }, 3000);
          }
        })
    }//if radicacion No liquidada
  })//Ajax radicación liquidada

});

function BuscarPorSession(valor){
  /********NOTE:Comprueba si La radicación está liquidada********/
  var id_radica = valor;//$("#radicacion").val();
  var route = "/mostrarliq";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "id_radica": id_radica
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validarliqd == '1') {//NOTE:Si la radicación ya está liquidada
      $("#botoncalcular").fadeOut();
      var derechos = info.derechos;
      CargarLiqDerechos(derechos);
      id_radica = $("#radicacion").val();
      datos = {
        "id_radica": id_radica
      };
      route = "/mostrarconcep";
      __ajax(route, token, type, datos)
      .done( function( info ){
        if(info.validarliqc == '1'){
          var conceptos = info.conceptos;
          CargarConceptosLiq(conceptos);
          id_radica = $("#radicacion").val();
          datos = {
            "id_radica": id_radica
          };
          route = "/mostrarrecaud";
          __ajax(route, token, type, datos)
          .done( function( info ){
            if(info.validarliqr == '1'){
              var recaudos = info.recaudos;
              CargarRecaudosLiq(recaudos);
            }
          })
        }
      })

    } else if(info.validarliqd == '0'){//Si la radicación no se ha liquidado
      $("#botoncalcular").fadeIn();
      LimpiarConceptos();
      OcultarConcepto();
      $("#acto_concepto").html('');
      var id_radica = valor;
      var datos = {
        "id_radica": id_radica
      };
      var route = "/derechos";
      var token = $("#token").val();
      var type = 'GET';
      __ajax(route, token, type, datos)
      .done( function( info ){
        if(info.validar == '1') {
          derechos = info.derechos;
          CargarDerechos(derechos);
          $("#totiva").val(info.iva);
          $("#totaliva").html(formatNumbderechos(info.iva));
          datos = {
            "actos": info.derechos
          };
          route = "/recaudos";
          token = $("#token").val();
          type = 'GET';
            __ajax(route, token, type, datos)//Recaudos
            .done( function( info ){
             if(info.validar == 5){
              alert(info.mensaje);
            }else if(info.validar == 1){
              CargarRecaudos(info);
            }

          })
          } else if(info.validar == '0') {
            $("#msj").html(info.mensaje);
            $("#msj-error").fadeIn();
            setTimeout(function() {
              $("#msj-error").fadeOut();
            }, 3000);
          }
        })
      }//if radicacion No liquidada
    })//Ajax radicación liquidada
}

function Conceptos(id_acto){

  var datos = {
    "id_acto": id_acto
  };
  var route = "/conceptos";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
  .done( function( info ){
    $("#acto_concepto").html(info.conceptos['nombre_acto']);
    CargarConceptos(info.conceptos);
  })
}


$("#imprimirliquidacion").click(function() {

 var tipo_impresion = "real";
 var datos = {
  "tipo_impresion": tipo_impresion
};
var route = "/validar_liquidacion_provisional";
var token = $("#token").val();
var type = 'GET';
__ajax(route, token, type, datos)
.done( function( info ){
  if(info.validar == '1'){
    var url = "/liquidacionpdf";
    $("<a>").attr("href", url).attr("target", "_blank")[0].click();
  }

})
});


$("#imprimirliquidacion_provisional").click(function() {

  var tipo_impresion = "provisional";

  var datos = {
    "tipo_impresion": tipo_impresion
  };
  var route = "/validar_liquidacion_provisional";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == '1'){
      var url = "/liquidacionpdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
    
  })

});


$("#mostrarparticipantes").click(function() {
  var id_radica = $("#radicacion").val();
  var route = "/anombrede";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "id_radica": id_radica
  };
  __ajax(route, token, type, datos)
  .done(function(info) {
    var anombrede = info.anombrede;
            CargarAnombreDe(anombrede);//trae los nombres involucrados
          })
});


function CargarAnombreDe(validar) {
  var i = 1;
  var htmlTags = "";
  for (let item in validar) {
    htmlTags +=
    '<tr>' +
    '<td>' +
    '<a href="javascript:;" onclick="Llevar(\'' + validar[item].id + '\', \'' + validar[item].fullname + '\', \'' + validar[item].autoreteiva + '\', \'' + validar[item].autoretertf + '\', \'' + validar[item].autoreteica + '\', \'' + validar[item].id_ciud + '\', document.getElementsByName(\'campo' + i + '\')[0].value);">' +
    validar[item].id +
    '</a>' +
    '</td>' +
    '<td>' +
    validar[item].fullname +
    '</td>' +
    '<td>' +
    '<input type="number" name="campo' + i + '" placeholder="campo' + i + '" size="4" min="0" max="100" oninput="if (parseInt(this.value) > 100) { this.value = 100; } if (isNaN(parseInt(this.value))) { this.value = \'\'; }">' +
    '</td>' +
    '</tr>';

    i++; // Incrementa el número de campo dinámico
  }
  document.getElementById('data').innerHTML = htmlTags;
  $('#modanombredeliq').modal('toggle');
}

function Obtener_RECAUDOS(id_radica) {
  var datos,recaudos;
  var token = $("#token").val();
  var type = 'GET';
  var route = "/mostrarrecaud";
         
      datos = {
        "id_radica": id_radica
      };

      return new Promise(function(resolve, reject) {
        __ajax(route, token, type, datos)
        .done(function(info) {
          if (info.validarliqr === '1') {
            resolve(info.recaudos);
          } else {
              reject(new Error('No se encontraron recaudos válidos.'));
          }
        })
        .fail(function(error) {
          reject(error);
        });
      });
  }

function Llevar(doc, nombre, autoreteiva, autoretertf, autoreteica, id_ciud, porcentaje) {
  $("#identificacion_cli1").val(doc);
  $("#nombre_cli1").val(nombre);
  var id_radica, totiva, porcentpago, reteiva, tarifa;
  id_radica = $("#radicacion").val();
  porcentpago = parseFloat(porcentaje / 100);
 
  Obtener_RECAUDOS(id_radica)
    .then(function(recaudos) {
      for (item in recaudos){
        totiva = recaudos[item].iva;
      }
    })
    .catch(function(error) {
      console.error('Error al obtener recaudos:', error.message);
    });

  if (autoreteiva == 'true') {
    var id_tar = 26;
    var route = "/tarifas";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
      "id_tar": id_tar
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
      tarifa = info.porcentajeiva; //Tarifa reteiva
    })

        console.log('porcentaje:', porcentpago);
        console.log('Tarifa:', tarifa);
        console.log('totiva:', totiva);
        reteiva = parseFloat(totiva * tarifa);
        reteiva = parseFloat(reteiva * porcentpago);
        reteiva = Math.round(reteiva);
        console.log('Reteiva:', reteiva);

  } else if (autoreteiva == 'false') {
      reteiva = 0;
  }
  

  if (autoretertf == 'true') {
    var id_tar = 28;
    var route = "/tarifas";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
      "id_tar": id_tar
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
      var tarifa = info.porcentajeiva; //Tarifa retertf
      var ingresos = parseFloat($("#totderechos").val()) + parseFloat($("#totconceptos").val());
      var retertf = ingresos * tarifa;
      $("#retertfide").val(Math.round(retertf));
      $("#retertf").html('-' + formatNumbderechos(Math.round(retertf)));
    })
//77777777777777777777777777777777777
    console.log(retertf);

  } else if (autoretertf == 'false') {
    var retertf = 0;
    $("#retertfide").val(retertf);
    $("#retertf").html('-' + formatNumbderechos(retertf));
    //Total_Menos_Deducciones();
  }

  if (autoreteica == 'true') {
    var route = "/validarciudad";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
      "id_ciud": id_ciud
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
      if (info.validar == 1) {
        var id_tar = 27;
        var route = "/tarifas";
        var token = $("#token").val();
        var type = 'GET';
        var datos = {
          "id_tar": id_tar
        };
        __ajax(route, token, type, datos)
        .done(function(info) {
          var ingresos = parseFloat($("#totderechos").val()) + parseFloat($("#totconceptos").val());
                                var tarifa = (info.porcentajeiva) / 1000; //Tarifa reteica
                                var reteica = ingresos * tarifa;
                                $("#reteicaide").val(Math.round(reteica));
                                $("#reteica").html('-' + formatNumbderechos(Math.round(reteica)));
                                //Total_Menos_Deducciones();
//77777777777777777777777777777777777777777777777777
                                console.log(reteica);

                              })
      } else if (info.validar == 0) {
        var reteica = 0;
        $("#reteicaide").val(reteica);
        $("#reteica").html('-' + formatNumbderechos(reteica));
        //Total_Menos_Deducciones();
      }

    })

  } else if (autoreteica == 'false') {
    var reteica = 0;
    $("#reteicaide").val(reteica);
    $("#reteica").html('-' + formatNumbderechos(reteica));
    //Total_Menos_Deducciones();
  }
  $('#modanombredeliq').modal('toggle');

}

