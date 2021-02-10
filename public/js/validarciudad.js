$("#departamento").change(function() {

    var id_depa = $("#departamento").val();
    var datos = {
        "id_depa": id_depa
    };
    var route = "/ciudad";
    var type = 'GET';
    var token = $("#token").val();

    __ajax(route, token, type, datos)
    .done( function( info ){
        var recorrer = info.ciudad;
        $('#ciudad').empty().append('whatever');//Limpiar
        for (item in recorrer) {
          $("#ciudad").append('<option value='+recorrer[item].id_ciud+'>'+recorrer[item].nombre_ciud+'</option>');
        }

      })
});

$("#departamento_empresa").change(function() {

    var id_depa = $("#departamento_empresa").val();
    var datos = {
        "id_depa": id_depa
    };
    var route = "/ciudad";
    var type = 'GET';
    var token = $("#token").val();

    __ajax(route, token, type, datos)
    .done( function( info ){
        var recorrer = info.ciudad;
        $('#ciudad_empresa').empty().append('whatever');//Limpiar
        for (item in recorrer) {
          $("#ciudad_empresa").append('<option value='+recorrer[item].id_ciud+'>'+recorrer[item].nombre_ciud+'</option>');
        }

      })
});
