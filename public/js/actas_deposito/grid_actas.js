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
             '<td>'+
                '<a href="javascript://" onclick="AbrirmodalAnular(\'' + data[item].id_act + '\');">' +
                '<i><img src="images/cancelar.png" width="28 px" height="28 px" title="Anular"></i>'+
                '</a>'+
            '</td>'+
            '</tr>';
    }

    document.getElementById('datos').innerHTML = htmlTags;
}

function AbrirmodalAnular(id_act){
    $("#id_acta").val(id_act);
    $('#modalanularacta').modal('show');
}


$("#Anularacta").click(function() {
    var motivo_anulacion = $("#motivo_anulacion").val();
    var id_act = $("#id_acta").val();
    var route = '/anularacta';
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_act": id_act,
        "motivo_anulacion": motivo_anulacion
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
        if(info.validar == 1){
            CargarGridActas(info.data);
             $('#modalanularacta').modal('hide');
        }else  if(info.validar == 888){
            $('#modalanularacta').modal('hide');
            alert(info.mensaje);
        }
               
    })
});

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
