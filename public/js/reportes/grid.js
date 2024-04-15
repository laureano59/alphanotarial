function CargarCajaDiarioGeneral(data, total_egreso, caja_diario_otros,  derechos_contado, conceptos_contado, ingresos_contado, iva_contado, recaudos_contado, aporteespecial_contado, impuestotimbre_contado, 
rtf_contado, deduccion_reteiva_contado, deduccion_reteica_contado, deduccion_retertf_contado,
total_fact_contado, derechos_credito, conceptos_credito, ingresos_credito, iva_credito, recaudos_credito, aporteespecial_credito,
impuestotimbre_credito, rtf_credito, deduccion_reteiva_credito, deduccion_reteica_credito,
deduccion_retertf_credito, total_fact_credito) {
    var htmlTags = "";
    var total_derechos = 0;
    var total_conceptos = 0;
    var total_recaudo = 0;
    var total_aporteespecial = 0;
    var total_impuesto_timbre = 0;
    var total_retencion = 0;
    var total_iva = 0;
    var total = 0;
    var total_gravado = 0;
    var total_reteiva = 0;
    var total_reteica = 0;
    var total_retertf = 0;

    for (item in data) {
        total_derechos = parseFloat(data[item].derechos) + total_derechos;
        total_conceptos = parseFloat(data[item].conceptos) + total_conceptos;
        total_recaudo = parseFloat(data[item].recaudo) + total_recaudo;
        total_aporteespecial = parseFloat(data[item].aporteespecial) + total_aporteespecial;
        total_impuesto_timbre = parseFloat(data[item].impuesto_timbre) + total_impuesto_timbre;
        total_retencion = parseFloat(data[item].retencion) + total_retencion;
        total_iva = parseFloat(data[item].iva) + total_iva;
        total = parseFloat(data[item].total) + total;
        total_gravado = parseFloat(data[item].total_gravado) + total_gravado;
        total_reteiva = parseFloat(data[item].reteiva) + total_reteiva;
        total_reteica = parseFloat(data[item].reteica) + total_reteica;
        total_retertf = parseFloat(data[item].retertf) + total_retertf;

        htmlTags +=
            '<tr>' +
            '<td>' +
            data[item].numfact +
            '</td>' +
            '<td>' +
            data[item].fecha +
            '</td>' +
            '<td>' +
            data[item].num_esc +
            '</td>' +
            '<td align="right">' + formatNumbderechos(Math.round(data[item].derechos)) +
            '</td>' +
            '<td align="right">' + formatNumbderechos(Math.round(data[item].conceptos)) +
            '</td>' +
            '<td align="right">' + formatNumbderechos(Math.round(data[item].total_gravado)) +
            '</td>' +
            '<td align="right">' + formatNumbderechos(Math.round(data[item].iva)) +
            '</td>' +
            '<td align="right">' + formatNumbderechos(Math.round(data[item].recaudo)) +
            '</td>' +
             '<td align="right">' + formatNumbderechos(Math.round(data[item].aporteespecial)) +
            '</td>' +
            '<td align="right">' + formatNumbderechos(Math.round(data[item].impuesto_timbre)) +
            '</td>' +
            '<td align="right">' + formatNumbderechos(Math.round(data[item].retencion)) +
            '</td>' +
            '<td align="right"><font color="red">(-' + formatNumbderechos(Math.round(data[item].reteiva)) +
            ')</font></td>' +
            '<td align="right"><font color="red">(-' + formatNumbderechos(Math.round(data[item].reteica)) +
            ')</font></td>' +
            '<td align="right"><font color="red">(-' + formatNumbderechos(Math.round(data[item].retertf)) +
            ')</font></td>' +
            '<td align="right">' + formatNumbderechos(Math.round(data[item].total)) +
            '</td>' +
            '<td>' +
            data[item].tipo_pago +
            '</td>' +
            '<td>' +
            data[item].estado +
            '</td>' +
            '<td>' +
            data[item].id_ncf +
            '</td>' +
            '</tr>';
    }
   

    htmlTags += '<tr>' +
        '<td>' +
        '<b>Total</b>' +
        '</td>' +
        '<td>' +
        '</td>' +
        '<td>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total_derechos)) + '</b>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total_conceptos)) + '</b>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total_gravado)) + '</b>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total_iva)) + '</b>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total_recaudo)) + '</b>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total_aporteespecial)) + '</b>' +
        '</td>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total_impuesto_timbre)) + '</b>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total_retencion)) + '</b>' +
        '</td>' +
        '<td align="right"><b><font color="red">(-' + formatNumbderechos(Math.round(total_reteiva)) + ')</font></b>' +
        '</td>' +
        '<td align="right"><b><font color="red">(-' + formatNumbderechos(Math.round(total_reteica)) + ')</font></b>' +
        '</td>' +
        '<td align="right"><b><font color="red">(-' + formatNumbderechos(Math.round(total_retertf)) + ')</font></b>' +
        '</td>' +
        '<td align="right"><b>' + formatNumbderechos(Math.round(total)) + '</b>' +
        '</td>' +
        '<td>' +
        '</td>' +
        '<td>' +
        '</td>' +
        '</tr>';
    document.getElementById('datos').innerHTML = htmlTags;

    htmlTags_2 =
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Derechos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_derechos)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(derechos_contado)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(derechos_credito)) +
        '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Conceptos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_conceptos)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(conceptos_contado)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(conceptos_credito)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Ingresos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_gravado)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(ingresos_contado)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(ingresos_credito)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Iva</b></font>' +
        '</td>'+
        '<td>'+
        formatNumbderechos(Math.round(total_iva)) +
        '</td>' +
        '<td>'+
        formatNumbderechos(Math.round(iva_contado)) +
        '</td>' +
        '<td>'+
        formatNumbderechos(Math.round(iva_credito)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Recaudos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_recaudo)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(recaudos_contado)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(recaudos_credito)) +
        '</td>' +
        '</tr>' +
         '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Aporte Especial</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_aporteespecial)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(aporteespecial_contado)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(aporteespecial_credito)) +
        '</td>' +
         '<td>' +
         '</tr>'+
         '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Impuesto Timbre</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_impuesto_timbre)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(impuestotimbre_contado)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(impuestotimbre_credito)) +
        '</td>' +
         '<td>' +
         '</tr>'+
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Retención</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_retencion)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(rtf_contado)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(rtf_credito)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteIva</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_reteiva)) +
        ')</font></td>' +
         '<td><font color="red">(-' +
        formatNumbderechos(Math.round(deduccion_reteiva_contado)) +
        ')</font></td>' +
         '<td><font color="red">(-' +
        formatNumbderechos(Math.round(deduccion_reteiva_credito)) +
        ')</font></td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteIca</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_reteica)) +
        ')</font></td>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(deduccion_reteica_contado)) +
        ')</font></td>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(deduccion_reteica_credito)) +
        ')</font></td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteRtf</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_retertf)) +
        ')</font></td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(deduccion_retertf_contado)) +
        ')</font></td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(deduccion_retertf_credito)) +
        ')</font></td>' +
        '</tr>' +
        '<tr>' +
        '<td>'+
        '<font size="2"><b>Gran Total</b></font>' +
        '</td>'+
        '<td>' +
        formatNumbderechos(Math.round(total)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_fact_contado)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_fact_credito)) +
        '</td>' +
        '</tr>';
       

    document.getElementById('datos_totales').innerHTML = htmlTags_2;

    /*======================================
    =            Otros periodos            =
    ======================================*/
    
    var total_derechos_otros = 0;
    var total_conceptos_otros = 0;
    var total_recaudo_otros = 0;
    var total_aporteespecial_otros = 0;
    var total_impuesto_timbre_otros = 0;
    var total_retencion_otros = 0;
    var total_iva_otros = 0;
    var total_otros = 0;
    var total_gravado_otros = 0;
    var total_reteiva_otros = 0;
    var total_reteica_otros = 0;
    var total_retertf_otros = 0;
    var htmlTags_3 = "";

    for (item2 in caja_diario_otros) {
        total_derechos_otros = parseFloat(caja_diario_otros[item2].derechos) + total_derechos_otros;
        total_conceptos_otros = parseFloat(caja_diario_otros[item2].conceptos) + total_conceptos_otros;
        total_recaudo_otros = parseFloat(caja_diario_otros[item2].recaudo) + total_recaudo_otros;
        total_aporteespecial_otros = parseFloat(caja_diario_otros[item2].aporteespecial) + total_aporteespecial_otros;
        total_impuesto_timbre_otros = parseFloat(caja_diario_otros[item2].impuesto_timbre) + total_impuesto_timbre_otros;
        total_retencion_otros = parseFloat(caja_diario_otros[item2].retencion) + total_retencion_otros;
        total_iva_otros = parseFloat(caja_diario_otros[item2].iva) + total_iva_otros;
        total_otros = parseFloat(caja_diario_otros[item2].total) + total_otros;
        total_gravado_otros = parseFloat(caja_diario_otros[item2].total_gravado) + total_gravado_otros;
        total_reteiva_otros = parseFloat(caja_diario_otros[item2].reteiva) + total_reteiva_otros;
        total_reteica_otros = parseFloat(caja_diario_otros[item2].reteica) + total_reteica_otros;
        total_retertf_otros = parseFloat(caja_diario_otros[item2].retertf) + total_retertf_otros;
      }

      /*----------  RESTA  ----------*/

      var total_derechos_resta = 0;
      var total_conceptos_resta = 0;
      var total_recaudo_resta = 0;
      var total_aporteespecial_resta = 0;
      var total_impuesto_timbre_resta = 0;
      var total_retencion_resta = 0;
      var total_iva_resta = 0;
      var total_resta = 0;
      var total_gravado_resta = 0;
      var total_reteiva_resta = 0;
      var total_reteica_resta = 0;
      var total_retertf_resta = 0;

      total_derechos_resta = parseInt(Math.round(total_derechos) - Math.round(total_derechos_otros));
      total_conceptos_resta = parseInt(Math.round(total_conceptos) - Math.round(total_conceptos_otros));
      total_recaudo_resta = parseInt(Math.round(total_recaudo) - Math.round(total_recaudo_otros));
      total_aporteespecial_resta = parseInt(Math.round(total_aporteespecial) - Math.round(total_aporteespecial_otros));
      total_impuesto_timbre_resta = parseInt(Math.round(total_impuesto_timbre) - Math.round(total_impuesto_timbre_otros));
      total_retencion_resta = parseInt(Math.round(total_retencion) - Math.round(total_retencion_otros));
      total_iva_resta = parseInt(Math.round(total_iva) - Math.round(total_iva_otros));
      total_resta = parseInt(Math.round(total) - Math.round(total_otros));
      total_gravado_resta = parseInt(Math.round(total_gravado) - Math.round(total_gravado_otros));
      total_reteiva_resta = parseInt(Math.round(total_reteiva) - Math.round(total_reteiva_otros));
      total_reteica_resta = parseInt(Math.round(total_reteica) - Math.round(total_reteica_otros));
      total_retertf_resta = parseInt(Math.round(total_retertf) - Math.round(total_retertf_otros));

        htmlTags_3 =
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Derechos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_derechos_otros)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(total_derechos_resta) +
        '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Conceptos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_conceptos_otros)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(total_conceptos_resta) +
        '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Ingresos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_gravado_otros)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(total_gravado_resta) +
        '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Iva</b></font>' +
        '</td>'+
        '<td>'+
        formatNumbderechos(Math.round(total_iva_otros)) +
        '</td>' +
        '<td>'+
        formatNumbderechos(total_iva_resta) +
        '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Recaudos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_recaudo_otros)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(total_recaudo_resta) +
        '</td>' +
        '</tr>' +

         '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Aporte Especial</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_aporteespecial_otros)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(total_aporteespecial_resta) +
        '</td>' +
        '</tr>'+


        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Impuesto Timbre</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_impuesto_timbre_otros)) +
        '</td>' +
               
         '<td>' +
        formatNumbderechos(total_impuesto_timbre_resta) +
        '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Retención</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_retencion_otros)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(total_retencion_resta) +
        '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteIva</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_reteiva_otros)) +
        ')</font></td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(total_reteiva_resta) +
        ')</font></td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteIca</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_reteica_otros)) +
        ')</font></td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(total_reteica_resta) +
        ')</font></td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteRtf</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_retertf_otros)) +
        ')</font></td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(total_retertf_resta) +
        ')</font></td>' +
        '</tr>' +

        '<tr>' +
        '<td>'+
        '<font size="2"><b>Gran Total</b></font>' +
        '</td>'+
        '<td>' +
        formatNumbderechos(Math.round(total_otros)) +
        '</td>' +
        '<td>' +
        formatNumbderechos(total_resta) +
        '</td>' +
        '</tr>';
      

    document.getElementById('datos_totales_otros_periodos').innerHTML = htmlTags_3;
    
    
    /*=====  End of Otros periodos  ======*/
    
}

