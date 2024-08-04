function CargarDerechos_FactUnica(validar) {
    var htmlTags = "";
    var totalderechos = 0;
    for (item in validar) {
        totalderechos += parseFloat(validar[item].derechos);
        htmlTags +=
            '<tr>' +
            '<td>' +
            validar[item].nombre_acto +
            '</td>' +
            '<td bgcolor="#ccffcc" align="right">' + formatNumbderechos(Math.round(validar[item].derechos)) +
            '</td>' +
            '</tr>';
    }

    document.getElementById('actos').innerHTML = htmlTags;
    $("#totderechos").val(Math.round(totalderechos));
}


function SumarTotales(valor, longitud) {

    var grantotalotor = 0;
    var grantotalcompa = 0;

    for (var i = 1; i <= longitud; i++) {
        if ($("#sumotor" + i).val() == '') {
            $("#sumotor" + i).val(0);
        }
        grantotalotor = parseFloat($("#sumotor" + i).val()) + grantotalotor;

        if ($("#sumcompa" + i).val() == '') {
            $("#sumcompa" + i).val(0);
        }
        grantotalcompa = parseFloat($("#sumcompa" + i).val()) + grantotalcompa;
    }
    $("#tototorgante").html(formatNumbderechos(grantotalotor));
    $("#totcompareciente").html(formatNumbderechos(grantotalcompa));
    $("#grantotalotorderechosiden").val(grantotalotor);
    $("#grantotalcompaderechosiden").val(grantotalcompa);

    var subtotalotorgante = grantotalotor + parseFloat($("#grantotalotorconceptosiden").val());
    $("#subtototorganteiden").val(subtotalotorgante);
    $("#subtototorgante").html(formatNumbderechos(subtotalotorgante));

    var subtotalcompareciente = grantotalcompa + parseFloat($("#grantotalcompaconceptosiden").val());
    $("#subtotcomparecienteiden").val(subtotalcompareciente);
    $("#subtotcompareciente").html(formatNumbderechos(subtotalcompareciente));

    /***Porcentaje del iva****/
    var id_tar = 9;
    var route = "/tarifas";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_tar": id_tar
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            var porcentajeiva = parseFloat((info.porcentajeiva) / 100);

            var totalivaotorgante = parseFloat(subtotalotorgante * porcentajeiva);
            $("#totalivaotoriden").val(Math.round(totalivaotorgante));
            $("#totalivaotor").html(formatNumbderechos(Math.round(totalivaotorgante)));

            var totalivacompareciente = parseFloat(subtotalcompareciente * porcentajeiva);
            $("#totalivacompaiden").val(Math.round(totalivacompareciente));
            $("#totalivacompa").html(formatNumbderechos(Math.round(totalivacompareciente)));
        })

    var grantotalotorgante = 0;
    var grantotalcompareciente = 0;

    grantotalotorgante = parseFloat($("#subtototorganteiden").val()) +
        parseFloat($("#totalivaotoriden").val()) + parseFloat($("#rtfotoriden").val()) +
        parseFloat($("#impconsumootoriden").val()) + parseFloat($("#totalsuperotoriden").val()) +
        parseFloat($("#totalfondocompaiden").val());
    $("#grantotalotorganteiden").val(Math.round(grantotalotorgante));
    $("#grantotalotorgante").html(formatNumbderechos(Math.round(grantotalotorgante)));

    grantotalcompareciente = parseFloat($("#subtotcomparecienteiden").val()) +
        parseFloat($("#totalivacompaiden").val()) + parseFloat($("#rtfcompaiden").val()) +
        parseFloat($("#impconsumocompaiden").val()) + parseFloat($("#totalsupercompaiden").val()) +
        parseFloat($("#totalfondocompaiden").val());
    $("#grantotalcomparecienteiden").val(Math.round(grantotalcompareciente));
    $("#grantotalcompareciente").html(formatNumbderechos(Math.round(grantotalcompareciente)));
}

