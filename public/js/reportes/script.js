$("#ron").click(function(){

  var opcion = 12;
  var reporte = "Reporte de Operaciones Notariales (RON) - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});


$("#ingresporescrituradores").click(function(){

  var opcion = 21;
  var reporte = "Informe de ingresos Escrituradores";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});

$("#imprimiringresosporescrituradores").click(function(){
  if (document.querySelector('input[name="seleccion"]:checked')) {
    var tipoinforme = '';
    var id_proto = '';
    var seleccion = $('input:radio[name=seleccion]:checked').val();
    if (seleccion == 'general') {
      opcionreporte = "general";
    }else if (seleccion == 'porescriturador') {
      opcionreporte = "porescriturador";
      id_proto = $("#id_proto").val();
    }

    if($("#start").val() == '' || $("#end").val() == ''){
      alert("Todos los campos son necesarios");
    }else{

      var route = "/cargarfechas";
      var token = $("#token").val();
      var type = 'GET';
      var fecha1 = $("#start").val();
      var fecha2 = $("#end").val();
      var datos = {
        "fecha1": fecha1,
        "fecha2": fecha2,
        "opcionreporte": opcionreporte,
        "id_proto": id_proto
      };

      __ajax(route, token, type, datos)
      .done( function( info ){
        if(info.validar == 1){
          var url = "/ingresosporescrituradorpdf";
          $("<a>").attr("href", url).attr("target", "_blank")[0].click();
        }
      })
    }
  }else{
    alert("Seleccione tipo de informe");
  }
});

function handleRadioButtonChange() {
  var seleccion = $('input:radio[name=seleccion]:checked').val();
  //var elemento = document.getElementById("mostrarprotocolista");
  if (seleccion == 'general') {
   $("#mostrarprotocolista").fadeOut();
 }else if (seleccion == 'porescriturador') {
   $("#mostrarprotocolista").fadeIn();
 }
}


$("#informeingresos_dian").click(function(){

  var opcion = 19;
  var reporte = "Informe de ingresos para la DIAN";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});

$("#enajenaciones").click(function(){

  var opcion = 20;
  var reporte = "Informe de Enajenaciones para la DIAN";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});

$("#consolidadocaja").click(function(){
  var opcion = 24;
  var reporte = "Consolidado de Caja";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});

$("#imprimirconsolidadocaja").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "/imprimirconsolidadocajapdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});


$("#informedegastos").click(function(){
  var opcion = 25;
  var reporte = "Informe de Gastos";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});

$("#imprimirinformedegastos").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "informedegastos";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});


$("#relnotcreditcajarapida").click(function(){
  var opcion = 26;
  var reporte = "Relación Nota Crédito Caja Rápida";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});

$("#relacionnotacreditocajarapida").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "relacionnotacreditocajarapida";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});

$("#generar_informe_ingresos_dian").click(function(){

 if (document.querySelector('input[name="seleccion"]:checked')) {

  var opcionreporte = '';
  var seleccion = $('input:radio[name=seleccion]:checked').val();
  if (seleccion == 'escrituras') {
    opcionreporte = "escrituras";
  }else if (seleccion == 'cajarapida') {
    opcionreporte = "cajarapida";
  }

  if($("#ingreso").val() == '' || $("#start").val() == '' || $("#end").val() == ''){
    alert("Todos los campos son necesarios");
  }else{

    var route = "/cargarfechas";
    var token = $("#token").val();
    var type = 'GET';
    var ingreso = $("#ingreso").val();
    var fecha1 = $("#start").val();
    var fecha2 = $("#end").val();
    var datos = {
      "fecha1": fecha1,
      "fecha2": fecha2,
      "ingreso": ingreso,
      "opcionreporte": opcionreporte
    };

    __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 1){
        var url = "generar_informe_ingresos_dian";
        $("<a>").attr("href", url)[0].click();
      }
    })
  }
  
}else{
  alert("Seleccione tipo de informe");
}

});

