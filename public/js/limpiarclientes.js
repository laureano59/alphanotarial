function LimpiarClientes(){
  $("#pmer_apellidocli").val('');
  $("#sgndo_apellidocli").val('');
  $("#pmer_nombrecli").val('');
  $("#sgndo_nombrecli").val('');
  $("#estadocivil").val('');
  $("#telefono_cli").val('');
  $("#direccion_cli").val('');
  $("#email_cli").val('');
  $("#empresa").val('');
  $("#digito_verif").val('');
  $("#telefono_cli_empresa").val('');
  $("#direccion_cli_empresa").val('');
  $("#email_cli_empresa").val('');
  $("#departamento").val('');
  $("#ciudad").val('');
  $("#departamento_empresa").val('');
  $("#ciudad_empresa").val('');
  document.querySelectorAll('[name=autoreiva]').forEach((x) => x.checked=false);
  document.querySelectorAll('[name=autorertf]').forEach((x) => x.checked=false);
  document.querySelectorAll('[name=autoreica]').forEach((x) => x.checked=false);
  document.querySelectorAll('[name=autoreiva_natural]').forEach((x) => x.checked=false);
  document.querySelectorAll('[name=autorertf_natural]').forEach((x) => x.checked=false);
  document.querySelectorAll('[name=autoreica_natural]').forEach((x) => x.checked=false);
}

$("#Adicionales").click(function(){
  $("#adicionales").show();
  $('#veradicionales').show();
});
