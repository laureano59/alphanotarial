<?php /* Smarty version 3.1.27, created on 2018-02-18 18:24:49
         compiled from "C:\wamp\www\camino\styles\templates\public\login.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:67815a89b6e154f1d7_15138397%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99d025e058fc38363a5b00fc12f7820ee46b350c' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\login.tpl',
      1 => 1518617541,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67815a89b6e154f1d7_15138397',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a89b6e1ab7584_57109234',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a89b6e1ab7584_57109234')) {
function content_5a89b6e1ab7584_57109234 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '67815a89b6e154f1d7_15138397';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionaloracion.css" type="text/css">
</head>

<body>

    <?php echo $_smarty_tpl->getSubTemplate ('overall/nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


    <br>
<div class="container" style="margin-top: 150px;">



	<center>

     <div id="_AJAX_"></div>



       <div class="form-signin" style="width: 500px;">

        <h2 class="form-signin-heading">Inicia Sesión</h2>

        <label for="inputUsuario" class="sr-only">Usuario</label>

        <input type="text" id="usuario"class="form-control" placeholder="Introduce tu usuario" required="" autofocus="">

        <label for="inputPassword" class="sr-only">Contraseña</label>

        <input type="password" id="pass" class="form-control" placeholder="Introduce tu contraseña" required="">

        <div class="checkbox">

          <label>

            <input type="checkbox"  id="session" value="1"> Recordarme

          </label>

        </div>

        <button class="btn btn-primary btn-block" id="send_request" type="button">Iniciar Sesión</button>

      </div>

    </center>

</div>

  <?php echo $_smarty_tpl->getSubTemplate ('overall/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>




	  <?php echo '<script'; ?>
>



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



		       var usuario, pass, session, form, result;

		       usuario = document.getElementById('usuario').value;

		       pass = document.getElementById('pass').value;

		       session = document.getElementById('session').checked ? true : false;



			   /*-------Validamos que los campos no esten vacíos--------*/

		       if(usuario != '' && pass != ''){



		           /*------Concatenamos y Pasamos los datos de forma manual------*/

			       /*--------------a través del metodo POST a PHP---------------*/

			       form = 'usuario=' + usuario + '&pass=' + pass + '&session=' + session;

			       //Objeto XMLHttpRequest creado por la función.

   			       objetoAjax=creaObjetoAjax();

   			       //Preparar el envio  con Open

			       objetoAjax.open('POST','?view=login',true);

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

                    result += '<strong>ERROR:</strong> El Usuario y la Contraseña no pueden estar Vacíos.';

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

            result2 += '<strong>CONECTADO:</strong>Te estamos redireccionando.';

			result2 += '</div>';

			//se redirecciona

			location.href = '?view=paneldecontrol';//window.location = '?view=index';

			/*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/

			/*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/

			document.getElementById('_AJAX_').innerHTML = result2;

		}else{

			result2 = '<div class="alert alert-dismissible alert-danger" style="width: 500px">';

            result2 += '<button type="button" class="close" data-dismiss="alert">&times;</button>';

            result2 += '<strong>ERROR:</strong>Credenciales incorrectos.';

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

      <?php echo '</script'; ?>
>

<?php }
}
?>