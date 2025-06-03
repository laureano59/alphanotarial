var detalle = [];

$("#agregaritem").click(function() {
  
  var cantidad = $("#cantidad").val();
  var serial = $("#serial").val();
  
  if(cantidad != '' && cantidad != null  && serial != '' && serial != null){
    var serial = $("#serial").val();
    var id_concepto;
    id_concepto = $("#id_concepto").val();

    var route = "/agregaritemcajarapida";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
      "id_concepto": id_concepto,     
      "cantidad": cantidad,
    };

    __ajax(route, token, type, datos)
    .done(function(info) {
      if(info.validar == 1){
        var nombre_concep;
        nombre_concep = info.nombre_concep;
        var nuevo = 
        {
          "id_concep":id_concepto,
          "nombre_concep":nombre_concep,
          "serial":serial,
          "cantidad":cantidad
         
        };

        detalle.push(nuevo);

        CargarDetalleFact(detalle);
      }
    })

  }else{
    alert("La cantidad y el serial son obligatorios");
  }  

});


function CargarDetalleFact(detalle){

  var htmlTags = "";
  for (item in detalle) {
    htmlTags +=
    '<tr>'+
    '<td>'+
    detalle[item].id_concep+
    '</td>'+
    '<td>'+
    detalle[item].nombre_concep+
    '</td>'+
    '<td align="right">'+
    detalle[item].serial +
    '</td>'+
    '<td>'+
    detalle[item].cantidad+    
    '<td>'+
        //'<a href="javascript://" OnClick="HacerAbono(\'' + data[item].id_fact + '\',\'' + data[item].saldo_fact + '\'' + ');">' +
    '<a href="javascript://" OnClick="Eliminaritem(\'' + item + '\'' + ');">' +
    '<i><img src="images/borrar.png" width="28 px" height="28 px" title="Eliminar"></i>'+
    '</a>'+
    '</td>'+
    '</tr>';
  }  
  document.getElementById('data').innerHTML = htmlTags;
}


function Eliminaritem(item){
  detalle.splice(item,1);
  CargarDetalleFact(detalle);

}



$("#guardar").click(function() {
  var x = document.getElementById("guardar_btn");
  var cantidad = $("#cantidad").val();
  var route = "/registro";
  var token = $("#token").val();
  var type = 'POST';
  var datos = {
    "detalle":detalle
  };

  __ajax(route, token, type, datos)
  .done(function(info) {
    if(info.validar == 1){
       x.style.display = "none";
      $("#impresora").fadeIn();
      var id_registro = info.id_registro;
      console.log(id_registro);
      $("#numregistro").html(id_registro);

    }else if(info.validar == 999){
      alert("Los Item están sin cantidades o vacíos");
    }
   
  })
});

$("#nuevoregistro").click(function() {
 window.location.reload();
 $("#itemrapida").val('0');
 detalle = [];
  
 $("#id_concepto").val('');
 $("#cantidad").val('');
  $("#serial").val('');

 document.getElementById('numregistro').innerHTML = '';

  //CargarDetalleFact(detalle);

});
