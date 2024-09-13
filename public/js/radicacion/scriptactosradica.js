$("#guardaractosradica").click(function() {
    if ($("#id_acto").val() != null) {
        /********NOTE:Comprueba si La radicación está liquidada********/
        var id_radica = $("#radicacion").val();
        var route = "/mostrarliq";
        var token = $("#token").val();
        var type = 'GET';
        var datos = {
            "id_radica": id_radica
        };
        __ajax(route, token, type, datos)
            .done(function(info) {
                if (info.validarliqd == '1') { //NOTE:Si la radicación ya está liquidada
                    $("#msj2").html(info.mensaje);
                    $("#msj-error2").fadeIn();
                    setTimeout(function() {
                        $("#msj-error2").fadeOut();
                    }, 3000);
                } else if (info.validarliqd == '0') { //NOTE:Si la radicación No está liquidada
                    var id_radica = $("#radicacion").val();
                    var id_acto = $("#id_acto").val();
                    var cuantia = $("#cuantia").val();
                    //var tradicion = $("#tradicion").val();
                    var fecha_tradicion = $("#fecha_tradicion").val();
                   
                    var tradicion = fecha_tradicion;
                   
                    if (cuantia == '') {
                        cuantia = 0;
                    }
                    var datos = {
                        "id_radica": id_radica,
                        "id_acto": id_acto,
                        "cuantia": cuantia,
                        "tradicion": tradicion
                    };
                    var route = "/actosradica";
                    var token = $("#token").val();
                    var type = 'POST';
                    __ajax(route, token, type, datos)
                        .done(function(info) {
                            if (info.validar == '1') {
                                validar = info.actos;
                                CargarActosCli(validar);
                            } else if (info.validar == '0') {
                                $("#msj2").html(info.mensaje);
                                $("#msj-error2").fadeIn();
                                setTimeout(function() {
                                    $("#msj-error2").fadeOut();
                                }, 3000);
                            }
                        })
                }
            })

    } else {
        alert("Debes de Seleccionar el Acto");
    }
});

function editaractoscliente(btn) {
    var route = "/actosradica/" + btn.value + "/edit";
    $.get(route, function(res) {
        $("#id_act").val(res.id_acto);
        $("#cuant").val(res.cuantia);
        $("#tradi").val(res.tradicion);
        $("#id_actoperrad").val(res.id_actoperrad);
        $("#id_rad").val(res.id_radica);
    });
    $('#modalactosradica').modal('toggle');
}

$("#actualizar").click(function() {
    var value, id_acto, cuantia, tradicion, datos, id_radica, actualizar;
    value = $("#id_actoperrad").val();
    id_acto = $("#id_act").val();
    cuantia = $("#cuant").val();
    tradicion = $("#tradi").val();
    id_radica = $("#id_rad").val();
    actualizar = 1;
    datos = {
        "id_acto": id_acto,
        "cuantia": cuantia,
        "tradicion": tradicion,
        "id_radica": id_radica,
        "actualizar": actualizar
    };

    var route = "/actosradica/" + value;
    var token = $("#token").val();

    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'PUT',
        dataType: 'json',
        data: datos,
        success: function(info) {
            var validar = info.actos;
            CargarActosCli(validar);
            $('#modalactosradica').modal('toggle');
        }

    });

});

function eliminaractoscliente(btn) {
    var route = "/actosradica/" + btn.value;
    var token = $("#token").val();
    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'DELETE',
        dataType: 'json',
        success: function(info) {
            var validar = info.actos;
            CargarActosCli(validar);
        }
    });
}

function eliminarotorgante(btn) {
    /********NOTE:Comprueba si La radicación está liquidada********/
    var id_radica = $("#radicacion").val();
    var route = "/mostrarliq";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            if (info.validarliqd == '1') { //NOTE:Si la radicación ya está liquidada
                $("#msj6").html(info.mensaje);
                $("#msj-error6").fadeIn();
                setTimeout(function() {
                    $("#msj-error6").fadeOut();
                }, 3000);
            } else if (info.validarliqd == '0') { //NOTE:Si la radicación No está liquidada
                var route = "/otorgante/" + btn.value;
                var token = $("#token").val();
                $.ajax({
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(info) {
                        var validar = info.otorgantes;
                        CargarOtorgantes(validar);
                    }
                });
            }
        })
}

