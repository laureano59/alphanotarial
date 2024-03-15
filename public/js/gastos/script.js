$("#guardargasto").click(function() {
	var concepto, valor_gasto, autoriza;
	concepto = $("#concepto").val();
	valor_gasto = $("#valor_gasto").val();
	autoriza = $("#autoriza").val();
	
	/*Validar Nulos*/

	if(concepto == '' || valor_gasto == '' || autoriza == ''){
		alert("Todos los campos son obligatorios");
	}else{
		var route = "/gastos_notaria";
		var token = $("#token").val();
		var type = 'POST';
		var datos = {
			"concepto": concepto,
			"valor_gasto": valor_gasto,
			"autoriza": autoriza
		};
		__ajax(route, token, type, datos)
		.done(function(info) {
			$("#btnguardar").fadeOut();
			$("#btnnuevo").fadeIn();
			document.getElementById('id_gas').innerHTML = info.id_gas;
			alert("Muy bien! Se ha guardado un nuevo registro");
			$("#btnimprimir").fadeIn();
			CargarGridGastos(info.gasto);
		})
	}
});


$("#nuevogasto").click(function() {
	
	document.getElementById('id_gas').innerHTML = '';
	$("#btnguardar").fadeIn();
    $("#btnnuevo").fadeOut();
    $("#boton_actualizar").fadeOut();
    $("#btnimprimir").fadeOut();

	$("#concepto").val('');
	$("#valor_gasto").val('');
	$("#autoriza").val('');
	window.location.reload();
});

$("#ActualizarGasto").click(function() {
	var concepto, valor_gasto, autoriza, id;
	concepto = $("#concepto").val();
	valor_gasto = $("#valor_gasto").val();
	autoriza = $("#autoriza").val();
	id = $("#id_update").val();

   	var route = "/gastos_notaria/" + id;
	var token = $("#token").val();
	var type = 'PUT';
	var datos = {
		"concepto": concepto,
		"valor_gasto": valor_gasto,
		"autoriza": autoriza
	};

    __ajax(route, token, type, datos)
     .done(function(info) {
     	$("#btnguardar").fadeOut();
     	$("#boton_actualizar").fadeOut();
    	$("#btnnuevo").fadeIn();
		$("#concepto").val('');
		$("#valor_gasto").val('');
		$("#autoriza").val('');
     	CargarGridGastos(info.gasto);
    })
});


$("#buscarpornumrecibo").click(function() {

	document.getElementById('id_gas').innerHTML = '';
	var id_gas = $("#id_gastos").val();

	var route = "consultar_gasto";
	var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_gas" : id_gas
       }
    __ajax(route, token, type, datos)
     .done(function(info) {
     	$("#btnimprimir").fadeIn();
        CargarGridGastos(info.gasto);
    })
});