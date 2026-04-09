function CargarCajaDiarioGeneral(data, total_egreso, caja_diario_otros,  derechos_contado, conceptos_contado, ingresos_contado, iva_contado, recaudos_contado, aporteespecial_contado, impuestotimbre_contado, 
timbreley175_contado, rtf_contado, deduccion_reteiva_contado, deduccion_reteica_contado, deduccion_retertf_contado,
total_fact_contado, derechos_credito, conceptos_credito, ingresos_credito, iva_credito, recaudos_credito, aporteespecial_credito,
impuestotimbre_credito, timbreley175_credito, rtf_credito, deduccion_reteiva_credito, deduccion_reteica_credito,
deduccion_retertf_credito, total_fact_credito, bonos_es) {
    var htmlTags = "";
    var total_derechos = 0;
    var total_conceptos = 0;
    var total_recaudo = 0;
    var total_aporteespecial = 0;
    var total_impuesto_timbre = 0;
    var total_timbreley175 = 0;
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
        total_timbreley175 = parseFloat(data[item].timbreley175) + total_timbreley175;
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
            '<td align="right">' + formatNumbderechos(Math.round(data[item].timbreley175)) +
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
         '<td align="right"><b>' + formatNumbderechos(Math.round(total_timbreley175)) + '</b>' +
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
        '<font size="2"><b>Total Timbre Ley 175</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_timbreley175)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(timbreley175_contado)) +
        '</td>' +
         '<td>' +
        formatNumbderechos(Math.round(timbreley175_credito)) +
        '</td>' +
         '<td>' +
         '</tr>'+
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total RetenciÃƒÂ³n</b></font>' +
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
        '<font size="2"><b>Total Bonos</b></font>' +
        '</td>' +
        '<td><font color="blue">(-' +
        formatNumbderechos(Math.round(0)) +
        ')</font></td>' +
         '<td><font color="blue">(-' +
        formatNumbderechos(Math.round(bonos_es)) +
        ')</font></td>' +
         '<td><font color="blue">(-' +
        formatNumbderechos(Math.round(0)) +
        ')</font></td>' +
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
        formatNumbderechos(Math.round(total_fact_contado - bonos_es)) +
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
    var total_timbreley175_otros = 0;
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
        total_timbreley175_otros = parseFloat(caja_diario_otros[item2].timbreley175) + total_timbreley175_otros;
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
      var total_timbreley175_resta = 0;
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
      total_timbreley175_resta = parseInt(Math.round(total_timbreley175) - Math.round(total_timbreley175_otros));
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
        '<font size="2"><b>Total Timbre Ley 175</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_timbreley175_otros)) +
        '</td>' +
               
         '<td>' +
        formatNumbderechos(total_timbreley175_resta) +
        '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total RetenciÃƒÂ³n</b></font>' +
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


function CargarCuentasCobroGeneradas(data){
  var htmlTags = '';
  for (item in data) {
     htmlTags +=
     '<tr>'+
     '<td>'+
     data[item].id_cce +
     '</td>'+
     '<td>'+
     data[item].id_cli +
     '</td>'+
      '<td>'+
     data[item].nombre_cli +
     '</td>'+
     '<td align="center">'+
     data[item].created_at +
     '</td>' +
     '<td>' +
            '<a href="javascript://" OnClick="ImprimirCC(\'' + data[item].id_cce + '\'' + ');">' +
            'imprimir' +
            '</a>' +
            '</td>' +
     '</tr>';
  } 
 
  document.getElementById('data').innerHTML = htmlTags;
 
}

function ImprimirCC(id_cce){
   
    var route = "validar_idcce";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
            "id_cce": id_cce
       }

    __ajax(route, token, type, datos)
     .done(function(info) {
        if(info.validar == 1){
            var url = "/cuentadecobropdf";
            $("<a>").attr("href", url).attr("target", "_blank")[0].click();
        }

    })
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


function CargarInformeCartera_facturas_activas(data){
  var total_saldo = 0;
  var total_facturas = 0;
  var htmlTags = '';
  for (item in data) {
    total_saldo = total_saldo + parseFloat(data[item].saldo_fact);
    total_facturas = total_facturas + parseFloat(data[item].total_fact);
      htmlTags +=
          '<tr>' +
          
          '<td>' +
          data[item].id_fact +
          '</td>' +
          '<td>' +
          data[item].fecha_fact +
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
          formatNumbderechos(data[item].saldo_fact) +
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
           '</td>' +
           '<td>' +
           '</td>' +
           '<td>' +
          '<td align="right"><b>' +
          formatNumbderechos(total_saldo) +
          '</b></td>' +
         '<td align="right"><b>' +
          formatNumbderechos(total_saldo) +
          '</b></td>' +
          '</tr>';

      document.getElementById('carteradata').innerHTML = htmlTags;
}

function CargarInformeCarteraBonos(data){
  var htmlTags = '';
  for (item in data) {
    
      htmlTags +=
          '<tr>' +
          '<td>' +
          data[item].id_abono +
          '</td>' +
           '<td>' +
          data[item].codigo_bono +
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
          formatNumbderechos(data[item].valor_abono) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].nuevo_saldo) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].valor_bon) +
          '</td>' +
         
          '</tr>';
      }     

      document.getElementById('carteradata').innerHTML = htmlTags;
}


