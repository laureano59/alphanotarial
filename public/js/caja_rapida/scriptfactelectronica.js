$("#cargartodo").click(function() {
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
    
  var route = "/cargarfacturasnodian";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
        "fecha1": fecha1,
        "fecha2": fecha2
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
          if(info.validar == 1){
            CargarFacturas(info.facturas);
            CargarNC(info.notas_c);
          }
        })
});

function CargarFacturas(data){
  var htmlTags = '';
  for (item in data) {

        htmlTags +=
            '<tr>' +
            '<td>' +
            data[item].id_fact +
            '</td>'+
            '</tr>';
  }

  document.getElementById('datos').innerHTML = htmlTags;

}

function CargarNC(data_nc){
  var htmlTags = '';
  for (item in data) {
        htmlTags +=
            '<tr>' +
            '<td>' +
            data[item].id_fact +
            '</td>'+
            '</tr>';
  }

  document.getElementById('datos').innerHTML = htmlTags;

}