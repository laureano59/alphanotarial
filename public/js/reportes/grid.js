function CargarCajaDiarioGeneral(data, total_egreso) {
    var htmlTags = "";
    var total_derechos = 0;
    var total_conceptos = 0;
    var total_recaudo = 0;
    var total_aporteespecial = 0;
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
        '</tr>' +

        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Conceptos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_conceptos)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Ingresos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_gravado)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Iva</b></font>' +
        '</td>'+
        '<td>'+
        formatNumbderechos(Math.round(total_iva)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Recaudos</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_recaudo)) +
        '</td>' +
        '</tr>' +
         '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Aporte Especial</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_aporteespecial)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total Retención</b></font>' +
        '</td>' +
        '<td>' +
        formatNumbderechos(Math.round(total_retencion)) +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteIva</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_reteiva)) +
        ')</font></td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteIca</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_reteica)) +
        ')</font></td>' +
        '</tr>' +
        '<tr>' +
        '<td>' +
        '<font size="2"><b>Total ReteRtf</b></font>' +
        '</td>' +
        '<td><font color="red">(-' +
        formatNumbderechos(Math.round(total_retertf)) +
        ')</font></td>' +
        '</tr>' +
        '<tr>' +
        '<td>'+
        '<font size="2"><b>Gran Total</b></font>' +
        '</td>'+
        '<td>' +
        formatNumbderechos(Math.round(total)) +
        '</td>' +
        '</tr>';
       

    document.getElementById('datos_totales').innerHTML = htmlTags_2;
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
  var total_factura = 0;
  var total_saldo = 0;
  var htmlTags = '';
  for (item in data) {
    total_factura = total_factura + parseFloat(data[item].total_fact);
    total_saldo = total_saldo + parseFloat(data[item].saldo_fact);
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
          formatNumbderechos(data[item].total_fact) +
          '</td>' +
          '<td align="right">' +
          formatNumbderechos(data[item].saldo_fact) +
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
          '<td align="right"><b>' +
          formatNumbderechos(total_factura) +
          '</b></td>' +
          '<td align="right"><b>' +
          formatNumbderechos(total_saldo) +
          '</b></td>' +
          '</tr>';

      document.getElementById('carteradata').innerHTML = htmlTags;
}

function CargarInformeCajadiario_rapida(data){
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