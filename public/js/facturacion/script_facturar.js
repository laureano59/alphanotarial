async function Factura(num_radica, opcion, conporcentaje) {
    
    try {

    lvconporcentaje = conporcentaje;

        /********Comprueba si La radicación está liquidada********/
      let id_radica = num_radica;
      let route = "/factderechos";
      let token = $("#token").val();
      let type = 'GET';
      $("#radicacion").html(id_radica);
      let datos = {
          "id_radica": id_radica
      };
      __ajax(route, token, type, datos)
      .done(function(info) {
    if (info.validarliqd == '1') { // Si la radicación ya está liquidada
      let actosliquidados = info.actos;
      let conceptos = info.conceptos;
      let recaudos = info.recaudos;

      /********Comprueba si La radicación está facturada********/
      let route = "/validarexixtefact";
      let token = $("#token").val();
      let type = 'GET';
      let datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
            if(info.validar == 1){//Radicación facturada se carga factura
              /*$("#msj2").html(info.mensaje);
              $("#msj-error2").fadeIn();
              setTimeout(function() {
                  $("#msj-error2").fadeOut();
              }, 2000);*/

              mostrarMensajeBonito('⚠️' + info.mensaje);

               // Número de factura
            $('#num_factura').text(info.prefijo+' - '+info.id_fact);

            // Fecha de escritura
            $('#fecha_escritura').text(info.fecha_fact);

            // Número de escritura
            $('#num_escritura').text(info.num_esc);
             
              CargarDerechos(actosliquidados, lvconporcentaje);
              CagarConceptos(conceptos, lvconporcentaje);
              CargarRecaudos(recaudos, lvconporcentaje);

              if(info.credito_fact == true){
                $("#credito").attr('checked', true);
            }else if(info.credito_fact == false){
                $("#contado").attr('checked', true);
            }
            }else if(info.validar == 0){//Radicación No facturada

              $("#anio_radica").html(info.anio);
              $("#id_tipoident1").val('');
                           
              if(opcion == 3){
                CargarDerechos(actosliquidados, lvconporcentaje);                
                CagarConceptos(conceptos, lvconporcentaje);
                CargarRecaudos(recaudos, lvconporcentaje);
              }

            } else if (info.validarliqd == '0') { // si la radicación no se ha liquidado
                /*$("#msj1").html(info.mensaje);
                $("#msj-error1").fadeIn();
                setTimeout(function() {
                  $("#msj-error1").fadeOut();
              }, 3000);*/
                 mostrarMensajeBonito('⚠️' + info.mensaje);
            }
          })// AJAX Si la radicación está liquidada
        }//sí está liquidada
          })// AJAX Si está facturada la radicación

  } catch (error) {
    console.error("Error en la función SumarConceptosFactMul:", error);
}
}


function ValidacionManual(){    
    let quien = $('input:radio[name=seleccion]:checked').val();
    let radicacion = document.getElementById('id_radica').value;

     let identificacion = document.getElementById('identificacion_cli1')
        ? document.getElementById('identificacion_cli1').value
        : '';

    let nombre = document.getElementById('nombre_cli1')
        ? document.getElementById('nombre_cli1').value
        : '';

     
     // Guardar selección actual del select
    let select = document.getElementById('id_formapago'); // ← cambia al ID real
    let valorSeleccionado = select ? select.value : null;

    /*Se toma las variables globales de las autorretenciones en variableas auxiliares para no perderlas*/
     let cli_doc_aux            =  cli_doc;     
     let cli_nombre_aux         =  cli_nombre;
     let cli_autoreteiva_aux    =  cli_autoreteiva;
     let cli_autoretertf_aux    =  cli_autoretertf;
     let cli_autoreteica_aux    =  cli_autoreteica;
     let cli_id_ciud_aux        =  cli_id_ciud;
     let cli_calidad_aux        =  cli_calidad;

    if (quien == 'manual') {
        Factura(radicacion, 3, 0);
        vaciar();
    } else if (quien == 'porcentaje') {
        Factura(radicacion, 3, 1);
        vaciar();
    }

    /*Vuelve y se recuperan las variables globales de autorretenciones*/
     cli_doc            =  cli_doc_aux;     
     cli_nombre         =  cli_nombre_aux;
     cli_autoreteiva    =  cli_autoreteiva_aux;
     cli_autoretertf    =  cli_autoretertf_aux;
     cli_autoreteica    =  cli_autoreteica_aux;
     cli_id_ciud        =  cli_id_ciud_aux;
     cli_calidad        =  cli_calidad_aux;


    // 🔹 Restaurar estado (después de reconstruir el DOM)
    setTimeout(function () {

        if (select && valorSeleccionado !== null) {
            select.value = valorSeleccionado;
        }

        let idInput = document.getElementById('identificacion_cli1');
        if (idInput) {
            idInput.value = identificacion;
        }

        let nombreInput = document.getElementById('nombre_cli1');
        if (nombreInput) {
            nombreInput.value = nombre;
        }

    }, 0);

    

    
}