function eliminarcompareciente(btn) {
    /********NOTE:Comprueba si La radicación está liquidada********/
    var id_radica = $("#radicacion").val();
    var route = "/mostrarliq";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            if (info.validarliqd == '1') { //NOTE:Si la radicación ya está liquidada
                $("#msj7").html(info.mensaje);
                $("#msj-error7").fadeIn();
                setTimeout(function() {
                    $("#msj-error7").fadeOut();
                }, 3000);
            } else if (info.validarliqd == '0') { //NOTE:Si la radicación No está liquidada
                var route = "/compareciente/" + btn.value;
                var token = $("#token").val();
                $.ajax({
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(info) {
                        var validar = info.comparecientes;
                        CargarComparecientes(validar);
                    }
                });
            }
        })
}

$("#agregar").click(function() {
    /********NOTE:Comprueba si La radicación está liquidada********/
    var id_radica = $("#radicacion").val();
    var route = "/mostrarliq";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            if (info.validarliqd == '1') { //NOTE:Si la radicación ya está liquidada
                $("#msj5").html(info.mensaje);
                $("#msj-error5").fadeIn();
                setTimeout(function() {
                    $("#msj-error5").fadeOut();
                }, 3000);
            } else if (info.validarliqd == '0') { //NOTE:Si la radicación No está liquidada
                var id_actoperrad = $("#id_actoperrad").val();
                var identificacion_cli = $("#identificacion_cli3").val();
                var porcentaje = $("#porcentajecli3").val();
                var id_cal1 = $("#calidad3").val();
                route = "/almacena";
                type = 'GET';
                datos = {
                    "id_cal1": id_cal1
                };

                if (porcentaje != '') {
                    __ajax(route, token, type, datos)
                        .done(function(info) {
                            var almacena = info.almacena;
                            var calidad = almacena;
                            var datos = {
                                "id_cal1": id_cal1,
                                "id_actoperrad": id_actoperrad,
                                "identificacion_cli": identificacion_cli,
                                "porcentaje": porcentaje
                            };

                            var route;
                            if (calidad == 1) {
                                route = "/otorgante";
                            } else if (calidad == 2) {
                                route = "/compareciente";
                            }

                            var token = $("#token3").val();
                            $.ajax({
                                url: route,
                                headers: {
                                    'X-CSRF-TOKEN': token
                                },
                                type: 'POST',
                                dataType: 'json',
                                data: datos,
                                success: function(info) {
                                    if (info.validar == 0) {
                                        $("#msg").html(info.msg);
                                        Dialogo1();
                                    } else if (info.validar == 1) {
                                        if (calidad == 1) {
                                            CargarOtorgantes(info.otorgantes);
                                        } else if (calidad == 2) {
                                            CargarComparecientes(info.comparecientes);
                                        }
                                    }
                                }
                            });
                        }) //Ajax Donde Almacenar Adicionales
                } else {
                    alert("El campo %Partc es Obligatorio")
                }

            }
        })
});

