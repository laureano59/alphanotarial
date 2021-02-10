function CargarGridActas(data) {
    var htmlTags = "";
    for (item in data) {
        htmlTags +=
            '<tr>' +
            '<td>' +
            data[item].id_act+
            '</td>' +
            '<td>' +
            data[item].fecha+
            '</td>' +
            '<td>' +
            data[item].proyecto+
            '</td>' +
            '<td>' +
            data[item].descripcion_tip+
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].deposito_act)) +
            '</td>' +
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].saldo)) +
            '</td>' +
            '</tr>';
    }

    document.getElementById('datos').innerHTML = htmlTags;
}

function CargarGridActasEgreso(data) {
    var htmlTags = "";
    for (item in data) {
        htmlTags +=
            '<tr>' +
            '<td>' +
            data[item].id_act+
            '</td>' +
            '<td>' +
            data[item].fecha+
            '</td>' +
            '<td>' +
            '<a href="javascript://" OnClick="GenerarDescuento(\'' + data[item].id_act + '\',\'' + data[item].saldo + '\'' + ');">' +
            data[item].nombre+
            '</a>'+
            '</td>' +
            '<td>' +
            data[item].proyecto+
            '</td>' +
            '<td>' +
            data[item].descripcion_tip+
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].deposito_act)) +
            '</td>' +
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].saldo)) +
            '</td>' +
            '</tr>';
    }
    document.getElementById('data').innerHTML = htmlTags;
}

function GenerarDescuento(id_acta, saldo){
  $("#num_acta").html(id_acta);
  $("#id_act_iden").val(id_acta);
  $("#saldo_iden").val(saldo);
}
