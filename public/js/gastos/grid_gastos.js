function CargarGridGastos(validar) {
   var htmlTags = "";
    for (item in validar) {
       htmlTags +=
        '<tr>'+
        '<td>' +
        '<a href="javascript://" OnClick="CargarRegistro(' +
        validar[item].id_gas +
        ', \'' + validar[item].concepto_gas + '\', \'' + validar[item].autorizado_por + '\', \'' + validar[item].valor_gas  + '\');">'+
        '<b class="green">' + validar[item].id_gas +'</b>'+
        '</a>' +
        '</td>' +
        '<td>'+
        validar[item].fecha_gas+
        '</td>'+
        '<td>'+
        validar[item].concepto_gas+
        '</td>'+
        '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(validar[item].valor_gas)) +
        '</td>'+
         '<td>'+
        validar[item].autorizado_por+
        '</td>'+
         '<td>'+
        validar[item].reembolsado_a+
        '</td>'+
         '<td>'+
            '<a href="javascript://" OnClick="Anulargasto(\''  + validar[item].id_gas  + '\'' + ');">' +
               '<i><img src="images/cancelar.png" width="28 px" height="28 px" title="Anular"></i>'+
            '</a>'+
         '</td>'+
        '</tr>';
    }
    document.getElementById('datos').innerHTML = htmlTags;
    
}


function CargarRegistro(id_gas, concepto_gas, autorizado_por, valor_gas){
   $("#btnguardar").fadeOut();
   $("#boton_actualizar").fadeIn();
   $("#concepto").val(concepto_gas);
   $("#valor_gasto").val(valor_gas);
   $("#autoriza").val(autorizado_por);
   $("#id_update").val(id_gas);//campo oculto

   
}

function Anulargasto(id_gas){
   if(confirm(`¿Está seguro que quiere anular el documento número ${id_gas}?`)) {
      console.log(id_gas);   
      var route = "/anular_gasto";
      var token = $("#token").val();
      var type = 'GET';
      var datos = {
        "id_gas": id_gas
      };
      __ajax(route, token, type, datos)
         .done(function(info) {
            if (info.validar == 1) {
               $("#msj1").html(`Muy bien el documento ${id_gas} se anuló exitosamente`);
               $("#msj-error1").fadeIn();
               setTimeout(function() {
                  $("#msj-error1").fadeOut();
               }, 4000);
            }
         })
   } else {
      console.log("La anulación fue cancelada.");    
   }  
}

