$("#buscar_fact").click(function(){
	var num_factura = $("#id_fact").val();
  	var route = "/existefactura";
  	var type = 'GET';
  	var token = $("#token").val();
  	var datos = { "num_factura": num_factura };
  	__ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
        	route = "/cargarfacturanotadebito";
        	__ajax(route, token, type, datos)
      		  .done(function(info) {
      		  	if(info.validar == 1){
      		  		CargarFactura(info.factura);
      		  	}
      		})

        }else if(info.validar == 0){
          $("#msj1").html(info.mensaje);
          $("#msj-error1").fadeIn();
          setTimeout(function() {
              $("#msj-error1").fadeOut();
          }, 3000);
        }
      })

});

function CargarFactura(validar){
	var htmlTags = "";
	for (item in validar) {
		htmlTags +=
        '<tr>'+
        '<td>'+
        validar[item].id_fact +
        '</td>'+
        '<td>'+
        validar[item].fecha_fact +
        '</td>'+
        '<td>'+
        validar[item].identificacion_cli +
        '</td>'+
        '<td>'+
        validar[item].cliente +
        '</td>'+
        '<td>'+
        formatNumbderechos(validar[item].total_fact) +
        '</td>'+
        '</tr>';
    }
   
    document.getElementById('data').innerHTML = htmlTags;
    
}



$("#crear_notadebito").click(function(){
	var id_fact = $("#id_fact").val();
	if(id_fact != ''){
		var num_factura = $("#id_fact").val();
  		var route = "/existefactura";
  		var type = 'GET';
  		var token = $("#token").val();
  		var datos = { "num_factura": num_factura };
  		__ajax(route, token, type, datos)
      		.done(function(info) {
        		if(info.validar == 1){//Si existe la factura
        			type = 'POST';
        			route = "/notasdebitofact";
        			__ajax(route, token, type, datos)
      		  		.done(function(info) {
      		  			if(info.validar == 1){
      		  				$("#id_notadebito").val(info.id_ndf);
      		  				$("#id_ndf").html(info.id_ndf);
      		  			}
      				})

        		}else if(info.validar == 0){
          			$("#msj1").html(info.mensaje);
          			$("#msj-error1").fadeIn();
          			setTimeout(function() {
              			$("#msj-error1").fadeOut();
          			}, 3000);
        		}
      	})
	}else{
		alert("Primero debes buscar una factura");
	}

});

$("#agregarconcepto").click(function(){
	var id_ndf = $("#id_notadebito").val();
	var cantidad = $("#cant").val();
    var id_conc = $("#id_conc").val();

    if(id_ndf != '' && cantidad != '' && id_conc != ''){
    	var route = "/detallenotadebito";
  		var type = 'POST';
  		var token = $("#token").val();
  		var datos = { 
  			"id_ndf": id_ndf,
  			"cantidad": cantidad,
  			"id_conc": id_conc
  		};

  		__ajax(route, token, type, datos)
    		.done(function(info) {
    			if(info.validar == 1){
    				CargarDetalleNotaDebito(info.detalle);
    			}
    		})

    }else{
    	alert("Es neceseario llenar todos los campos");
    }
     
});


function CargarDetalleNotaDebito(validar){
	var htmlTags2 = "";
	for (item in validar) {
		htmlTags2 +=
        '<tr>'+
        '<td>'+
        validar[item].id_detnd +
        '</td>'+
        '<td>'+
        validar[item].concepto +
        '</td>'+
        '<td>'+
        validar[item].cantidad_concepto +
        '</td>'+
        '<td>'+
        formatNumbderechos(validar[item].valor_concepto) +
        '</td>'+
        '<td>'+
        formatNumbderechos(validar[item].subtotal) +
        '</td>'+
        '<td>'+
        formatNumbderechos(validar[item].iva) +
        '</td>'+
        '<td>'+
        formatNumbderechos(validar[item].total_concepto) +
        '</td>'+
        '<td>' +
            '<div class="hidden-sm hidden-xs btn-group">' +
            '<button class="btn btn-xs btn-danger" title="Eliminar" value=' + '"' + validar[item].id_detnd + '"' + 'OnClick="Eliminaritem(this);">' +
            '<i class="ace-icon fa fa-trash-o bigger-120"></i>' +
            '</button>' +
            '</div>' +
            '</td>' +
        '</tr>';
    }
   
    document.getElementById('detalle').innerHTML = htmlTags2;

}

function Eliminaritem(id){
	var id_detnd = id.value;
	var id_ndf = $("#id_notadebito").val();
	var type = 'DELETE';
  	var token = $("#token").val();
  	var route = "/detallenotadebito/" + id_detnd;
  	var datos = { 
  			"id_ndf": id_ndf
  		};
 		
  	__ajax(route, token, type, datos)
    	.done(function(info) {
    		if(info.validar == 1){
    			CargarDetalleNotaDebito(info.detalle);
    		}
    	})
}


$("#enviar_nota_debito").click(function(){
	var opcion = "ND";
	var type = 'GET';
  	var token = $("#token").val();
  	var route = "/enviarnotadebito";
  	var datos = { 
  			"opcion": opcion
  		};

  	__ajax(route, token, type, datos)
    	.done(function(info) {
   		
    		
    	})
});


