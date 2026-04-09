/* =========================
   ARRAYS FACTURA
========================= */
let detalle_derechos        = []; // Derechos (con IVA)
let detalle_conceptos       = []; // Conceptos (con IVA)
let detalle_recaudos        = []; // Recaudos (sin IVA)
let detalle_deducciones     = []; // Retenciones: IVA, ICA, Fuente
let inputIdsDerechos        = [];
let inputIdsConceptos       = [];
let abonosporactasdeposito  = [];
let total_deducciones   = 0;
let cli_doc;       
let cli_nombre;
let cli_autoreteiva;
let cli_autoretertf;
let cli_autoreteica;
let cli_id_ciud;
let cli_calidad;
let flash_retenciones = 0;

/* =========================
   TOTALES
========================= */
let subtotal        = 0;
let total_iva       = 0;
let total_recaudos  = 0;
let total_all       = 0;

function CargarDerechos(validar, conporcentaje) {

    let i = 1;
    let htmlTags = "";

    // 👉 FILA EXTRA SOLO SI ES PORCENTAJE
    if (conporcentaje == 1) {
        htmlTags +=
            '<tr>' +
                '<td width="40%"></td>' +
                '<td width="20%"></td>' +
                '<td width="20%" align="center">' +
                    '<input type="number" ' +
                           'id="porcentaje_global" ' +
                           'min="1" max="100" ' +
                           'class="input-sm" ' +
                           'placeholder="1 - 100" /> ' +
                    '<button type="button" ' +
                            'class="btn btn-xs btn-success" ' +
                            'OnClick="Pinta_porcentaje();">' +
                        'OK' +
                    '</button>' +
                '</td>' +
                '<td width="20%"></td>' +
                '<td></td>' +
            '</tr>';
    }



    for (let item in validar) {

        // Definir input según si es valor o porcentaje
        let inputHtml = "";
        let inputId = "";

        if (conporcentaje == 0) {
            inputId = 'valorderechos' + i;
            inputHtml =
                '<input placeholder="Valor" type="text" ' +
                'id="' + inputId + '" ' +
                'class="col-xs-10 col-sm-8" ' +
                'onKeyPress="return soloNumeros(event)" />';
        }

        if (conporcentaje == 1) {
            inputId = 'porcentajederechos' + i;
            inputIdsDerechos.push(inputId);
            inputHtml =
                '<input placeholder="%" size="5" maxlength="3" type="text" ' +
                'id="' + inputId + '" ' +
                'class="input-sm" ' +
                'onKeyPress="return soloNumeros(event)" />';
        }

        // Construcción de la fila
        htmlTags +=
            '<tr>' +
                '<td width="40%">' +
                    validar[item].nombre_acto +
                '</td>' +
                '<td width="20%" bgcolor="#ccffcc" align="right">' +
                    formatNumbderechos(Math.round(validar[item].derechos)) +
                '</td>' +
                '<td width="20%">' +
                    inputHtml +
                '</td>' +
                '<td width="20%" bgcolor="#FADEDE" align="right">' +
                    '<span id="saldodere' + i + '"></span>' +
                    '<input type="hidden" id="saldoderechos' + i + '" />' +
                '</td>' +
                '<td>' +
                    '<a href="javascript://" ' +
                       'OnClick="AgregarItemDerechos(' +
                           '\'' + conporcentaje + '\',' +
                           '\'' + inputId + '\',' +
                            '\'' + validar[item].id_detalleliqd + '\',' +
                             '\'' + validar[item].nombre_acto + '\',' +
                           '\'' + validar[item].id_acto + '\'' +
                       ');">' +
                        '<img src="images/nuevo.png" width="28" height="28" title="Agregar">' +
                    '</a>' +
                '</td>' +
            '</tr>';

        i++;
    }

    // Finalmente cargamos el HTML en la tabla
    document.getElementById("data_derechos").innerHTML = htmlTags;
    CargarSaldosDerechos(validar);
}


