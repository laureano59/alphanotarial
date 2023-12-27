$("#identificacion_cli1").blur(function(){
  if($("#identificacion_cli1").val() != ''){
    var identificacion_cli = $("#identificacion_cli1").val();
    var tipo_doc = $("#id_tipoident1 option:selected").val();
    var calidad = 1;//NOTE:Para distinguir en cual input poner el nombre del cliente
    var datos = {
        "identificacion_cli": identificacion_cli,
        "tipo_doc": tipo_doc
    };
    var route = "/principales";
    var token = $("#token").val();
    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'GET',
        dataType: 'json',
        data: datos,

        success: function(info) {
            if (info.validar == '0') {
              $("#tipo_documento").val(info.tipo_doc);
              if(info.tipo_doc == 31){ //Si es empresa
                $("#tipo_documento_empresa").val(info.tipo_doc);
                $("#identificacion_empresa").val(info.identificacion_cli);
                LimpiarClientes();
                $("#calidad").val(calidad);//Campo oculto en modal cliente
                  $("#modalcliente-empresa").modal('toggle');
              }else{
                $("#identificacion").val(info.identificacion_cli);
                LimpiarClientes();
                $("#calidad").val(calidad);
                $("#modalcliente").modal('toggle');
              }
            }else if (info.validar == '1'){
              $("#nombre_cli1").val(info.nombre);
            }else if (info.validar == '7'){
              alert(info.concepto);
            }
          }
    });
  }
});

$("#cajarapida").click(function() {

  var route = "/sessionescajarapida";
  var token = $("#token").val();
  var type = 'GET';
  var opcion = 1;
  var datos = {
    "opcion": opcion
    };
    
    __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
          var url = "/cajarapida";
          $("<a>").attr("href", url).attr("target", "")[0].click();
        }
      })

});



$("#nuevafactura").click(function() {
   window.location.reload();
  $("#itemrapida").val('0');
  $("#numfactrapida").val('');
  detalle = [];
  total_iva = 0;
  total = 0;
  total_all = 0;

  $("#identificacion_cli1").val('');
  $("#nombre_cli1").val('');

  $("#id_tipoident1").val('');
  $("#id_formapago").val('');

  $("#id_concepto").val('');
  $("#cantidad").val('');
  
  document.getElementById('numfat').innerHTML = '';

  //CargarDetalleFact(detalle);

});


$("#actualizar_cambios") .click(function() {
  var num_factura = parseInt($("#numfactrapida").val());
  console.log(num_factura);
  var identificacion_cli1 = $("#identificacion_cli1").val();
  var formapago = $("#id_formapago").val();
  var opcion = "actualizar";
  var route = "/facturacajarapida/"+num_factura;
  var token = $("#token").val();
  var type = 'PUT';
  var datos = {
    "opcion": opcion,
    "identificacion_cli1":identificacion_cli1,
    "formapago":formapago,
    "total_iva":total_iva,
    "total":total,
    "total_all":total_all,
    "detalle":detalle
    };
    
    __ajax(route, token, type, datos)
          .done(function(info) {
            if(info.validar == 1){
              alert(info.Mensaje);
            }else{
              alert("Error al generar la factura");
            }

            })

});


$("#guardar").click(function() {
  var x = document.getElementById("guardar_btn");
  x.style.display = "none";
  var identificacion_cli1 = $("#identificacion_cli1").val();
  var formapago = $("#id_formapago").val();
  var tipo_fact = "cajarapida";
  var route = "/facturacajarapida";
  var token = $("#token").val();
  var type = 'POST';
  var datos = {
    "tipo_fact": tipo_fact,
    "identificacion_cli1":identificacion_cli1,
    "formapago":formapago,
    "total_iva":total_iva,
    "total":total,
    "total_all":total_all,
    "detalle":detalle
    };
    
    __ajax(route, token, type, datos)
          .done(function(info) {
            if(info.validar == 1){
              $("#impresora").fadeIn();
              var prefijo, id_fact;
              prefijo = info.prefijo;
              id_fact = info.id_fact;
              $("#numfactrapida").val(id_fact);
              $("#numfat").html(prefijo + '-' + ' ' + id_fact);
            }else{
              alert("Error al generar la factura");
            }

            })
});

var detalle = [];
var total_iva = 0;
var total = 0;
var total_all = 0;

