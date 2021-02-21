$("#cambiar_protocolista").click(function() {
	var opcion = 1;
	var route = "/sessiones_protocolista";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
    	"opcion": opcion
  	};

  	__ajax(route, token, type, datos)
  	.done( function( info ){
    	if(info.validar == 1){
        	location.href="/panel_protocolistas";
    	}
  	})
});

$("#guardar").click(function() {
  var anio_radica = $("#anio_radica").val();
  var id_radica = $("#id_radica").val();
  var id_proto = $("#id_proto").val();
  
  if(id_proto === null){
    id_proto = '';
  }

  if(anio_radica != '' && id_radica != '' && id_proto != ''){
    var id = id_radica;
    var route = "/radicacion/" + id;
    var token = $("#token").val();
    var type = 'PUT';
    var datos = {
      "id": id,
      "anio_radica": anio_radica,
      "id_radica": id_radica,
      "id_proto": id_proto
    };

    __ajax(route, token, type, datos)
    .done( function( info ){
      if(info.validar == 1){
          $("#msj").html(info.mensaje);
          $("#msj-error").fadeIn();
          setTimeout(function() {
          $("#msj-error").fadeOut();
          }, 3000);
        }
    })
    
  }else{
    alert("Todos los campos son obligatorios");
  }


});