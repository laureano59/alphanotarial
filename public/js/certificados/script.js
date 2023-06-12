$("#certitimbre").click(function() {
	$("#guycertificadoretefuente").fadeOut();
	$("#guycertificadotimbre").fadeIn();
});

$("#certirtf").click(function() {
	$("#guycertificadotimbre").fadeOut();
	$("#guycertificadoretefuente").fadeIn();
});

$("#imprimircertificadotimbre").click(function() {

	
	var num_factura = $("#num_factura").val();
	var anio_fiscal = $("#anio_fiscal").val();
	var tipo_certificado = 1;

	var route = "/existefactura";
  	var token = $("#token").val();
  	var type = 'GET';
  	var datos = {
    	"num_factura": num_factura,
    	"anio_trabajo": anio_fiscal,
    	"tipo_certificado": tipo_certificado
  	};

  	__ajax(route, token, type, datos)
  	.done( function( info ){
    	if(info.validar == 0){
        	$("#msj1").html(info.mensaje);
              $("#msj-error1").fadeIn();
              setTimeout(function() {
                  $("#msj-error1").fadeOut();
              }, 3000);
    	}else if(info.validar == 1){
    		var url = "/certificado_impuesto_timbre";
      		$("<a>").attr("href", url).attr("target", "_blank")[0].click();

    	}
  	})
	
});


$("#imprimircertificadoretefuente").click(function() {

	
	var num_factura = $("#num_factura2").val();
	var anio_fiscal = $("#anio_fiscal2").val();
	var tipo_certificado = 2;

	var route = "/existefactura";
  	var token = $("#token").val();
  	var type = 'GET';
  	var datos = {
    	"num_factura": num_factura,
    	"anio_trabajo": anio_fiscal,
    	"tipo_certificado": tipo_certificado
  	};

  	__ajax(route, token, type, datos)
  	.done( function( info ){
    	if(info.validar == 0){
        	$("#msj2").html(info.mensaje);
              $("#msj-error2").fadeIn();
              setTimeout(function() {
                  $("#msj-error2").fadeOut();
              }, 3000);
    	}else if(info.validar == 1){
    		var url = "/certificado_impuesto_timbre";
      		$("<a>").attr("href", url).attr("target", "_blank")[0].click();

    	}
  	})
	
});