$("#agregaritem").click(function() {
  var longi_detalle = detalle.length;
  if(longi_detalle >= 6){
    alert("Maximo 6 item");
  }else{
    var identificacion_cli1 = $("#identificacion_cli1").val();
    var formapago = $("#id_formapago").val();

    if(identificacion_cli1 != '' && formapago != null){
      var id_concepto, cantidad, identificacion_cli1;
      id_concepto = $("#id_concepto").val();
      cantidad = $("#cantidad").val();
      identificacion_cli1 = $("#identificacion_cli1").val();

      //var route = "/detallefacturacajarapida";
      var route = "/agregaritemcajarapida";
      var token = $("#token").val();
      var type = 'GET';
      var datos = {
      "id_concepto": id_concepto,
      "identificacion_cli1": identificacion_cli1,
      "cantidad": cantidad,
      "formapago": formapago
      };
    
    __ajax(route, token, type, datos)
          .done(function(info) {
            if(info.validar == 1){
              var nombre_concep, valor_unitario, subtotal;
              nombre_concep = info.nombre_concep;
              valor_unitario = info.valor_unitario;
              subtotal = info.subtotal;
              total_iva += info.total_iva;
              total += subtotal;
              total_all += subtotal +  info.total_iva;
              var total_item = info.total; 

                        
               var nuevo = 
              {
                "id_concep":id_concepto,
                "nombre_concep":nombre_concep,
                "valor_unitario":valor_unitario,
                "cantidad":cantidad,
                "subtotal":subtotal,
                "iva":info.total_iva,
                "total": total_item
              };

              detalle.push(nuevo);

             
              CargarDetalleFact(detalle);
            }
          })

  }else{
    alert("Debes ingresar la información del cliente y la forma de pago");
  }

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
        formatNumbderechos(detalle[item].valor_unitario) +
        '</td>'+
        '<td>'+
        detalle[item].cantidad+
        '</td>'+
        '<td align="right">'+
        formatNumbderechos(detalle[item].subtotal)+
        '</td>'+
        '<td>'+
        //'<a href="javascript://" OnClick="HacerAbono(\'' + data[item].id_fact + '\',\'' + data[item].saldo_fact + '\'' + ');">' +
        '<a href="javascript://" OnClick="Eliminaritem(\'' + item + '\',\'' + detalle[item].subtotal+ '\',\'' + detalle[item].iva  + '\'' + ');">' +
         '<i><img src="images/borrar.png" width="28 px" height="28 px" title="Eliminar"></i>'+
        '</a>'+
        '</td>'+
        '</tr>';
    }

    htmlTags +=
        '<tr>'+
        '<td>'+
        '</td>'+
         '<td>'+
        '</td>'+
        '<td>'+
        '</td>'+
        '<td bgcolor="##DAF7A6"><b>'+
          'Total bruto:'+
        '</b></td>'+
        '<td  bgcolor="##DAF7A6" align="right"><b>'+
        formatNumbderechos(total)+
        '</b></td>'+
        '<td>'+
        '</td>'+
        '</tr>'+
        '<tr>'+
        '<td>'+
        '</td>'+
        '<td>'+
        '</td>'+
        '<td>'+
        '</td>'+
        '<td><b>'+
          'Iva:'+
        '</b></td>'+
        '<td align="right"><b>'+
        formatNumbderechos(total_iva)+
        '</b></td>'+
        '<td>'+
        '</td>'+
        '</tr>'+
        '<tr>'+
        '<td>'+
        '</td>'+
        '<td>'+
        '</td>'+
        '<td>'+
        '</td>'+
        '<td bgcolor="##DAF7A6"><b>'+
          'Total neto:'+
        '</b></td>'+
        '<td bgcolor="##DAF7A6" align="right"><b>'+
        formatNumbderechos(total_all)+
        '</b></td>'+
        '<td>'+
        '</td>'+
        '</tr>';
    document.getElementById('data').innerHTML = htmlTags;
}


function Eliminaritem(item, subto, iva){
  total = total - subto;
  total_iva = total_iva - iva;
  var aux = parseInt(iva) + parseInt(subto);
  total_all = total_all - aux;
  detalle.splice(item,1);
  CargarDetalleFact(detalle);
   
}


$("#copiasfacturarapida").click(function() {
  $("#guycopiafacturacajarapida").fadeIn();
});

$("#imprimircopiafacturacajarapida").click(function() {
  var num_factura = $("#num_factura").val();
  var route = "/existefacturacajarapida";
  var type = 'GET';
  var token = $("#token").val();
  var datos = { 
    "num_factura": num_factura,
   };
  __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
          var url = "/copiafacturacajarapidapos";
          $("<a>").attr("href", url).attr("target", "_blank")[0].click();

        }else if(info.validar == 0){
          $("#msj1").html(info.mensaje);
          $("#msj-error1").fadeIn();
          setTimeout(function() {
              $("#msj-error1").fadeOut();
          }, 3000);
        }
      })
});


$("#editarfacturacajarapida").click(function() {
  var route = "/sessionescajarapida";
  var token = $("#token").val();
  var type = 'GET';
  var opcion = 2;
  var datos = {
    "opcion": opcion
    };
    
    __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
          var url = "/cajarapida";
          $("<a>").attr("href", url).attr("target", "")[0].click();
        }
         
      })
});

$("#validarfacturaparaeditar").click(function() {

  var route = "/validareditarfacturacajarapida";
  var token = $("#token").val();
  var type = 'GET';
  var num_factura = $("#numfactrapidavisual").val();
  $("#numfactrapida").val('');
  $("#numfactrapida").val(num_factura);
  var datos = {
    "num_factura": num_factura
    };
    
    __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
          var botonvalidar = document.getElementById("botonvalidar");
          botonvalidar.style.display = "none";

          var impresora = document.getElementById("impresora");
          impresora.style.display = "";
          
          $("#id_tipoident1").val('');
          $("#identificacion_cli1").val('');
          $("#nombre_cli1").val('');
          $("#id_concepto").val('');
          $("#cantidad").val('');

          $("#ocultar").fadeIn();


          var detalle, subtotal, total_iva, total;
              detalle = info.detalle;
              subtotal = info.subtotal;
              total_iva = info.total_iva;
              total = info.total;
              //CargarDetalleFact(detalle, subtotal, total_iva, total);

          
        }else if(info.validar == 0){
          $("#msj").html(info.mensaje);
          $("#msj-error").fadeIn();
          setTimeout(function() {
            $("#msj-error").fadeOut();
          }, 3000);

        }
      })
});