$("#generar_informe_enajenaciones_dian").click(function(){

 if (document.querySelector('input[name="seleccion"]:checked')) {

  var opcionreporte = '';
  var seleccion = $('input:radio[name=seleccion]:checked').val();
  if (seleccion == 'enajenacionesprincipales') {
    opcionreporte = "enajenacionesprincipales";
  }else if (seleccion == 'enajenacionesvendedoressecundarios') {
    opcionreporte = "enajenacionesvendedoressecundarios";
  }else if (seleccion == 'enajenacionescompradoressecundarios') {
    opcionreporte = "enajenacionescompradoressecundarios";
  }

  if($("#start").val() == '' || $("#end").val() == ''){
    alert("Todos los campos son necesarios");
  }else{

    var route = "/cargarfechas";
    var token = $("#token").val();
    var type = 'GET';
    var ingreso = $("#ingreso").val();
    var fecha1 = $("#start").val();
    var fecha2 = $("#end").val();
    var datos = {
      "fecha1": fecha1,
      "fecha2": fecha2,
      "opcionreporte": opcionreporte
    };

    __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 1){
        var url = "informe_enejenaciones_dian";
        $("<a>").attr("href", url)[0].click();
      }
    })
  }
  
}else{
  alert("Seleccione tipo de informe");
}

});


$("#certificadortf").click(function(){
  var opcion = 13;
  var reporte = "Certificado de Retención en la Fuente";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});


$("#diariocaja").click(function(){
  var opcion = 1;
  var reporte = "Relación de Facturas Diarias - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#mensualcaja").click(function(){
  var opcion = 1;
  var reporte = "Relación de Facturas Mensual - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#actos_notariales_escritura").click(function(){
  var opcion = 2;
  var reporte = "Informe de Actos Notariales por Escritura";
  var ordenar = "pornumescritura";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte,
    "ordenar": ordenar
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});



$("#libroindice").click(function(){
  var opcion = 2;
  var reporte = "Libro Índice de Escrituras";
  var ordenar = "pornombre";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte,
    "ordenar": ordenar
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })

});



$("#librorelaciondeescrituras").click(function(){
  var opcion = 2;
  var reporte = "Libro Relación de Escrituras";
  var ordenar = "porescritura";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte,
    "ordenar": ordenar
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
  
});


