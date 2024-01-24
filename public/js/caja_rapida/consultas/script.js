$("#buscar").click(function(){
  if (document.querySelector('input[name="seleccion"]:checked')) {
    var tipoconsulta = '';
    var seleccion = $('input:radio[name=seleccion]:checked').val();
    if (seleccion == 'factura') {
      tipoconsulta = "factura";
    }else if (seleccion == 'identificacion') {
      tipoconsulta = "identificacion";
    }else if (seleccion == 'nombre') {
      tipoconsulta = "nombre";
  	}else if (seleccion == 'usuario') {
      tipoconsulta = "Facturador";
    }

    var anio = $("#anio").val();


  	$("#tipo_filtro").html(tipoconsulta);

  	var buscar = $("#buscar_info").val();

  	var datos = {
      "filtro": tipoconsulta,
      "anio": anio,
      "info": buscar
    };

  	var route = "buscarencajarapida";
    var token = $("#token").val();
    var type = 'GET';

    __ajax(route, token, type, datos)
      .done( function( info ){
      	var consulta = info.consulta;
      	CargarConsulta(consulta);
    })

  }else{
    alert("Seleccione el filtro");
  }

 });