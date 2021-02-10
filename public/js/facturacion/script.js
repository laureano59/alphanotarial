function Factura(num_radica, opcion) {
  /********NOTE:Comprueba si La radicación está liquidada********/
  var id_radica = num_radica;
  var route = "/factderechos";
  var token = $("#token").val();
  var type = 'GET';
  $("#radicacion").html(id_radica);
  var datos = {
      "id_radica": id_radica
  };
  __ajax(route, token, type, datos)
  .done(function(info) {
    if (info.validarliqd == '1') { //NOTE:Si la radicación ya está liquidada
      var actosliquidados = info.actos;
      var conceptos = info.conceptos;
      var recaudos = info.recaudos;

      /********NOTE:Comprueba si La radicación está facturada********/
      var route = "/validarexixtefact";
      var token = $("#token").val();
      var type = 'GET';
      var datos = {
        "id_radica": id_radica
      };
      __ajax(route, token, type, datos)
          .done(function(info) {
            if(info.validar == 1){//Radicación facturada se carga factura
              $("#msj2").html(info.mensaje);
              $("#msj-error2").fadeIn();
              setTimeout(function() {
                  $("#msj-error2").fadeOut();
              }, 2000);
              /*******NOTE: Carga datos factura********/
              $("#num_factura").html(info.prefijo+' - '+info.id_fact);
              $("#fecha_fact").html(info.fecha_fact);
              $("#num_escritura").html(info.num_esc);
              $("#identificacion_cli1").val(info.identificacion_cli);
              $("#nombre_cli1").val(info.nombrede);
              $("#reteiva").html(formatNumbderechos(info.deduccion_reteiva));
              $("#retertf").html(formatNumbderechos(info.deduccion_retertf));
              $("#reteica").html(formatNumbderechos(info.deduccion_reteica));
              $("#totalcompleto").html(formatNumbderechos(info.total_fact));

              if(info.credito_fact == true){
                $("#credito").attr('checked', true);
              }else if(info.credito_fact == false){
                $("#contado").attr('checked', true);
              }
            }else if(info.validar == 0){//Radicación No facturada

              $("#anio_radica").html(info.anio);
              $("#id_tipoident1").val('');
              $("#identificacion_cli1").val('');
              $("#nombre_cli1").val('');
              $("#id_tipoident2").val('');
              $("#identificacion_cli2").val('');
              $("#nombre_cli2").val('');
              if(opcion == 1){
                CargarDerechos_FactUnica(actosliquidados);
                CargarRecaudos(recaudos);
                CagarConceptos(conceptos);
              }else if(opcion == 2){
                CargarDerechos_FactDoble(actosliquidados);
                CargarRecaudos_Fact_Doble(recaudos);
                CagarConceptos(conceptos);
              }else if(opcion == 3){
                CargarDerechos_Fact_Multiple(actosliquidados);
                CargarRecaudos_Fact_Multiple(recaudos);
                CagarConceptos_Fact_Multiple(conceptos);
              }

            } else if (info.validarliqd == '0') { //NOTE:si la radicación no se ha liquidado
                $("#msj1").html(info.mensaje);
                $("#msj-error1").fadeIn();
                setTimeout(function() {
                  $("#msj-error1").fadeOut();
                }, 3000);
              }
          })//NOTE:AJAX Si la radicación está liquidada
        }//sí está liquidada
          })//NOTE:AJAX Si está facturada la radicación
}

function CarGarDatosFactMulRadio(){
  Clean_Fact_Mul();
  /********NOTE:Comprueba si La radicación está liquidada********/
  var id_radica = $("#id_radica").val();
  var route = "/factderechos";
  var token = $("#token").val();
  var type = 'GET';
  $("#radicacion").html(id_radica);
  var datos = {
      "id_radica": id_radica
  };
  __ajax(route, token, type, datos)
  .done(function(info) {
    if (info.validarliqd == '1') { //NOTE:Si la radicación ya está liquidada
      var actosliquidados = info.actos;
      var conceptos = info.conceptos;
      var recaudos = info.recaudos;

      CargarDerechos_Fact_Multiple(actosliquidados);
      CargarRecaudos_Fact_Multiple(recaudos);
      CagarConceptos_Fact_Multiple(conceptos);
    }
  })
}

$("#mostrarparticipantes").click(function() {
    var id_radica = $("#id_radica").val();
    var route = "/anombrede";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            var anombrede = info.anombrede;
            CargarAnombreDe(anombrede, 7);//para factunica
        })
});