$("#informerecaudos").click(function(){
  var opcion = 11;
  var reporte = "Informe de Recaudos Mes - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#retefuentesaplicadas").click(function(){
  var opcion = 22;
  var reporte = "Informe de Retefuentes Aplicadas";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#informederetefuentes").click(function(){
  var opcion = 23;
  var reporte = "Informe de Retefuentes";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#informeimptimbre").click(function(){
  var opcion = 29;
  var reporte = "Informe de Timbre";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#informerecaudosdiario").click(function(){
  var opcion = 11;
  var reporte = "Informe de Recaudos Caja - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});


$("#relacionnotascreditomensual").click(function(){
  var opcion = 8;
  var reporte = "Notas Crédito Mensual - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#relacionnotascreditodiario").click(function(){
  var opcion = 8;
  var reporte = "Notas Crédito Diario - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});


$("#informecarterames").click(function(){
  var opcion = 9;
  var reporte = "Relación de Cartera por Fecha";
  var ordenar = "porfecha";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte,
    "ordenar": ordenar
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});


$("#informecarterafacturasactivas").click(function(){
  var opcion = 27;
  var reporte = "Relación de Cartera Facturas Activas";
  var ordenar = "facturasactivas";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte,
    "ordenar": ordenar
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});




$("#informecarteracliente").click(function(){
  var opcion = 10;
  var reporte = "Relación de Cartera por Cliente";
  var ordenar = "porcliente";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte,
    "ordenar": ordenar
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#ingresosporconcepto").click(function(){
  var opcion = 3;
  var reporte = "Relación de Facturas Diarias por Conceptos - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#ingresosporconceptomensual").click(function(){
  var opcion = 3;
  var reporte = "Relación de Conceptos por Mes - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#estadisticonotarial").click(function(){
  var opcion = 4;
  var reporte = "Reporte estadístico notarial - Escrituración";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#enlaces").click(function(){
  var opcion = 7;
  var reporte = "Reporte de enlaces";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#imprimirestadisticonotarial").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "/estadisticonotarialpdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});

$("#imprimirretefuentesaplicadas").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "/retefuentesaplicadaspdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});

$("#imprimirretefuentes").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
      "fecha1": fecha1,
      "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "/informeretefuentespdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});

$("#imprimirinformetimbre").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
      "fecha1": fecha1,
      "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "/informetimbre";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});


$("#imprimirenlaces").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "/enlacespdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});

$("#imprimircertificadortf").click(function(){
  var route = "/cargaridentificacion";
  var token = $("#token").val();
  var type = 'GET';
  var identificacion = $("#identificacion").val();
  var datos = {
    "identificacion": identificacion
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "/copiacertificadortf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })

});

$("#auxiliarcaja").click(function(){
  var opcion = 5;
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#registrocivil").click(function(){
  var opcion = 6;
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});


$("#generarreporte").click(function(){
  if (document.querySelector('input[name="seleccion"]:checked')) {

    var tipoinforme = '';

    var seleccion = $('input:radio[name=seleccion]:checked').val();
    if (seleccion == 'completo') {
      tipoinforme = "completo";
    }else if (seleccion == 'contado') {
      tipoinforme = "contado";
    }else if (seleccion == 'credito') {
      tipoinforme = "credito";
    }

    
    var fecha1 = $("#start").val();
    var fecha2 = $("#end").val();

    var datos = {
      "fecha1": fecha1,
      "fecha2": fecha2,
      "tipoinforme": tipoinforme
    };
    var route = "/cajadiario";
    var token = $("#token").val();
    var type = 'GET';

    __ajax(route, token, type, datos)
    .done( function( info ){
      var cajadiario = info.cajadiario;
      var cajadiario_otros_periodos = info.cajadiario_otros_periodos;
      var cruces = info.cruces;
      var total_egreso = info.total_egreso;
      var derechos_contado = info.derechos_contado;
      var conceptos_contado = info.conceptos_contado;
      var ingresos_contado = info.ingresos_contado;
      var iva_contado = info.iva_contado;
      var recaudos_contado = info.recaudos_contado;
      var aporteespecial_contado = info.aporteespecial_contado;
      var impuestotimbre_contado = info.impuestotimbre_contado;
      var rtf_contado = info.rtf_contado;
      var deduccion_reteiva_contado = info.deduccion_reteiva_contado;
      var deduccion_reteica_contado = info.deduccion_reteica_contado;
      var deduccion_retertf_contado = info.deduccion_retertf_contado;
      var total_fact_contado = info.total_fact_contado;
      var derechos_credito = info.derechos_credito;
      var conceptos_credito = info.conceptos_credito;
      var ingresos_credito = info.ingresos_credito;
      var iva_credito = info.iva_credito;
      var recaudos_credito = info.recaudos_credito;
      var aporteespecial_credito = info.aporteespecial_credito;
      var impuestotimbre_credito = info.impuestotimbre_credito;
      var rtf_credito = info.rtf_credito;
      var deduccion_reteiva_credito = info.deduccion_reteiva_credito;
      var deduccion_reteica_credito = info.deduccion_reteica_credito;
      var deduccion_retertf_credito = info.deduccion_retertf_credito;
      var total_fact_credito = info.total_fact_credito;

      CargarCajaDiarioGeneral(cajadiario, total_egreso, cajadiario_otros_periodos, derechos_contado, conceptos_contado, ingresos_contado, iva_contado, recaudos_contado, aporteespecial_contado, impuestotimbre_contado, 
        rtf_contado, deduccion_reteiva_contado, deduccion_reteica_contado, deduccion_retertf_contado,
        total_fact_contado, derechos_credito, conceptos_credito, ingresos_credito, iva_credito, recaudos_credito, aporteespecial_credito,
        impuestotimbre_credito, rtf_credito, deduccion_reteiva_credito, deduccion_reteica_credito,
        deduccion_retertf_credito, total_fact_credito);
      CargarCrucesActas(cruces);
    })

  }else{
    alert("Seleccione tipo de informe");
  }
  
});

$("#generarreportelibroindice").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/libroindice";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var libroindice = info.libroindice;
    if(info.paragrid == '2'){
      CargarLibroIndice(libroindice);
    }else if(info.paragrid == '1'){
      CargarLibroRelacion(libroindice);
    }else if(info.paragrid == '3'){
      CargarLibroRelacion(libroindice);
    }
  })
});

$("#generarreporterelacionnotascredito").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/relacionnotacredito";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var rel_notas_credito = info.rel_notas_credito;
    CargarRelNotasCredito(rel_notas_credito);
  })
});



$("#generarreportecarterames").click(function(){

  if (document.querySelector('input[name="seleccion"]:checked')) {
    var opcionreporte = '';
    var seleccion = $('input:radio[name=seleccion]:checked').val();
    if (seleccion == 'maycero') {
      opcionreporte = "maycero";
    }else if (seleccion == 'completo') {
      opcionreporte = "completo";
    }

    if($("#start").val() == '' || $("#end").val() == ''){
      alert("Todos los campos son necesarios");
    }else{

      var fecha1 = $("#start").val();
      var fecha2 = $("#end").val();

      var datos = {
        "fecha1": fecha1,
        "fecha2": fecha2,
        "opcionreporte": opcionreporte
      };
      var route = "/informecartera";
      var token = $("#token").val();
      var type = 'GET';

      __ajax(route, token, type, datos)
      .done( function( info ){
        var informecartera = info.informecartera;
        CargarInformeCartera(informecartera);
      })
    }
  }else{
    alert("Seleccione tipo de informe");
  }
});



$("#generarreportecarteracliente").click(function(){
 if (document.querySelector('input[name="seleccion"]:checked')) {
  var opcionreporte = '';
  var seleccion = $('input:radio[name=seleccion]:checked').val();
  if (seleccion == 'maycero') {
    opcionreporte = "maycero";
  }else if (seleccion == 'completo') {
    opcionreporte = "completo";
  }

  if( $("#identificacion_cli").val() == ''){
    alert("Todos los campos son necesarios");
  }else{

   var identificacion_cli = $("#identificacion_cli").val();

   var datos = {
    "identificacion_cli": identificacion_cli,
    "opcionreporte": opcionreporte
  };
  var route = "/informecartera";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informecartera = info.informecartera;
    CargarInformeCartera(informecartera);
  })
}
}else{
  alert("Seleccione tipo de informe");
}

});


