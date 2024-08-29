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