$("#mostrarparticipantesfactmultiple").click(function() {
    var id_radica = $("#id_radica").val();
    var route = "/anombrede";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            var anombrede = info.anombrede;
            CargarAnombreDe(anombrede, 3);//para factMutiple
        })
});

$("#mostrarparticipantesotor").click(function() {
    var id_radica = $("#id_radica").val();
    var route = "/anombrede";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            var anombrede = info.anombrede;
            CargarAnombreDe(anombrede, 1);
        })
});

$("#mostrarparticipantescompa").click(function() {
    var id_radica = $("#id_radica").val();
    var route = "/anombrede";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_radica": id_radica
    };
    __ajax(route, token, type, datos)
        .done(function(info) {
            var anombrede = info.anombrede;
            CargarAnombreDe(anombrede, 2);
        })
});

$("#identificacion_cli1").blur(function() {
    if ($("#identificacion_cli1").val() != '') {
        var identificacion_cli = $("#identificacion_cli1").val();
        var tipo_doc = $("#id_tipoident1").val();
        var calidad = 1; //NOTE:Para distinguir en que input se muestra el nombre del cliente
        var datos = {
            "identificacion_cli": identificacion_cli,
            "tipo_doc": tipo_doc
        };
        var route = "/principales";
        var token = $("#token").val();
        var type = "GET";
        __ajax(route, token, type, datos)
            .done(function(info) {
                if (info.validar == '0') {
                    $("#tipo_documento").val(info.tipo_doc);
                    if (info.tipo_doc == 4) { //Si es empresa
                        $("#calidad").val(calidad); //NOTE:Campo oculto en modal cliente
                        $("#identificacion_empresa").val(info.identificacion_cli);
                        LimpiarClientes();
                        $("#modalcliente-empresa").modal('toggle');
                    } else {
                        $("#calidad").val(calidad); //NOTE:Campo oculto en modal cliente
                        $("#identificacion").val(info.identificacion_cli);
                        LimpiarClientes();
                        $("#modalcliente").modal('toggle');
                    }
                } else if (info.validar == '1') {
                    $("#nombre_cli1").val(info.nombre);
                }
            })
    }
});

//------------NOTE:Calidad2-------------------

$("#identificacion_cli2").blur(function(){

  if($("#identificacion_cli2").val() != ''){
    var identificacion_cli = $("#identificacion_cli2").val();
    var tipo_doc = $("#id_tipoident2").val();
    var calidad = 2; //NOTE:Para distinguir en que input se muestra el nombre del cliente
    var datos = {
        "identificacion_cli": identificacion_cli,
        "tipo_doc": tipo_doc
    };
    var route = "/principales";
    var token = $("#token").val();
    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'GET',
        dataType: 'json',
        data: datos,

        success: function(info) {
            if (info.validar == '0') {
              $("#tipo_documento").val(info.tipo_doc);
              if(info.tipo_doc == 4){ //NOTE:Si es empresa
                $("#calidad").val(calidad);//NOTE:Campo oculto en modal cliente
                LimpiarClientes();
                $("#identificacion_empresa").val(info.identificacion_cli);
                $("#modalcliente-empresa").modal('toggle');
              }else{
                $("#calidad").val(calidad);//NOTE:Campo oculto en modal cliente
                LimpiarClientes();
                $("#identificacion").val(info.identificacion_cli);
                $("#modalcliente").modal('toggle');
              }
            }else if (info.validar == '1'){
              $("#nombre_cli2").val(info.nombre);
            }
          }
    });
  }
});

