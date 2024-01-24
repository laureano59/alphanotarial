function CargarConsulta(data){
	var htmlTags = '';
	for (item in data) {
        htmlTags +=
            '<tr>'+
            '<td>'+
             data[item].id_fact+
            '</td>'+
            '<td>'+
            data[item].fecha_fact+
            '</td>'+
            '<td>'+
            data[item].a_nombre_de+
            '</td>'+
            '<td>'+
            data[item].nombre+
            '</td>'+
            '<td>'+
            data[item].usuario+
            '</td>'+
            '</tr>';
    }
            document.getElementById('data_consulta').innerHTML = htmlTags;
}