function CargarDerechos_Fact_Multiple(validar) {
    var htmlTags = "";
    var porcentajecomprador, porcentajevendedor, quien, porcentaje;
    porcentajecomprador = parseFloat($("#porcentajecomprador").val() / 100);
    porcentajevendedor = parseFloat($("#porcentajevendedor").val() / 100);
    quien = $('input:radio[name=porcentajes]:checked').val();
    if (quien == 'comprador') {
        porcentaje = porcentajecomprador;
        $("#parti1").html($("#porcentajecomprador").val());
        $("#parti2").html($("#porcentajecomprador").val());
        $("#parti3").html($("#porcentajecomprador").val());
    } else if (quien == 'vendedor') {
        porcentaje = porcentajevendedor;
        $("#parti1").html($("#porcentajevendedor").val());
        $("#parti2").html($("#porcentajevendedor").val());
        $("#parti3").html($("#porcentajevendedor").val());
    }

    var i = 1;
    var longitud = validar.length;

    for (item in validar) {
        htmlTags +=
            '<tr>' +
            '<td width="30%">' +
            validar[item].nombre_acto +
            '</td>' +
            '<td width="20%" bgcolor="#ccffcc" align="right">' +
            formatNumbderechos(Math.round(validar[item].derechos)) +
            '</td>' +
            '<td width="20%" bgcolor="#FFF9BB" align="right">' +
            formatNumbderechos(Math.round(validar[item].derechos * porcentaje)) +
            '</td>' +
            '<td width="10%">' +
            '<input type="text" id="porcentaje' + i + '" maxlength="3" class="col-xs-10 col-sm-8" onblur="porcentaje_fact_multiple(\'' + (validar[item].derechos * porcentaje) + '\',\'' + i + '\',\'' + longitud + '\'' + ')" onKeyPress="return soloNumeros(event)" />' +
            '</td>' +
            '<td width="20%" bgcolor="#ccffcc" align="right">' +
            '<span id="totalderechos' + i + '"></span>' +
            '<input type="hidden" id="totalderechosiden' + i + '" />' +
            '</td>' +
            '</tr>';
        i++;
    }
    document.getElementById('actos').innerHTML = htmlTags;
}

function porcentaje_fact_multiple(derechos, i, longitud) {
    var porcentaje = $("#porcentaje" + i).val();
    porcentaje = (parseInt(porcentaje)) / 100;
    var derechos_fact_mul = 0;
    derechos_fact_mul = parseFloat(derechos) * porcentaje;
    $("#totalderechosiden" + i).val(derechos_fact_mul);

    if ($("#porcentaje" + i).val() == '') {
        $("#porcentaje" + i).val(0);
    }

    $("#totalderechos" + i).html(formatNumbderechos(Math.round(derechos_fact_mul)));

    SumarTotalesFactMutiple(derechos_fact_mul, longitud);

}

function SumarTotalesFactMutiple(valor, longitud) {
    var totalderechos = 0;

    for (var i = 1; i <= longitud; i++) {
        if ($("#totalderechos" + i).val() == '') {
            $("#totalderechos" + i).val(0);
        }
        totalderechos = parseFloat($("#totalderechosiden" + i).val()) + totalderechos;
    }

    $("#totderechos").val(totalderechos);
    if ($("#totconceptos").val() == '') {
        $("#totconceptos").val(0);
    }
    var subtotal = parseFloat($("#totconceptos").val()) + parseFloat($("#totderechos").val());
    $("#subtotal").html(formatNumbderechos(Math.round(subtotal)));

    /***Porcentaje del iva****/
    var id_tar = 9;
    var route = "/tarifas";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_tar": id_tar
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            var porcentajeiva = parseFloat((info.porcentajeiva) / 100);
            var totaliva = parseFloat(subtotal * porcentajeiva);
            $("#totiva").val(Math.round(totaliva));
            $("#iva").html(formatNumbderechos(Math.round(totaliva)));
        })

        Total_Menos_Deducciones();
}

function Calcular_Conceptos_FactMultiple(atributo, totalconcepto) {
    var porcentaje, total, totalconceptoiden;
    porcentaje = parseFloat($("#porcentaje" + atributo).val() / 100);
    total = $("#" + totalconcepto + "participacioniden").val() * porcentaje;
    $("#totalconcepto" + atributo).html(formatNumbderechos(total));
    totalconceptoiden = "totalconcepto" + atributo + "iden";
    $("#" + totalconceptoiden).val(total);
    SumarConceptosFactMul();
}

function SumarConceptosFactMul() {
    var datos = {
        "id_radica": 0
    };
    var route = "/traeconceptos";
    var token = $("#token").val();
    var type = 'GET';
    __ajax(route, token, type, datos)
        .done(function(info) {
            var conceptos = info.conceptos;
            var sumatoria = 0;
            var totalconceptoiden;
            for (item in conceptos) {
                totalconceptoiden = "totalconcepto" + conceptos[item].atributo + "iden";
                if ($("#" + totalconceptoiden).val() == '') {
                    $("#" + totalconceptoiden).val(0)
                }
                sumatoria = parseFloat($("#" + totalconceptoiden).val()) + sumatoria;
            }
            $("#totconceptos").val(sumatoria);
            if ($("#totderechos").val() == '') {
                $("#totderechos").val(0);
            }
            var subtotal = parseFloat($("#totconceptos").val()) + parseFloat($("#totderechos").val());
            $("#subtotal").html(formatNumbderechos(Math.round(subtotal)));

            /***NOTE: Porcentaje del iva****/
            var id_tar = 9;
            route = "/tarifas";
            token = $("#token").val();
            type = 'GET';
            datos = {
                "id_tar": id_tar
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    var porcentajeiva = parseFloat((info.porcentajeiva) / 100);
                    var totaliva = parseFloat(subtotal * porcentajeiva);
                    $("#totiva").val(Math.round(totaliva));
                    $("#iva").html(formatNumbderechos(Math.round(totaliva)));
                })
        })

        Total_Menos_Deducciones();
}