function ListingPrincipales(id, nombreacto, tradicion, cuantia) {


    $("#calidad1").val('');
    $("#calidad2").val('');
    $("#id_tipoident1").val('');
    $("#id_tipoident2").val('');
    $("#identificacion_cli1").val('');
    $("#identificacion_cli2").val('');
    $("#porcentajecli1").val('');
    $("#porcentajecli2").val('');
    $("#nombre_cli1").val('');
    $("#nombre_cli2").val('');
    $("#Acto_Actual").html('');
    $("#Acto_Actual").html(nombreacto);

    var valor_cuantia = cuantia;


    $("#clientesprincipales").show();

    $("#id_actoperrad").val(id);
    var datos = {
        "id_actoperrad": id,
        "valor_cuantia": valor_cuantia,
        "tradicion": tradicion
    };
    var route = "/verprincipales";
    //var token = $("#token").val();
    $.ajax({
        url: route,
        type: 'GET',
        dataType: 'json',
        data: datos,

        success: function(res) {
            if (res.validarprincipales != 0) {
                $("#calidad1").val(res.principales.id_cal1);
                $("#calidad2").val(res.principales.id_cal2);
                $("#id_tipoident1").val(res.principales.id_tipoident1);
                $("#id_tipoident2").val(res.principales.id_tipoident2);
                $("#identificacion_cli1").val(res.principales.identificacion_cli1);
                $("#identificacion_cli2").val(res.principales.identificacion_cli2);
                $("#porcentajecli1").val(res.principales.porcentajecli1);
                $("#porcentajecli2").val(res.principales.porcentajecli2);
                $("#nombre_cli1").val(res.nombre1);
                $("#nombre_cli2").val(res.nombre2);
            }

            /************NOTE:Se valida el acto para la retefuente****************/
            var datos = {
                "id_acto": res.id_acto
            };
            var route = "/validaractos";
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
                    var validar = info.actos;
                    if (!validar.retefuente) {
                        $("#porcentajecli1").prop('disabled', true);
                        $("#porcentajecli2").prop('disabled', true);
                        $("#porcentajecli1").val(0);
                        $("#porcentajecli2").val(0);
                    }

                    if (validar.retefuente || validar.porcentajes) {
                        $("#porcentajecli1").prop('disabled', false);
                        $("#porcentajecli2").prop('disabled', false);
                        //$("#porcentajecli1").val('');
                        //$("#porcentajecli2").val('');
                    }
                }
            });

            CargarOtorgantes(res.otorgantes);
            CargarComparecientes(res.comparecientes);
        }
    });
}

$("#ActualizarPrincipales").click(function() {
    if ($("#calidad1").val() != '' && $("#calidad2").val() != '' &&
        $("#id_tipoident1").val() != '' && $("#id_tipoident2").val() != '' &&
        $("#identificacion_cli1").val() != '' && $("#identificacion_cli2").val() != '' &&
        $("#porcentajecli1").val() != '' && $("#porcentajecli2").val() != '') {
        /********NOTE:Comprueba si La radicación está liquidada********/
        var id_radica = $("#radicacion").val();
        var route = "/mostrarliq";
        var token = $("#token").val();
        var type = 'GET';
        var datos = {
            "id_radica": id_radica
        };
        __ajax(route, token, type, datos)
            .done(function(info) {
                if (info.validarliqd == '1') { //NOTE:Si la radicación ya está liquidada
                    $("#msj4").html(info.mensaje);
                    $("#msj-error4").fadeIn();
                    setTimeout(function() {
                        $("#msj-error4").fadeOut();
                    }, 3000);
                } else if (info.validarliqd == '0') { //NOTE:Si la radicación No está liquidada
                    var calidad1, calidad2, identificacion_cli, identificacion_cli2,
                        porcentajecli1, porcentajecli2, id, actualizar;
                    id = $("#id_actoperrad").val();
                    id_cal1 = $("#calidad1").val();
                    id_cal2 = $("#calidad2").val();
                    identificacion_cli = $("#identificacion_cli1").val();
                    identificacion_cli2 = $("#identificacion_cli2").val();
                    porcentajecli1 = $("#porcentajecli1").val();
                    porcentajecli2 = $("#porcentajecli2").val();
                    actualizar = 2;
                    datos = {
                        "id_cal1": id_cal1,
                        "id_cal2": id_cal2,
                        "identificacion_cli": identificacion_cli,
                        "identificacion_cli2": identificacion_cli2,
                        "porcentajecli1": porcentajecli1,
                        "porcentajecli2": porcentajecli2,
                        "actualizar": actualizar
                    };

                    var route = "/actosradica/" + id;
                    var token = $("#token").val();

                    $.ajax({
                        url: route,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        type: 'PUT',
                        dataType: 'json',
                        data: datos,
                        success: function(res) {
                            if (res.validar == 0) {
                                $("#msg").html(res.msg);
                                //$("#msj-error2").fadeIn();
                                Dialogo1();


                            } else if (res.validar == 1) {

                            }
                        }
                    });
                }
            })
    } else {
        alert("Todos los campos son obligatorios");
    }
});
