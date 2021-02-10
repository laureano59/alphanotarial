function CargarConsulta(data){
	var htmlTags = '';
	for (item in data) {
        htmlTags +=
            '<tr>'+
            '<td>'+
             data[item].id_radica+
            '</td>'+
            '<td>'+
            data[item].fecha_radica+
            '</td>'+
            '<td>'+
            data[item].usuario+
            '</td>'+
            '<td>'+
            data[item].protocolista+
            '</td>'+
            '<td>'+
            data[item].id_fact+
            '</td>'+
            '<td>'+
            data[item].fecha_fact+
            '</td>'+
            '<td>'+
            data[item].num_esc+
            '</td>'+
            '<td>'+
            data[item].fecha_esc+
            '</td>'+
            '<td>'+
            data[item].otorgante+
            '</td>'+
            '<td>'+
            data[item].nombre_otorgante+
            '</td>'+
            '<td>'+
            data[item].compareciente+
            '</td>'+
            '<td>'+
            data[item].nombre_compareciente+
            '</td>'+
            '<td>'+
            data[item].nombre_acto+
            '</td>'+
            '</tr>';
    }
            document.getElementById('data_seguimiento').innerHTML = htmlTags;
}