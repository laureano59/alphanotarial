$("#cargartodo").click(function() {
  var fecha1 = $("#start").val();
  var fecha2 = $("#end").val();
    
  var route = "/cargarfacturaelectronica";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
        "fecha1": fecha1,
        "fecha2": fecha2
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
          CargarFacturas(info.facturas);
          CargarNC(info.notas_c);
          CargarND(info.notas_d);
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

function CargarND(data){
  var htmlTags = '';
  for (item in data) {

        htmlTags +=
            '<tr>' +
            '<td>' +
            data[item].id_ndf +
            '</td>'+
            '<td>'+
            '<a href="javascript://" OnClick="Enviar_ND(' + data[item].id_ndf + ');">' +
            '<button class="btn btn-minier btn-primary">Enviar</button>'+
            '</a>'+
            '</td>'+
            '</tr>';
  }

  document.getElementById('datos_nd').innerHTML = htmlTags;

}

function Enviar(factura){
  var opcion = "F1";
  var num_fact = factura;
  var route = "/enviarfactura";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
        "num_fact": num_fact,
        "opcion": opcion
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
         
        })
}


function Enviar_NC(factura){
  var opcion = "NC";
  var num_fact = factura;
  var route = "/enviarfactura";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
        "num_fact": num_fact,
        "opcion": opcion
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
         
        })
}


function Enviar_ND(factura){
  var opcion = "ND";
  var num_fact = factura;
  var route = "/enviarfactura";
  var token = $("#token").val();
  var type = 'GET';
  var datos = {
        "num_fact": num_fact,
        "opcion": opcion
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
         
        })
}

