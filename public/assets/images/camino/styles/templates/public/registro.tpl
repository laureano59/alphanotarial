{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionaloracion.css" type="text/css">
</head>
<body>
    {include 'overall/nav.tpl'}
<div class="container" style="margin-top: 150px;">

	<center>
     <div id="_AJAX_"></div>

       <div class="form-signin" style="width: 500px;">
        <h2 class="form-signin-heading">Registrar Usuario</h2>
        <label for="inputUsuario" class="sr-only">Usuario</label>
        <input type="text" id="usuario"class="form-control" placeholder="Introduce tu usuario" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="pass" class="form-control" placeholder="Introduce tu contraseña" required="">
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="email" class="form-control" placeholder="Introduce tu email" required="">
        <br>
		<button class="btn btn-primary btn-block" id="send_request" type="button">Registrarme</button>
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

		  function validaremail(valor){
			 if (/\S+@\S+\.\S+/.test(valor)){
				 return 1;
             }else{
				 return 0;
             }
		  }

		  /*------obtengo el elemento por el id send_request, es decir apunta al------*/
		  /*------------------------elemento desde javascript------------------------*/
		  document.getElementById('send_request').onclick = function(){

		       var usuario, pass, email, form, result;
		       usuario = document.getElementById('usuario').value;
		       pass = document.getElementById('pass').value;
		       email = document.getElementById('email').value;

			   /*-------Validamos que los campos no esten vacíos--------*/
		       if(usuario != '' && pass != '' && email != ''){
				    if(validaremail(email)==1){
						/*------Concatenamos y Pasamos los datos de forma manual------*/
			            /*--------------a través del metodo POST a PHP---------------*/
			            form = 'usuario=' + usuario + '&pass=' + pass + '&email=' + email;
			            //Objeto XMLHttpRequest creado por la función.
   			            objetoAjax=creaObjetoAjax();
   			            //Preparar el envio  con Open
			            objetoAjax.open('POST','?view=registrar',true);
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
                        result += '<strong>ERROR:</strong> El email es incorrecto.';
				        result += '</div>';
				   	    document.getElementById('_AJAX_').innerHTML = result;
					}
			    }else{
					result = '<div class="alert alert-dismissible alert-danger" style="width: 500px">';
                    result += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    result += '<strong>ERROR:</strong> Todos los campos deben estar llenos.';
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
		console.log(miTexto);
       	if(parseInt(miTexto)==1){
			result2 = '<div class="alert alert-dismissible alert-success style="width: 500px">';
            result2 += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            result2 += '<strong>Registro completado:</strong>Te estamos redireccionando.';
			result2 += '</div>';
			//se redirecciona
			location.href = '?view=index';//window.location = '?view=index';
			/*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/
			/*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/
			document.getElementById('_AJAX_').innerHTML = result2;
		}else if(parseInt(miTexto)==2){
			result2 = '<div class="alert alert-dismissible alert-danger" style="width: 500px">';
            result2 += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            result2 += '<strong>ERROR:</strong>El usuario ya existe.';
			result2 += '</div>';
			/*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/
			/*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/
			document.getElementById('_AJAX_').innerHTML = result2;

			}else{
				result2 = '<div class="alert alert-dismissible alert-danger" style="width: 500px">';
                result2 += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                result2 += '<strong>ERROR:</strong>El email ya existe.';
			    result2 += '</div>';
			   /*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/
			  /*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/
			}   document.getElementById('_AJAX_').innerHTML = result2;

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