$("#generarreportecarterafacturasactivas").click(function(){
  var opcionreporte = '';
   var datos = {
    "opcionreporte": opcionreporte
  };
  var route = "/informecartera";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informecartera = info.informecartera;
    CargarInformeCartera_facturas_activas(informecartera);
  })

});

$("#informediariocajarapida").click(function(){
  var opcion = 14;
  var reporte = "Relación de Facturas Caja Rápida";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#statusfactelectronicacajarapida").click(function(){
  var opcion = 16;
  var reporte = "Facturas por enviar a la DIAN";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#informeporconceptoscajarapida").click(function(){
  var opcion = 15;
  var reporte = "Relación de Facturas Diarias Por Grupos Caja Rápida";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});


$("#generarreportecajadiario").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/generarreportecajadiario";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informe = info.Informe_cajadiario_rapida;
    var contado = info.Contado;
    var credito = info.Credito;
    var facturadores = info.facturadores;
    
    CargarInformeCajadiario_rapida(informe, contado, credito, facturadores);
  })
});

$("#generarreportecajadiarioporconceptos").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/generarreportecajadiarioporconceptos";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informe = info.Informe_cajadiario_rapida_conceptos;
    CargarInformeCajadiario_rapida_conceptos(informe);
  })
});


$("#generarinformederecaudos").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/informerecaudos";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    document.getElementById('valor1').innerHTML = formatNumbderechos(info.valor1);
    document.getElementById('valor1b').innerHTML = formatNumbderechos(info.valor1);
    document.getElementById('valor2').innerHTML = formatNumbderechos(info.valor2);
    document.getElementById('valor3').innerHTML = formatNumbderechos(info.valor3);
    document.getElementById('valor4').innerHTML = formatNumbderechos(info.valor4);
    document.getElementById('valor5').innerHTML = formatNumbderechos(info.valor5);
    document.getElementById('valor6').innerHTML = formatNumbderechos(info.valor6);
    document.getElementById('valor7').innerHTML = formatNumbderechos(info.valor7);

    document.getElementById('ran1escr').innerHTML = (info.ran1escr);
    document.getElementById('ran2escr').innerHTML = info.ran2escr;
    document.getElementById('ran3escr').innerHTML = info.ran3escr;
    document.getElementById('ran4escr').innerHTML = info.ran4escr;
    document.getElementById('ran5escr').innerHTML = info.ran5escr;
    document.getElementById('ran6escr').innerHTML = info.ran6escr;
    document.getElementById('sincescr').innerHTML = info.sincescr;
    document.getElementById('excescr').innerHTML = info.excescr;

    document.getElementById('ran1super').innerHTML = formatNumbderechos(info.ran1super);
    document.getElementById('ran2super').innerHTML = formatNumbderechos(info.ran2super);
    document.getElementById('ran3super').innerHTML = formatNumbderechos(info.ran3super);
    document.getElementById('ran4super').innerHTML = formatNumbderechos(info.ran4super);
    document.getElementById('ran5super').innerHTML = formatNumbderechos(info.ran5super);
    document.getElementById('ran6super').innerHTML = formatNumbderechos(info.ran6super);
    document.getElementById('sincsuper').innerHTML = formatNumbderechos(info.sincsuper);
    document.getElementById('excsuper').innerHTML = formatNumbderechos(info.excsuper);

    document.getElementById('ran1fondo').innerHTML = formatNumbderechos(info.ran1fondo);
    document.getElementById('ran2fondo').innerHTML = formatNumbderechos(info.ran2fondo);
    document.getElementById('ran3fondo').innerHTML = formatNumbderechos(info.ran3fondo);
    document.getElementById('ran4fondo').innerHTML = formatNumbderechos(info.ran4fondo);
    document.getElementById('ran5fondo').innerHTML = formatNumbderechos(info.ran5fondo);
    document.getElementById('ran6fondo').innerHTML = formatNumbderechos(info.ran6fondo);
    document.getElementById('sincfondo').innerHTML = formatNumbderechos(info.sincfondo);
    document.getElementById('excfondo').innerHTML = formatNumbderechos(info.excfondo);

    document.getElementById('ran1total').innerHTML = formatNumbderechos(info.ran1total);
    document.getElementById('ran2total').innerHTML = formatNumbderechos(info.ran2total);
    document.getElementById('ran3total').innerHTML = formatNumbderechos(info.ran3total);
    document.getElementById('ran4total').innerHTML = formatNumbderechos(info.ran4total);
    document.getElementById('ran5total').innerHTML = formatNumbderechos(info.ran5total);
    document.getElementById('ran6total').innerHTML = formatNumbderechos(info.ran6total);
    document.getElementById('sinctotal').innerHTML = formatNumbderechos(info.sinctotal);
    document.getElementById('exctotal').innerHTML = formatNumbderechos(info.exctotal);

    document.getElementById('total_escrituras').innerHTML = info.total_escrituras;
    document.getElementById('total_recaudos').innerHTML = formatNumbderechos(info.total_recaudos);

    document.getElementById('total_super').innerHTML = formatNumbderechos(info.total_super);
    document.getElementById('total_fondo').innerHTML = formatNumbderechos(info.total_fondo);

  })
});

