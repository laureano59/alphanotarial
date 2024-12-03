function CargarGridBonos(data) {
    var htmlTags = "";
    for (item in data) {
        htmlTags +=
            '<tr>' +
             '<td>' +
            data[item].codigo_bono +
            '</td>' +
            '<td>' +
            '<a href="javascript://" OnClick="HacerAbono(\'' + data[item].id_fact + '\',\'' + data[item].id_bon + '\',\'' + data[item].saldo + '\'' + ');">' +
            data[item].id_fact +
            '</a>' +
            '</td>' +
            '<td>' +
            data[item].fecha_fact +
            '</td>' +
            '<td>' +
            data[item].cliente+
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].valor_bono)) +
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].saldo)) +
            '</td>' +
            '</tr>';
    }
    document.getElementById('data').innerHTML = htmlTags;
}

function HacerAbono(id_fact, id_bon, saldo){
    $("#num_fact").html(id_fact);
    $("#id_fact_iden").val(id_fact);
    $("#saldo_iden").val(saldo);
    //$("#abono").val(valor_abono);

    var factura = id_fact;
    var route = "/sessionabonos_bon";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
            "factura": factura,
            "id_bon": id_bon
       }

    __ajax(route, token, type, datos)
     .done(function(info) {

    })
}

var globalData = [];
function CargarBonos(data) {
    var htmlTags = "";
    for (item in data) {
        htmlTags +=
            '<tr>' +
             '<td>' +
            data[item].codigo_bono +
            '</td>' +
            '<td>' +
            data[item].id_fact +
            '</td>' +
            '<td>' +
            data[item].num_esc +
            '</td>' +
             '<td>' +
            data[item].id_radica +
            '</td>' +
            '<td>' +
            data[item].fecha_fact +
            '</td>' +
            '<td>' +
            data[item].cliente+
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(data[item].valor_bono)) +
            '</td>' +
            '<td bgcolor="#ccffcc" align="center">' + 
            '<input type="checkbox" id="check_' + item + '">' + // Aquí agregamos el checkbox
            '</td>' +
            '</tr>';
    }

    globalData = data;

    document.getElementById('data_bono').innerHTML = htmlTags;
}


