$("#GuardarReportado").click(function() {
	var identificacion_rep, nombre_rep, concepto_rep, activo, id_tipo_rep;
	identificacion_rep = $("#identificacion").val();
	nombre_rep = $("#nombre").val();
	concepto_rep = $("#concepto").val();
	activo = $("#estado").val();
	id_tipo_rep = $("#tipo").val();

	/*Valida si existe el reportado*/

	var route = "/validarreportados";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
    	"identificacion_rep": identificacion_rep
    	};
    __ajax(route, token, type, datos)
    .done(function(info) {
    	if(info.validar == 1){
    		alert(info.mensaje);
    		CargarGridReportados(info.reportado);
    	}else if(info.validar == 0){
    		var route2 = "/reportados";
    		var token2 = $("#token").val();
    		var type2 = 'POST';
    		var datos2 = {
    			"identificacion_rep": identificacion_rep,
    			"nombre_rep": nombre_rep,
    			"id_tipo_rep": id_tipo_rep,
    			"concepto_rep": concepto_rep,
    			"activo": activo
    		};
        	__ajax(route2, token2, type2, datos2)
    		.done(function(info) {
    			alert("Muy bien! Se ha guardado un nuevo registro");
    			CargarGridReportados(info.reportado);
    		})

    	}
    	
            })

});

$("#ActualizarReportado").click(function() {
	var nombre = $("#nombre").val();
    var identifi = $("#identificacion").val();
    var id_tip = $("#tipo").val();
    var concepto = $("#concepto").val();
    var activ = $("#estado").val();
    var id = $("#id_reportado").val();
    var route = "/reportados/" + id;
    var token = $("#token").val();
    var type = 'PUT';
    var datos = {
        "id" : id,
        "nombre_rep" : nombre,
        "identificacion_rep" : identifi,
        "id_tipo_rep" : id_tip,
        "concepto_rep" : concepto,
        "activo" : activ
       };

    __ajax(route, token, type, datos)
     .done(function(info) {
     	$("#boton_guardar").fadeIn();
        $("#boton_actualizar").fadeOut();
        $("#identificacion").val('');
		$("#nombre").val('');
		$("#concepto").val('');
		$("#estado").val('');
		$("#tipo").val('');
     	CargarGridReportados(info.reportado);
    })
});

function EliminarReportado(id) {
	var id_reg = id.value;
	var route = "/reportados/" + id_reg;
	var token = $("#token").val();
    var type = 'DELETE';
    var datos = {
        "id" : id_reg
       }
    __ajax(route, token, type, datos)
     .done(function(info) {
        $("#boton_guardar").fadeIn();
        $("#boton_actualizar").fadeOut();
        $("#identificacion").val('');
        $("#nombre").val('');
        $("#concepto").val('');
        $("#estado").val('');
        $("#tipo").val('');
     	CargarGridReportados(info.reportado);
    })
}