async function CargarSaldosDerechos(validar) {

    let i = 1;
    let route = "/sumasaldosderechosliq";
    let token = $("#token").val();
    let type = 'POST';

    for (let item in validar) {

        let datos = {
            "id_liq": validar[item].id_detalleliqd
        };

        await __ajax(route, token, type, datos)
            .done(function(info) {

                // 🔹 Valores base
                let derechos = parseFloat(validar[item].derechos) || 0;
                let saldoBD  = parseFloat(info.saldo) || 0;

                // 🔹 Cálculo del saldo restante
                let saldoFinal = derechos - saldoBD;

                if (saldoFinal < 0) {
                    saldoFinal = 0;
                }

                // 🔹 Mostrar saldo calculado
                document.getElementById('saldodere' + i).innerHTML =
                    formatNumbderechos(Math.round(saldoFinal));

                // 🔹 Guardar saldo real
                document.getElementById('saldoderechos' + i).value =
                    saldoFinal;
            });

        i++;
    }
}



async function CagarConceptos(validar, conporcentaje) {

    let htmlTagsc = "";
    let i = 1;
    let conceptos_liq = [];

    let route = "/traeconceptos";
    let token = $("#token").val();
    let type = 'GET';

    // 🔹 UNA sola petición
    let datos = { "id_radica": 0 };

    await __ajax(route, token, type, datos)
    .done(function(info) {

        let conceptos = info.conceptos;

        for (let item in validar) {

            for (let item2 in conceptos) {

                let atributo = conceptos[item2].atributo;
                let totalatributo = "total" + atributo;

                if (parseFloat(validar[item][totalatributo]) > 0) {

                    // Guardar solo lo que tiene valor
                    conceptos_liq.push({
                        atributo: atributo,
                        total: validar[item][totalatributo]
                    });

                    let inputHtmlc = "";
                    let inputId = "";


                    if (conporcentaje == 0) {
                        inputId = 'valor' + atributo;

                        inputHtmlc =
                            '<input placeholder="Valor" type="text" ' +
                            'id="valor' + atributo + '" ' +
                            'class="col-xs-10 col-sm-8" ' +
                            'onkeypress="return soloNumeros(event)" />';
                    }

                    if (conporcentaje == 1) {
                        inputId = 'porcentaje' + atributo;
                        inputIdsConceptos.push(inputId);
                        inputHtmlc =
                            '<input placeholder="%" size="5" maxlength="3" type="text" ' +
                            'id="porcentaje' + atributo + '" ' +
                            'class="input-sm" ' +
                            'onkeypress="return soloNumeros(event)" />';
                    }

                    htmlTagsc +=
                        '<tr>' +
                            '<td width="40%">' + atributo + '</td>' +
                            '<td width="20%" bgcolor="#ccffcc" align="right">' +
                                formatNumbderechos(Math.round(validar[item][totalatributo])) +
                            '</td>' +
                            '<td width="20%">' + inputHtmlc + '</td>' +
                            '<td width="20%" bgcolor="#FADEDE" align="right">' +
                                '<span id="saldo' + atributo + '"></span>' +
                                '<input type="hidden" id="saldodoconc' + i + '" />' +
                            '</td>' +
                             '<td>' +
                                '<a href="javascript://" ' +
                                    'OnClick="AgregarItemConceptos(' +
                                        '\'' + conporcentaje + '\',' +
                                        '\'' + inputId + '\',' +
                                        '\'' + atributo + '\'' +
                                        ');">' +
                                        '<img src="images/nuevo.png" width="28" height="28" title="Agregar">' +
                                '</a>' +
                               '</td>' +
                        '</tr>';

                    i++;
                }
            }
        }

        // 🔹 Render FINAL
        document.getElementById('data_conceptos').innerHTML = htmlTagsc;

        // 🔹 Ahora SÍ se calculan los saldos
        CargarSaldosConceptos(conceptos_liq);
    });
}



async function CargarSaldosConceptos(conceptos_liq) {

    let route = "/sumasaldosconceptosliq";
    let token = $("#token").val();
    //let type = 'GET';
     let type = 'POST';

    let datos = {
        "conceptos": conceptos_liq
    };
   

    try {
        const info = await __ajax(route, token, type, datos);

        const saldos = info.saldos;
        console.table(saldos);

        Object.entries(saldos).forEach(([atributo, valor]) => {
            const span = document.getElementById(atributo);
            if (span) {
                span.innerHTML = formatNumbderechos(Math.round(Number(valor)));
            }
        });

    } catch (e) {
        console.error('Error en CargarSaldosConceptos', e);
    }
        
}


