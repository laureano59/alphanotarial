$("#guardarliq").click(function() {
   CalConceptos();
  /******Se Valida que La Radicación esté Completa********/
  var id_radica = $("#radicacion").val();
  var datos = {
      "id_radica": id_radica
  };
  var route = "/validarradicacion";
  var token = $("#token").val();
  var type = 'GET';
  __ajax(route, token, type, datos)
  .done( function( info ){
    if(info.validar == 0){
      $("#msjrad1").html(info.mensaje);
      $("#msj-errorrad1").fadeIn();
      setTimeout(function() {
          $("#msj-errorrad1").fadeOut();
      }, 3000);
    }else if(info.validar == 1){
      $("#msjrad1").html(info.mensaje);
      $("#msj-errorrad1").fadeIn();
      setTimeout(function() {
          $("#msj-errorrad1").fadeOut();
      }, 4000);
    }else if(info.validar == 2){

      /***********Recaudos**************/
      var totrecsuper, totrecfondo, totiva, totrtf, totreteconsumo,
          totalrecaudos, totaporteespecial, total_impuesto_timbre, 
          totaltimbredecreto175, grantotalliq;
          totrecsuper = $("#totrecsuper").val();
          totrecfondo = $("#totrecfondo").val();
          totiva = $("#totivacompleto").val();
          totrtf = $("#totrtf").val();
          totreteconsumo = $("#totreteconsumo").val();
          totaporteespecial = $("#totaporteespecial").val();
          total_impuesto_timbre = $("#total_impuesto_timbre").val();
          totalrecaudos = $("#totrecaudos").val();
          grantotalliq = $("#grantot").val();
          totaltimbredecreto175 = $("#totaltimbredecreto175").val();


           /***********Conceptos**************/

          var totalconceptos;   
          let detalle_conceptos = [];
          totalconceptos = $("#totalconcept").val();      
       
          datos = {
              "id_radica": 0
          };
          route = "/traeconceptos";
          token = $("#token").val();
          type = 'GET';
          __ajax(route, token, type, datos)
          .done( function( info ){
            var conceptos = info.conceptos;
            for (item in conceptos) {              
              var atributo = conceptos[item].atributo;
              var id_concep = conceptos[item].id_concep;
              var hojasVal = $("#hojas" + atributo).val();
              var totalVal = parseFloat(
              ($("#total" + id_concep).val() || "0").replace(/,/g, '')
              );             

              if (totalVal > 0) {
                  var obj = {};
                  obj["hojas" + atributo] = hojasVal;
                  obj["total" + atributo] = totalVal;
                  detalle_conceptos.push(obj);
              }
            }            

             datos = {
              "id_radica": id_radica,
              "totrecsuper": totrecsuper,
              "totrecfondo": totrecfondo,
              "totiva": totiva,
              "totrtf": totrtf,
              "totreteconsumo": totreteconsumo,
              "totaporteespecial": totaporteespecial,
              "total_impuesto_timbre": total_impuesto_timbre,
              "totalrecaudos": totalrecaudos,
              "grantotalliq": grantotalliq,
              "totaltimbredecreto175": totaltimbredecreto175,            
              "detalle_conceptos": detalle_conceptos,
              "totalconceptos": totalconceptos
            };
            route = "/liquidacion";
            token = $("#token").val();
            type = 'POST';
            __ajax(route, token, type, datos)
            .done( function( info ){
                if(info.validar == 4){
                    $("#msjrad1").html(info.mensaje);
                    $("#msj-errorrad1").fadeIn();
                    setTimeout(function() {
                      $("#msj-errorrad1").fadeOut();
                    }, 4000);
                }else if(info.validar == 7){
                        $("#liqok").fadeIn();
                        $("#mensajeliq").html(info.mensaje);
                        setTimeout(function() {
                          $("#liqok").fadeOut();
                        }, 4000);
                      }

            })
          })         
    }
  })
});
