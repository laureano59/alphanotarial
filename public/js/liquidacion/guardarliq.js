$("#guardarliq").click(function() {
  CalConceptos();
  /******NOTE: Se Valida que La Radicación esté Completa********/
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
      /***********NOTE:Derechos Notariales**************/
      var id_radica, datos;
      id_radica = $("#radicacion").val();

      datos = {
          "id_radica": id_radica
      };
      var route = "/liqderechos";
      var token = $("#token").val();
      var type = 'POST';
      __ajax(route, token, type, datos)
      .done( function( info ){
        if(info.validarliqd == 1){

          /***********NOTE:Conceptos **********
          Insertar Elementos a Objeto dinamicamente************/

          datos = {
              "id_radica": 0
          };
          var route = "/traeconceptos";
          var token = $("#token").val();
          var type = 'GET';
          __ajax(route, token, type, datos)
          .done( function( info ){
            var conceptos = info.conceptos;
            var atributo;
            var id_concep;
              datos = {
                "id_radica": id_radica
              };
            for (item in conceptos) {
              atributo = conceptos[item].atributo;
              id_concep = conceptos[item].id_concep;
              datos["hojas"+atributo] = $("#hojas"+atributo).val();
              datos["total"+id_concep] = $("#total"+id_concep).val();
            }

            datos["totalconceptos"] = $("#totalconcept").val();
              route = "/liqconceptos";
              token = $("#token").val();
              type = 'POST';
              __ajax(route, token, type, datos)
              .done( function( info ){
                if(info.validarliqc == 1){

                  /***********NOTE:Recaudos**************/
                  var totrecsuper, totrecfondo, totiva, totrtf, totreteconsumo,
                  totalrecaudos, totaporteespecial, grantotalliq;
                  totrecsuper = $("#totrecsuper").val();
                  totrecfondo = $("#totrecfondo").val();
                  totiva = $("#totivacompleto").val();
                  totrtf = $("#totrtf").val();
                  totreteconsumo = $("#totreteconsumo").val();
                  totaporteespecial = $("#totaporteespecial").val();
                  totalrecaudos = $("#totrecaudos").val();
                  grantotalliq = $("#grantot").val();

                  datos = {
                      "id_radica": id_radica,
                      "totrecsuper": totrecsuper,
                      "totrecfondo": totrecfondo,
                      "totiva": totiva,
                      "totrtf": totrtf,
                      "totreteconsumo": totreteconsumo,
                      "totaporteespecial": totaporteespecial,
                      "totalrecaudos": totalrecaudos,
                      "grantotalliq": grantotalliq
                    };

                  route = "/liqrecaudos";
                  token = $("#token").val();
                  type = 'POST';
                  __ajax(route, token, type, datos)
                  .done( function( info ){
                    if(info.validarliqr == 1){
                      $("#liqok").fadeIn();
                      $("#mensajeliq").html(info.mensaje);
                      setTimeout(function() {
                        $("#liqok").fadeOut();
                      }, 3000);
                    }
                })//Ajax Liq_recaudos
              }//if Liq_conceptos
            })//Ajax Liq_conceptos
          })//ajax conceptos
        }//if Liq_derechos
      })//Ajax Liq_derechos
    }
  })
});