$("#recalcularfactmultiple").click(function() {
  Total_Menos_Deducciones();
});

function CagarConceptos_Fact_Multiple(validar) {
    var porcentajecomprador, porcentajevendedor, quien, porcentaje;
    porcentajecomprador = parseFloat($("#porcentajecomprador").val() / 100);
    porcentajevendedor = parseFloat($("#porcentajevendedor").val() / 100);
    quien = $('input:radio[name=porcentajes]:checked').val();
    if (quien == 'comprador') {
        porcentaje = porcentajecomprador;
    } else if (quien == 'vendedor') {
        porcentaje = porcentajevendedor;
    }
    for (item in validar) {
        datos = {
            "id_radica": 0
        };
        var route = "/traeconceptos";
        var token = $("#token").val();
        var type = 'GET';
        __ajax(route, token, type, datos)
            .done(function(info) {
                var conceptos = info.conceptos;
                var atributo;
                var atributototal;
                var atributoparticipacion;
                var atributoparticipacioniden;

                for (item2 in conceptos) {
                    totalatributo = "total" + conceptos[item2].atributo;
                    atributo = conceptos[item2].atributo;
                    totalatributoiden = "total" + conceptos[item2].atributo + "iden";
                    atributoparticipacion = "total" + conceptos[item2].atributo + "participacion";
                    atributoparticipacioniden = "total" + conceptos[item2].atributo + "participacioniden";
                    if (parseFloat(validar[item][totalatributo]) > 0) {
                        $("#" + atributo).fadeIn();
                        $("#" + totalatributo).html(formatNumbderechos(validar[item][totalatributo]));
                        $("#" + totalatributoiden).val(validar[item][totalatributo]);
                        $("#" + atributoparticipacion).html(formatNumbderechos(validar[item][totalatributo] * porcentaje));
                        $("#" + atributoparticipacioniden).val(parseFloat(validar[item][totalatributo] * porcentaje));
                    } else if (parseFloat(validar[item][totalatributo]) < 1) {
                        $("#" + atributo).fadeOut();
                    }
                }
            })
    }
}

function CargarRecaudos_Fact_Multiple(validar) {
    var porcentajecomprador, porcentajevendedor, quien, porcentaje;
    porcentajecomprador = parseFloat($("#porcentajecomprador").val() / 100);
    porcentajevendedor = parseFloat($("#porcentajevendedor").val() / 100);
    quien = $('input:radio[name=porcentajes]:checked').val();
    if (quien == 'comprador') {
        porcentaje = porcentajecomprador;
    } else if (quien == 'vendedor') {
        porcentaje = porcentajevendedor;
    }

    var grantotal = 0;
    for (item in validar) {
        if (parseFloat(validar[item].retefuente) > 0) {
            $("#totalrtf").html(formatNumbderechos(validar[item].retefuente));
            $("#totalrtfiden").val(validar[item].retefuente);
            $("#totalrtfparticipacion").html(formatNumbderechos(validar[item].retefuente * porcentaje));
            $("#totalrtfparticipacioniden").val(validar[item].retefuente * porcentaje);
        } else if (parseFloat(validar[item].retefuente) < 1) {
            $("#totalrtf").html('0.00');
            $("#totalrtfiden").val(0);
            $("#totalrtfparticipacion").html('0.00');
            $("#totalrtfparticipacioniden").val(0);
        }

        if (parseFloat(validar[item].recsuper) > 0) {
            $("#totalsuper").html(formatNumbderechos(validar[item].recsuper));
            $("#totalsuperiden").val(validar[item].recsuper);
            $("#totalsuperparticipacion").html(formatNumbderechos(validar[item].recsuper * porcentaje));
            $("#totalsuperparticipacioniden").val(validar[item].recsuper * porcentaje);
        } else if (parseFloat(validar[item].recsuper) < 1) {
            $("#totalsuper").html('0.00');
            $("#totalsuperiden").val(0);
            $("#totalsuperparticipacion").html('0.00');
            $("#totalsuperparticipacioniden").val(0);
        }

        if (parseFloat(validar[item].recfondo) > 0) {
            $("#totalfondo").html(formatNumbderechos(validar[item].recfondo));
            $("#totalfondoiden").val(parseFloat(validar[item].recfondo));
            $("#totalfondoparticipacion").html(formatNumbderechos(validar[item].recfondo * porcentaje));
            $("#totalfondoparticipacioniden").val(validar[item].recfondo * porcentaje);
        } else if (parseFloat(validar[item].recfondo) < 1) {
            $("#totalfondo").html('0.00');
            $("#totalfondoiden").val(0);
            $("#totalfondoparticipacion").html('0.00');
            $("#totalfondoparticipacioniden").val(0);
        }

        if (parseFloat(validar[item].aporteespecial) > 0) {
            $("#totalaporteespecial").html(formatNumbderechos(validar[item].aporteespecial));
            $("#totalaporteespecialiden").val(parseFloat(validar[item].aporteespecial));
            $("#totalaporteespecialparticipacion").html(formatNumbderechos(validar[item].aporteespecial * porcentaje));
            $("#totalaporteespecialparticipacioniden").val(validar[item].aporteespecial * porcentaje);
        } else if (parseFloat(validar[item].aporteespecial) < 1) {
            $("#totalaporteespecial").html('0.00');
            $("#totalaporteespecialiden").val(0);
            $("#totalaporteespecialparticipacion").html('0.00');
            $("#totalaporteespecialparticipacioniden").val(0);
        }

        if (parseFloat(validar[item].impuestotimbre) > 0) {
            $("#totalimpuestotimbre").html(formatNumbderechos(validar[item].impuestotimbre));
            $("#totalimpuestotimbreiden").val(parseFloat(validar[item].impuestotimbre));
            $("#totalimpuestotimbreparticipacion").html(formatNumbderechos(validar[item].impuestotimbre * porcentaje));
            $("#totalimpuestotimbreparticipacioniden").val(validar[item].impuestotimbre * porcentaje);
        } else if (parseFloat(validar[item].impuestotimbre) < 1) {
            $("#totalimpuestotimbre").html('0.00');
            $("#totalimpuestotimbreiden").val(0);
            $("#totalimpuestotimbreparticipacion").html('0.00');
            $("#totalimpuestotimbreparticipacioniden").val(0);
        }
    }
    
}

