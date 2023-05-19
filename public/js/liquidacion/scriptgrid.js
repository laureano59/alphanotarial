//NOTE: Cargar Derechos Notariales
function CargarDerechos(validar) {
    var htmlTags = "";
    var totalderechos = 0;
    for (item in validar) {
      totalderechos += parseFloat(validar[item].derechos);
        htmlTags +=
        '<tr>'+
        '<td>'+
        '<a href="javascript://" OnClick="Conceptos(' + validar[item].id_acto + ');">' +
        validar[item].nombre_acto+
        '</a>'+
        '</td>'+
        '<td>'+
        '<b class="green">' + '$' + formatNumber(validar[item].cuantia) + '</b>' +
        '</td>'+
        '<td>'+
        '<b class="purple">' + formatNumbderechos(validar[item].derechos) + '</b>' +
        '</td>'+
        '</tr>';
    }
    htmlTags +='<tr>'+
    '<td>'+
    '<b class="brown">TOTAL DERECHOS</b>'+
    '</td>'+
    '<td>'+
    '<b class="brown">NOTARIALES </b>'+
    '</td>'+
    '<td>'+
    '<b class="brown">'+ formatNumbderechos(Math.round(totalderechos))+'</b>'+
    '<input type="hidden" id="totderechos" value="0">'+
    '</td>'+
    '</tr>';

    document.getElementById('datos').innerHTML = htmlTags;
    totalderechos = Math.round(totalderechos);
    $("#totderechos").val(totalderechos);
}

//NOTE: Cargar Liq Derechos
function CargarLiqDerechos(validar) {
    var htmlTags = "";
    var totalderechos = 0;
    for (item in validar) {
      totalderechos += parseFloat(validar[item].derechos);
        htmlTags +=
        '<tr>'+
        '<td>'+
        validar[item].nombre_acto+
        '</td>'+
        '<td>'+
        '<b class="green">' + '$' + formatNumber(validar[item].cuantia) + '</b>' +
        '</td>'+
        '<td>'+
        '<b class="purple">' + formatNumbderechos(validar[item].derechos) + '</b>' +
        '</td>'+
        '</tr>';
    }
    htmlTags +='<tr>'+
    '<td>'+
    '<b class="brown">TOTAL DERECHOS</b>'+
    '</td>'+
    '<td>'+
    '<b class="brown">NOTARIALES </b>'+
    '</td>'+
    '<td>'+
    '<b class="brown">'+ formatNumbderechos(totalderechos)+'</b>'+
    '<input type="hidden" id="totderechos" value="0">'+
    '</td>'+
    '</tr>';
    document.getElementById('datos').innerHTML = htmlTags;
    $("#totderechos").val(totalderechos);
}

//NOTE: Cargar Recaudos
function CargarRecaudos(validar) {
  $("#recaudos").fadeIn();
  $("#totalrecsuper").html(formatNumbderechos(validar.recsuper));
  $("#totalrecfondo").html(formatNumbderechos(validar.recfondo));
  $("#totrecsuper").val(validar.recsuper);
  $("#totrecfondo").val(validar.recfondo);
  $("#totaporteespecial").val(validar.aporteespecial);
  $("#total_impuesto_timbre").val(validar.impuesto_timbre);

  

  if(validar.rtf > 0){
    $("#retefuente").fadeIn();
    $("#totalrtf").html(formatNumbderechos(validar.rtf));
    $("#totrtf").val(validar.rtf);
  }else if(validar.rtf == 0){
      $("#retefuente").fadeOut();
      $("#totalrtf").html(formatNumbderechos(0));
  }

  if(validar.reteconsumo > 0){
    $("#totalreteconsumo").html(formatNumbderechos(validar.reteconsumo));
    $("#reteconsumo").fadeIn();
  }else if(validar.reteconsumo == 0){
      $("#reteconsumo").fadeOut();
      $("#totalreteconsumo").html(formatNumbderechos(0));
  }

  if(validar.aporteespecial > 0){
    $("#totalaporteespecial").html(formatNumbderechos(validar.aporteespecial));
    $("#aporteespecial").fadeIn();
  }else{
    $("#aporteespecial").fadeOut();
      $("#totalaporteespecial").html(formatNumbderechos(0));
  }


  if(validar.impuesto_timbre > 0){
    $("#totalimpuestotimbre").html(formatNumbderechos(validar.impuesto_timbre));
    $("#impuesto_timbre").fadeIn();
  }else{
    $("#impuesto_timbre").fadeOut();
      $("#totalimpuestotimbre").html(formatNumbderechos(0));
  }




}

//NOTE: Cargar Recaudos Liq
function CargarRecaudosLiq(validar) {
  for (item in validar){
    $("#recaudos").fadeIn();
    $("#totalrecsuper").html(formatNumbderechos(validar[item].recsuper));
    $("#totalrecfondo").html(formatNumbderechos(validar[item].recfondo));
    $("#totaliva").html(formatNumbderechos(validar[item].iva));
    $("#totalrecaudos").html(formatNumbderechos(validar[item].totalrecaudos));
    $("#grantotal").html(formatNumbderechos(Math.round(validar[item].grantotalliq)));

    if(validar[item].retefuente > 0){
      $("#retefuente").fadeIn();
      $("#totalrtf").html(formatNumbderechos(Math.round(validar[item].retefuente)));
    }else if(validar[item].retefuente < 1){
        $("#retefuente").fadeOut();
    }

    if(validar[item].reteconsumo > 0){
      $("#totalreteconsumo").html(formatNumbderechos(validar[item].reteconsumo));
      $("#reteconsumo").fadeIn();
    }else if(validar[item].reteconsumo < 1){
        $("#reteconsumo").fadeOut();
    }

    if(validar[item].aporteespecial > 0){
      $("#totalaporteespecial").html(formatNumbderechos(validar[item].aporteespecial));
      $("#aporteespecial").fadeIn();
    }else if(validar[item].aporteespecial < 1){
        $("#aporteespecial").fadeOut();
    }

     if(validar[item].total_impuesto_timbre > 0){
      $("#totalimpuestotimbre").html(formatNumbderechos(validar[item].total_impuesto_timbre));
      $("#impuesto_timbre").fadeIn();
    }else if(validar[item].aporteespecial < 1){
        $("#impuesto_timbre").fadeOut();
    }



  }
}
