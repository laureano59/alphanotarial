//NOTE: Cargar Conceptos
function CargarConceptos(validar) {
    var totalconceptos = 0;
    var conceptos = validar;
    for (item in conceptos) {
        if (conceptos[item].estado == 1) {
            $("#" + conceptos[item].atributo).fadeIn();
        } else if (conceptos[item].atributo == 0) {
            $("#" + conceptos[item].atributo).fadeOut();
        }
    }
}

/*****************NOTE:CALCULAR VALOR CONCEPTOS*********************/
function InputTexto(atributo, id) {
    var hojas = $("#"+atributo).val();
    CacularConceptos(hojas, id, atributo);
}

function CacularConceptos(hojas, id_concep, atributo) {
    var datos = {
        "id_concep": id_concep,
        "hojas": hojas
    };
    var route = "/valorconceptos";
    var token = $("#token").val();
    var total;
    var type = 'GET';
    __ajax(route, token, type, datos)
        .done(function(info) {
          var total;
          total = info.total;
          var cadena = atributo,
          inicio = 5,//Elimina String:hojas
          subCadena = cadena.substring(inicio);//Elimina String:hojas
          $("#total"+subCadena).html(formatNumbderechos(total));
          $("#total"+id_concep).val(total);
          CalConceptos();
        })
}

//NOTE: Calcular Conceptos Automatico
function CalConceptos() {
    datos = {
        "id_radica": 0
    };
    var route = "/traeconceptos";
    var token = $("#token").val();
    var type = 'GET';
    __ajax(route, token, type, datos)
        .done(function(info) {
            var conceptos = info.conceptos;
            var res = 0;
            for (item in conceptos) {
                res = parseInt($("#total" + conceptos[item].id_concep).val()) + res;
            }
            $("#totalconceptos").html(formatNumbderechos(Math.round(res)));
            $("#totalconcept").val(res);
        })


    /***************NOTE:IVA CONCEPTOS*******************/
    var id_tar = 9; //NOTE:Tarifa Iva
    var datos = {
        "id_tar": id_tar
    };
    var route = "/tarifas";
    var token = $("#token").val();
    var type = 'GET';
    __ajax(route, token, type, datos)
        .done(function(info) {
            var iva = info.porcentajeiva / 100;
            var totaliva = $("#totalconcept").val() * iva;
            totaliva = parseFloat($("#totiva").val()) + totaliva;
            $("#totaliva").html(formatNumbderechos(Math.round(totaliva)));
            var totalrecaudos = 0;
            totalrecaudos = totaliva + parseFloat($("#totrecsuper").val()) +
                parseFloat($("#totrecfondo").val()) + parseFloat($("#totrtf").val()) +
                parseFloat($("#totreteconsumo").val()) + 
                parseFloat($("#totaporteespecial").val());
            $("#totalrecaudos").html(formatNumbderechos(Math.round(totalrecaudos)));
            $("#totrecaudos").val(totalrecaudos);
            $("#totivacompleto").val(totaliva);
            var grantotal = 0;
            grantotal = parseFloat($("#totderechos").val()) + parseFloat($("#totrecaudos").val()) +
                parseFloat($("#totalconcept").val());
            $("#grantotal").html(formatNumbderechos(Math.round(grantotal)));
            $("#grantot").val(grantotal);
        })
}

//NOTE: Calcular Conceptos Manual
$("#CalcularConceptos").click(function() {
  CalConceptos();
});

function CargarConceptosLiq(validar) {
    for (item in validar) {
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
              var hojasatributo;
              var atributototal;
              for (item2 in conceptos) {
                totalatributo = "total"+conceptos[item2].atributo;
                atributo = conceptos[item2].atributo;
                hojasatributo = "hojas"+conceptos[item2].atributo;
                  if (parseFloat(validar[item][totalatributo]) > 0) {
                      $("#"+atributo).fadeIn();
                      $("#"+hojasatributo).val(validar[item][hojasatributo]);
                      $("#"+totalatributo).html(formatNumbderechos(validar[item][totalatributo]));
                  } else if (parseFloat(validar[item][totalatributo]) < 1) {
                      $("#"+atributo).fadeOut();
                  }
              }
          })
        $("#totalconceptos").html(formatNumbderechos(validar[item].totalconceptos));
    }
}