function Calcular_Recaudos_FactMultiple() {
    var pagosuper, pagosuperiden, pagofondo, pagofondoiden, 
    pagoaporteespecial, pagoaporteespecialiden, 
    pagoimpuestotimbre, pagoimpuestotimbreiden, porcentajeimpuestotimbre,
    totalcompleto, porcentajesuper, porcentajefondo, porcentajeaporteespecial, totalsuperparticipacioniden,
    totalfondoparticipacioniden, pagortf, pagortfiden;

    porcentajertf = parseFloat($("#porcentajertf").val() / 100);
    porcentajesuper = parseFloat($("#porcentajesuper").val() / 100);
    porcentajefondo = parseFloat($("#porcentajefondo").val() / 100);
    porcentajeaporteespecial = parseFloat($("#porcentajeaporteespecial").val() / 100);
    porcentajeimpuestotimbre = parseFloat($("#porcentajeimpuestotimbre").val() / 100);
   
    totalrtfparticipacioniden = $("#totalrtfparticipacioniden").val();
    totalsuperparticipacioniden = $("#totalsuperparticipacioniden").val();
    totalfondoparticipacioniden = $("#totalfondoparticipacioniden").val();
    totalaporteespecialparticipacioniden = $("#totalaporteespecialparticipacioniden").val();
    totalimpuestotimbreparticipacioniden = $("#totalimpuestotimbreparticipacioniden").val();
    
    pagortf = parseFloat(totalrtfparticipacioniden * porcentajertf);
    pagosuper = parseFloat(totalsuperparticipacioniden * porcentajesuper);
    pagofondo = parseFloat(totalfondoparticipacioniden * porcentajefondo);
    pagoaporteespecial = parseFloat(totalaporteespecialparticipacioniden * porcentajeaporteespecial);
    pagoimpuestotimbre = parseFloat(totalimpuestotimbreparticipacioniden * porcentajeimpuestotimbre);

    $("#totrtf").val(pagortf);
    $("#totfondo").val(pagofondo);
    $("#totsuper").val(pagosuper);
    $("#totaporteespecial").val(pagoaporteespecial);
    $("#totimpuestotimbre").val(pagoimpuestotimbre);


    $("#pagortf").html(formatNumbderechos(Math.round(pagortf)));
    $("#pagosuper").html(formatNumbderechos(Math.round(pagosuper)));
    $("#pagofondo").html(formatNumbderechos(Math.round(pagofondo)));
    $("#pagoaporteespecial").html(formatNumbderechos(Math.round(pagoaporteespecial)));
    $("#pagoimpuestotimbre").html(formatNumbderechos(Math.round(pagoimpuestotimbre)));
    
    $("#pagortfiden").val(pagortf);
    $("#pagosuperiden").val(pagosuper);
    $("#pagofondoiden").val(pagofondo);
    $("#pagoaporteespecialiden").val(pagoaporteespecial);
    $("#pagoimpuestotimbreiden").val(pagoimpuestotimbre);

    $("#rtf").html(formatNumbderechos(Math.round(pagortf)));
    $("#super").html(formatNumbderechos(Math.round(pagosuper)));
    $("#fondo").html(formatNumbderechos(Math.round(pagofondo)));
    $("#aporteespecial").html(formatNumbderechos(Math.round(pagoaporteespecial)));
    $("#impuestotimbre").html(formatNumbderechos(Math.round(pagoimpuestotimbre)));

   
}

