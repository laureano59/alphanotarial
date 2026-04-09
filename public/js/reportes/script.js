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

$("#act_id_rep, #informe_actas_credito, #informe_actas_identificacion").click(function(){
  var opcion = 38; // Usar la misma opción (RelacionActasIdentificacion) para todos
  var reporte = "Informe de Actas a Crédito por cliente";
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

$("#generarreporte_actasporidentificacion, #generarreporte_actascredito").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var identificacion = $("#identificacion_cli").val();
  var estado_acta = $('input:radio[name=estado_acta]:checked').val() || 'todas';
  if (fecha1 == '' || fecha2 == '') {
    alert('Seleccione un rango de fecha.');
    return;
  }
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2,
    "identificacion": identificacion,
    "estado_acta": estado_acta
  };
  var route = "/reporte_actas_identificacion";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informe = info.depositos;
    if (document.getElementById('datos')) {
      CargarInformeActasPorIdentificacion(informe);
    } else if (document.getElementById('data')) {
      CargarInformeActasCredito(informe);
    }
  });
});

function urlExportActasIdentificacionExcelPdf() {
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var identificacion = $("#identificacion_cli").val() || '';
  var estado_acta = $('input:radio[name=estado_acta]:checked').val() || 'todas';
  if (fecha1 == '' || fecha2 == '') {
    alert('Seleccione un rango de fecha.');
    return null;
  }
  return {
    fecha1: fecha1,
    fecha2: fecha2,
    identificacion: identificacion,
    estado_acta: estado_acta
  };
}

function esInformeActasCreditoPorCliente() {
  var titulo = $(".page-header h1").text() || "";
  titulo = titulo.toLowerCase();
  return titulo.indexOf("actas a crédito por cliente") !== -1 ||
         titulo.indexOf("actas a credito por cliente") !== -1;
}

$("#exportar_excel_actas_identificacion, #exportar_excel_actascredito").click(function(e){
  e.preventDefault();
  var p = urlExportActasIdentificacionExcelPdf();
  if (!p) return;

  var esReporteCredito = esInformeActasCreditoPorCliente() || $(this).attr("id") === "exportar_excel_actascredito";
  var estadoExportar = esReporteCredito ? "credito" : p.estado_acta;
  var rutaExportar = esReporteCredito ? "/reporte_actas_credito_excel" : "/reporte_actas_identificacion_excel";

  var url = rutaExportar + "?fecha1=" + encodeURIComponent(p.fecha1)
    + "&fecha2=" + encodeURIComponent(p.fecha2)
    + "&identificacion=" + encodeURIComponent(p.identificacion)
    + "&estado_acta=" + encodeURIComponent(estadoExportar);
  window.open(url, "_blank");
});

