$( ".chosen1" ).change(function() {
  $("#cuantia").val('');
  $("#tradicion").val('');
  $("#catastro").val('');
  $("#matriprefijo").val('');
  $("#matricula").val('');  
  
  var id_acto = $("#id_acto").val();

  var datos = {
      "id_acto": id_acto
  };
  var route = "/validaractos";
  var token = $("#token").val();
  var type = 'GET';

__ajax(route, token, type, datos)
      .done( function( info ){

        var validar = info.actos;
        if(validar.cuantia == false){
            $("#cuantia").prop('disabled', true);
        }else if(validar.cuantia == true){
            $("#cuantia").prop('disabled', false);
        }

        if(validar.catastro == false){
            $("#catastro").prop('disabled', true);
        }else if(validar.cuantia == true){
            $("#catastro").prop('disabled', false);
        }

        if(validar.tradicion == false){
            $("#tradicion").prop('disabled', true);
        }else if(validar.tradicion == true){
            $("#tradicion").prop('disabled', false);
        }
      })
  
});
