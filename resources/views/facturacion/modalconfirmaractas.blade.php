<!-- Modal Actas de Depósito -->
<div class="modal fade" id="modalActasDeposito" tabindex="-1" role="dialog" 
     data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:15px; border:none; box-shadow:0 15px 40px rgba(0,0,0,0.2);">

            <div class="modal-header border-0 text-center d-block pb-0">
                <div style="font-size:45px;">💰</div>
                <h5 class="modal-title font-weight-bold mt-2" style="color:#2c3e50;">
                    Actas de Depósito Disponibles
                </h5>
            </div>

            <div class="modal-body text-center pt-2">
                <p class="text-muted mb-0" style="font-size:15px; line-height:1.6;">
                    Este cliente tiene <strong>actas de depósito activas</strong>.<br>
                    ¿Desea consultarlas ahora para aplicar los descuentos correspondientes?
                </p>
            </div>

            <div class="modal-footer border-0 d-flex justify-content-between">
                <button type="button" 
                        class="btn btn-light px-4" 
                        onclick="CerrarActas()">
                    No
                </button>

                <button type="button" 
                        class="btn btn-success px-4 font-weight-bold"
                        onclick="verActasDeposito()">
                    Sí, ver actas
                </button>
            </div>

        </div>
    </div>
</div>


<script>
function CerrarActas() {

    $('#modalActasDeposito').modal('hide');
}

function verActasDeposito() {

    let actas = $('#modalActasDeposito').data('actas_deposito');
    $('#modalActasDeposito').modal('hide');

     Cargar_Actas_Cliente(actas);
     $('#mod_egresos_actas_fact').modal('toggle');   
}




function Cargar_Actas_Cliente(data) {
    let htmlTags = "";
    let i = 1;
    let longitud = data.length;
    let saldo_escrituras = 0;
    data.forEach(function(item) {
        saldo_escrituras =  Number(item.deposito_escrituras) - 
        Number(item.total_egresos_por_acta);
        htmlTags +=
        '<tr>' +
        '<td>' +
       item.id_act +
        '</td>' +
        '<td>' +
        item.fecha_acta +
        '</td>' +
        '<td>' +
        '<font size="1">' + item.proyecto + '</font>' +
        '</td>' +
        '<td>' +
        '<font size="1">' + item.tipo_deposito + '</font>' +
        '</td>' +
        '<td align = "right">' +
        formatNumbderechos(Math.round(item.deposito_escrituras)) +
        '</td>' +
        '<td align = "right">' +
        formatNumbderechos(Math.round(item.deposito_boleta)) +
        '</td>' +
         '<td align = "right">' +
        formatNumbderechos(Math.round(item.deposito_registro)) +
        '</td>' +
         '<td align = "right">' +
        formatNumbderechos(Math.round(item.deposito_act)) +
        '</td>' +
        '<td align = "right">' +
        formatNumbderechos(Math.round(item.saldo)) +
        '</td>' +
         '<td align = "right">' +
        formatNumbderechos(Math.round(saldo_escrituras)) +
        '</td>' +
        '<td>' +
        '<input type="text" id="descuento' + i + '"  onKeyPress="return soloNumeros(event)" />' +
        '</td>' +
        '<td>' +
        '<a href="javascript://" OnClick="GenerarDescuento(\'' + item.id_act + '\',\'' + i + '\',\'' + saldo_escrituras + '\',\'' + Number(item.deposito_escrituras)  + '\',\'' + Number(item.saldo) +  '\'' + ');">' +
        '<i><img src="images/comprobar.png" width="28 px" height="28 px" title="Aplicar"></i>' +
        '</a>' +
        '</td>' +
        '<td>' +
        '<a href="javascript://" OnClick="EliminarDescuento(\'' + item.id_act + '\',\'' + i +  '\'' + ');">' +
        '<i><img src="images/cancelar.png" width="28 px" height="28 px" title="Aplicar"></i>' +
        '</a>' +
        '</td>' +
        '</tr>';
        i++;
    });

    document.getElementById('datos_acta').innerHTML = htmlTags;
}


async function GenerarDescuento(id_acta, i, saldo_escrituras, deposito_escrituras, saldo_general) {

    
    let descuento = Number($("#descuento" + i).val());    

    if (descuento != '') {
        if (descuento  <= saldo_escrituras) {
             $("#descuento" + i).prop("disabled", true);  
             // 🔍 Validar si ya existe el concepto
             let existe = abonosporactasdeposito.some(item => item.id_acta === id_acta);

             if (existe) {
                mostrarMensajeBonito('⚠️ Esta acta ya fue agregegada al descuento.');
                return;
             }

            let nuevosaldo = saldo_general - descuento;            
            let nuevo = {
                tipo:        'ACTAS',
                id_acta:     id_acta,
                descuento:   Number(descuento),
                saldo:       Number(nuevosaldo)
            };

        abonosporactasdeposito.push(nuevo);
        
        }else{
             mostrarMensajeBonito(" ⚠️ El Saldo en escrituras es insuficiente para este descuento");
        }


    }else{
        mostrarMensajeBonito(" ⚠️ Debes asignar el valor a descontar");
    }




   


   /* var descuento, saldo, nuevosaldo, opcion;
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
    }*/
}


function EliminarDescuento(id_act, i) {

    // Habilitar nuevamente el input
    $("#descuento" + i).prop("disabled", false);
    $("#descuento" + i).val('');

    // Buscar el índice real dentro del array
    let index = abonosporactasdeposito.findIndex(
        item => Number(item.id_acta) === Number(id_act)
    );

    // Si existe, eliminarlo
    if (index !== -1) {
        abonosporactasdeposito.splice(index, 1);
    }

}

</script>

