function CargarGridReportados(validar) {
   var htmlTags = "";
    var totalderechos = 0;
    for (item in validar) {
       htmlTags +=
        '<tr>'+
        '<td>' +
        '<a href="javascript://" OnClick="CargarRegistro(' +
        validar[item].id_rep +
        ', \'' + validar[item].nombre_rep + '\', \'' + validar[item].identificacion_rep + '\', \'' + validar[item].id_tipo_rep + '\', \'' + validar[item].concepto_rep + '\', \'' + validar[item].activo + '\');">'+
        '<b class="green">' + validar[item].identificacion_rep +'</b>'+
        '</a>' +
        '</td>' +
        '<td>'+
        validar[item].nombre_rep+
        '</td>'+
        '<td>'+
        validar[item].id_tipo_rep+
        '</td>'+
        '<td>'+
        validar[item].activo+
        '</td>'+
        '<td>' +
            '<div class="hidden-sm hidden-xs btn-group">' +
            '<button class="btn btn-xs btn-danger" title="Eliminar" value=' + '"' + validar[item].id_rep + '"' + 'OnClick="EliminarReportado(this);">' +
            '<i class="ace-icon fa fa-trash-o bigger-120"></i>' +
            '</button>' +
            '</div>' +
            '</td>' +
        '</tr>';
    }
    document.getElementById('datos').innerHTML = htmlTags;
    
}


function CargarRegistro(id_rep, nombre_rep, identificacion_rep, id_tipo_rep, concepto_rep, activo){

        
        //$("#boton_actualizar").fadeOut();
        $("#id_reportado").val(id_rep);
        $("#boton_guardar").fadeOut();
        $("#boton_actualizar").fadeIn();
        $("#concepto").val(concepto_rep);
        $("#identificacion").val(identificacion_rep);
        $("#nombre").val(nombre_rep);
        $("#estado").val(activo);
        $("#tipo").val(id_tipo_rep);

}