function CargarCrucesActas(data){
  var total_cruce = 0;
  var htmlTags3 = '';
  for (item in data) {
      total_cruce = parseFloat(data[item].valor_egreso) + total_cruce;
      htmlTags3 +=
          '<tr>' +
          '<td>' +
          data[item].num_fact +
          '</td>' +
          '<td>' +
          data[item].num_act +
          '</td>' +
          '<td>' +
          data[item].fecha_acta +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].valor_egreso) +
          '</td>' +
          '</tr>';
        }
        htmlTags3 += '<tr>' +
            '<td>' +
            '<b>Total</b>' +
            '</td>' +
            '<td>' +
            '</td>' +
            '<td>' +
            '</td>' +
            '<td align="right"><b>' + formatNumbderechos(Math.round(total_cruce)) + '</b>' +
            '</td>' +
            '</tr>';
        document.getElementById('data_cruce').innerHTML = htmlTags3;
}

function CargarIngresoConceptos(data, gtotal){
  var totalconceptos = gtotal;
  var htmlTags = '';
  for (item in data) {
     htmlTags +=
     '<tr>'+
     '<td>'+
     data[item].concepto +
     '</td>'+
     '<td>'+
     data[item].escrituras +
     '</td>'+
     '<td align="right">'+
     formatNumbderechos(data[item].total) +
     '</td>' +
     '</tr>';
  }

  htmlTags +=
  '<tr>'+
     '<td>'+
     '</td>'+
     '<td>'+
     '<b>Total:</b>'+
     '</td>'+
     '<td align="right"><b>'+
     formatNumbderechos(totalconceptos) +
     '</b></td>' +
     '</tr>';
 
  document.getElementById('data').innerHTML = htmlTags;
 
}

