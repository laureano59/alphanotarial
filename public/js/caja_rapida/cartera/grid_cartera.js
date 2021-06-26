function CargarGridCartera(data) {
    var htmlTags = "";
    for (item in data) {
        htmlTags +=
            '<tr>' +
            '<td>' +
            '<a href="javascript://" OnClick="HacerAbono(\'' + data[item].id_fact + '\',\'' + data[item].saldo_fact + '\'' + ');">' +
            data[item].id_fact +
            '</a>' +
            '</td>' +
            '<td>' +
            data[item].fecha_fact +
            '</td>' +
            '<td>' +
            data[item].cliente+
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].total_fact)) +
            '</td>' +
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].saldo_fact)) +
            '</td>' +
            '</tr>';
    }
    document.getElementById('data').innerHTML = htmlTags;
}

function HacerAbono(id_fact, saldo){
    $("#num_fact").html(id_fact);
    $("#id_fact_iden").val(id_fact);
    $("#saldo_iden").val(saldo);

    var factura = id_fact;
    var route = "/sessionabonos";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
            "factura": factura
       }

    __ajax(route, token, type, datos)
     .done(function(info) {

    })
}