$("#guardarfacturaunica").click(function() {
    /********NOTE:Valida que forma pago esté seleccionado*********/
    if (document.querySelector('input[name="formapago"]:checked')) {
      var mediopago = $("#mediopago option:selected").val();
      if(mediopago != ''){
        /******NOTE:Valida que a nombre de no esté vacío*******/
        if ($("#identificacion_cli1").val() != '' && $("#nombre_cli1").val() != '') {
            /*****NOTE:Envío datos de la factura******/
            var formapago = $('input:radio[name=formapago]:checked').val();
            if (formapago == 'contado') {
                formapago = false;
            } else if (formapago == 'credito') {
                formapago = true;
            }
            var id_radica = $("#id_radica").val();
            var identificacion_cli1 = $("#identificacion_cli1").val();
            var nombre_cli1 = $("#nombre_cli1").val();
            var total_derechos = $("#totderechos").val();
            var total_conceptos = $("#totconceptos").val();
            var total_iva = $("#totiva").val();
            var total_rtf = $("#totrtf").val();
            var total_reteconsumo = $("#totreteconsumo").val();
            var total_aporteespecial = $("#totaporteespecial").val();
            var total_fondo = $("#totfondo").val();
            var total_super = $("#totsuper").val();
            var total_fact = $("#grantotal").val();
            var reteiva = $("#reteivaide").val();
            var retertf = $("#retertfide").val();
            var reteica = $("#reteicaide").val();
            var doc_acargo_de = $("#doc_acargo_de").val();
            var detalle_acargo_de = $("#detalle_acargo_de").val();

            var valor = $("#valor").val();
            var numcheque = $("#numcheque").val();
            var id_banco = $("#id_banco option:selected").val();

            var datos = {
                "id_radica": id_radica,
                "formapago": formapago,
                "mediopago": mediopago,
                "identificacion_cli1": identificacion_cli1,
                "nombre_cli1": nombre_cli1,
                "total_derechos": total_derechos,
                "total_conceptos": total_conceptos,
                "total_iva": total_iva,
                "total_rtf": total_rtf,
                "total_reteconsumo": total_reteconsumo,
                "total_aporteespecial": total_aporteespecial,
                "total_fondo": total_fondo,
                "total_super": total_super,
                "total_fact": total_fact,
                "reteiva": reteiva,
                "retertf": retertf,
                "reteica": reteica,
                "valor": valor,
                "numcheque": numcheque,
                "id_banco": id_banco,
                "doc_acargo_de": doc_acargo_de,
                "detalle_acargo_de":detalle_acargo_de
            };
            var route = "/facturacion";
            var token = $("#token").val();
            var type = "POST";
            __ajax(route, token, type, datos)
                .done(function(info) {
                    if (info.validar == 1) {
                        var prefijo_fact = info.prefijo_fact;
                        var id_fact = info.num_fact;
                        var fecha_fact = info.fecha_fact;
                        $("#num_factura").html(prefijo_fact+'-'+id_fact);
                        $("#fecha_fact").html(fecha_fact);
                        /*******NOTE:Se envía datos para escrituras*********/
                        datos = {
                          "id_radica": id_radica
                        };
                        var route = "/escrituracion";
                        var token = $("#token").val();
                        var type = "POST";
                        __ajax(route, token, type, datos)
                            .done(function(info) {
                              if(info.validar == 1){
                                var num_escritura = info.num_esc;
                                $("#num_escritura").html(num_escritura);
                              }else if(info.validar == 0){
                                var num_escritura = info.num_esc;
                                $("#num_escritura").html(num_escritura);
                                $("#msj2").html(info.mensaje);
                                $("#msj-error2").fadeIn();
                                setTimeout(function() {
                                    $("#msj-error2").fadeOut();
                                }, 4000);
                              }
                            }) //Ajax escritura


                            // =============================================
                            // =       Enviar Factura electronica          =
                            // =============================================

                            var opcion = "F1";
                            var num_fact = id_fact;
                            var route = "/enviarfactura";
                            var token = $("#token").val();
                            var type = 'GET';
                            var datos = {
                              "num_fact": num_fact,
                              "opcion": opcion
                            };
                            __ajax(route, token, type, datos)
                              .done(function(info) {
                                if(info.status == 1){
                                  var mensaje = info.mensaje;
                                  var opcion2 = info.opcion2;
                                  //Genera Factura PDF
                                  pdfFacturaUnica();

                                  /*----------  Enviar email  ----------*/
                                  
                                  route = "/enviarcorreo";
                                  datos = {
                                    "num_fact": num_fact,
                                    "opcion": opcion,
                                    "email_cliente":info.email_cliente,
                                    "opcion2":opcion2
                                  };

                                  __ajax(route, token, type, datos)
                                  .done(function(info) {
                                      $("#informacion").html("Muy bien! Factura Enviada y Generada");
                                      $("#mod_factelectronica").modal('toggle');
                                  })

                                }else if(info.status == 0){
                                  //Genera Comprovante PDF
                                  pdfFacturaUnica();
                                  $("#informacion").html(info.mensaje);
                                  $("#mod_factelectronica").modal('toggle');
                                }
                            })

                    } else if (info.validar == 0) { //NOTE:Valida que la radicación ya ha sido facturada
                        $("#msj2").html(info.mensaje);
                        $("#msj-error2").fadeIn();
                        setTimeout(function() {
                            $("#msj-error2").fadeOut();
                        }, 4000);
                    }
                }) //NOTE:Ajax de la factura

        } else {
            $("#msj1").html("Debe especificar documento y a nombre de quien va la factura");
            $("#msj-error1").fadeIn();
            setTimeout(function() {
                $("#msj-error1").fadeOut();
            }, 4000);
        }

      }else{
        alert("Debe Seleccionar el medio de pago");
        }

    } else {
        $("#msj1").html("Por favor seleccione la forma de pago: Contado o Crédito");
        $("#msj-error1").fadeIn();
        setTimeout(function() {
            $("#msj-error1").fadeOut();
        }, 4000);
    }
});