$("#mostrarparticipantes").click(function() {
    let id_radica = $("#id_radica").val();
    let route = "/anombrede";
    let token = $("#token").val();
    let type = 'GET';
    let datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
    .done(function(info) {
        let anombrede = info.anombrede;
            CargarNombres(anombrede, 3);//para factMutiple
        })
});

function CargarNombres(validar, calidad) {
    let htmlTags = "";
    for (item in validar) {
        htmlTags +=
        '<tr>' +
        '<td>' +
        '<a href="javascript://" OnClick="Autoretenciones_modal(\'' + validar[item].id + '\', \'' + validar[item].fullname + '\', \'' + validar[item].autoreteiva + '\',\'' + validar[item].autoretertf + '\',\'' + validar[item].autoreteica + '\',\'' + validar[item].id_ciud + '\', \'' + calidad + '\');">' +
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


async function Autoretenciones_modal(doc, nombre, autoreteiva, autoretertf, autoreteica, id_ciud, calidad){

    cli_doc            =  doc;     
    cli_nombre         =  nombre;
    cli_autoreteiva    =  autoreteiva;
    cli_autoretertf    =  autoretertf;
    cli_autoreteica    =  autoreteica;
    cli_id_ciud        =  id_ciud;
    cli_calidad        =  calidad;

    console.log(cli_doc);
    console.log(cli_nombre);
    console.log(cli_autoreteiva);
    console.log(cli_autoretertf);
    console.log(cli_autoreteica);
    console.log(cli_id_ciud);
    console.log(cli_calidad);

    let identificacion_cli = doc;
      
      $("#identificacion_cli1").val(doc);
      $("#nombre_cli1").val(nombre);

      $('#mod_anombrede').modal('toggle');

      console.table(detalle_derechos);
      console.log(autoreteiva);
      console.log(autoretertf);
      console.log(autoreteica);
      console.log(id_ciud);

       let route = "/retenciones";
       let token = $("#token").val();
       let type = 'GET';
       let datos = {
              "autoreteiva"         : autoreteiva,
              "autoretertf"         : autoretertf,
              "autoreteica"         : autoreteica,              
              "ingresos"            : subtotal,
              "total_iva"           : total_iva,
              "id_ciud"             : id_ciud
            };
        __ajax(route, token, type, datos)
        .done(function(info) {
            // Limpiar deducciones anteriores
            detalle_deducciones.length = 0;

            if (Number(info.reteiva) > 0) {
                detalle_deducciones.push({
                    nombre: 'Autoretención IVA',
                    campo_fact: 'deduccion_reteiva',
                    valor: Number(info.reteiva)
                });
            }

            if (Number(info.reteica) > 0) {
                detalle_deducciones.push({
                    nombre: 'Autoretención ICA',
                    campo_fact: 'deduccion_reteica',
                    valor: Number(info.reteica)
                });
            }

            if (Number(info.retefuente) > 0) {
                detalle_deducciones.push({
                nombre: 'Autoretención en la fuente',
                campo_fact: 'deduccion_retertf',
                valor: Number(info.retefuente)
                });
            }

            // Recalcular factura completa
               CargarDetalleFact();
               flash_retenciones = 1;

        })

}


 function Autoretenciones(doc, nombre, autoreteiva, autoretertf, autoreteica, id_ciud, calidad){


       let route = "/retenciones";
       let token = $("#token").val();
       let type = 'GET';
       let datos = {
              "autoreteiva"         : autoreteiva,
              "autoretertf"         : autoretertf,
              "autoreteica"         : autoreteica,              
              "ingresos"            : subtotal,
              "total_iva"           : total_iva,
              "id_ciud"             : id_ciud
            };
        __ajax(route, token, type, datos)
        .done(function(info) {
            // Limpiar deducciones anteriores
            detalle_deducciones.length = 0;

            if (Number(info.reteiva) > 0) {
                detalle_deducciones.push({
                    nombre: 'Autoretención IVA',
                    campo_fact: 'deduccion_reteiva',
                    valor: Math.round(Number(info.reteiva))//Number(info.reteiva)
                });
            }

            if (Number(info.reteica) > 0) {
                detalle_deducciones.push({
                    nombre: 'Autoretención ICA',
                    campo_fact: 'deduccion_reteica',
                    valor: Math.round(Number(info.reteica))//Number(info.reteica)
                });
            }

            if (Number(info.retefuente) > 0) {
                detalle_deducciones.push({
                nombre: 'Autoretención en la fuente',
                campo_fact: 'deduccion_retertf',
                valor: Math.round(Number(info.retefuente))//Number(info.retefuente)
                });
            }

            // Recalcular factura completa
               CargarDetalleFact();
               flash_retenciones = 1;

        })

}


document.getElementById('boton_autoretenciones').addEventListener('click', function () {    

   
    Autoretenciones(cli_doc, cli_nombre, cli_autoreteiva, cli_autoretertf, cli_autoreteica, cli_id_ciud, cli_calidad);

});


$("#guardar").click(function() {

    if(flash_retenciones == 1){

         // 👉 Validaciones antes de guardar factura
         let route = "/validarfactura";
         let token = $("#token").val();
         let validar = '';
         let identificacion = $("#identificacion_cli1").val();
         let type = 'POST';
         let datos = {
          "detalle_derechos":       detalle_derechos,
          "detalle_conceptos":      detalle_conceptos,
          "detalle_recaudos":       detalle_recaudos,
          "identificacion":         identificacion          
      };
    
    __ajax(route, token, type, datos)
      .done(function(info) {
        validar = info.status;

        if (validar === 'warning') {
            mostrarErroresDerechos(info.alertas);
            return;
        }else if (validar === 'ok') {
        
            $('#mediopefectivo').val('');
            $('#medioptransferencia_bancaria').val('');
            $('#medioppse').val('');
            $('#medioptarjeta_credito').val('');
            $('#medioptarjeta_debito').val('');            
            $('#mediopconsignacion_bancaria').val('');            
            $('#mediopactadeposito').val('');
            $('#valorbono').val('');        
            $('#codigo_bono').val('');
            $('#totalbono').val('');
            // Select
            $('#id_tipo_bono').val('').change();

            $('#totalFactura').text(formatNumbderechos(total_all));   
            //Modal medios de pago
            $('#modalMediosPago').modal('show');

            if(info.actas == '1'){
                //$('#modalActasDeposito').modal('show');
                 let actas_deposito = info.actas_deposito;
                
                    $('#modalActasDeposito')
                    .data('actas_deposito', actas_deposito)
                    .modal('show');
                
            }
        }

    })    


        // $(this).hide(); Cuando se de acpetar en medios depago 
    }else if(flash_retenciones == 0){       
        mostrarMensajeBonito('⚠️ Los ingresos han cambiado presiona el botón Autorretenciones.');
    }
});


function mostrarErroresDerechos(alertas) {

    let html = '';

    alertas.forEach(function(item) {
        html += `
            <li class="list-group-item" style="border-left:5px solid #dc3545;">
                <strong>${item.nombre_acto}</strong><br>
                <small style="color:#dc3545;">
                    ${item.mensaje}
                </small>
            </li>
        `;
    });

    $('#listaErroresDerechos').html(html);
    $('#modalErroresDerechos').modal('show');
}

function mostrarMensajeBonito(mensaje) {
    $('#mensajeModalBonito').text(mensaje);
    $('#modalMensajeBonito').modal('show');
}

function mostrarErrorDinamico(codigo, mensaje) {
    const titulo = codigo ? `Error ${codigo}` : 'Error del Servidor';
    $('#modalErrorTitulo').html('⚠️ ' + titulo);  // Tu modal existente
    $('#modalErrorSubtitulo').text('Código: ' + (codigo || 'N/A'));
    $('#contenidoError').html(mensaje + '<br><small class="text-muted">' + new Date().toLocaleString('es-CO') + '</small>');
    $('#modalError').modal('show');  // O tu #modalErrorPersonalizado
}






$("#nuevafactura").click(function() {

    //$('#guardar').show();     
   $('#autoretenciones').show();     
     vaciar_all();      
     location.reload();

   
});


$('#guardarfactura').on('click', function () {

  // Tomar valores
  let efectivo              = Number($('#mediopefectivo').val()) || 0;
  let transferencia         = Number($('#medioptransferencia_bancaria').val()) || 0;
  let pse                   = Number($('#medioppse').val()) || 0;
  let tarjetaCredito        = Number($('#medioptarjeta_credito').val()) || 0;
  let tarjetaDebito         = Number($('#medioptarjeta_debito').val()) || 0;
  let consignacion_bancaria = Number($('#mediopconsignacion_bancaria').val()) || 0;  
  let mediopactadeposito = Number($('#mediopactadeposito').val()) || 0;
  let valorBono             = Number($('#valorbono').val()) || 0;
  let totalBono             = Number($('#totalbono').val()) || 0;
  let tipoBono              = $('#id_tipo_bono').val();
  let detalle_acargo_de     = $("#detalle_acargo_de").val();
  let doc_acargo_de         = $("#doc_acargo_de").val();
  let forma_pago            = $("#id_formapago").val();
  let codigo_bono           = $("#codigo_bono").val();

  let total_medios =
  efectivo +
  transferencia +
  pse +
  tarjetaCredito +
  tarjetaDebito +
  valorBono +
  consignacion_bancaria +
  mediopactadeposito;

  if (valorBono > 0 && !tipoBono) {
    mostrarMensajeBonito('⚠️ Debe seleccionar el tipo de bono.');
    return;
  }

  if (total_medios !== total_all) {
       mostrarMensajeBonito('❌ El total de los medios de pago no coincide con la factura.');
    return;
  }


    // 👉 Lógica para enviar al controlador de factura
   
    let route = "/facturacion";
    let token = $("#token").val();    
    let type = 'POST';
    let datos = {
          "detalle_derechos":       detalle_derechos,
          "detalle_conceptos":      detalle_conceptos,
          "detalle_recaudos":       detalle_recaudos,
          "detalle_deducciones":    detalle_deducciones,
          "total_deducciones":      total_deducciones,
          "cli_doc":                cli_doc,
          "detalle_acargo_de":      detalle_acargo_de,
          "doc_acargo_de":          doc_acargo_de,
          "cli_nombre":             cli_nombre,
          "forma_pago":             forma_pago,
          "subtotal":               subtotal,
          "total_iva":              total_iva,
          "total_recaudos":         total_recaudos,
          "total_all":              total_all,
          "efectivo":               efectivo,
          "transferencia":          transferencia,
          "pse":                    pse,
          "tarjetaCredito":         tarjetaCredito,
          "tarjetaDebito":          tarjetaDebito,
          "consignacion_bancaria":  consignacion_bancaria,
          "mediopactadeposito":     mediopactadeposito,
          "valorBono":              valorBono,
          "totalBono":              totalBono,
          "tipoBono":               tipoBono,
          "codigo_bono":            codigo_bono,
          "abonosporactasdeposito": abonosporactasdeposito

      };
    
    __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == '7'){            
            $('#num_factura').text(info.id_fact);        // Número de factura            
            $('#fecha_escritura').text(info.fecha_fact); // Fecha de escritura           
            $('#num_escritura').text(info.num_escr);     // Número de escritura            

            //mostrarMensajeBonito('✅' + info.mensaje);
              // Cerrar modal si todo está OK
             $('#modalMediosPago').modal('hide');
            //return;
             $('#autoretenciones').hide();  
              mostrarModalFactura(info);
              return;           


           
        }

        // ERROR dinámico del controlador NUEVO (campo 'codigo')
        if (info.codigo) {
            mostrarErrorDinamico(info.codigo, info.mensaje);
                return;
            }            
        })
        .fail(function(xhr) {  // Añade .fail() para errores HTTP
            const res = xhr.responseJSON || {};
            // Error del controlador (500) o conexión
            mostrarErrorDinamico(res.codigo || 500, res.mensaje || 'Error de conexión al servidor');
        });
});