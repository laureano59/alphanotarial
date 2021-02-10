$("#identificacion_cli1").blur(function() {
    if ($("#identificacion_cli1").val() != '') {
        var identificacion_cli = $("#identificacion_cli1").val();
        var tipo_doc = $("#id_tipoident1").val();
        var calidad = 1; //NOTE:Para distinguir en que input se muestra el nombre del cliente
        var datos = {
            "identificacion_cli": identificacion_cli,
            "tipo_doc": tipo_doc
        };
        var route = "/principales";
        var token = $("#token").val();
        var type = "GET";
        __ajax(route, token, type, datos)
            .done(function(info) {
                if (info.validar == '0') {
                    $("#tipo_documento").val(info.tipo_doc);
                    if (info.tipo_doc == 31) { //Si es empresa
                        $("#calidad").val(calidad); //NOTE:Campo oculto en modal cliente
                        $("#identificacion_empresa").val(info.identificacion_cli);
                        LimpiarClientes();
                        $("#modalcliente-empresa").modal('toggle');
                    } else {
                        $("#calidad").val(calidad); //NOTE:Campo oculto en modal cliente
                        $("#identificacion").val(info.identificacion_cli);
                        LimpiarClientes();
                        $("#modalcliente").modal('toggle');
                    }
                } else if (info.validar == '1') {
                    $("#nombre_cli1").val(info.nombre);
                }
            })
    }
});

$("#GuardarActaDeposito").click(function() {
    var identificacion_cli, id_tip, proyecto, deposito_act, id_radica,
        efectivo, cheque, tarjeta_credito, num_cheque, num_tarjetacredito,
        observaciones_act, codigo_ban, anio_fiscal;

    identificacion_cli = $("#identificacion_cli1").val();
    id_tip = $("#id_tip option:selected").val();
    proyecto = $("#proyecto").val();
    deposito_act = $("#deposito_act").val();
    anio_fiscal = $("#anio_fiscal").val();
    id_radica = $("#id_radica").val();
    efectivo = $("#efectivo").val();
    cheque = $("#cheque").val();
    tarjeta_credito = $("#tarjeta_credito").val();
    num_cheque = $("#num_cheque").val();
    num_tarjetacredito = $("#num_tarjetacredito").val();
    observaciones_act = $("#observaciones_act").val();
    codigo_ban = $("#codigo_ban option:selected").val();

    if (identificacion_cli != '' && id_tip != '' && proyecto != '' &&
        deposito_act != '') {
        var datos = {
            "identificacion_cli": identificacion_cli,
            "id_tip": id_tip,
            "proyecto": proyecto,
            "deposito_act": deposito_act,
            "id_radica": id_radica,
            "anio_fiscal": anio_fiscal,
            "efectivo": efectivo,
            "cheque": cheque,
            "tarjeta_credito": tarjeta_credito,
            "num_cheque": num_cheque,
            "num_tarjetacredito": num_tarjetacredito,
            "observaciones_act": observaciones_act,
            "codigo_ban": codigo_ban
        };

        var route = "/actas_deposito";
        var token = $("#token").val();
        var type = 'POST';

        __ajax(route, token, type, datos)
            .done(function(info) {
                $("#id_act").html(info.id_act);
                CargarGridActas(info.actas_depo_all);
            })

    } else {
        alert("Los campos con título Azul son obligatorios");
    }
});

$("#buscarporidentif").click(function() {
    $("#num_acta").html('');
    $("#descuento").val('');
    var opcion, identificacion_cli, tipogrid;
    tipogrid = $("#tipogrid").val();
    opcion = 1;
    identificacion_cli = $("#identif").val();
    if (identificacion_cli != '') {
        var route = "/buscaracta";
        var token = $("#token").val();
        var type = 'GET';

        var datos = {
            "identificacion_cli": identificacion_cli,
            "opcion": opcion
        }

        __ajax(route, token, type, datos)
            .done(function(info) {
                if (tipogrid == 'retiros') {
                    var actas_depo_all = info.actas_depo_all;
                    CargarGridActasEgreso(actas_depo_all);
                } else if (tipogrid == 'depositos') {
                    CargarGridActas(info.actas_depo_all);
                }
            })
    } else {
        alert("Aún no ha escrito el número de Documento que desea buscar");
    }
});

$("#buscarpornumacta").click(function() {
    $("#num_acta").html('');
    $("#descuento").val('');
    var opcion, id_act, tipogrid;
    opcion = 2;
    tipogrid = $("#tipogrid").val();
    id_act = $("#idacta").val();
    if (id_act != '') {
        var route = "/buscaracta";
        var token = $("#token").val();
        var type = 'GET';

        var datos = {
            "id_acta": id_act,
            "opcion": opcion
        }

        __ajax(route, token, type, datos)
            .done(function(info) {
                if (tipogrid == 'retiros') {
                    var actas_depo_all = info.actas_depo_all;
                    CargarGridActasEgreso(actas_depo_all);
                } else if (tipogrid == 'depositos') {
                    CargarGridActas(info.actas_depo_all);
                }
            })
    } else {
        alert("Aún no ha escrito el número de Acta que desea buscar");
    }
});



$("#GuardarEgreso").click(function() {
    var descuento, saldo, nuevosaldo, opcion, id_acta, concepto_egreso, id_radica, observaciones, anio_fiscal;
    id_acta = $("#id_act_iden").val();
    observaciones = $("#observaciones").val();

    if(id_acta == 0){
        alert("Debe Seleccionar el Acta dando click en el nombre del Cliente");
    }else{

        saldo = parseInt($("#saldo_iden").val());
        descuento = $("#descuento").val();
        concepto_egreso = $("#id_con").val();
        if(concepto_egreso == null){
            alert("Debe seleccionar un Tipo Egreso");
        }else{

            id_radica = $("#id_radica").val();
            anio_fiscal = $("#anio_fiscal").val();
            if(id_radica == '' && anio_fiscal == ''){
                alert("Debe ingresar el número de radicación y el año fiscal");
            }else{

            $("#id_act_iden").val(0);

            if (descuento != '') {
                if (saldo >= descuento) {
                    nuevosaldo = saldo - descuento;
                    opcion = 2; //Cuando se hace sin factura ni número de radicación
                    var route = "/egreso";
                    var token = $("#token").val();
                    var type = 'POST';
                    var datos = {
                        "id_acta": id_acta,
                        "id_radica": id_radica,
                        "anio_fiscal": anio_fiscal,
                        "nuevosaldo": nuevosaldo,
                        "descuento": descuento,
                        "concepto_egreso": concepto_egreso,
                        "observaciones": observaciones,
                        "opcion": opcion
                    };
                    __ajax(route, token, type, datos)
                    .done(function(info) {
                        if (info.validar == 1) {
                            $("#msj1").html(info.mensaje);
                            $("#msj-error1").fadeIn();
                            setTimeout(function() {
                                $("#msj-error1").fadeOut();
                            }, 4000);


                            route = "/depositos/" + id_acta;
                            type = 'PUT';
                            datos = {
                                "nuevosaldo": nuevosaldo
                            };
                            __ajax(route, token, type, datos)
                                .done(function(info) {
                                    if (info.validar == 1) {
                                    //Recargo grid por identificacion o por id_act
                                    }
                                })
                        }
                    }) //AJAX Nuevo Saldo

        } else {
            alert("El Saldo es Insuficiente Para este descuento");
        }
    } else {
        alert("Debes asignar el valor a descontar");
    }

            }



        }


        

    }

    
});

function mayus(e) {
    e.value = e.value.toUpperCase();
}