function CagarConceptos(validar) {
    for (item in validar) {
        datos = {
            "id_radica": 0
        };
        var route = "/traeconceptos";
        var token = $("#token").val();
        var type = 'GET';
        __ajax(route, token, type, datos)
            .done(function(info) {
                var conceptos = info.conceptos;
                var atributo;
                var hojasatributo;
                var atributototal;
                for (item2 in conceptos) {
                    totalatributo = "total" + conceptos[item2].atributo;
                    atributo = conceptos[item2].atributo;
                    totalatributoiden = "total" + conceptos[item2].atributo + "iden";
                    if (parseFloat(validar[item][totalatributo]) > 0) {
                        $("#" + atributo).fadeIn();
                        $("#" + totalatributo).html(formatNumbderechos(validar[item][totalatributo]));
                        $("#" + totalatributoiden).val(validar[item][totalatributo]);
                    } else if (parseFloat(validar[item][totalatributo]) < 1) {
                        $("#" + atributo).fadeOut();
                    }
                }
            })

        if (parseFloat(validar[item].totalconceptos) > 0) {
            $("#totconceptos").val(parseFloat(validar[item].totalconceptos));
        } else if (parseFloat(validar[item].totalconceptos) < 1) {
            $("#totconceptos").val(0);
        }
    }

    var subtotal = parseFloat($("#totconceptos").val()) + parseFloat($("#totderechos").val());
    $("#subtotal").html(formatNumbderechos(Math.round(subtotal)));
}


function CargarRecaudos(validar) {
   
    var grantotal = 0;
    for (item in validar) {
        grantotal = parseFloat(validar[item].grantotalliq);
        if (parseFloat(validar[item].iva) > 0) {
            $("#totiva").val(parseFloat(validar[item].iva));
            $("#iva").html(formatNumbderechos(Math.round($("#totiva").val())));
        } else if (parseFloat(validar[item].iva) < 1) {
            $("#iva").html('$0.00');
        }

        if (parseFloat(validar[item].retefuente) > 0) {
            $("#totrtf").val(parseFloat(Math.round(validar[item].retefuente)));
            $("#rtf").html(formatNumbderechos(Math.round($("#totrtf").val())));
        } else if (parseFloat(validar[item].retefuente) < 1) {
            $("#totrtf").val(0);
            $("#rtf").html('$0.00');
        } else {
            $("#totrtf").val(0);
            $("#rtf").html('$0.00');
        }

        if (parseFloat(validar[item].reteconsumo) > 0) {
            $("#totreteconsumo").val(parseFloat(validar[item].reteconsumo));
            $("#reteconsumo").html(formatNumbderechos($("#totreteconsumo").val()));
        } else if (parseFloat(validar[item].reteconsumo) < 1) {
            $("#reteconsumo").html('0.00');
        }

         if (parseFloat(validar[item].aporteespecial) > 0) {
            $("#totaporteespecial").val(parseFloat(validar[item].aporteespecial));
            $("#aporteespecial").html(formatNumbderechos($("#totaporteespecial").val()));
        } else if (parseFloat(validar[item].aporteespecial) < 1) {
            $("#aporteespecial").html('0.00');
        }

         if (parseFloat(validar[item].impuestotimbre) > 0) {
            $("#totimpuestotimbre").val(parseFloat(validar[item].impuestotimbre));
            $("#impuestotimbre").html(formatNumbderechos($("#totimpuestotimbre").val()));
        } else if (parseFloat(validar[item].impuestotimbre) < 1) {
            $("#impuestotimbre").html('0.00');
        }

        if (parseFloat(validar[item].recsuper) > 0) {
            $("#totsuper").val(parseFloat(validar[item].recsuper));
            $("#super").html(formatNumbderechos($("#totsuper").val()));
        } else if (parseFloat(validar[item].recsuper) < 1) {
            $("#super").html('0.00');
        }

        if (parseFloat(validar[item].recfondo) > 0) {
            $("#totfondo").val(parseFloat(validar[item].recfondo));
            $("#fondo").html(formatNumbderechos($("#totfondo").val()));
        } else if (parseFloat(validar[item].recfondo) < 1) {
            $("#fondo").html('0.00');
        }
    }
    $("#grantotal").val(grantotal);
    $("#totalcompleto").html(formatNumbderechos(Math.round($("#grantotal").val())));
}


function CargarAnombreDe(validar, calidad) {
    var htmlTags = "";
    for (item in validar) {
        htmlTags +=
            '<tr>' +
            '<td>' +
            '<a href="javascript://" OnClick="Llevar(\'' + validar[item].id + '\', \'' + validar[item].fullname + '\', \'' + validar[item].autoreteiva + '\',\'' + validar[item].autoretertf + '\',\'' + validar[item].autoreteica + '\',\'' + validar[item].id_ciud + '\', \'' + calidad + '\');">' +
            validar[item].id +
            '</a>' +
            '</td>' +
            '<td>' +
            validar[item].fullname +
            '</td>' +
            '<td>' +
            '<a href="javascript://"  OnClick="A_Cargo(\'' + validar[item].id + '\');">' +
                '<i><img src="images/comprobar.png" width="14 px" height="14 px" title="Selecciona"></i>'+
            '</a>'+

            '</td>' +
            '</tr>';
    }
    document.getElementById('datos_anombrede').innerHTML = htmlTags;
    $('#mod_anombrede').modal('toggle');
}

