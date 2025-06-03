$("#imprimir").click(function() {

	//GenerarPdf();
	// =============================================
    // =       Enviar Factura electronica          =
    // =============================================
  
    var opcion = "F1";
    var num_fact = $("#numfactrapida").val();
    var route = "/enviarfacturacajarapida";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
    	"num_fact": num_fact,
    	"opcion": opcion
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
    	if(info.status == 1){
    		var mensaje = info.mensaje;
    		var opcion2 = info.opcion2;
            
            GenerarPdf();
            
            //----------  Enviar email  ----------//

            route = "/enviarcorreo";
            datos = {
            	"num_fact": num_fact,
                "opcion": opcion,
                "email_cliente":info.email_cliente,
                "opcion2":opcion2
                };
            __ajax(route, token, type, datos)
            .done(function(info) {
            	$("#informacion").html("Muy bien! Factura Enviada y Generada");
            	$("#mod_factelectronica").modal('toggle');
            })
        }else if(info.status == 0){
        	//Genera Comprovante PDF
            GenerarPdf();
            $("#informacion").html(info.mensaje);
            $("#mod_factelectronica").modal('toggle');
         }
    })
});

function GenerarPdf(){
    botonnuevo.style.display = "block";
    impresora.style.display = "none";
    //botonagregar.style.display = "none";
	var url = "/facturacajarapidapdf";
	//$("<a>").attr("href", url).attr("target", "_blank")[0].click(); 
     // Abrir en nueva ventana y guardarla en una variable
    var nuevaVentana = window.open(url, '_blank');

    // Espera 10 segundos y luego cierra la ventana
    setTimeout(function() {
        if (nuevaVentana) {
            nuevaVentana.close();
        }
    }, 10000); // 3000 milisegundos = 3 segundos

}


$("#imprimircajarapida").click(function() {

    //GenerarPdfCajaRapida();
    // =============================================
    // =       Enviar Factura electronica          =
    // =============================================

    var opcion = "F1";
    var num_fact = $("#numfactrapida").val();
    var route = "/enviarfacturacajarapida";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "num_fact": num_fact,
        "opcion": opcion
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
        if(info.status == 1){
            var mensaje = info.mensaje;
            var opcion2 = info.opcion2;
            
            GenerarPdfCajaRapida();
            
            //----------  Enviar email  ----------//

            route = "/enviarcorreo";
            datos = {
                "num_fact": num_fact,
                "opcion": opcion,
                "email_cliente":info.email_cliente,
                "opcion2":opcion2
                };
            __ajax(route, token, type, datos)
            .done(function(info) {
                $("#informacion").html("Muy bien! Factura Enviada y Generada");
                $("#mod_factelectronica").modal('toggle');
            })
        }else if(info.status == 0){
            //Genera Comprovante PDF
            GenerarPdf();
            $("#informacion").html(info.mensaje);
            $("#mod_factelectronica").modal('toggle');
         }
    })
});

function GenerarPdfCajaRapida(){
    botonvalidar.style.display = "block";
    impresora.style.display = "none";
    var url = "/facturacajarapidapdf";
    $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    
}

