//NOTE: Cargar Actos Cliente
function CargarActosCli(validar) {
    var htmlTags = "";
    for (item in validar) {
        htmlTags +=
            '<tr>' +
            '<td>' +

            '<a href="javascript://" OnClick="ListingPrincipales(\'' + validar[item].id_actoperrad + '\',\'' + validar[item].nombre_acto + '\', \'' + validar[item].tradicion + '\',\'' + validar[item].cuantia + '\'  '  + ');">' +
            
            validar[item].nombre_acto +
            '</a>' +
            '</td>' +
            '<td>' +
            '<b class="green">' + '$' + formatNumber(validar[item].cuantia) + '</b>' +
            '</td>' +
            '<td>' +
            '<b class="blue">' + validar[item].tradicion + '</b>' +
            '</td>' +
            '<td>' +
            '<div class="hidden-sm hidden-xs btn-group">' +
            '<button class="btn btn-xs btn-info" title="Editar" value=' + '"' + validar[item].id_actoperrad + '"' + 'OnClick="editaractoscliente(this);">' +
            '<i class="ace-icon fa fa-pencil bigger-120"></i>' +
            '</button>' +
            '<button class="btn btn-xs btn-danger" title="Eliminar" value=' + '"' + validar[item].id_actoperrad + '"' + 'OnClick="eliminaractoscliente(this);">' +
            '<i class="ace-icon fa fa-trash-o bigger-120"></i>' +
            '</button>' +
            '</div>' +
            '</td>' +
            '</tr>'
    }
    document.getElementById('datos').innerHTML = htmlTags;
}

//NOTE: Cargar Otorgantes
function CargarOtorgantes(otor) {
    var htmlTags = "";
    for (item in otor) {
        htmlTags +=
            '<tr>' +
            '<td class="">' + otor[item].identificacion_cli + '</td>' +
            '<td>' +
            '<b class="blue">' + otor[item].fullname + '</b>' +
            '</td>' +
            '<td>' +
            otor[item].porcentaje_otor +
            '</td>' +
            '<td>' +
            '<div class="hidden-sm hidden-xs btn-group">' +
            '<button class="btn btn-xs btn-danger" title="Eliminar" value=' + '"' + otor[item].id_otor + '"' + 'OnClick="eliminarotorgante(this);">' +
            '<i class="ace-icon fa fa-trash-o bigger-120"></i>' +
            '</button>' +
            '</div>' +
            '</td>' +
            '</tr>'
    }
    document.getElementById('infotorgantes').innerHTML = htmlTags;
}

//NOTE: Cargar Comparecientes
function CargarComparecientes(comp) {
    var htmlTags = "";
    for (item in comp) {
        htmlTags +=
            '<tr>' +
            '<td class="">' + comp[item].identificacion_cli2 + '</td>' +
            '<td>' +
            '<b class="blue">' + comp[item].fullname + '</b>' +
            '</td>' +
            '<td>' +
            comp[item].porcentaje_comp +
            '</td>' +
            '<td>' +
            '<div class="hidden-sm hidden-xs btn-group">' +
            '<button class="btn btn-xs btn-danger" title="Eliminar" value=' + '"' + comp[item].id_comp + '"' + 'OnClick="eliminarcompareciente(this);">' +
            '<i class="ace-icon fa fa-trash-o bigger-120"></i>' +
            '</button>' +
            '</div>' +
            '</td>' +
            '</tr>'
    }
    document.getElementById('infcomparecientes').innerHTML = htmlTags;
}

function formatNumber(n) {
    return n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