function CargarRecaudos(validar, conporcentaje) {

    let i = 1;
    let htmlTags = "";
    let inputId;
    let rete_liq;
    let nombre_rete;
    let nombre_campo_liq;
    let nombre_campo_fact;

    for (let item in validar) {

        /* =========================================
           RETENCIÓN EN LA FUENTE
        ==========================================*/
        if (parseFloat(validar[item].retefuente) > 0) {

            let inputHtml = "";

            if (conporcentaje == 0) {
                inputId             = 'retefuente';
                nombre_rete         = 'Retención en la fuente';
                nombre_campo_liq    = 'retefuente';
                nombre_campo_fact   = 'total_rtf';
                rete_liq            =  validar[item].retefuente;
                inputHtml           =
                    '<input placeholder="Valor" type="text" id="retefuente" ' +
                    'class="col-xs-10 col-sm-8" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            if (conporcentaje == 1) {
                inputId             = 'retefuenteporcent';
                nombre_rete         = 'Retención en la fuente';
                nombre_campo_liq    = 'retefuente';
                nombre_campo_fact   = 'total_rtf';
                rete_liq            =  validar[item].retefuente;
                inputHtml           =
                    '<input placeholder="%" size="5" maxlength="3" type="text" id="retefuenteporcent" ' +
                    'class="input-sm" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            htmlTags +=
            '<tr>' +
                '<td width="40%">Retención en la fuente</td>' +
                '<td width="20%" bgcolor="#ccffcc" align="right">' +
                    formatNumbderechos(Math.round(validar[item].retefuente)) +
                '</td>' +
                '<td width="20%">' + inputHtml + '</td>' +
                '<td width="20%" bgcolor="#FADEDE" align="right">' +
                    '<span id="saldoretefuente"></span>' +
                    '<input type="hidden" id="retef" />' +
                '</td>' +
                '<td>' +
                    '<a href="javascript://" ' +
                       'OnClick="AgregarItemRecaudos(' +
                           '\'' + conporcentaje + '\',' +
                           '\'' + inputId + '\',' +
                            '\'' + nombre_rete + '\',' +
                             '\'' + nombre_campo_liq + '\',' +
                             '\'' + nombre_campo_fact + '\',' +                                                
                           '\'' + rete_liq + '\'' +
                       ');">' +
                        '<img src="images/nuevo.png" width="28" height="28" title="Agregar">' +
                    '</a>' +
                '</td>' +
            '</tr>';
        }

        /* =========================================
           SUPER
        ==========================================*/
        if (parseFloat(validar[item].recsuper) > 0) {

            let inputHtml = "";

            if (conporcentaje == 0) {
                inputId             = 'recsuper';
                nombre_rete         = 'Super';
                nombre_campo_liq    = 'recsuper';
                nombre_campo_fact   = 'total_super';
                rete_liq            =  validar[item].recsuper;
                inputHtml           =
                    '<input placeholder="Valor" type="text" id="recsuper" ' +
                    'class="col-xs-10 col-sm-8" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            if (conporcentaje == 1) {
                rete_liq            =  validar[item].recsuper;
                nombre_rete         = 'Super';
                nombre_campo_liq    = 'recsuper';
                nombre_campo_fact   = 'total_super';
                inputId             = 'recsuperporcent';
                inputHtml           =
                    '<input placeholder="%" size="5" maxlength="3" type="text" id="recsuperporcent" ' +
                    'class="input-sm" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            htmlTags +=
            '<tr>' +
                '<td width="40%">Super</td>' +
                '<td width="20%" bgcolor="#ccffcc" align="right">' +
                    formatNumbderechos(Math.round(validar[item].recsuper)) +
                '</td>' +
                '<td width="20%">' + inputHtml + '</td>' +
                '<td width="20%" bgcolor="#FADEDE" align="right">' +
                    '<span id="saldorecasuper"></span>' +
                    '<input type="hidden" id="totalderechosiden" />' +
                '</td>' +
                '<td>' +
                    '<a href="javascript://" ' +
                       'OnClick="AgregarItemRecaudos(' +
                           '\'' + conporcentaje + '\',' +
                           '\'' + inputId + '\',' +
                            '\'' + nombre_rete + '\',' +
                             '\'' + nombre_campo_liq + '\',' +
                              '\'' + nombre_campo_fact + '\',' +                                                 
                           '\'' + rete_liq + '\'' +
                       ');">' +
                        '<img src="images/nuevo.png" width="28" height="28" title="Agregar">' +
                    '</a>' +
                '</td>' +
            '</tr>';
        }

        /* =========================================
           FONDO
        ==========================================*/
        if (parseFloat(validar[item].recfondo) > 0) {

            let inputHtml = "";

            if (conporcentaje == 0) {
                inputId             = 'recfondo';
                nombre_rete         = 'Fondo';
                nombre_campo_liq    = 'recfondo';
                nombre_campo_fact   = 'total_fondo';
                rete_liq            =  validar[item].recfondo;
                inputHtml           =
                    '<input placeholder="Valor" type="text" id="recfondo" ' +
                    'class="col-xs-10 col-sm-8" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            if (conporcentaje == 1) {
                inputId             = 'recfondoporcent';
                nombre_rete         = 'Fondo';
                nombre_campo_liq    = 'recfondo';
                nombre_campo_fact   = 'total_fondo';
                rete_liq            =  validar[item].recfondo;
                inputHtml           =
                    '<input placeholder="%" size="5" maxlength="3" type="text" id="recfondoporcent" ' +
                    'class="input-sm" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            htmlTags +=
            '<tr>' +
                '<td width="40%">Fondo</td>' +
                '<td width="20%" bgcolor="#ccffcc" align="right">' +
                    formatNumbderechos(Math.round(validar[item].recfondo)) +
                '</td>' +
                '<td width="20%">' + inputHtml + '</td>' +
                '<td width="20%" bgcolor="#FADEDE" align="right">' +
                    '<span id="saldorecafondo"></span>' +
                    '<input type="hidden" id="recaufondo' + i + '" />' +
                '</td>' +
                '<td>' +
                    '<a href="javascript://" ' +
                       'OnClick="AgregarItemRecaudos(' +
                           '\'' + conporcentaje + '\',' +
                           '\'' + inputId + '\',' +
                            '\'' + nombre_rete + '\',' +
                             '\'' + nombre_campo_liq + '\',' +
                              '\'' + nombre_campo_fact + '\',' +                                                   
                           '\'' + rete_liq + '\'' +
                       ');">' +
                        '<img src="images/nuevo.png" width="28" height="28" title="Agregar">' +
                    '</a>' +
                '</td>' +
            '</tr>';
        }

        /* =========================================
           APORTE ESPECIAL
        ==========================================*/
        if (parseFloat(validar[item].aporteespecial) > 0) {

            let inputHtml = "";

            if (conporcentaje == 0) {
                inputId             = 'aporteespecial';
                nombre_rete         = 'Aporte Especial';
                nombre_campo_liq    = 'aporteespecial';
                nombre_campo_fact   = 'total_aporteespecial';
                rete_liq            =  validar[item].aporteespecial;
                inputHtml           =
                    '<input placeholder="Valor" type="text" id="aporteespecial" ' +
                    'class="col-xs-10 col-sm-8" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            if (conporcentaje == 1) {
                inputId             = 'aporteespecialporcent';
                nombre_rete         = 'Aporte Especial';
                nombre_campo_liq    = 'aporteespecial';
                nombre_campo_fact   = 'total_aporteespecial';
                rete_liq            =  validar[item].aporteespecial;
                inputHtml           =
                    '<input placeholder="%" size="5" maxlength="3" type="text" id="aporteespecialporcent" ' +
                    'class="input-sm" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            htmlTags +=
            '<tr>' +
                '<td width="40%">Aporte especial</td>' +
                '<td width="20%" bgcolor="#ccffcc" align="right">' +
                    formatNumbderechos(Math.round(validar[item].aporteespecial)) +
                '</td>' +
                '<td width="20%">' + inputHtml + '</td>' +
                '<td width="20%" bgcolor="#FADEDE" align="right">' +
                    '<span id="saldoaportespecial"></span>' +
                    '<input type="hidden" id="aportespecialhiden" />' +
                '</td>' +
                '<td>' +
                    '<a href="javascript://" ' +
                       'OnClick="AgregarItemRecaudos(' +
                           '\'' + conporcentaje + '\',' +
                           '\'' + inputId + '\',' +
                            '\'' + nombre_rete + '\',' +
                             '\'' + nombre_campo_liq + '\',' + 
                              '\'' + nombre_campo_fact + '\',' +                                                  
                           '\'' + rete_liq + '\'' +
                       ');">' +
                        '<img src="images/nuevo.png" width="28" height="28" title="Agregar">' +
                    '</a>' +
                '</td>' +
            '</tr>';
        }

        /*=========================================
           IMPUESTO TIMBRE
        ==========================================*/
        if (parseFloat(validar[item].impuestotimbre) > 0) {

            let inputHtml = "";

            if (conporcentaje == 0) {
                inputId             = 'impuestotimbre';
                nombre_rete         = 'Impuesto timbre';
                nombre_campo_liq    = 'impuestotimbre';
                nombre_campo_fact   = 'total_impuesto_timbre';
                rete_liq            =  validar[item].impuestotimbre;
                inputHtml           =
                    '<input placeholder="Valor" type="text" id="impuestotimbre" ' +
                    'class="col-xs-10 col-sm-8" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            if (conporcentaje == 1) {
                inputId             = 'impuestotimbreporcent';
                nombre_rete         = 'Impuesto timbre';
                nombre_campo_liq    = 'impuestotimbre';
                nombre_campo_fact   = 'total_impuesto_timbre';
                rete_liq            =  validar[item].impuestotimbre;
                inputHtml           =
                    '<input placeholder="%" size="5" maxlength="3" type="text" id="impuestotimbreporcent" ' +
                    'class="input-sm" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            htmlTags +=
            '<tr>' +
                '<td width="40%">Impuesto timbre</td>' +
                '<td width="20%" bgcolor="#ccffcc" align="right">' +
                    formatNumbderechos(Math.round(validar[item].impuestotimbre)) +
                '</td>' +
                '<td width="20%">' + inputHtml + '</td>' +
                '<td width="20%" bgcolor="#FADEDE" align="right">' +
                    '<span id="saldoimpuestotimbr"></span>' +
                    '<input type="hidden" id="impuestotimbrehiden" />' +
                '</td>' +
                '<td>' +
                    '<a href="javascript://" ' +
                       'OnClick="AgregarItemRecaudos(' +
                           '\'' + conporcentaje + '\',' +
                           '\'' + inputId + '\',' +
                            '\'' + nombre_rete + '\',' +
                             '\'' + nombre_campo_liq + '\',' + 
                              '\'' + nombre_campo_fact + '\',' +                                                   
                           '\'' + rete_liq + '\'' +
                       ');">' +
                        '<img src="images/nuevo.png" width="28" height="28" title="Agregar">' +
                    '</a>' +
                '</td>' +
            '</tr>';
        }

        /* =========================================
           TIMBRE LEY 175
        ==========================================*/
        if (parseFloat(validar[item].timbrec) > 0) {

            let inputHtml = "";

            if (conporcentaje == 0) {
                inputId             = 'timbrec';
                nombre_rete         = 'Impuesto timbre Ley 175';
                nombre_campo_liq    = 'timbrec';
                nombre_campo_fact   = 'total_timbrec';
                rete_liq            =  validar[item].timbrec;               
                inputHtml           =
                    '<input placeholder="Valor" type="text" id="timbrec" ' +
                    'class="col-xs-10 col-sm-8" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            if (conporcentaje == 1) {
                inputId             = 'timbrecporcent';
                nombre_rete         = 'Impuesto timbre Ley 175';
                nombre_campo_liq    = 'timbrec';
                nombre_campo_fact   = 'total_timbrec';
                rete_liq            =  validar[item].timbrec;
                inputHtml           =
                    '<input placeholder="%" size="5" maxlength="3" type="text" id="timbrecporcent" ' +
                    'class="input-sm" ' +
                    'onKeyPress="return soloNumeros(event)" />';
            }

            htmlTags +=
            '<tr>' +
                '<td width="40%">Timbre Ley 175</td>' +
                '<td width="20%" bgcolor="#ccffcc" align="right">' +
                    formatNumbderechos(Math.round(validar[item].timbrec)) +
                '</td>' +
                '<td width="20%">' + inputHtml + '</td>' +
                '<td width="20%" bgcolor="#FADEDE" align="right">' +
                    '<span id="saldotimbreca"></span>' +
                    '<input type="hidden" id="timbrechiden" />' +
                '</td>' +
               '<td>' +
                    '<a href="javascript://" ' +
                       'OnClick="AgregarItemRecaudos(' +
                           '\'' + conporcentaje + '\',' +
                           '\'' + inputId + '\',' +
                            '\'' + nombre_rete + '\',' +
                            '\'' + nombre_campo_liq + '\',' + 
                             '\'' + nombre_campo_fact + '\',' +                                               
                           '\'' + rete_liq + '\'' +
                       ');">' +
                        '<img src="images/nuevo.png" width="28" height="28" title="Agregar">' +
                    '</a>' +
                '</td>' +
            '</tr>';
        }

        i++;
    }

    document.getElementById('data_recaudos').innerHTML = htmlTags;

    CargarSaldosRecaudos(validar);
}


async function CargarSaldosRecaudos(recaudos_liq) {

    let route = "/sumasaldosrecaudos";
    let token = $("#token").val();
    let type = 'POST';

    let datos = {
        "recaudos_liq": recaudos_liq
    };
   

    await __ajax(route, token, type, datos)
    .done(function(info) {
         const saldos = info.saldos;
         Object.entries(saldos).forEach(([atributo, valor]) => {
            const span = document.getElementById(atributo);

            if (span) {
                span.innerHTML = formatNumbderechos(Math.round(Number(valor)));
            }
        });
    });    
        
}


function AgregarItemDerechos(conporcentaje, inputId, idDetalle, acto, id_acto) {

    let valor = document.getElementById(inputId).value;
    let identificacion_cli1 = $("#identificacion_cli1").val();
    let id_formapago = $("#id_formapago").val();
    flash_retenciones = 0;

    if (valor === "" || parseFloat(valor) < 0 || identificacion_cli1 === "" || id_formapago === null) {
        mostrarMensajeBonito('⚠️ Debes ingresar el cliente, la forma de pago y el valor.');
        return;
    }

    valor =  Number(valor);//Number(valor);


    let route = "/CalcularIvaDerechos";
    let token = $("#token").val();

    let datos = {
        "id_acto": id_acto,
        "conporcentaje": conporcentaje,
        "idDetalle": idDetalle,
        "valor": valor
    };

    __ajax(route, token, 'POST', datos)
    .done(function(info) {

        // 🔍 Validar si ya existe el acto
        let existe = detalle_derechos.some(item => item.nombre_acto === acto);

        if (existe) {
            mostrarMensajeBonito('⚠️ Este acto ya fue agregado.');
            return;
        }

        let nuevo = {
            tipo: 'INGRESO',
            nombre_acto:        acto,
            valor:              Math.round(Number(info.valor)),//Number(info.valor),
            iva:                Number(info.iva),//Number(info.iva),
            id_detalleliqd :    idDetalle
        };

        detalle_derechos.push(nuevo);
        CargarDetalleFact();
    });
}


function AgregarItemConceptos(conporcentaje, inputId, concepto) {

    let valor = document.getElementById(inputId).value;
    let identificacion_cli1 = $("#identificacion_cli1").val();
    let id_formapago = $("#id_formapago").val();
    flash_retenciones = 0;

    if (valor === "" || parseFloat(valor) < 0 || identificacion_cli1 === "" || id_formapago === null) {
        mostrarMensajeBonito('⚠️ Debes ingresar el cliente, la forma de pago y el valor.');
        return;
    }

    valor =  Number(valor);//Number(valor);

    let route = "/CalcularIvaConceptos";
    let token = $("#token").val();

    let datos = {
        "conporcentaje": conporcentaje,
        "valor": valor,
        "concepto": concepto
    };

    __ajax(route, token, 'POST', datos)
    .done(function(info) {

        // 🔍 Validar si ya existe el concepto
        let existe = detalle_conceptos.some(item => item.nombre_acto === concepto);

        if (existe) {
            mostrarMensajeBonito('⚠️ Este concepto ya fue agregado.');
            return;
        }

        let nuevo = {
            tipo:        'INGRESO',
            nombre_acto: concepto,
            valor:       Math.round(Number(info.valor)),//Number(info.valor),
            iva:         Number(info.iva)//Number(info.iva)
        };

        detalle_conceptos.push(nuevo);
        CargarDetalleFact();
    });
}


function AgregarItemRecaudos(conporcentaje, inputId, nombre_rete, nombre_campo_liq, nombre_campo_fact, rete_liq) {

    let valor = document.getElementById(inputId).value;
    let identificacion_cli1 = $("#identificacion_cli1").val();
    let id_formapago = $("#id_formapago").val();
    flash_retenciones = 0;

    if (valor === "" || parseFloat(valor) < 0 || identificacion_cli1 === "" || id_formapago === null) {
        mostrarMensajeBonito('⚠️ Debes ingresar el cliente, la forma de pago y el valor.');
        return;
    }

    valor =  Number(valor);//Number(valor);

    if (conporcentaje == 1) {
        valor = (valor / 100) * rete_liq;
    }

    // 🔍 Validar si ya existe el concepto
    let existe = detalle_recaudos.some(item => item.nombre_acto === nombre_rete);

    if (existe) {
        mostrarMensajeBonito('⚠️ Este recaudo ya fue agregado.');
            return;
    }



    let nuevo = {
        tipo: 'RECAUDO',
        nombre_acto:        nombre_rete,
        nombre_campo_liq:   nombre_campo_liq,
        nombre_campo_fact:  nombre_campo_fact,
        valor:              valor,//valor
    };

    detalle_recaudos.push(nuevo);
    CargarDetalleFact();
}


function CargarDetalleFact() {

    // Reiniciar acumuladores globales
    subtotal          = 0;
    total_iva         = 0;
    total_recaudos    = 0;
    total_deducciones = 0;
    total_all         = 0;

    let html = "";

    /* =========================
       DERECHOS
    ========================= */
    detalle_derechos.forEach((item, index) => {

        subtotal  += Number(item.valor);
        total_iva += Number(item.iva);

        html +=
            '<tr>' +
                '<td>' + item.nombre_acto + '</td>' +
                '<td align="right">' + formatNumbderechos(Number(item.valor)) + '</td>' +
                '<td>' +
                    '<a href="javascript://" onclick="EliminarDerechos(' + index + ')">' +
                        '<img src="images/borrar.png" width="28" title="Eliminar">' +
                    '</a>' +
                '</td>' +
            '</tr>';
    });

    /* =========================
       CONCEPTOS
    ========================= */
    detalle_conceptos.forEach((item, index) => {

        subtotal  += Number(item.valor);
        total_iva += Number(item.iva);

        html +=
            '<tr>' +
                '<td>' + item.nombre_acto + '</td>' +
                '<td align="right">' + formatNumbderechos(Number(item.valor)) + '</td>' +
                '<td>' +
                    '<a href="javascript://" onclick="EliminarConceptos(' + index + ')">' +
                        '<img src="images/borrar.png" width="28">' +
                    '</a>' +
                '</td>' +
            '</tr>';
    });

    /* =========================
       🔹 REDONDEO NORMAL (SIN DECIMALES)
    ========================= */

    subtotal  = Math.round(subtotal);
    total_iva = Math.round(total_iva);

    html +=
        '<tr>' +
            '<td><b>Subtotal ingresos</b></td>' +
            '<td align="right"><b>' + formatNumbderechos(subtotal) + '</b></td>' +
            '<td></td>' +
        '</tr>' +
        '<tr>' +
            '<td><b>IVA</b></td>' +
            '<td align="right"><b>' + formatNumbderechos(total_iva) + '</b></td>' +
            '<td></td>' +
        '</tr>';

    /* =========================
       DEDUCCIONES
    ========================= */
    detalle_deducciones.forEach((item) => {

        total_deducciones += Number(item.valor);

        html +=
            '<tr>' +
                '<td>(-) ' + item.nombre + '</td>' +
                '<td align="right" style="color:#c0392b; font-weight:bold;">-' +
                    formatNumbderechos(Number(item.valor)) +
                '</td>' +
                '<td></td>' +
            '</tr>';
    });

    /* =========================
       RECAUDOS
    ========================= */
    detalle_recaudos.forEach((item, index) => {

        total_recaudos += Number(item.valor);        

        html +=
            '<tr>' +
                '<td>' + item.nombre_acto + '</td>' +
                '<td align="right">' + formatNumbderechos(Number(item.valor)) + '</td>' +
                '<td>' +
                    '<a href="javascript://" onclick="EliminarRecaudo(' + index + ')">' +
                        '<img src="images/borrar.png" width="28">' +
                    '</a>' +
                '</td>' +
            '</tr>';
    });

    /* =========================
       TOTAL FINAL
    ========================= */

    total_deducciones = total_deducciones;
    total_recaudos    = total_recaudos;

    total_all = subtotal + total_iva - total_deducciones + total_recaudos;

    html +=
        '<tr style="background-color:#DAF7A6 !important;">' +
            '<td><b>Total a pagar</b></td>' +
            '<td align="right"><b>' + formatNumbderechos(total_all) + '</b></td>' +
            '<td></td>' +
        '</tr>';

    document.getElementById('data_detalle').innerHTML = html;
}



function Pinta_porcentaje(){

    let porcent = Number(document.getElementById('porcentaje_global').value);

     // DERECHOS
    inputIdsDerechos.forEach(function(id) {
        let input = document.getElementById(id);
        if (input) {
            input.value = porcent;
        }
    });

    // CONCEPTOS
    inputIdsConceptos.forEach(function(id) {
        let input = document.getElementById(id);
        if (input) {
            input.value = porcent;
        }
    });


    $('#retefuenteporcent').val(porcent);
    $('#recsuperporcent').val(porcent);
    $('#recfondoporcent').val(porcent);
    $('#aporteespecialporcent').val(porcent);
    $('#impuestotimbreporcent').val(porcent);
    $('#timbrecporcent').val(porcent);   

}




function EliminarDerechos(index) {
    detalle_derechos.splice(index, 1);
    CargarDetalleFact();
    flash_retenciones = 0;
}

function EliminarConceptos(index) {
    detalle_conceptos.splice(index, 1);
    CargarDetalleFact();
    flash_retenciones = 0;
}

function EliminarRecaudo(index) {
    detalle_recaudos.splice(index, 1);
    CargarDetalleFact();
    flash_retenciones = 0;
}


function vaciar(){   

   detalle_derechos.length          = 0;
   detalle_conceptos.length         = 0;
   detalle_recaudos.length          = 0;
   detalle_deducciones.length       = 0;
   inputIdsDerechos.length          = 0;
   inputIdsConceptos.length         = 0;
   abonosporactasdeposito.length    = 0;
   subtotal                         = 0;
   total_iva                        = 0;
   total_recaudos                   = 0;
   total_all                        = 0;
   total_deducciones                = 0;
   flash_retenciones                = 0;


   CargarDetalleFact();


}


function vaciar_all(){

    const sel = document.getElementById('id_formapago');
    sel.value = "";

    document.getElementById('identificacion_cli1').value = '';
    document.getElementById('nombre_cli1').value = '';

  

   detalle_derechos.length          = 0;
   detalle_conceptos.length         = 0;
   detalle_recaudos.length          = 0;
   detalle_deducciones.length       = 0;
   abonosporactasdeposito.length    = 0;
   inputIdsDerechos.length          = 0;
   inputIdsConceptos.length         = 0;
   subtotal                         = 0;
   total_iva                        = 0;
   total_recaudos                   = 0;
   total_all                        = 0;
   total_deducciones                = 0;
   flash_retenciones                = 0;
   cli_doc                          = '';
   cli_nombre                       = '';
   cli_autoreteiva                  = '';
   cli_autoretertf                  = '';
   cli_autoreteica                  = '';
   cli_id_ciud                      = '';
   cli_calidad                      = '';

   CargarDetalleFact();


}