function CargarLibroIndice(data){
  var htmlTags = '';
  for (item in data) {
      htmlTags +=
          '<tr>' +
          '<td>' +
          data[item].otorgante +
          '</td>' +
          '<td>' +
          data[item].fecha +
          '</td>' +
          '<td>' +
          data[item].num_esc +
          '</td>' +
          '<td>' +
          data[item].compareciente +
          '</td>' +
          '<td>' +
          data[item].acto +
          '</td>' +
          '</tr>';
      }
      document.getElementById('libro').innerHTML = htmlTags;
}

function CargarLibroRelacion(data){
  var htmlTags = '';
  for (item in data) {
      htmlTags +=
          '<tr>' +
           '<td>' +
          data[item].fecha +
          '</td>' +
           '<td>' +
          data[item].num_esc +
          '</td>' +
          '<td>' +
          data[item].otorgante +
          '</td>' +
          '<td>' +
          data[item].compareciente +
          '</td>' +
          '<td>' +
          data[item].acto +
          '</td>' +
          '</tr>';
      }
      document.getElementById('libro').innerHTML = htmlTags;
}

function CargarRelNotasCredito(data){
  var htmlTags = '';
  for (item in data) {
      htmlTags +=
          '<tr>' +
          '<td>' +
          data[item].id_ncf +
          '</td>' +
          '<td>' +
          data[item].id_fact +
          '</td>' +
          '<td>' +
          data[item].id_radica +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].total_fact) +
          '</td>' +
          '<td>' +
          data[item].detalle +
          '</td>' +
          '</tr>';
      }
      document.getElementById('data_relnota').innerHTML = htmlTags;
}

