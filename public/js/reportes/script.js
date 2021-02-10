$("#ron").click(function(){

  var opcion = 12;
  var reporte = "Reporte de Operaciones Notariales (RON)";
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
  var reporte = "Relación de Facturas Diarias";
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
  var reporte = "Relación de Facturas Mensual";
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
  var reporte = "Libro Índice";
  var ordenar = "libroindice";
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



$("#libroalfabetico").click(function(){
  var opcion = 2;
  var reporte = "Libro Alfabético Notarial";
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


$("#informerecaudos").click(function(){
  var opcion = 11;
  var reporte = "Informe de Recaudos Mes";
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
  var reporte = "Informe de Recaudos Caja";
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
  var reporte = "Notas Crédito Mensual";
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
  var reporte = "Notas Crédito Diario";
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
  var reporte = "Relación de Facturas Diarias por Conceptos";
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
  var reporte = "Relación de Conceptos por Mes";
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

$("#enlaces").click(function(){
  var opcion = 7;
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
        var cruces = info.cruces;
        var total_egreso = info.total_egreso;
        CargarCajaDiarioGeneral(cajadiario, total_egreso);
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
    CargarLibroIndice(libroindice);
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
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();

  var datos = {
      "fecha1": fecha1,
      "fecha2": fecha2
  };
  var route = "/informecartera";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informecartera = info.informecartera;
    CargarInformeCartera(informecartera);
  })
});

$("#generarreportecarteracliente").click(function(){
  var identificacion_cli = $("#identificacion_cli").val();
  
  var datos = {
      "identificacion_cli": identificacion_cli
  };
  var route = "/informecartera";
  var token = $("#token").val();
  var type = 'GET';

  __ajax(route, token, type, datos)
  .done( function( info ){
    var informecartera = info.informecartera;
    CargarInformeCartera(informecartera);
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