$("#imprimir_pdf_actas_identificacion, #imprimir_pdf_actascredito").click(function(e){
  e.preventDefault();
  var p = urlExportActasIdentificacionExcelPdf();
  if (!p) return;
  var url = "/reporte_actas_identificacion_pdf?fecha1=" + encodeURIComponent(p.fecha1)
    + "&fecha2=" + encodeURIComponent(p.fecha2)
    + "&identificacion=" + encodeURIComponent(p.identificacion)
    + "&estado_acta=" + encodeURIComponent(p.estado_acta);
  window.open(url, "_blank");
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

$("#certificadostf").click(function(){
  var opcion = 13;
  var reporte = "Certificado de Retención en la Fuente";
  var ordenar = "nuevos";
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

$("#ingresosexcedentes").click(function(){
  var opcion = 40;
  var reporte = "Relación de ingresos de excedentes otros periodos";
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

$("#informecarterabonosactiva").click(function(){
  var opcion = 33;
  var reporte = "Relación de Cartera Bonos Activos";
  var ordenar = "bonosactivos";
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

$("#interfazdatax").click(function(){

  var opcion = 34;
  var reporte = "Interfaz contable Data X Escrituras";
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

$("#interfazdataxcjrapida").click(function(){

  var opcion = 35;  
  var reporte = "Interfaz contable Data X Caja Rápida";
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

$("#interfazdataxactasdepo").click(function(){

  var opcion = 36;  
  var reporte = "Interfaz contable Data X Actas de Depósito";
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

$("#generararchivodatax").click(function(){

  const checkbox = document.querySelector('input[name="encabezado"]:checked');
  const valorSeleccionado = checkbox ? checkbox.value : null;

  const checkboxnc = document.querySelector('input[name="notacreditoescr"]:checked');
  const valorSeleccionadonc = checkboxnc ? checkboxnc.value : null;


  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2,
    "opcionreporte": valorSeleccionado
  };

  if (valorSeleccionadonc === 'on') {
    url = "/exceldataxnc";  
  } else {
      url = "/exceldatax";  
  }

  __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 1){       
        $("<a>").attr("href", url).attr("target", "_blank")[0].click();
      }
    })
  
});

$("#generararchivodataxcajarapida").click(function(){
  var url;

  const checkbox = document.querySelector('input[name="encabezado"]:checked');
  const valorSeleccionado = checkbox ? checkbox.value : null;

  const checkboxnc = document.querySelector('input[name="notacreditocr"]:checked');
  const valorSeleccionadonc = checkboxnc ? checkboxnc.value : null;

  
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2,
    "opcionreporte": valorSeleccionado
  };

  if (valorSeleccionadonc === 'on') {
    url = "/exceldataxCajarapidaNC";  
  } else {
      url = "/exceldataxCajarapida";  
  }

  __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 1){        
        $("<a>").attr("href", url).attr("target", "_blank")[0].click();
      }
    })
  
});


$("#generararchivodataxactasdepo").click(function(){
  
  const checkbox = document.querySelector('input[name="encabezado"]:checked');
  const valorSeleccionado = checkbox ? checkbox.value : null;  

  
  var route = "/cargarfechas";
  var token = $("#token").val();
  var type = 'GET';
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2,
    "opcionreporte": valorSeleccionado
  };

  var url = "/exceldataxactasdepo";

  __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 1){        
        $("<a>").attr("href", url).attr("target", "_blank")[0].click();
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


$("#carterabonoscliente").click(function(){
  var opcion = 31;
  var reporte = "Relación de cartera Bonos por Cliente";
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

$("#informecarterabonomes").click(function(){
  var opcion = 32;
  var reporte = "Relación de Cartera Bonos por Fecha";
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
  var ordenar = $(this).data('ordenar');
  console.log(ordenar);
  var route = "/cargaridentificacion";
  var token = $("#token").val();
  var type = 'GET';
  var identificacion = $("#identificacion").val();
  var aniogravable = $("#aniogravable").val();
  var datos = {
    "identificacion": identificacion,
    "aniogravable": aniogravable
  };

  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 1){
      if(ordenar == 'nuevos'){
        var url = "/certificadortf";
      }else{
        var url = "/copiacertificadortf";       
      }

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

$("#registrocivil777").click(function(){
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
      var timbreley175_contado = info.timbreley175contado;
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
      var timbreley175_credito = info.timbreley175credito;
      var rtf_credito = info.rtf_credito;
      var deduccion_reteiva_credito = info.deduccion_reteiva_credito;
      var deduccion_reteica_credito = info.deduccion_reteica_credito;
      var deduccion_retertf_credito = info.deduccion_retertf_credito;
      var total_fact_credito = info.total_fact_credito;
      var bonos_es = info.bonos_es;

      CargarCajaDiarioGeneral(cajadiario, total_egreso, cajadiario_otros_periodos, derechos_contado, conceptos_contado, ingresos_contado, iva_contado, recaudos_contado, aporteespecial_contado, impuestotimbre_contado, 
        timbreley175_contado, rtf_contado, deduccion_reteiva_contado, deduccion_reteica_contado, deduccion_retertf_contado,
        total_fact_contado, derechos_credito, conceptos_credito, ingresos_credito, iva_credito, recaudos_credito, aporteespecial_credito,
        impuestotimbre_credito, timbreley175_credito, rtf_credito, deduccion_reteiva_credito, deduccion_reteica_credito,
        deduccion_retertf_credito, total_fact_credito, bonos_es);
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
    $("#Botonexcel").fadeIn();

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
    }else if (seleccion == 'credito') {
      opcionreporte = "credito";
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

$("#generarreportecarterabonosmes").click(function(){

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
      var route = "/informecarterabonos";
      var token = $("#token").val();
      var type = 'GET';

      __ajax(route, token, type, datos)
      .done( function( info ){
        $("#Botonexcel").fadeIn();
        var informecarterabon = info.informecarterabon;
        CargarInformeCarteraBonos(informecarterabon);
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
  var identificacion_cli = $("#identificacion_cli").val();
  var datos = {
    "opcionreporte": opcionreporte,
    "identificacion_cli": identificacion_cli
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

$("#generarreportecarterabonosactivas").click(function(){
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
    var route = "/informecarterabonos";
    var token = $("#token").val();
    var type = 'GET';

    __ajax(route, token, type, datos)
    .done( function( info ){
      $("#Botonexcel").fadeIn();
      var informecarterabon = info.informecarterabon;
      CargarInformeCarteraBonosActivos(informecarterabon);
    })
  }
}else{
  alert("Seleccione tipo de informe");
}

});

$("#repcarterabonoscliente").click(function(){
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
  var route = "/informecarterabonos";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    $("#Botonexcel").fadeIn();
    var informecarterabon = info.informecarterabon;
    CargarInformeCarteraBonos(informecarterabon);
  })
}
}else{
  alert("Seleccione tipo de informe");
}

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
  .done(function(info){

    let data = info.recaudos;

    let filas = [
        {pref: "sinc", tarifa: "valor1"},
        {pref: "exc", tarifa: "valor1b"},
        {pref: "ran1", tarifa: "valor2"},
        {pref: "ran2", tarifa: "valor3"},
        {pref: "ran3", tarifa: "valor4"},
        {pref: "ran4", tarifa: "valor5"},
        {pref: "ran5", tarifa: "valor6"},
        {pref: "ran6", tarifa: "valor7"},
    ];

    filas.forEach((fila, i) => {

        let d = data[i];

        $("#" + fila.pref + "escr").text(d.cant_escr);

        $("#" + fila.pref + "super").text(formatNumbderechos(parseFloat(d.total_super || 0)));
        $("#" + fila.pref + "fondo").text(formatNumbderechos(parseFloat(d.total_fondo || 0)));

        $("#" + fila.tarifa).text(formatNumbderechos(parseFloat(d.tarifa || 0)));

        $("#" + fila.pref + "total").text(formatNumbderechos(parseFloat(d.total || 0)));
    });

    let t = data[8];

    $("#total_escrituras").text(t.cant_escr);
    $("#total_super").text(formatNumbderechos(parseFloat(t.total_super || 0)));
    $("#total_fondo").text(formatNumbderechos(parseFloat(t.total_fondo || 0)));
    $("#total_recaudos").text(formatNumbderechos(parseFloat(t.total || 0)));

  });

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

$("#excelcarteraclientebonos").click(function(){
  var url = "/excelcarteraclientebonos";
  $("<a>").attr("href", url).attr("target", "_blank")[0].click();
});

$("#generarreporteespecial").click(function(){
  var url = "/cajadiarioespecial";
  $("<a>").attr("href", url).attr("target", "_blank")[0].click();
});



$("#excelnotcredi").click(function(){
  var url = "/excelnotascredito";
  $("<a>").attr("href", url).attr("target", "_blank")[0].click();
});


$("#excelcarteraxfechbonos").click(function(){
  var url = "/excelcarterafechabonos";
  $("<a>").attr("href", url).attr("target", "_blank")[0].click();
});


$("#excelcarteraclientebonosacti").click(function(){
  var url = "/excelcarteraclientebonosacti";
  $("<a>").attr("href", url).attr("target", "_blank")[0].click();
});



$("#excelreteaplicada").click(function(){

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
        var url = "/excelretencionesaplicadas";
        $("<a>").attr("href", url).attr("target", "_blank")[0].click();
      }
    })
  
});


$("#ExcNotCrCjRapid").click(function(){

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
        var url = "/exnotcredcajarap";
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

$("#trazabilidad_egreso").click(function(){
  var opcion = 41;
  var reporte = "Trazabilidad de Egreso";
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


$("#pruebafer").click(function(){
  var opcion = 37;
  var reporte = "Prueba Fer";
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


$("#cuentasdecobrogeneradas").click(function(){
  var opcion = 30;
  var reporte = "Cuentas de Cobro Generadas";
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


$("#cuentasdecobro_generadas").click(function(){
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
    "fecha1": fecha1,
    "fecha2": fecha2
  };
  var route = "/cuentas_cobro_generadas";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var ccg = info.cuenta_cobro_escr;    
    CargarCuentasCobroGeneradas(ccg);
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


function obtenerParametrosInformeEgresos() {
  if (document.querySelector('input[name="seleccion"]:checked')) {
    var opcionreporte = '';
    var seleccion = $('input:radio[name=seleccion]:checked').val();
    if (seleccion == 'maycero') {
      opcionreporte = "maycero";
    } else if (seleccion == 'completo') {
      opcionreporte = "completo";
    } else if (seleccion == 'credito') {
      opcionreporte = "credito";
    }

    if($("#start").val() == '' || $("#end").val() == ''){
      alert("Todos los campos son necesarios");
      return null;
    }else{

      var fecha1 = $("#start").val();
      var fecha2 = $("#end").val();
      var identificacion = ($("#identificacion_cli").val() || '').trim();
      return {
        "fecha1": fecha1,
        "fecha2": fecha2,
        "opcionreporte": opcionreporte,
        "identificacion": identificacion
      };
    }
  }else{
    alert("Seleccione tipo de informe");
    return null;
  }
}

$("#generarreporte_egresos").off("click").on("click", function(){
  var datos = obtenerParametrosInformeEgresos();
  if (!datos) return;

  var route = "/reporte_egresos";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informe = info.egresos;
    CargarInformeEgresos(informe);
  });
});

$("#exportar_excel_egresos").off("click").on("click", function(e){
  e.preventDefault();
  var datos = obtenerParametrosInformeEgresos();
  if (!datos) return;

  var url = "/reporte_egresos_excel?fecha1=" + encodeURIComponent(datos.fecha1)
    + "&fecha2=" + encodeURIComponent(datos.fecha2)
    + "&opcionreporte=" + encodeURIComponent(datos.opcionreporte)
    + "&identificacion=" + encodeURIComponent(datos.identificacion);

  window.open(url, "_blank");
});

$('a[href="/relaciondeegresosdiariospdf"]').off("click").on("click", function(e){
  var datos = obtenerParametrosInformeEgresos();
  if (!datos) {
    e.preventDefault();
    return;
  }
  var url = "/relaciondeegresosdiariospdf?fecha1=" + encodeURIComponent(datos.fecha1)
    + "&fecha2=" + encodeURIComponent(datos.fecha2)
    + "&opcionreporte=" + encodeURIComponent(datos.opcionreporte)
    + "&identificacion=" + encodeURIComponent(datos.identificacion);
  $(this).attr("href", url);
});

function obtenerParametrosTrazabilidadEgreso() {
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
  var identificacion = ($("#identificacion_cli").val() || '').trim();
  var tipo_acta = $('input:radio[name=tipo_acta_egreso]:checked').val() || 'todas';
  if (fecha1 == '' || fecha2 == '') {
    alert('Seleccione un rango de fecha.');
    return null;
  }
  return {
    fecha1: fecha1,
    fecha2: fecha2,
    identificacion: identificacion,
    tipo_acta: tipo_acta
  };
}

$("#generarreporte_trazabilidadegreso").off("click").on("click", function(e){
  e.preventDefault();
  var p = obtenerParametrosTrazabilidadEgreso();
  if (!p) return;

  var route = "/reporte_trazabilidad_egreso";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, p)
  .done( function( info ){
    CargarTrazabilidadEgreso(info.trazabilidad || []);
  });
});

$("#exportar_excel_trazabilidadegreso").off("click").on("click", function(e){
  e.preventDefault();
  var p = obtenerParametrosTrazabilidadEgreso();
  if (!p) return;
  var url = "/reporte_trazabilidad_egreso_excel?fecha1=" + encodeURIComponent(p.fecha1)
    + "&fecha2=" + encodeURIComponent(p.fecha2)
    + "&identificacion=" + encodeURIComponent(p.identificacion)
    + "&tipo_acta=" + encodeURIComponent(p.tipo_acta);
  window.open(url, "_blank");
});

$("#imprimir_pdf_trazabilidadegreso").off("click").on("click", function(e){
  e.preventDefault();
  var p = obtenerParametrosTrazabilidadEgreso();
  if (!p) return;
  var url = "/reporte_trazabilidad_egreso_pdf?fecha1=" + encodeURIComponent(p.fecha1)
    + "&fecha2=" + encodeURIComponent(p.fecha2)
    + "&identificacion=" + encodeURIComponent(p.identificacion)
    + "&tipo_acta=" + encodeURIComponent(p.tipo_acta);
  window.open(url, "_blank");
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