function CargarInformeCartera(data){
  var total_saldo = 0;
  var htmlTags = '';
  for (item in data) {
    total_saldo = total_saldo + parseFloat(data[item].abono_car);
      htmlTags +=
          '<tr>' +
          '<td>' +
          data[item].id_car +
          '</td>' +
          '<td>' +
          data[item].id_fact +
          '</td>' +
          '<td>' +
          data[item].fecha_fact +
          '</td>' +
            '<td>' +
          data[item].fecha_abono +
          '</td>' +
          '<td>' +
          data[item].num_esc +
          '</td>' +
          '<td>' +
          data[item].identificacion_cli +
          '</td>' +
          '<td>' +
          data[item].cliente +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].saldogeneral) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].abono_car) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].nuevo_saldo) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].total_fact) +
          '</td>' +
         
          '</tr>';
      }

      htmlTags +=
       '<tr>' +
          '<td>' +
         '<b>Totales:</b>'+
          '</td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
           '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
           '<td>' +
          '</td>' +
          '<td align="right"><b>' +
          formatNumbderechos(total_saldo) +
          '</b></td>' +
          '<td>' +
          '</td>' +
           '<td>' +
          '</td>' +
          '</tr>';

      document.getElementById('carteradata').innerHTML = htmlTags;
}

