<script>

  //función creación del objeto XMLHttpRequest.
  function creaObjetoAjax () { //Mayoría de navegadores
    var obj;
    if (window.XMLHttpRequest) {
        obj=new XMLHttpRequest();
      }
    else { //para IE 5 y IE 6
      obj=new ActiveXObject(Microsoft.XMLHTTP);
      }
    return obj;
    }

  document.getElementById('send_request').onclick = function(){
    var form, algo;
    algo = 0;

    form = 'algo=' + algo;
    objetoAjax=creaObjetoAjax();
    objetoAjax.open('POST','?view=usuariosonline',true);
    objetoAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    objetoAjax.setRequestHeader("Content-length", form.length);
    objetoAjax.setRequestHeader("Connection", "close");
    objetoAjax.onreadystatechange = recogeDatos;
    objetoAjax.send(form);
    }
function recogeDatos(){
  var result2;
  if (objetoAjax.readyState==4 && objetoAjax.status==200){
    miTexto=objetoAjax.responseText;
    document.getElementById('_AJAXUSERONLINE_').innerHTML =   miTexto;
  }
}

</script>