$("#generarreporte_conceptos").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/ingresoporconceptos";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var conceptos = info.conceptos;
    var total = info.grantotal;
    CargarIngresoConceptos(conceptos, total);
  })
});

$("#escrituras_sin_factura").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/escripendtfact";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var EscSinFact = info.Reporte;
    CargarEscrSinFact(EscSinFact);
  })
});

$("#escrisinfact").click(function(){
  var opcion = 28;
  var reporte = "Escrituras Pendientes de Factura";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#generar_ron").click(function(){
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      var url = "/informe_ron";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    }
  })
});


$("#informedepositos").click(function(){
  var opcion = 17;
  var reporte = "Relación de depósitos diarios";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});

$("#informeegresos").click(function(){
  var opcion = 18;
  var reporte = "Relación de egresos";
  var route = "/cargartiporeporte";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    "opcionreporte": opcion,
    "reporte": reporte
  };
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      location.href="/reportes";
    }
  })
});


$("#generarreporte_depositos").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/reporte_depositos";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informe = info.depositos;
    CargarInformeDepositos(informe);
  })
});


$("#generarreporte_egresos").click(function(){
  if (document.querySelector('input[name="seleccion"]:checked')) {
    var opcionreporte = '';
    var seleccion = $('input:radio[name=seleccion]:checked').val();
    if (seleccion == 'maycero') {
      opcionreporte = "maycero";
    }else if (seleccion == 'completo') {
      opcionreporte = "completo";
    }

    if($("#start").val() == '' || $("#end").val() == ''){
      alert("Todos los campos son necesarios");
    }else{

      var fecha1 = $("#start").val();
      var fecha2 = $("#end").val();
      var datos = {
        "fecha1": fecha1,
        "fecha2": fecha2,
        "opcionreporte": opcionreporte
      };
      var route = "/reporte_egresos";
      var token = $("#token").val();
      var type = 'GET';

      __ajax(route, token, type, datos)
      .done( function( info ){
        var informe = info.egresos;
        CargarInformeEgresos(informe);
      })
    }
  }else{
    alert("Seleccione tipo de informe");
  }
});



//jquery accordion
$( "#accordion" ).accordion({
  collapsible: true ,
  heightStyle: "content",
  animate: 250,
  header: ".accordion-header"
}).sortable({
  axis: "y",
  handle: ".accordion-header",
  stop: function( event, ui ) {
            // IE doesn't register the blur when sorting
            // so trigger focusout handlers to remove .ui-state-focus
    ui.item.children( ".accordion-header" ).triggerHandler( "focusout" );
  }
});
        //jquery tabs
$( "#tabs" ).tabs();