$("#guardarfacturamultiple").click(function() {
  /*******Valida totales de la factura y la liquidación*********/

  datos = {
    "id_radica": 0
  };
  var route = "/validartotalfactliq";
  var token = $("#token").val();
  var type = "GET";
  __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
          /********NOTE:Valida que forma pago esté seleccionado*********/
          if (document.querySelector('input[name="formapago"]:checked')) {
            var mediopago = $("#mediopago option:selected").val();
            if(mediopago != ''){
              /******NOTE:Valida que a nombre de no esté vacío*******/
              if ($("#identificacion_cli1").val() != '' && $("#nombre_cli1").val() != '') {
                  /*****NOTE:Envío datos de la factura******/
                  var formapago = $('input:radio[name=formapago]:checked').val();
                  if (formapago == 'contado') {
                      formapago = false;
                  } else if (formapago == 'credito') {
                      formapago = true;
                  }
                  var id_radica = $("#id_radica").val();
                  var identificacion_cli1 = $("#identificacion_cli1").val();
                  var nombre_cli1 = $("#nombre_cli1").val();
                  var total_derechos = $("#totderechos").val();
                  var total_conceptos = $("#totconceptos").val();
                  var total_iva = $("#totiva").val();
                  var total_rtf = $("#totrtf").val();
                  var total_reteconsumo = $("#totreteconsumo").val();
                  var total_fondo = $("#totfondo").val();
                  var total_super = $("#totsuper").val();
                  var total_aporteespecial = $("#totaporteespecial").val();
                  var total_fact = $("#grantotal").val();
                  var reteiva = $("#reteivaide").val();
                  var retertf = $("#retertfide").val();
                  var reteica = $("#reteicaide").val();

                  var doc_acargo_de = $("#doc_acargo_de").val();
                  var detalle_acargo_de = $("#detalle_acargo_de").val();

                  var valor = $("#valor").val();
                  var numcheque = $("#numcheque").val();
                  var id_banco = $("#id_banco option:selected").val();

                  var datos = {
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
                      "id_radica": id_radica,
                      "formapago": formapago,
                      "mediopago": mediopago,
                      "identificacion_cli1": identificacion_cli1,
                      "nombre_cli1": nombre_cli1,
                      "total_derechos": total_derechos,
                      "total_conceptos": total_conceptos,
                      "total_iva": total_iva,
                      "total_rtf": total_rtf,
                      "total_reteconsumo": total_reteconsumo,
                      "total_fondo": total_fondo,
                      "total_super": total_super,
                      "total_aporteespecial": total_aporteespecial,
                      "total_fact": total_fact,
                      "reteiva": reteiva,
                      "retertf": retertf,
                      "reteica": reteica,
                      "valor": valor,
                      "numcheque": numcheque,
                      "id_banco": id_banco,
                      "doc_acargo_de": doc_acargo_de,
                      "detalle_acargo_de":detalle_acargo_de
                      };
                    for (item in conceptos) {
                      atributo = conceptos[item].atributo;
                      id_concep = conceptos[item].id_concep;
                      datos["total"+atributo+"iden"] = $("#totalconcepto"+atributo+"iden").val();
                    }

                  var route = "/facturacion";
                  var token = $("#token").val();
                  var type = "POST";
                  __ajax(route, token, type, datos)
                      .done(function(info) {
                          if (info.validar == 1) {
                              var prefijo_fact = info.prefijo_fact;
                              var id_fact = info.num_fact;
                              var fecha_fact = info.fecha_fact;
                              $("#num_factura").html(prefijo_fact+'-'+id_fact);
                              $("#fecha_fact").html(fecha_fact);
                              /*******NOTE:Se envía datos para escrituras*********/
                              datos = {
                                "id_radica": id_radica
                              };
                              var route = "/escrituracion";
                              var token = $("#token").val();
                              var type = "POST";
                              __ajax(route, token, type, datos)
                                  .done(function(info) {
                                    if(info.validar == 1){
                                      var num_escritura = info.num_esc;
                                      $("#num_escritura").html(num_escritura);
                                    }else if(info.validar == 0){
                                      var num_escritura = info.num_esc;
                                      $("#num_escritura").html(num_escritura);
                                      $("#msj2").html(info.mensaje);
                                      $("#msj-error2").fadeIn();
                                      setTimeout(function() {
                                          $("#msj-error2").fadeOut();
                                      }, 4000);
                                    }
                                  }) //Ajax escritura

                            // =============================================
                            // =       Enviar Factura electronica          =
                            // =============================================

                            var opcion = "F1";
                            var num_fact = id_fact;
                            var route = "/enviarfactura";
                            var token = $("#token").val();
                            var type = 'GET';
                            var datos = {
                              "num_fact": num_fact,
                              "opcion": opcion
                            };
                            __ajax(route, token, type, datos)
                              .done(function(info) {
                                if(info.status == 1){
                                  var opcion2 = info.opcion2;
                                  //Genera Factura PDF
                                  pdfFacturaMultiple();

                                  /*----------  Enviar email  ----------*/
                                  
                                  route = "/enviarcorreo";
                                  datos = {
                                    "num_fact": num_fact,
                                    "opcion": opcion,
                                    "email_cliente":info.email_cliente,
                                    "opcion2":opcion2
                                  };

                                  __ajax(route, token, type, datos)
                                  .done(function(info) {
                                      $("#informacion").html("Muy bien! Factura Enviada y Generada");
                                      $("#mod_factelectronica").modal('toggle');
                                  })

                                }else if(info.status == 0){
                                  //Genera Comprovante PDF
                                  pdfFacturaMultiple();
                                  $("#informacion").html(info.mensaje);
                                  $("#mod_factelectronica").modal('toggle');
                                }
                            })

                          } else if (info.validar == 0) { //NOTE:Valida que la radicación ya ha sido facturada
                              $("#msj2").html(info.mensaje);
                              $("#msj-error2").fadeIn();
                              setTimeout(function() {
                                  $("#msj-error2").fadeOut();
                              }, 4000);
                          }
                      }) //NOTE:Ajax de la factura
                    })//AJAX conceptos
              } else {
                  $("#msj1").html("Debe especificar documento y a nombre de quien va la factura");
                  $("#msj-error1").fadeIn();
                  setTimeout(function() {
                      $("#msj-error1").fadeOut();
                  }, 4000);
              }

            }else{
              alert("Debe Seleccionar el medio de pago");
              }
          } else {
              $("#msj1").html("Por favor seleccione la forma de pago: Contado o Crédito");
              $("#msj-error1").fadeIn();
              setTimeout(function() {
                  $("#msj-error1").fadeOut();
              }, 4000);
          }

        }else if(info.validar == 0){
          $("#msj2").html(info.mensaje);
          $("#msj-error2").fadeIn();
          setTimeout(function() {
              $("#msj-error2").fadeOut();
          }, 4000);
        }
      }) //Ajax validar totales
});


