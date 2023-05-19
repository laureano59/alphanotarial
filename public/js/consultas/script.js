$(document).ready(function() {
    $('#radicaciones').DataTable();
} );

$("#buscar").click(function(){
  if (document.querySelector('input[name="seleccion"]:checked')) {
    var tipoconsulta = '';
    var seleccion = $('input:radio[name=seleccion]:checked').val();
    if (seleccion == 'radicacion') {
      tipoconsulta = "radicacion";
    }else if (seleccion == 'factura') {
      tipoconsulta = "factura";
    }else if (seleccion == 'escritura') {
      tipoconsulta = "escritura";
    }else if (seleccion == 'otorgante') {
      tipoconsulta = "otorgante";
  	}else if (seleccion == 'compareciente') {
      tipoconsulta = "compareciente";
    }else if (seleccion == 'protocolista') {
      tipoconsulta = "protocolista";
  	}else if (seleccion == 'usuario') {
      tipoconsulta = "usuario";
  	}


    var anio = $("#anio").val();


  	$("#tipo_filtro").html(tipoconsulta);

  	var buscar = $("#buscar_info").val();

  	var datos = {
      "filtro": tipoconsulta,
      "anio": anio,
      "info": buscar
    };

  	var route = "/seguimiento";
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


$("#buscar_secun").click(function(){
  if (document.querySelector('input[name="seleccion"]:checked')) {
    var tipoconsulta = '';
    var seleccion = $('input:radio[name=seleccion]:checked').val();
    if (seleccion == 'radicacion') {
      tipoconsulta = "radicacion";
    }else if (seleccion == 'factura') {
      tipoconsulta = "factura";
    }else if (seleccion == 'escritura') {
      tipoconsulta = "escritura";
    }else if (seleccion == 'otorgante') {
      tipoconsulta = "otorgante";
    }else if (seleccion == 'compareciente') {
      tipoconsulta = "compareciente";
    }else if (seleccion == 'protocolista') {
      tipoconsulta = "protocolista";
    }else if (seleccion == 'usuario') {
      tipoconsulta = "usuario";
    }


    var anio = $("#anio").val();


    $("#tipo_filtro").html(tipoconsulta);

    var buscar = $("#buscar_info").val();

    var datos = {
      "filtro": tipoconsulta,
      "anio": anio,
      "info": buscar
    };

    var route = "/seguimiento_secun";
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
