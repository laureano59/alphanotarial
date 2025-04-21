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

function ImpuestoTimbreC() {
  var cuantia = parseFloat($("#cuantia").val());
  let id_acto = document.getElementById('id_acto').value;
  
        var datos = {
        "id_acto": id_acto
      };
      var route = "/validartimbrec";
      var token = $("#token").val();
      var type = 'GET';
      __ajax(route, token, type, datos)
      .done( function( info ){

        if(info.timbrecata == 1){
          route = "/validar_tarifa";
          token = $("#token").val();
          type = 'GET';
          __ajax(route, token, type, datos)
          .done( function( info ){

            var timbreuvt = parseFloat(info.timbrec);
            
            if(cuantia >= timbreuvt){
              
              if (confirm("Cuantía superior a 6000UVT Decreto 175 del 2025 ¿Es Comerciante o persona jurídica?")) {
                 if (confirm("¿Su patrimonio es superior a $1.411.950.000?")){

                  var timbredecreto175 = cuantia * 0.01;
                  $("#timbredecreto175").val(timbredecreto175);

                 }else{
                  $("#timbredecreto175").val(0);
                 }
              } else {
                $("#timbredecreto175").val(0);
              }
            }else{
              $("#timbredecreto175").val(0);
            }

          })

        }else{
          //No pasa nada porque no tiene timbreC
        }
      })
     
}