function CargarInformeCarteraBonosActivos(data){
  var total_saldo = 0;
  var total_bono = 0;
  var htmlTags = '';
  for (item in data) {
    total_saldo = total_saldo + parseFloat(data[item].saldo);
    total_bono = total_bono + parseFloat(data[item].valor_bono);
      htmlTags +=
          '<tr>' +
          '<td>' +
          data[item].codigo_bono +
          '</td>' +
          '<td>' +
            '<a href="javascript://" OnClick="VerDetalle(\'' + data[item].id_fact + '\'' + ');">' +
            data[item].id_fact +
            '</a>' +
            '</td>' +
          '<td>' +
          data[item].fecha_fact +
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
          '<td align="right" bgcolor="#ffead8">' +
          formatNumbderechos(data[item].valor_bono) +
          '</td>' +
           '<td align="right" bgcolor="#ffead8">' +
          formatNumbderechos(data[item].saldo) +
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
           '<td align="right"><b>' +
           formatNumbderechos(total_bono) +
          '</td>' +
          '<td align="right"><b>' +
          formatNumbderechos(total_saldo) +
          '</b></td>' +
          '</tr>';

      document.getElementById('carteradatabonosactivos').innerHTML = htmlTags;
}

function VerDetalle(id_fact){
    $('#modaldetallebonos').modal('show');
    $("#factura").html(id_fact);  
   

    var porfactura = "porfactura";
   
    var datos = {
        "num_factura": id_fact,
        "porfactura": porfactura
    };
    
      var route = "/informecarterabonos";
      var token = $("#token").val();
      var type = 'GET';

      __ajax(route, token, type, datos)
      .done( function( info ){
        var informecarterabon = info.informecarterabon;
        CargarInformeCarteraBonos(informecarterabon);
      }) 

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
          'CrÃƒÂ©dito' +
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

function CargarInformeActasCredito(data){
    var totaldepositos = 0;
    var totaldepositosboleta = 0;
    var totaldepositosregistro = 0;
    var totaldepositosescritura = 0;
    var totalsaldo = 0;
    var htmlTags = '';
  for (item in data) {
    totaldepositos = totaldepositos + parseFloat(data[item].deposito_act);
    totaldepositosboleta = totaldepositosboleta + parseFloat(data[item].deposito_boleta);
    totaldepositosregistro = totaldepositosregistro + parseFloat(data[item].deposito_registro);
    totaldepositosescritura += parseFloat(data[item].deposito_escrituras) || 0;
    totalsaldo = totalsaldo + parseFloat(data[item].saldo);
    
    var anulada_estado = (data[item].anulada == 1 || data[item].anulada == true || data[item].anulada === 't') ? 'Anulada' : 'Activa';
    var credito_estado = data[item].credito_act == 1 ? 'Crédito' : 'Normal';
    var num_esc = data[item].num_esc || '';
    var id_fact = data[item].id_fact || '';

    htmlTags +=
          '<tr>' +
          '<td>' + data[item].fecha + '</td>' +
          '<td>' + (data[item].id_radica || '') + '</td>' +
          '<td>' + data[item].id_act + '</td>' +
          '<td>' + num_esc + '</td>' +
          '<td>' + id_fact + '</td>' +
          '<td>' + data[item].identificacion_cli + ' ' + (data[item].nombre || '') + '</td>' +
          '<td align="right">$' + formatNumbderechos(data[item].deposito_act) + '</td>' +
          '<td align="right">$' + formatNumbderechos(data[item].deposito_boleta) + '</td>' +
          '<td align="right">$' + formatNumbderechos(data[item].deposito_registro) + '</td>' +
          '<td align="right">$' + formatNumbderechos(data[item].deposito_escrituras || 0) + '</td>' +
          '<td align="right">$' + formatNumbderechos(data[item].saldo) + '</td>' +
          '<td>' + credito_estado + '</td>' +
          '<td>' + anulada_estado + '</td>' +
          '<td>' + (data[item].observaciones_act || '') + '</td>' +
          '</tr>';
  }

  htmlTags += '<tr><td colspan="6" align="right"><b>Totales:</b></td>' +
    '<td align="right"><b>$' + formatNumbderechos(totaldepositos) + '</b></td>' +
    '<td align="right"><b>$' + formatNumbderechos(totaldepositosboleta) + '</b></td>' +
    '<td align="right"><b>$' + formatNumbderechos(totaldepositosregistro) + '</b></td>' +
    '<td align="right"><b>$' + formatNumbderechos(totaldepositosescritura) + '</b></td>' +
    '<td align="right"><b>$' + formatNumbderechos(totalsaldo) + '</b></td>' +
    '<td colspan="3"></td></tr>';

  document.getElementById('data').innerHTML = htmlTags;
}


function CargarInformeDepositos(data){
    var totaldepositos = 0;
    var totaldepositosboleta = 0;
    var totaldepositosregistro = 0;
    var totaldepositosescritura = 0;
    var totalsaldo = 0;
    var htmlTags = '';
  for (item in data) {
    totaldepositos = totaldepositos + parseFloat(data[item].deposito_act);
    totaldepositosboleta = totaldepositosboleta + parseFloat(data[item].deposito_boleta);
    totaldepositosregistro = totaldepositosregistro + parseFloat(data[item].deposito_registro);
    //totaldepositosescritura = totaldepositosescritura + parseFloat(data[item].deposito_escrituras);
    totaldepositosescritura += parseFloat(data[item].deposito_escrituras) || 0;
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
          data[item].descripcion_tip +
          '</td>' +
           '<td>' +
          data[item].nombre +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].deposito_boleta) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].deposito_registro) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].deposito_escrituras) +
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
          '</td>' +
          '<td>' +
          '<b>Totales:</b>'+
          '</td>' +
           '<td align="right"><b>' +
          formatNumbderechos(totaldepositosboleta) +
          '</b></td>' +
           '<td align="right"><b>' +
          formatNumbderechos(totaldepositosregistro) +
          '</b></td>' +
          '<td align="right"><b>' +
          formatNumbderechos(totaldepositosescritura) +
          '</b></td>' +
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


