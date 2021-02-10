$("#guardar").click(function(){
  var anio_radica = $("#anio_radica").val();
  var id_proto = $("#id_proto").val();
  var datos = {"anio_radica": anio_radica, "id_proto": id_proto};
  var route = "/radicacion";
  var token = $("#token").val();

  if(id_proto != null){

    var type = 'POST';
  __ajax(route, token, type, datos)
  .done( function( info ){
    $("#id_radica").val(info.idradica);
    var id_radica = info.idradica;
    route = "/sessiones";
    type = 'GET';
    datos = {"id_radica": id_radica};

    __ajax(route, token, type, datos)
    .done( function( info ){

    })
  })

  }else{
    alert("Seleccione un protocolista");
  }
  
});
