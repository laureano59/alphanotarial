function Clean_Fact_Mul(){
  $("#totderechos").val(0);
  $("#totconceptos").val(0);
  $("#totiva").val(0);
  $("#totrtf").val(0);
  $("#totreteconsumo").val(0);
  $("#totfondo").val(0);
  $("#totsuper").val(0);
  $("#reteivaide").val(0);
  $("#retertfide").val(0);
  $("#reteicaide").val(0);
  $("#grantotal").val(0);
  $("#pagosuper").html('');
  $("#pagofondo").html('');
  $("#pagosuperiden").val(0);
  $("#pagofondoiden").val(0);
  $("#porcentajesuper").val('');
  $("#porcentajefondo").val('');

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
          var porcentaje;
          var totalconcepto;
          var totalconceptoiden;
          for (item2 in conceptos) {
              totalatributo = "total" + conceptos[item2].atributo;
              atributo = conceptos[item2].atributo;
              totalatributoiden = "total" + conceptos[item2].atributo + "iden";
              atributoparticipacion = "total" + conceptos[item2].atributo + "participacion";
              atributoparticipacioniden = "total" + conceptos[item2].atributo + "participacioniden";
              porcentaje = "porcentaje" + conceptos[item2].atributo;
              totalconcepto = "totalconcepto" + conceptos[item2].atributo;
              totalconceptoiden = "totalconcepto" + conceptos[item2].atributo + "iden";
              $("#" + totalatributo).html('');
              $("#" + totalatributoiden).val('');
              $("#" + atributoparticipacion).html('');
              $("#" + atributoparticipacioniden).val('');
              $("#" + porcentaje).val('');
              $("#" + totalconcepto).html('');
              $("#" + totalconceptoiden).val('');
          }
      })
}