function CargarInformeActasPorIdentificacion(data){
    var totaldepositos = 0;
    var totaldepositosboleta = 0;
    var totaldepositosregistro = 0;
    var totaldepositosescritura = 0;
    var totalsaldo = 0;
    var htmlTags = '';
    var tbody = document.getElementById('datos');
    if (!tbody) {
        return;
    }

    var identificacionFilter = $("#identificacion_cli").val();
    var showClienteColumn = (identificacionFilter === "" || identificacionFilter === undefined);

    if (!showClienteColumn && data && data.length > 0) {
        var elNombre = document.getElementById('nombre_cliente_reporte');
        if (elNombre) {
            elNombre.innerText = 'Cliente: ' + data[0].identificacion_cli + ' ' + (data[0].nombre || '');
        }
        $("#th_cliente").hide();
    } else {
        var elNombre2 = document.getElementById('nombre_cliente_reporte');
        if (elNombre2) {
            elNombre2.innerText = '';
        }
        $("#th_cliente").show();
    }

    if (!data || !data.length) {
        tbody.innerHTML = '';
        return;
    }

  for (item in data) {
    if (!Object.prototype.hasOwnProperty.call(data, item)) {
        continue;
    }
    totaldepositos = totaldepositos + parseFloat(data[item].deposito_act);
    totaldepositosboleta = totaldepositosboleta + parseFloat(data[item].deposito_boleta);
    totaldepositosregistro = totaldepositosregistro + parseFloat(data[item].deposito_registro);
    totaldepositosescritura += parseFloat(data[item].deposito_escrituras) || 0;
    totalsaldo = totalsaldo + parseFloat(data[item].saldo);

    var ca = data[item].credito_act;
    var estado = (ca == 1 || ca === true || ca === '1' || ca === 't' || ca === 'true') ? 'Crédito' : 'Normal';
    var an = data[item].anulada;
    var activa = (an == 1 || an === true || an === '1' || an === 't' || an === 'true') ? 'Anulada' : 'Activa';

    htmlTags +=
          '<tr>' +
           '<td>' +
          data[item].fecha +
          '</td>' +
          '<td>' +
          data[item].id_radica +
          '</td>' +
           '<td>' +
          data[item].id_act +
          '</td>' +
           '<td>' +
          (data[item].num_esc || '') +
          '</td>' +
           '<td>' +
          (data[item].id_fact || '') +
          '</td>' +
          (showClienteColumn ? ('<td>' + data[item].identificacion_cli + ' ' + (data[item].nombre || '') + '</td>') : '') +
           '<td align="right">' +
          formatNumbderechos(data[item].deposito_act) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].deposito_boleta) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].deposito_registro) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].deposito_escrituras) +
          '</td>' +
           '<td align="right">' +
          formatNumbderechos(data[item].saldo) +
          '</td>' +
           '<td>' +
          estado +
          '</td>' +
           '<td>' +
          activa +
          '</td>' +
          '<td>' +
          (data[item].observaciones_act || '') +
          '</td>' +
          '</tr>';
      }

      var blankCells = '';
      var numCells = showClienteColumn ? 5 : 4;
      for (var i = 0; i < numCells; i++) {
          blankCells += '<td></td>';
      }

      htmlTags +=
       '<tr>' + blankCells +
          '<td>' +
          '<b>Totales:</b>'+
          '</td>' +
          '<td align="right"><b>' +
          formatNumbderechos(totaldepositos) +
          '</b></td>' +
           '<td align="right"><b>' +
          formatNumbderechos(totaldepositosboleta) +
          '</b></td>' +
           '<td align="right"><b>' +
          formatNumbderechos(totaldepositosregistro) +
          '</b></td>' +
           '<td align="right"><b>' +
          formatNumbderechos(totaldepositosescritura) +
          '</b></td>' +
           '<td align="right"><b>' +
          formatNumbderechos(totalsaldo) +
          '</b></td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>' +
          '<td>' +
          '</td>'+
          '</tr>';

      tbody.innerHTML = htmlTags;
}