$("#racalcular").click(function() {
  SumarConceptosOtor();
  SumarConceptosCompa();
  RecalcularTotalesOtorCompa();
});

function RecalcularTotalesOtorCompa(){

    var grantotalotorgante = 0;
    var grantotalcompareciente = 0;

    grantotalotorgante = parseFloat($("#subtototorganteiden").val()) +
    parseFloat($("#totalivaotoriden").val()) + parseFloat($("#rtfotoriden").val()) +
    parseFloat($("#impconsumootoriden").val()) + parseFloat($("#totalsuperotoriden").val()) +
    parseFloat($("#totalfondootoriden").val());
    $("#grantotalotorganteiden").val(Math.round(grantotalotorgante));
    $("#grantotalotorgante").html(formatNumbderechos(Math.round(grantotalotorgante)));

    grantotalcompareciente = parseFloat($("#subtotcomparecienteiden").val()) +
    parseFloat($("#totalivacompaiden").val()) + parseFloat($("#rtfcompaiden").val()) +
    parseFloat($("#impconsumocompaiden").val()) + parseFloat($("#totalsupercompaiden").val()) +
    parseFloat($("#totalfondocompaiden").val());
    $("#grantotalcomparecienteiden").val(Math.round(grantotalcompareciente));
    $("#grantotalcompareciente").html(formatNumbderechos(Math.round(grantotalcompareciente)));

    Total_Menos_Deducciones_Compa();
    Total_Menos_Deducciones_Otor();

  }


  $("#imprimirfactura").click(function() {
      var datos = { "algo": 0 };
      var token = $("#token").val();
      var route = "/validarrtfmaycero";
      var type = 'GET';
      __ajax(route, token, type, datos)
          .done(function(info) {
            if(info.validar == true){
              alert("Imprimir Ceritificado de Retención en la Fuente");
              var route = "/guardarcertificadortf";
              var type = 'POST';
              __ajax(route, token, type, datos)
                  .done(function(info) {
                    if(info.valida == 1){
                      var url1 = "/certificadortf";
                      $("<a>").attr("href", url1).attr("target", "_blank")[0].click();
                    }
                  })
              var url2 = "/factunicapdf";
              $("<a>").attr("href", url2).attr("target", "_blank")[0].click();
            }else if(info.validar == false){
              var url = "/factunicapdf";
              $("<a>").attr("href", url).attr("target", "_blank")[0].click();
            }
          })
  });

  function pdfFacturaUnica(){

    var datos = { "algo": 0 };
      var token = $("#token").val();
      var route = "/validarrtfmaycero";
      var type = 'GET';
      __ajax(route, token, type, datos)
          .done(function(info) {
            if(info.validar == true){
              alert("Imprimir Ceritificado de Retención en la Fuente");
              var route = "/guardarcertificadortf";
              var type = 'POST';
              __ajax(route, token, type, datos)
                  .done(function(info) {
                    if(info.valida == 1){
                      var url1 = "/certificadortf";
                      $("<a>").attr("href", url1).attr("target", "_blank")[0].click();
                    }
                  })
              var url2 = "/factunicapdf";
              $("<a>").attr("href", url2).attr("target", "_blank")[0].click();
            }else if(info.validar == false){
              var url = "/factunicapdf";
              $("<a>").attr("href", url).attr("target", "_blank")[0].click();
            }
          })
  }

  $("#imprimirfacturamultiple").click(function() {
    quien = $('input:radio[name=porcentajes]:checked').val();
    if (quien == 'comprador') {
      var url = "/factunicapdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    } else if (quien == 'vendedor') {
      alert("Recuerde Imprimir Certificado de Retención en la Fuente");
      var url2 = "/factunicapdf";
      $("<a>").attr("href", url2).attr("target", "_blank")[0].click();
    }

  });

  function pdfFacturaMultiple(){
    quien = $('input:radio[name=porcentajes]:checked').val();
    if (quien == 'comprador') {
      var url = "/factunicapdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
    } else if (quien == 'vendedor') {
      alert("Recuerde Imprimir Certificado de Retención en la Fuente");
      var url2 = "/factunicapdf";
      $("<a>").attr("href", url2).attr("target", "_blank")[0].click();
    }
  }

  $("#imprimircertificadortf").click(function() {
      var datos = { "algo": 0 };
      var token = $("#token").val();
      var route = "/validarrtfmaycero";
      var type = 'GET';
      __ajax(route, token, type, datos)
          .done(function(info) {
            if(info.validar == true){
              var route = "/guardarcertificadortf";
              var type = 'POST';
              __ajax(route, token, type, datos)
                  .done(function(info) {
                    if(info.valida == 1){
                      var url1 = "/certificadortf";
                      $("<a>").attr("href", url1).attr("target", "_blank")[0].click();
                    }
                  })
            }else if(info.validar == false){
            }
          })
  });

$("#copiasfactura").click(function() {
  $("#guycopiafactura").fadeIn();
});

$("#imprimircopiafactura").click(function() {
  var num_factura = $("#num_factura").val();
  var route = "/existefactura";
  var type = 'GET';
  var token = $("#token").val();
  var anio_trabajo = $("#anio_fiscal").val();
  var datos = { 
    "num_factura": num_factura,
    "anio_trabajo": anio_trabajo
  };
  __ajax(route, token, type, datos)
      .done(function(info) {
        if(info.validar == 1){
          var url = "/copiafactura";
          $("<a>").attr("href", url).attr("target", "_blank")[0].click();

        }else if(info.validar == 0){
          $("#msj1").html(info.mensaje);
          $("#msj-error1").fadeIn();
          setTimeout(function() {
              $("#msj-error1").fadeOut();
          }, 3000);
        }
      })
});
