$("#mostrarfactura").click(function(){
  var num_factura = $("#id_fact").val();
  var route = "/existefactura";
  var type = 'GET';
  var token = $("#token").val();
  //var anio_trabajo = 2025;//$("#anio_fiscal").val(2025);
  var datos = { 
    "num_factura": num_factura
    //"anio_trabajo": anio_trabajo
};
__ajax(route, token, type, datos)
.done(function(info) {
    if(info.validar == 1){
      //var url = "/copiafactura";
      //$("<a>").attr("href", url).attr("target", "_blank")[0].click();

      var url = "/copiafactura";
      document.getElementById('pdfIframe').src = url;
      $('#pdfModal').modal('show');

  }else if(info.validar == 0){
      $("#msj1").html(info.mensaje);
      $("#msj-error1").fadeIn();
      setTimeout(function() {
          $("#msj-error1").fadeOut();
      }, 3000);
  }
})

  });

$("#notacredito").click(function(){
  var id_fact, detalle_ncf;
  id_fact = $("#id_fact").val();
  detalle_ncf = $("#detalle_ncf").val();
  if(id_fact != '' && detalle_ncf !=''){
    var datos = {
      "id_fact": id_fact,
    };
    var route = "/facturacion/"+id_fact;
    var token = $("#token").val();
    var type = 'PUT';
    __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 0){
        $("#msj1").html(info.mensaje);
        $("#msj-error1").fadeIn();
        setTimeout(function() {
        $("#msj-error1").fadeOut();
        }, 3000);
      }else if(info.validar == 1){
        datos = {
          "id_fact": id_fact,
          "detalle_ncf": detalle_ncf
        };
        route = "/notascreditofact";
        token = $("#token").val();
        type = 'POST';
        __ajax(route, token, type, datos)
        .done( function( info ){
          if(info.validar == 1){
            var id_ncf = info.id_ncf;
            id_fact = info.id_ncf;

            // =============================================
            // =       Enviar Factura electronica          =
            // =============================================

            var opcion = "NC";
            var num_fact = id_fact;
            var route = "/enviarfactura";
            var token = $("#token").val();
            var type = 'GET';
            var datos = {
              "num_fact": id_fact,
              "opcion": opcion
              };

            __ajax(route, token, type, datos)
              .done(function(info) {
                if(info.status == 1){
                  var mensaje = info.mensaje;
                  var opcion2 = info.opcion2;
                  //Genera Factura PDF
                  var url1 = "/notacreditopdf";
                  $("<a>").attr("href", url1).attr("target", "_blank")[0].click();
                  $("#id_ncf").html(id_ncf);
                  $("#msj").html(info.mensaje);
                  $("#msj-error").fadeIn();
                  setTimeout(function() {
                    $("#msj-error").fadeOut();
                  }, 3000);

                $("#informacion").html("Muy bien! Nota Credito Enviada y Generada");
                $("#mod_factelectronica").modal('toggle');
                                  
                 

                }else if(info.status == 0){
                  //Genera Comprovante PDF
                  //pdfFacturaUnica();
                  alert(info.mensaje);
                  $("#informacion").html(info.mensaje);
                  $("#mod_factelectronica").modal('toggle');
                                }
              })//AJAX Envoice
            
          } else if(info.validar == 0){
            $("#msj1").html(info.mensaje);
            $("#msj-error1").fadeIn();
            setTimeout(function() {
            $("#msj-error1").fadeOut();
            }, 3000);
          }
        })//AJAX notascredito
      } else if(info.validar == 7){
          $("#msj1").html(info.mensaje);
          $("#msj-error1").fadeIn();
          setTimeout(function() {
          $("#msj-error1").fadeOut();
          }, 3000);
      }
    })//AJAX Factura

  }else{
    alert("Falta rellenar campos");
  }
});


$("#notacreditocajarapida").click(function(){
  var id_fact, detalle_ncf;
  id_fact = $("#id_fact").val();
  detalle_ncf = $("#detalle_ncf").val();
  if(id_fact != '' && detalle_ncf !=''){
    var datos = {
      "id_fact": id_fact,
    };
    var route = "/notacreditocajarapida/"+id_fact;
    var token = $("#token").val();
    var type = 'PUT';
    __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 0){
        $("#msj1").html(info.mensaje);
        $("#msj-error1").fadeIn();
        setTimeout(function() {
        $("#msj-error1").fadeOut();
        }, 3000);
      }else if(info.validar == 1){
        datos = {
          "id_fact": id_fact,
          "detalle_ncf": detalle_ncf
        };
        route = "/notacreditocajarapida";
        token = $("#token").val();
        type = 'POST';
        __ajax(route, token, type, datos)
        .done( function( info ){
          if(info.validar == 1){
            var id_ncf = info.id_ncf;
            id_fact = info.id_fact;
            // =============================================
            // =       Enviar Factura electronica          =
            // =============================================

            var opcion = "NC";
            var num_fact = id_fact;
            var route = "/enviarfacturacajarapida";
            var token = $("#token").val();
            var type = 'GET';
            var datos = {
              "num_fact": id_fact,
              "opcion": opcion
              };

            __ajax(route, token, type, datos)
              .done(function(info) {
                if(info.status == 1){
                  var mensaje = info.mensaje;
                  var opcion2 = info.opcion2;
                  //Genera Factura PDF
                  var url1 = "/copianotacreditocajarapidapdf";
                  $("<a>").attr("href", url1).attr("target", "_blank")[0].click();
                  $("#id_ncf").html(id_ncf);
                  $("#msj").html(info.mensaje);
                  $("#msj-error").fadeIn();
                  setTimeout(function() {
                    $("#msj-error").fadeOut();
                  }, 3000);

                $("#informacion").html("Muy bien! Nota Credito Enviada y Generada");
                $("#mod_factelectronica").modal('toggle');


                }else if(info.status == 0){
                  //Genera Comprovante PDF
                  //pdfFacturaUnica();
                  alert(info.mensaje);
                  $("#informacion").html(info.mensaje);
                  $("#mod_factelectronica").modal('toggle');
                                }
              })//AJAX Envoice
            
          } else if(info.validar == 0){
            $("#msj1").html(info.mensaje);
            $("#msj-error1").fadeIn();
            setTimeout(function() {
            $("#msj-error1").fadeOut();
            }, 3000);
          }
        })//AJAX notascredito
      } else if(info.validar == 7){
          $("#msj1").html(info.mensaje);
          $("#msj-error1").fadeIn();
          setTimeout(function() {
          $("#msj-error1").fadeOut();
          }, 3000);
      }
    })//AJAX Factura

  }else{
    alert("Falta rellenar campos");
  }
});