/** Relación de egresos y Trazabilidad de egreso: mismo layout agrupado por acta. */
function renderEgresosAgrupadosPorActa(data, tbodyId) {
    var htmlTags = '';
    var totalegresos = 0;

    if (!data || data.length === 0) {
      document.getElementById(tbodyId).innerHTML = '<tr><td>No hay informacion para los filtros seleccionados.</td></tr>';
      return;
    }

    for (var item in data) {
      if (!data.hasOwnProperty(item)) continue;
      var acta = data[item];
      var egresos = acta.egresos || [];
      var egresosHtml = '';

      for (var i = 0; i < egresos.length; i++) {
        var e = egresos[i];
        totalegresos += parseFloat(e.egreso_egr || 0);
        egresosHtml +=
          '<tr style="background:#f3f8ff;">' +
            '<td>' + (e.id_egr || '') + '</td>' +
            '<td>' + (e.fecha_egreso || '') + '</td>' +
            '<td>' + (e.id_con || '') + '</td>' +
            '<td>' + (e.concepto_egreso || '') + '</td>' +
            '<td>' + (e.factura || '') + '</td>' +
            '<td align="right">' + formatNumbderechos(e.egreso_egr || 0) + '</td>' +
            '<td align="right">' + formatNumbderechos(e.descuento_boleta || 0) + '</td>' +
            '<td align="right">' + formatNumbderechos(e.descuento_registro || 0) + '</td>' +
            '<td align="right">' + formatNumbderechos(e.descuento_escritura || 0) + '</td>' +
            '<td align="right">' + formatNumbderechos(e.saldo_final || 0) + '</td>' +
            '<td>' + (e.observaciones_egr || '') + '</td>' +
          '</tr>';
      }

      htmlTags +=
        '<tr>' +
          '<td colspan="11">' +
            '<table class="table table-bordered" style="margin-bottom:8px;">' +
              '<tr style="background:#eef6ea;">' +
                '<td><b>Acta:</b> ' + (acta.id_act || '') + '</td>' +
                '<td><b>Fecha Acta:</b> ' + (acta.fecha_acta || '') + '</td>' +
                '<td><b>Rad:</b> ' + (acta.id_radica || '') + '</td>' +
                '<td><b>Identificacion:</b> ' + (acta.identificacion_cli || '') + '</td>' +
                '<td><b>Cliente:</b> ' + (acta.nombre || '') + '</td>' +
                '<td><b>Estado:</b> ' + (acta.credito_estado || 'NORMAL') + '</td>' +
                '<td><b>Concepto Base:</b> ' + (acta.concepto_base || 'Acta') + '</td>' +
              '</tr>' +
              '<tr style="background:#eef6ea;">' +
                '<td><b>Valor Acta:</b> $' + formatNumbderechos(acta.deposito_act || 0) + '</td>' +
                '<td><b>Boleta:</b> $' + formatNumbderechos(acta.deposito_boleta || 0) + '</td>' +
                '<td><b>Registro:</b> $' + formatNumbderechos(acta.deposito_registro || 0) + '</td>' +
                '<td><b>Escritura:</b> $' + formatNumbderechos(acta.deposito_escrituras || 0) + '</td>' +
                '<td colspan="2"><b>Egresos:</b> ' + egresos.length + '</td>' +
              '</tr>' +
            '</table>' +
            '<table class="table table-bordered table-striped" style="margin-bottom:16px;">' +
              '<thead>' +
                '<tr style="background:#dce9f7;">' +
                  '<th>No. Egreso</th>' +
                  '<th>Fecha</th>' +
                  '<th>Id_Con</th>' +
                  '<th>Concepto Egreso</th>' +
                  '<th>Factura</th>' +
                  '<th>Valor</th>' +
                  '<th>Desc. Boleta</th>' +
                  '<th>Desc. Registro</th>' +
                  '<th>Desc. Escritura</th>' +
                  '<th>Saldo</th>' +
                  '<th>Observacion</th>' +
                '</tr>' +
              '</thead>' +
              '<tbody>' + egresosHtml + '</tbody>' +
            '</table>' +
          '</td>' +
        '</tr>';
    }

      '<tr><td colspan="11">' +
        '<table class="table" style="margin-top:8px;"><tr>' +
        '<td><b>Totales egresos (valor):</b></td>' +
        '<td align="right"><b>' + formatNumbderechos(totalegresos) + '</b></td>' +
        '</tr></table>' +
      '</td></tr>';

    document.getElementById(tbodyId).innerHTML = htmlTags;
}

