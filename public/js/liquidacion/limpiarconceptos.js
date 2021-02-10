function LimpiarConceptos(){
  /**********Inputs NOTE:Cantidad Hojas y Cantidad Paquetes***********/

  var datos = {
      "id_radica": 0
  };
  var route = "/traeconceptos";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
      .done(function(info) {
          var conceptos = info.conceptos;
          var totaliden;
          var hojasatributo;
          var atributototal;
          for (item in conceptos) {
            totalatributo = "total"+conceptos[item].atributo;
            hojasatributo = "hojas"+conceptos[item].atributo;
            totaliden = "total"+conceptos[item].id_concep;
            $("#"+hojasatributo).val('');
            $("#"+totalatributo).html('');
            $("#"+totaliden).val('0');
          }
      })

  $("#totalconceptos").html('');
  $("#totalconcept").val(0);
  $("#grantotal").html('');
  $("#grantot").val(0);
  $("#totrecsuper").val(0);
  $("#totrecfondo").val(0);
  $("#totiva").val(0);
  $("#totivacompleto").val(0);
  $("#totaliva").html('');
  $("#totrtf").val(0);
  $("#totreteconsumo").val(0);
  $("#totrecaudos").val(0);
  $("#totderechos").val(0);
}

function OcultarConcepto(){
  var datos = {
      "id_radica": 0
  };
  var route = "/traeconceptos";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
      .done(function(info) {
          var conceptos = info.conceptos;
          var atributo;
          for (item in conceptos) {
            atributo = conceptos[item].atributo;
            $("#"+atributo).fadeOut();
          }
      })
}