function CargarInformeCajadiario_rapida(data, contado, credito, facturadores){
  var subtotal = 0;
  var total_iva = 0;
  var total_factura = 0;
  var htmlTags = '';
  for (item in data) {
   
    total_iva = total_iva + parseFloat(data[item].total_iva);
    subtotal = subtotal + parseFloat(data[item].subtotal);
    total_factura = total_factura + parseFloat(data[item].total_fact);
    htmlTags +=
          '<tr>' +
           '<td>' +
          data[item].fecha_fact +
          '</td>' +
          '<td>' +
          data[item].prefijo + ' ' + data[item].id_fact +
          '</td>' +
           '<td>' +
          data[item].a_nombre_de +
          '</td>' +
           '<td>' +
          data[item].cliente +
          '</td>' +
         
           '<td align="right">' +
          formatNumbderechos(data[item].subtotal) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].total_iva) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].total_fact) +
          '</td>' +
          '<td>' +
          data[item].forma_pago +
          '</td>' +
          '<td>' +
          data[item].estado +
          '</td>' +
          '<td>' +
          data[item].id_ncf +
          '</td>' +
           '<td>' +
          data[item].name +
          '</td>' +
          '</tr>';
      }

      htmlTags +=
       '<tr>' +
          '<td>' +
         '<b>Totales:</b>'+
          '</td>' +
          '<td>' +
          '</td>' +
           '<td>' +
          '</td>' +
           '<td>' +
          '</td>' +
          '<td align="right"><b>' +
          formatNumbderechos(subtotal) +
          '</b></td>' +
          '<td align="right"><b>' +
          formatNumbderechos(total_iva) +
          '</b></td>' +
          '<td align="right"><b>' +
          formatNumbderechos(total_factura) +
          '</b></td>' +
          '<td>'
          '</td>' +
           '<td>' +
          '</td>' +
          '<td>' +
           '</td>'+
          '</tr>';

      document.getElementById('data_tabla').innerHTML = htmlTags;

      var htmlTags2 = '';
      var contado_iva = 0;
      var contado_subtotal = 0;
      var contado_total_factura = 0;


      for (item in contado) {
   
        contado_iva = parseFloat(contado[item].total_contado_iva);
        contado_subtotal = parseFloat(contado[item].subtotal_contado);
        contado_total_factura = parseFloat(contado[item].total_contado_fact);
      }


      var credito_iva = 0;
      var credito_subtotal = 0;
      var credito_total_factura = 0;


      for (item in credito) {
   
        credito_iva = parseFloat(credito[item].total_credito_iva);
        credito_subtotal = parseFloat(credito[item].subtotal_credito);
        credito_total_factura = parseFloat(credito[item].total_credito_fact);
      }

      htmlTags2 +=
          '<tr>' +
           '<td>' +
          'Contado' +
          '</td>' +
          '<td>' +
          formatNumbderechos(contado_subtotal)+
          '</td>' +
           '<td>' +
            formatNumbderechos(contado_iva)+
          '</td>' +
           '<td>' +
          formatNumbderechos(contado_total_factura) +
          '</td>' +
          '</tr>'+

          '<tr>' +
           '<td>' +
          'Crédito' +
          '</td>' +
          '<td>' +
          formatNumbderechos(credito_subtotal)+
          '</td>' +
           '<td>' +
           formatNumbderechos(credito_iva)+
          '</td>' +
           '<td>' +
          formatNumbderechos(credito_total_factura) +
          '</td>' +
          '</tr>';

          document.getElementById('data_2').innerHTML = htmlTags2;
          
          var htmlTags3 = '';
          for (item3 in facturadores) {
           htmlTags3 +=
            '<tr>' +
            '<td>' +
            facturadores[item3].facturador +
            '</td>' +
            '<td>' +
            formatNumbderechos(facturadores[item3].subtotal) +
            '</td>' +
            '<td>' +
            formatNumbderechos(facturadores[item3].iva) +
            '</td>' +
            '<td>' +
            formatNumbderechos(facturadores[item3].total) +
            '</td>' +
            '</tr>';
          }

          document.getElementById('data3').innerHTML = htmlTags3;
}

