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


$("#aperturacajarapida").click(function() {

  $("#modalapertura").modal("show");

});

$("#guardarbase").click(function() {
  var valor_base = $("#valor_base").val();
  if (valor_base == '' || valor_base <= 0){
    alert("Debe contener un valor mayor a cero");
  }else{

    var route = "/guardarbasecajarapida";
    var token = $("#token").val();
    var type = 'POST';
    var datos = {
    "valor_base": valor_base
    };

      __ajax(route, token, type, datos)
      .done(function(info) {
          if(info.validar == 1){
            $("#msj2").html(info.mensaje);
            $("#msj-error2").fadeIn();
            setTimeout(function() {
              $("#msj-error2").fadeOut();
            }, 3000);
          }else if(info.validar == 2){
            $("#msj2").html(info.mensaje);
            $("#msj-error2").fadeIn();
            setTimeout(function() {
              $("#msj-error2").fadeOut();
            }, 3000);
          }else if(info.validar == 7){
            $("#msj2").html(info.mensaje);
            $("#msj-error2").fadeIn();
            setTimeout(function() {
              $("#msj-error2").fadeOut();
            }, 3000);
          }
      })
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
 $("#idregistro").val('');
 $("#efectivo").val('');

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
  var identificacion_cli1 = $("#identificacion_cli1").val();
  var formapago = $("#id_formapago").val();
  var idreg = $("#idregistro").val();
  //var mediopago = $("#mediopago option:selected").val();
  var efectivo = $("#efectivo").val();
  var cheque = $("#cheque").val();
  var consignacion_bancaria = $("#consignacion_bancaria").val();
  var pse = $("#pse").val();
  var transferencia_bancaria = $("#transferencia_bancaria").val();
  var tarjeta_credito = $("#tarjeta_credito").val();
  var tarjeta_debito = $("#tarjeta_debito").val();
  var id_banco = $("#id_banco option:selected").val();
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
    "detalle":detalle,
    "efectivo":efectivo,
    "cheque":cheque,
    "consignacion_bancaria":consignacion_bancaria,
    "pse":pse,
    "transferencia_bancaria":transferencia_bancaria,
    "tarjeta_credito":tarjeta_credito,
    "tarjeta_debito":tarjeta_debito,
    "id_banco":id_banco,
    "id_registro":idreg,

  };

  __ajax(route, token, type, datos)
  .done(function(info) {
    if(info.validar == 1){
      var prefijo, id_fact;
          prefijo = info.prefijo;
          id_fact = info.id_fact;
          $("#numfactrapida").val(id_fact);
          $("#numfat").html(prefijo + '-' + ' ' + id_fact);
      // =============================================
      // =       Enviar Factura electronica          =
      // =============================================
  
    var opcion = "F1";
    var num_fact = $("#numfactrapida").val();
    var route = "/enviarfacturacajarapida";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
      "num_fact": num_fact,
      "opcion": opcion
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
      if(info.status == 1){
          var mensaje = info.mensaje;
          var opcion2 = info.opcion2;
          console.log(opcion2);
          console.log(mensaje);

          $("#informacion").html("Muy bien! Factura Enviada, ahora puedes imprimirla");
          $("#mod_factelectronica").modal('toggle');  
          x.style.display = "none";
          $("#impresora").fadeIn();          

          // =============================================
          // =       Enviar Correo al cliente            =
          // =============================================

          route = "/enviarcorreocajrap";
          token = $("#token").val();
          type = 'GET';
          datos = {
      
          };
          __ajax(route, token, type, datos)
            .done(function(info) {
            if(info.status == 1){
              
            }
          })

            //fetch("/enviarcorreo");
        }
      })

     }else if(info.validar == 888){
      alert("Los medios de pago deben ser igual que el total a pagar");
    }else if(info.validar == 999){
      alert("Los Item están sin cantidades o vacíos");
    }else if(info.validar == 777){
      alert("El Id_registro es incorrecto o no existe");
    }else if(info.validar == 111){
      alert("El Id_registro ya fué utilizado");
    }
   
  })
});



var detalle = [];
var total_iva = 0;
var total = 0;
var total_all = 0;

$("#agregaritem").click(function() {
  console.log(gv_registro);
  console.log(gv_registro);
  var longi_detalle = detalle.length;
  var id_registro = $("#idregistro").val();
  if(longi_detalle >= 6){
    alert("Maximo 6 item");
  }else{
    var identificacion_cli1 = $("#identificacion_cli1").val();
    var formapago = $("#id_formapago").val();
    var cantidad = $("#cantidad").val();

    if(identificacion_cli1 != '' && formapago != null){
      if(cantidad != '' && cantidad != null){
        if(gv_registro == 1){
          if(id_registro == ''){
            alert("El Id_registro es obligatorio");
          } else{
            Validar_agregar_items(identificacion_cli1, formapago, cantidad);
          }
        }

        if(gv_registro == 0){
          Validar_agregar_items(identificacion_cli1, formapago, cantidad);
        }      
   
      }else{
        alert("La cantidad es obligatoria");
      }

    }else{
      alert("Debes ingresar la información del cliente y la forma de pago");
    }

  }

});

function Validar_agregar_items(identificacion_cli1, formapago, cantidad){
   var id_concepto;
        id_concepto = $("#id_concepto").val();
        
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

}


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

      var nuevaVentana = window.open(url, '_blank');

    // Espera 10 segundos y luego cierra la ventana
    setTimeout(function() {
        if (nuevaVentana) {
            nuevaVentana.close();
        }
    }, 10000); // 3000 milisegundos = 3 segundos

     
    }else if(info.validar == 0){
      $("#msj1").html(info.mensaje);
      $("#msj-error1").fadeIn();
      setTimeout(function() {
        $("#msj-error1").fadeOut();
      }, 3000);
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


$("#consumidorfinal").click(function() {
  $("#identificacion_cli1").val('222222222222');
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
  
});

var gv_registro = 0;


document.getElementById('id_concepto').addEventListener('change', function() {
    let selectedValue = this.value; // Obtiene el valor seleccionado
          
    if(selectedValue == 2  || selectedValue == 19){   
     
     $("#mostrarnumregistro").fadeIn();
     //document.getElementById("idregistro").value = '';
     //idregistrohiden
     gv_registro = 1;

    }else{
      $("#mostrarnumregistro").fadeOut();
      //document.getElementById("idregistro").value = '0';
      gv_registro = 0;
    }
   
});
