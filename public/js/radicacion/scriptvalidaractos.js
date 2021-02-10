$( ".chosen1" ).change(function() {
  $("#cuantia").val('');
  $("#tradicion").val('');
  var id_acto = $("#id_acto").val();

  var datos = {
      "id_acto": id_acto
  };
  var route = "/validaractos";
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
        var validar = info.actos;
          if(validar.cuantia == false){
            $("#cuantia").prop('disabled', true);
          }else if(validar.cuantia == true){
            $("#cuantia").prop('disabled', false);
          }

          if(validar.tradicion == false){
            $("#tradicion").prop('disabled', true);
          }else if(validar.tradicion == true){
            $("#tradicion").prop('disabled', false);
          }
      }
  });
});
