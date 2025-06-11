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
            '<td>'+
            '<a href="javascript://" OnClick="Enviar(' + data[item].id_fact + ');">' +
            '<button class="btn btn-minier btn-primary">Enviar</button>'+
            '</a>'+
            '</td>'+
            '</tr>';
  }

  document.getElementById('datos').innerHTML = htmlTags;

}

function CargarNC(data){
  var htmlTags = '';
  for (item in data) {
        htmlTags +=
            '<tr>' +
            '<td>' +
            data[item].id_ncf +
            '</td>'+
            '<td>'+
            '<a href="javascript://" OnClick="Enviar_NC(' + data[item].id_ncf + ');">' +
            '<button class="btn btn-minier btn-primary">Enviar</button>'+
            '</a>'+
            '</td>'+
            '</tr>';
  }

  document.getElementById('datos_nc').innerHTML = htmlTags;

}


function Enviar(factura){
  var opcion = "F1";
  var retransmitir = "1";
  var num_fact = factura;
  var route = "/enviarfacturacajarapida";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
        "num_fact": num_fact,
        "opcion": opcion,
        "retransmitir": retransmitir
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
         
        })
}


function Enviar_NC(factura){
  var opcion = "NC";
  var retransmitir = "1";
  var num_fact = factura;
  var route = "/enviarfacturacajarapida";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
        "num_fact": num_fact,
        "opcion": opcion,
        "retransmitir": retransmitir
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
         
        })
}