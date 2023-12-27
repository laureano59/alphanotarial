$("#identificacion_cli1").blur(function(){
  if($("#identificacion_cli1").val() != ''){
    var identificacion_cli = $("#identificacion_cli1").val();
    var tipo_doc = $("#id_tipoident1 option:selected").val();
    var calidad = 1;//NOTE:Para distinguir en cual input poner el nombre del cliente
    var datos = {
        "identificacion_cli": identificacion_cli,
        "tipo_doc": tipo_doc
    };
    var route = "/principales";
    var token = $("#token").val();
    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'GET',
        dataType: 'json',
        data: datos,

        success: function(info) {
            if (info.validar == '0') {
              $("#tipo_documento").val(info.tipo_doc);
              if(info.tipo_doc == 31){ //Si es empresa
                $("#tipo_documento_empresa").val(info.tipo_doc);
                $("#identificacion_empresa").val(info.identificacion_cli);
                LimpiarClientes();
                $("#calidad").val(calidad);//Campo oculto en modal cliente
                  $("#modalcliente-empresa").modal('toggle');
              }else{
                $("#identificacion").val(info.identificacion_cli);
                LimpiarClientes();
                $("#calidad").val(calidad);
                $("#modalcliente").modal('toggle');
              }
            }else if (info.validar == '1'){
              $("#nombre_cli1").val(info.nombre);
            }else if (info.validar == '7'){
              alert(info.concepto);
            }
          }
    });
  }
});

//------------NOTE:Calidad2-------------------

$("#identificacion_cli2").blur(function(){

  if($("#identificacion_cli2").val() != ''){
    var identificacion_cli = $("#identificacion_cli2").val();
    var tipo_doc = $("#id_tipoident2 option:selected").val();
    var calidad = 2; //NOTE:Para distinguir en que input se muestra el nombre del cliente
    var datos = {
        "identificacion_cli": identificacion_cli,
        "tipo_doc": tipo_doc
    };
    var route = "/principales";
    var token = $("#token").val();
    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'GET',
        dataType: 'json',
        data: datos,

        success: function(info) {
            if (info.validar == '0') {
              $("#tipo_documento").val(info.tipo_doc);
              if(info.tipo_doc == 31){ //NOTE:Si es empresa
                $("#calidad").val(calidad);//NOTE:Campo oculto en modal cliente
                LimpiarClientes();
                $("#identificacion_empresa").val(info.identificacion_cli);
                $("#modalcliente-empresa").modal('toggle');
              }else{
                $("#calidad").val(calidad);//NOTE:Campo oculto en modal cliente
                LimpiarClientes();
                $("#identificacion").val(info.identificacion_cli);
                $("#modalcliente").modal('toggle');
              }
            }else if (info.validar == '1'){
              $("#nombre_cli2").val(info.nombre);
            }
          }
    });
  }
});

$("#identificacion_cli3").blur(function(){

  if($("#identificacion_cli3").val() != ''){
    var identificacion_cli = $("#identificacion_cli3").val();
    var tipo_doc = $("#id_tipoident3").val();
    var calidad = 3;//NOTE:Para distinguir en que input se muestra el nombre del cliente
    var datos = {
        "identificacion_cli": identificacion_cli,
        "tipo_doc": tipo_doc
    };
    var route = "/principales";
    var token = $("#token3").val();
    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'GET',
        dataType: 'json',
        data: datos,

        success: function(info) {
            if (info.validar == '0') {
              $("#tipo_documento").val(info.tipo_doc);
              if(info.tipo_doc == 31){ //NOTE:Si es empresa
                $("#calidad").val(calidad);//NOTE:Campo oculto en modal cliente
                LimpiarClientes();
                $("#identificacion_empresa").val(info.identificacion_cli);
                $("#modalcliente-empresa").modal('toggle');
              }else{
                $("#calidad").val(calidad);//NOTE:Campo oculto en modal cliente
                LimpiarClientes();
                $("#identificacion").val(info.identificacion_cli);
                $("#modalcliente").modal('toggle');
              }
            }else if (info.validar == '1'){
              $("#nombre_cli3").val(info.nombre);
            }
          }
    });
  }
});