function CargarInformeEgresos(data) {
  var htmlTags = '';
  var totalegresos = 0;
  for (var item in data) {
    if (!data.hasOwnProperty(item)) continue;
    totalegresos += parseFloat(data[item].egreso_egr || 0);
    htmlTags +=
      '<tr>' +
      '<td>' + (data[item].id_act || '') + '</td>' +
      '<td>' + (data[item].fecha_egreso || '') + '</td>' +
      '<td>' + (data[item].identificacion_cli || '') + '</td>' +
      '<td>' + (data[item].nombre || '') + '</td>' +
      '<td align="right">' + formatNumbderechos(data[item].deposito_act || 0) + '</td>' +
      '<td align="right">' + formatNumbderechos(data[item].egreso_egr || 0) + '</td>' +
      '<td align="right">' + formatNumbderechos(data[item].saldo_final || 0) + '</td>' +
      '<td>' + (data[item].observaciones_egr || '') + '</td>' +
      '<td>' + (data[item].concepto_egreso || '') + '</td>' +
      '<td>' + (data[item].factura || '') + '</td>' +
      '<td>' + (data[item].id_radica || '') + '</td>' +
      '</tr>';
  }

  htmlTags +=
    '<tr>' +
    '<td colspan="5" align="right"><b>TOTAL:</b></td>' +
    '<td align="right"><b>' + formatNumbderechos(totalegresos) + '</b></td>' +
    '<td colspan="5"></td>' +
    '</tr>';

  document.getElementById('data').innerHTML = htmlTags;
}

function CargarTrazabilidadEgreso(data){
    renderEgresosAgrupadosPorActa(data, 'data_trazabilidadegreso');
}

function CargarEscrSinFact(data){
  var htmlTags = '';
  for (item in data) {
    htmlTags +=
          '<tr>' +
           '<td>' +
          data[item].num_esc +
          '</td>' +
          '<td>' +
          data[item].fecha_esc +
          '</td>' +
           '<td>' +
          data[item].id_radica +
          '</td>' +
          '</tr>';
      }

      document.getElementById('data').innerHTML = htmlTags;
}
