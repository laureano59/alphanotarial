{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
</head>
<body>
{include 'overall/admin-nav.tpl'}

<br><br>
<div class="container" style="margin-top: 150px;">

	<center>
     <div id="_AJAX_"></div>

       <div class="form-signin" style="width: 500px;">
        <h2 class="form-signin-heading"><U>Transmisión en Vivo</U></h2>
        <label for="inputsrc1" class="sr-only">Src 1</label><br><br>
        <label><b>TV ONLINE</b></label><input type="text" id="src1"class="form-control" placeholder="Introduce Src 1" required="" autofocus="" value="{$dir1}">
        <label for="inputsrc2" class="sr-only">Src 2</label><br><br>
        <label><b>TV HOME</b></label><input type="text" id="src2" class="form-control" placeholder="Introduce Src 2" required="" value="{$dir2}">
        <label for="inputautoplay1" class="sr-only">AutoPlay1</label><br><br>
				<label><b>Autoplay para TV ONLINE</b></label>
        <select class="form-control" id="autoplay1">
          <option>¿Desea Activar Autoplay para TV ONLINE?</option>
          <option value="1">SI</option>
          <option value="2">NO</option>
        </select>
        <label for="inputautoplay2" class="sr-only">AutoPlay2</label><br><br>
				<label><b>Autoplay para TV HOME</b></label>
        <select class="form-control" id="autoplay2">
          <option>¿Desea Activar Autoplay para TV HOME?</option>
          <option value="1">SI</option>
          <option value="2">NO</option>
        </select><br><br>
        <button class="btn btn-primary btn-block" id="send_request" type="button">Guardar</button>
      </div>
    </center>
</div>
  {include 'overall/footer.tpl'}

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

		  /*------obtengo el elemento por el id send_request, es decir apunta al------*/
		  /*------------------------elemento desde javascript------------------------*/
		  document.getElementById('send_request').onclick = function(){

		       var src1, src2, autoplay1, autoplay2, form, result;
		       src1 = document.getElementById('src1').value;
		       src2 = document.getElementById('src2').value;
           autoplay1 = document.getElementById('autoplay1').value;
           autoplay2 = document.getElementById('autoplay2').value;

			   /*-------Validamos que los campos no esten vacíos--------*/
		       if(src1 != '' && src2 != ''){

		           /*------Concatenamos y Pasamos los datos de forma manual------*/
			       /*--------------a través del metodo POST a PHP---------------*/
			       form = 'src1=' + src1 + '&src2=' + src2 + '&autoplay1=' + autoplay1 + '&autoplay2=' + autoplay2;
			       //Objeto XMLHttpRequest creado por la función.
   			       objetoAjax=creaObjetoAjax();
   			       //Preparar el envio  con Open
			       objetoAjax.open('POST','?view=admintv',true);
			       //console.log(form);
   			       //Enviar cabeceras para que acepte POST:
   			       objetoAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                   objetoAjax.setRequestHeader("Content-length", form.length);
                   objetoAjax.setRequestHeader("Connection", "close");
                   objetoAjax.onreadystatechange = recogeDatos;
	               objetoAjax.send(form);
			    }else{
					result = '<div class="alert alert-dismissible alert-danger" style="width: 500px">';
                    result += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    result += '<strong>ERROR:</strong> Src 1 y Src 2 no pueden estar Vacíos.';
				    result += '</div>';
				    /*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/
				    /*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/
				    document.getElementById('_AJAX_').innerHTML = result;
				}
		    }
function recogeDatos(){
	var result2;
    if (objetoAjax.readyState==4 && objetoAjax.status==200){
        miTexto=objetoAjax.responseText;
		//console.log(miTexto);
       	if(parseInt(miTexto)==1){
			result2 = '<div class="alert alert-dismissible alert-success style="width: 500px">';
            result2 += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            result2 += '<strong>PROCESO TERMINADO:</strong> Gracias.';
			result2 += '</div>';
			//se redirecciona
			//location.href = '?view=paneldecontrol';//window.location = '?view=index';
			/*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/
			/*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/
			document.getElementById('_AJAX_').innerHTML = result2;
		}else{
			result2 = '<div class="alert alert-dismissible alert-danger" style="width: 500px">';
            result2 += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            result2 += '<strong>ERROR:</strong>Error, vuelve a intentarlo.';
			result2 += '</div>';
			/*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/
			/*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/
			document.getElementById('_AJAX_').innerHTML = result2;
			}

	}else if(objetoAjax.readyState != 4){
		result2 = '<div class="alert alert-dismissible alert-warning style="width: 500px">';
        result2 += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        result2 += 'Procesando...';
		result2 += '</div>';
		/*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/
		/*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/
		document.getElementById('_AJAX_').innerHTML = result2;
		}
}
      </script>
