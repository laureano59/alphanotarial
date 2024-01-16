$("#buscar").click(function() {

  /********NOTE:Comprueba si La radicación está liquidada********/
  var id_radica = $("#radicacion").val();
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

    } else if(info.validarliqd == '0'){//NOTE:si la radicación no se ha liquidado
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

    } else if(info.validarliqd == '0'){//NOTE:si la radicación no se ha liquidado
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