function A_Cargo(doc){

    $("#detalle_acargo_de").val('');
    $('#mod_acargo_de').modal('toggle');
    $("#doc_acargo_de").val(doc);
}

function Llevar(doc, nombre, autoreteiva, autoretertf, autoreteica, id_ciud, calidad) {
    if (calidad == 7) { //Para factura unica
        $("#identificacion_cli1").val(doc);
        $("#nombre_cli1").val(nombre);

        if (autoreteiva == 'true') {
            var id_tar = 26;
            var route = "/tarifas";
            var token = $("#token").val();
            var type = 'GET';
            var datos = {
                "id_tar": id_tar
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    var tarifa = info.porcentajeiva; //Tarifa reteiva
                    var reteiva = parseFloat($("#totiva").val() * tarifa);
                    $("#reteivaide").val(Math.round(reteiva));
                    $("#reteiva").html('-' + formatNumbderechos(Math.round(reteiva)));
                    /******NOTE:Recalcula Gran Total con las deducciones******/
                    Total_Menos_Deducciones();
                })

        } else if (autoreteiva == 'false') {
            var reteiva = 0;
            $("#reteivaide").val(reteiva);
            $("#reteiva").html('-' + formatNumbderechos(reteiva));
            Total_Menos_Deducciones();
        }
        if (autoretertf == 'true') {
            var id_tar = 28;
            var route = "/tarifas";
            var token = $("#token").val();
            var type = 'GET';
            var datos = {
                "id_tar": id_tar
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    var tarifa = info.porcentajeiva; //Tarifa retertf
                    var ingresos = parseFloat($("#totderechos").val()) + parseFloat($("#totconceptos").val());
                    var retertf = ingresos * tarifa;
                    $("#retertfide").val(Math.round(retertf));
                    $("#retertf").html('-' + formatNumbderechos(Math.round(retertf)));
                    Total_Menos_Deducciones();
                })

        } else if (autoretertf == 'false') {
            var retertf = 0;
            $("#retertfide").val(retertf);
            $("#retertf").html('-' + formatNumbderechos(retertf));
            Total_Menos_Deducciones();
        }

        if (autoreteica == 'true') {
            var route = "/validarciudad";
            var token = $("#token").val();
            var type = 'GET';
            var datos = {
                "id_ciud": id_ciud
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    if (info.validar == 1) {
                        var id_tar = 27;
                        var route = "/tarifas";
                        var token = $("#token").val();
                        var type = 'GET';
                        var datos = {
                            "id_tar": id_tar
                        };
                        __ajax(route, token, type, datos)
                            .done(function(info) {
                                var ingresos = parseFloat($("#totderechos").val()) + parseFloat($("#totconceptos").val());
                                var tarifa = (info.porcentajeiva) / 1000; //Tarifa reteica
                                var reteica = ingresos * tarifa;
                                $("#reteicaide").val(Math.round(reteica));
                                $("#reteica").html('-' + formatNumbderechos(Math.round(reteica)));
                                Total_Menos_Deducciones();
                            })
                    } else if (info.validar == 0) {
                        var reteica = 0;
                        $("#reteicaide").val(reteica);
                        $("#reteica").html('-' + formatNumbderechos(reteica));
                        Total_Menos_Deducciones();
                    }

                })

        } else if (autoreteica == 'false') {
            var reteica = 0;
            $("#reteicaide").val(reteica);
            $("#reteica").html('-' + formatNumbderechos(reteica));
            Total_Menos_Deducciones();
        }
        $('#mod_anombrede').modal('toggle');

        /***Si el cliente tiene depositos****/

        route = "/validaractadeposito";
        token = $("#token").val();
        type = 'GET';
        datos = {
            "identificacion_cli": doc
        };
        __ajax(route, token, type, datos)
            .done(function(info) {
                if (info.validar == 0) {
                    //alert("no hay actas");
                } else if (info.validar == 1) {
                    var actas_deposito = info.actas_deposito;
                    Cargar_Actas_Cliente(actas_deposito);
                    $('#mod_egresos_actas_fact').modal('toggle');
                }
            })

    } else if (calidad == 3) { //Factura Multiple
     

      /*********Se calcula retención en la Fuente con los porcentajes de
      ***********************cada vendedor*****************************/
      var identificacion_cli = doc;
      //var route = "/retefuenteporvendedor";
      //var token = $("#token").val();
      //var type = 'GET';
      //var datos = {
         // "identificacion_cli": identificacion_cli
      //};
      //__ajax(route, token, type, datos)
        //  .done(function(info) {
          //  if(info.validar == 0){
            //}else if(info.validar == 1){
              //var rtfcliente = info.rtfcliente;
              //$("#rtf").html(formatNumbderechos(rtfcliente));
              //$("#totrtf").val(rtfcliente);
              //Total_Menos_Deducciones();
            //}
          //})

        $("#identificacion_cli1").val(doc);
        $("#nombre_cli1").val(nombre);

        if (autoreteiva == 'true') {
            var id_tar = 26;
            var route = "/tarifas";
            var token = $("#token").val();
            var type = 'GET';
            var datos = {
                "id_tar": id_tar
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    var tarifa = info.porcentajeiva; //Tarifa reteiva
                    var reteiva = parseFloat($("#totiva").val() * tarifa);
                    $("#reteivaide").val(Math.round(reteiva));
                    $("#reteiva").html('-' + formatNumbderechos(Math.round(reteiva)));
                    /******NOTE:Recalcula Gran Total con las deducciones******/
                    //console.log(reteiva);
                    Total_Menos_Deducciones();
                })

        } else if (autoreteiva == 'false') {
            var reteiva = 0;
            $("#reteivaide").val(reteiva);
            $("#reteiva").html('-' + formatNumbderechos(reteiva));
            Total_Menos_Deducciones();
        }
        if (autoretertf == 'true') {
            var id_tar = 28;
            var route = "/tarifas";
            var token = $("#token").val();
            var type = 'GET';
            var datos = {
                "id_tar": id_tar
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    var tarifa = info.porcentajeiva; //Tarifa retertf
                    var ingresos = parseFloat($("#totderechos").val()) + parseFloat($("#totconceptos").val());
                    var retertf = ingresos * tarifa;
                    $("#retertfide").val(Math.round(retertf));
                    $("#retertf").html('-' + formatNumbderechos(Math.round(retertf)));
                    Total_Menos_Deducciones();
                })

        } else if (autoretertf == 'false') {
            var retertf = 0;
            $("#retertfide").val(retertf);
            $("#retertf").html('-' + formatNumbderechos(retertf));
            Total_Menos_Deducciones();
        }

        if (autoreteica == 'true') {
            var route = "/validarciudad";
            var token = $("#token").val();
            var type = 'GET';
            var datos = {
                "id_ciud": id_ciud
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    if (info.validar == 1) {
                        var id_tar = 27;
                        var route = "/tarifas";
                        var token = $("#token").val();
                        var type = 'GET';
                        var datos = {
                            "id_tar": id_tar
                        };
                        __ajax(route, token, type, datos)
                            .done(function(info) {
                                var ingresos = parseFloat($("#totderechos").val()) + parseFloat($("#totconceptos").val());
                                var tarifa = (info.porcentajeiva) / 1000; //Tarifa reteica
                                var reteica = ingresos * tarifa;
                                $("#reteicaide").val(Math.round(reteica));
                                $("#reteica").html('-' + formatNumbderechos(Math.round(reteica)));
                                Total_Menos_Deducciones();
                            })
                    } else if (info.validar == 0) {
                        var reteica = 0;
                        $("#reteicaide").val(reteica);
                        $("#reteica").html('-' + formatNumbderechos(reteica));
                        Total_Menos_Deducciones();
                    }

                })

        } else if (autoreteica == 'false') {
            var reteica = 0;
            $("#reteicaide").val(reteica);
            $("#reteica").html('-' + formatNumbderechos(reteica));
            Total_Menos_Deducciones();
        }
        $('#mod_anombrede').modal('toggle');

        /***Si el cliente tiene depositos****/

        route = "/validaractadeposito";
        token = $("#token").val();
        type = 'GET';
        datos = {
            "identificacion_cli": doc
        };
        __ajax(route, token, type, datos)
            .done(function(info) {
                if (info.validar == 0) {
                    //alert("no hay actas");
                } else if (info.validar == 1) {
                    var actas_deposito = info.actas_deposito;
                    Cargar_Actas_Cliente(actas_deposito);
                    $('#mod_egresos_actas_fact').modal('toggle');
                }
            })
    }

}