function CargarInformeCajadiario_rapida_conceptos(data){
  var subtotal = 0;
  var total_iva = 0;
  var total_factura = 0;
  var htmlTags = '';
  for (item in data) {
   
    total_iva = total_iva + parseFloat(data[item].iva);
    subtotal = subtotal + parseFloat(data[item].subtotal);
    total_factura = total_factura + parseFloat(data[item].total);
    htmlTags +=
          '<tr>' +
           '<td>' +
          data[item].id_concep +
          '</td>' +
          '<td>' +
          data[item].nombre_concep +
          '</td>' +
           '<td>' +
          data[item].cantidad +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].subtotal) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].iva) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].total) +
          '</td>' +
          '</tr>';
      }

      htmlTags +=
       '<tr>' +
          '<td>' +
         '<b>Totales:</b>'+
          '</td>' +
          '<td>' +
          '</td>' +
           '<td>' +
          '</td>' +
          '<td align="right"><b>' +
          formatNumbderechos(subtotal) +
          '</b></td>' +
          '<td align="right"><b>' +
          formatNumbderechos(total_iva) +
          '</b></td>' +
          '<td align="right"><b>' +
          formatNumbderechos(total_factura) +
          '</b></td>' +
          '</tr>';

      document.getElementById('data_tabla').innerHTML = htmlTags;
}

function CargarInformeDepositos(data){
    var totaldepositos = 0;
    var totalsaldo = 0;
    var htmlTags = '';
  for (item in data) {
    totaldepositos = totaldepositos + parseFloat(data[item].deposito_act);
    totalsaldo = totalsaldo + parseFloat(data[item].saldo);
    htmlTags +=
          '<tr>' +
           '<td>' +
          data[item].id_act +
          '</td>' +
          '<td>' +
          data[item].fecha +
          '</td>' +
           '<td>' +
          data[item].identificacion_cli +
          '</td>' +
           '<td>' +
          data[item].nombre +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].deposito_act) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].saldo) +
          '</td>' +
           '<td>' +
          data[item].observaciones_act +
          '</td>' +
           '<td>' +
          data[item].id_radica +
          '</td>' +
          '</tr>';
      }

       htmlTags +=
       '<tr>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '<b>Totales:</b>'+
          '</td>' +
          '<td align="right"><b>' +
          formatNumbderechos(totaldepositos) +
          '</b></td>' +
          '<td align="right"><b>' +
          formatNumbderechos(totalsaldo) +
          '</b></td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>'+
          '</tr>';

      document.getElementById('data').innerHTML = htmlTags;
}

function CargarInformeEgresos(data){
    
    var totalegresos = 0;
    var htmlTags = '';
  for (item in data) {
   
    totalegresos = totalegresos + parseFloat(data[item].egreso_egr);
    htmlTags +=
          '<tr>' +
           '<td>' +
          data[item].id_act +
          '</td>' +
          '<td>' +
          data[item].fecha_egreso +
          '</td>' +
           '<td>' +
          data[item].identificacion_cli +
          '</td>' +
           '<td>' +
          data[item].nombre +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].saldo_de_deposito) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].egreso_egr) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].nuevo_saldo) +
          '</td>' +
           '<td>' +
          data[item].observaciones_egr +
          '</td>' +
           '<td>' +
          data[item].descripcion_tip +
          '</td>' +
           '<td>' +
          data[item].id_fact +
          '</td>' +
           '<td>' +
          data[item].id_radica +
          '</td>' +
          '</tr>';
      }

       htmlTags +=
       '<tr>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '<b>Totales:</b>'+
          '</td>' +
          '<td align="right"><b>' +
         
          '</b></td>' +
          '<td align="right"><b>' +
          formatNumbderechos(totalegresos) +
          '</b></td>' +
           '<td align="right"><b>' +
          
          '</b></td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>'+
           '<td>' +
          '</td>'+
          '</tr>';

      document.getElementById('data').innerHTML = htmlTags;
}