function Total_Menos_Deducciones() {
    /******Recalcula Gran Total con las deducciones******/
    var grantotal = parseFloat($("#totderechos").val()) +
        parseFloat($("#totconceptos").val()) +
        parseFloat($("#totiva").val()) +
        parseFloat($("#totrtf").val()) +
        parseFloat($("#totreteconsumo").val()) +
        parseFloat($("#totaporteespecial").val()) +
        parseFloat($("#totimpuestotimbre").val()) +
        parseFloat($("#totfondo").val()) +
        parseFloat($("#totsuper").val());

    var deducciones = parseFloat($("#reteivaide").val()) +
        parseFloat($("#retertfide").val()) +
        parseFloat($("#reteicaide").val());



    grantotal = Math.round(grantotal - deducciones);
    
    $("#grantotal").val(grantotal);
    $("#totalcompleto").html(formatNumbderechos(grantotal));

}

function Total_Menos_Deducciones_Otor() {
    /******Recalcula Gran Total con las deducciones******/
    var grantotal = parseFloat($("#grantotalotorderechosiden").val()) +
        parseFloat($("#grantotalotorconceptosiden").val()) +
        parseFloat($("#totalivaotoriden").val()) +
        parseFloat($("#rtfotoriden").val()) +
        parseFloat($("#impconsumootoriden").val()) +
        parseFloat($("#totalfondootoriden").val()) +
        parseFloat($("#totalsuperotoriden").val());

    var deducciones = parseFloat($("#reteivaotoriden").val()) +
        parseFloat($("#retertfotoriden").val()) +
        parseFloat($("#reteicaotoriden").val());

    grantotal = Math.round(grantotal - deducciones);
    $("#grantotalotorganteiden").val(grantotal);
    $("#grantotalotorgante").html(formatNumbderechos(grantotal));

}

function Total_Menos_Deducciones_Compa() {
    /******Recalcula Gran Total con las deducciones******/
    var grantotal = parseFloat($("#grantotalcompaderechosiden").val()) +
        parseFloat($("#grantotalcompaconceptosiden").val()) +
        parseFloat($("#totalivacompaiden").val()) +
        parseFloat($("#rtfcompaiden").val()) +
        parseFloat($("#impconsumocompaiden").val()) +
        parseFloat($("#totalfondocompaiden").val()) +
        parseFloat($("#totalsupercompaiden").val());

    var deducciones = parseFloat($("#reteivacompiden").val()) +
        parseFloat($("#retertfcompiden").val()) +
        parseFloat($("#reteicacompiden").val());

    grantotal = Math.round(grantotal - deducciones);
    $("#grantotalcomparecienteiden").val(grantotal);
    $("#grantotalcompareciente").html(formatNumbderechos(grantotal));

}

function Cargar_Actas_Cliente(data) {
    var htmlTags = "";
    var i = 1;
    var longitud = data.length;
    for (item in data) {
        htmlTags +=
            '<tr>' +
            '<td>' +
            data[item].id_act +
            '</td>' +
            '<td>' +
            data[item].fecha_acta +
            '</td>' +
            '<td>' +
            '<font size="1">' + data[item].proyecto + '</font>' +
            '</td>' +
            '<td>' +
            '<font size="1">' + data[item].tipo_deposito + '</font>' +
            '</td>' +
            '<td>' +
            formatNumbderechos(Math.round(data[item].deposito_act)) +
            '</td>' +
            '<td>' +
            formatNumbderechos(Math.round(data[item].saldo)) +
            '</td>' +
            '<td>' +
            '<input type="text" id="descuento' + i + '"  onKeyPress="return soloNumeros(event)" />' +
            '</td>' +
            '<td>' +
            '<a href="javascript://" OnClick="GenerarDescuento(\'' + data[item].id_act + '\',\'' + i + '\',\'' + data[item].saldo + '\',\'' + data[item].identificacion_cli + '\'' + ');">' +
            '<i><img src="images/comprobar.png" width="28 px" height="28 px" title="Generar Descuento"></i>' +
            '</a>' +
            '</td>' +
            '</tr>';
        i++;
    }

    document.getElementById('datos_acta').innerHTML = htmlTags;
}

function GenerarDescuento(id_acta, i, sald, identificacion_cli) {
    var descuento, saldo, nuevosaldo, opcion;
    saldo = parseInt(sald);
    descuento = $("#descuento" + i).val();
    if (descuento != '') {
        if (saldo >= descuento) {
            nuevosaldo = saldo - descuento;
            opcion = 1; //Cuando se hace al facturar
            var id_radica = $("#id_radica").val();
            var route = "/egreso";
            var token = $("#token").val();
            var type = 'POST';
            $("#radicacion").html(id_radica);
            var datos = {
                "id_radica": id_radica,
                "id_acta": id_acta,
                "nuevosaldo": nuevosaldo,
                "descuento": descuento,
                "concepto_egreso": 1,
                "opcion": opcion
            };
            __ajax(route, token, type, datos)
                .done(function(info) {
                    if (info.validar == 1) {
                        route = "/depositos/" + id_acta;
                        type = 'PUT';
                        datos = {
                            "nuevosaldo": nuevosaldo
                        };
                        __ajax(route, token, type, datos)
                            .done(function(info) {
                                if (info.validar == 1) {
                                    route = "/validaractadeposito";
                                    type = 'GET';
                                    datos = {
                                        "identificacion_cli": identificacion_cli
                                    };
                                    __ajax(route, token, type, datos)
                                        .done(function(info) {
                                            if (info.validar == 0) {
                                                //alert("no hay actas");
                                            } else if (info.validar == 1) {
                                                var actas_deposito = info.actas_deposito;
                                                Cargar_Actas_Cliente(actas_deposito);
                                            }
                                        })
                                }
                            }) //AJAX Nuevo Saldo

                    }
                }) //AJAX Descuento
        } else {
            alert("El Saldo es Insuficiente Para este descuento");
        }
    } else {
        alert("Debes asignar el valor a descontar");
    }
}

function Descuento(id_acta, i, longitud) {
    var descuento = $("#descuento" + i).val();
    //alert(descuento + ', '+id_acta);

}
