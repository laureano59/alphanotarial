<?php /* Smarty version 3.1.27, created on 2018-02-19 04:59:13
         compiled from "C:\wamp\www\camino\styles\templates\public\adminstyles.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:98625a8a4b91cdc3a0_14598075%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba3568892ccf78add36271da0c11fedb635b1f79' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\adminstyles.tpl',
      1 => 1518621648,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98625a8a4b91cdc3a0_14598075',
  'variables' => 
  array (
    'selected1' => 0,
    'selected2' => 0,
    'selected3' => 0,
    'selected4' => 0,
    'selected5' => 0,
    'mostrartitulo' => 0,
    'mostrartexto' => 0,
    'derecha' => 0,
    'izquierda' => 0,
    'mediasize' => 0,
    'fondoimagenuso' => 0,
    'colorimage' => 0,
    'fondocoloruso' => 0,
    'colorcolor' => 0,
    'fondovideouso' => 0,
    'videobacground' => 0,
    'colorvideo' => 0,
    'slide' => 0,
    'sl' => 0,
    'opacidad' => 0,
    'idstyles' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a4b920ac861_62908035',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a4b920ac861_62908035')) {
function content_5a8a4b920ac861_62908035 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '98625a8a4b91cdc3a0_14598075';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">

</head>

<body>

<?php echo $_smarty_tpl->getSubTemplate ('overall/admin-nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>




<br><br><br><br><br><br><br><center>

<h3 class="mbr-section-title display-2"><U>Modulo Header</U></h3></center>

<?php if (isset($_GET['error'])) {?>

  <?php if ($_GET['error'] == '1') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">La foto debe ser una imagen con formato  (  jpg,  png,  gif,  jpeg  ).</div>

  <?php }?>

  <?php if ($_GET['error'] == '2') {?>

    <div class="alert alert-success" role="alert" style="width: 500px">Carga Exitosa</div>

  <?php }?>

  <?php if ($_GET['error'] == '3') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el archivo</div>

  <?php }?>

  <?php if ($_GET['error'] == '4') {?>

    <div class="alert alert-warning" role="alert" style="width: 500px">Imagen Eliminada</div>

  <?php }?>

  <?php if ($_GET['error'] == '5') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el id de la imagen</div>

  <?php }?>

<?php }?>

<div id="_AJAX_"></div>

<div class="form-horizontal range-form">

  <fieldset>

    <legend>Styles</legend>

    <select class="form-control" id="styles" onclick="selecstyles(this);">

      <option value="1" <?php echo $_smarty_tpl->tpl_vars['selected1']->value;?>
>Style 1 : TV + Fondo Imagen</option>

      <option value="2" <?php echo $_smarty_tpl->tpl_vars['selected2']->value;?>
>Style 2 : TV + Fondo Video</option>

      <option value="3" <?php echo $_smarty_tpl->tpl_vars['selected3']->value;?>
>Style 3 : Fondo Imagen</option>

      <option value="4" <?php echo $_smarty_tpl->tpl_vars['selected4']->value;?>
>Style 4 : Fondo Video</option>

      <option value="5" <?php echo $_smarty_tpl->tpl_vars['selected5']->value;?>
>Style 5 : Slide</option>

    </select><br>

     <div id="DivMuestraSlide" style="display:block">

    <legend>Caption</legend>

    <div class="form-group">

      <div class="checkbox">

        <label>

          <input type="checkbox" id="titulo"<?php echo $_smarty_tpl->tpl_vars['mostrartitulo']->value;?>
> Mostrar Título

        </label>

      </div>

      <div class="checkbox">

        <label>

          <input type="checkbox" id="texto"<?php echo $_smarty_tpl->tpl_vars['mostrartexto']->value;?>
> Mostrar Texto

        </label>

      </div>

    </div>

<hr>

    <legend>Posición</legend>

    <div class="form-group">

      <div class="radio">

        <label>

          <input type="radio" name="posicion" id="derecha" value="1"<?php echo $_smarty_tpl->tpl_vars['derecha']->value;?>
> Derecha

        </label>

      </div>

      <div class="radio">

        <label>

          <input type="radio" name="posicion" id="izquierda" value="2"<?php echo $_smarty_tpl->tpl_vars['izquierda']->value;?>
> Izquierda

        </label>

      </div>

    </div>

    <hr>

    <div class="form-group">

      <div class="range-slider">

        <label><b>Media Size</b></label><input class="range-slider__range" type="range" value="<?php echo $_smarty_tpl->tpl_vars['mediasize']->value;?>
" min="20" max="70" id="size">

        <span class="range-slider__value">70</span>

      </div>

    </div>

    <hr>

    <div class="form-group">

      <div class="radio">

        <label>

          <input type="radio" name="tipofondo" id="imagen" value="opcion1" onclick="mostrarReferencia(this);" <?php echo $_smarty_tpl->tpl_vars['fondoimagenuso']->value;?>
> <b>Background Image</b>

        </label>

      </div>

      <div id="DivMuestraCargImage" style="display:none">

        <label for="inputimage" class="col-lg-2 control-label">Cargar Imagen</label>

        <form enctype="multipart/form-data" action="?view=cargarimagen" method="POST">

          <input name="foto" type="file"/>

          <input type="submit" value="Cargar Foto" name="submit" style="width: 120px;" />

        </form><br>

        <label>Color</label>

        <input type="color" id="colorimage" value="<?php echo $_smarty_tpl->tpl_vars['colorimage']->value;?>
">

      </div>



      <div class="radio">

        <label>

          <input type="radio" name="tipofondo" id="color" value="opcion2" onclick="mostrarReferencia(this);" <?php echo $_smarty_tpl->tpl_vars['fondocoloruso']->value;?>
> <b>Background Color</b>

        </label>

      </div>

      <div id="DivMuestraColor" style="display:none">

        <label>Color</label>

        <input type="color" id="colorcolor" value="<?php echo $_smarty_tpl->tpl_vars['colorcolor']->value;?>
">

      </div>

      <div class="radio">

        <label>

          <input type="radio" name="tipofondo" id="video" value="opcion3" onclick="mostrarReferencia(this);" <?php echo $_smarty_tpl->tpl_vars['fondovideouso']->value;?>
> <b>Background Video</b>

        </label>

      </div>

      <div id="DivMuestraVideo" style="display:none">

        <label><b>Youtube</b></label>

        <input type="text" class="form-control" id="inputYoutube" placeholder="youtube" value="<?php echo $_smarty_tpl->tpl_vars['videobacground']->value;?>
"><br>

        <label><b>Color</b></label>

        <input type="color" id="colorvideo" value="<?php echo $_smarty_tpl->tpl_vars['colorvideo']->value;?>
">

      </div>

    </div>

      </div>

    <hr>

    <div id="DivMuestraCargarSlide" style="display:none">

      <div class="radio">

        <label>

          <input type="radio" name="tiposlide" id="imagen" value="imagen" onclick="mostrarReferencia2(this);"> Cargar Imagen

        </label>

      </div>

      <div class="radio">

        <label>

          <input type="radio" name="tiposlide" id="video" value="video" onclick="mostrarReferencia2(this);"> Cargar Video

        </label>

      </div>





      <div id="DivMuestraSlideImagen" style="display:none">



        <form enctype="multipart/form-data" action="?view=slide" method="POST">

          <input type="hidden" name="validar" id="validar" value="1">

          <br><label>Descripción de la Foto:</label>

          <input type="text" required=""  class="form-control" id="descripcion" name="descripcion" placeholder="Escribir descripción de la foto">

          <label>Título que se mostrará sobre la foto:</label>

          <input type="text" class="form-control" id="titulo_slide" name="titulo_slide" placeholder="Escribir título que desea mostrar">

          <label>Texto que se mostrará sobre la foto </label>

          <input type="text" class="form-control" id="texto_slide" name="texto_slide" placeholder="Escribir texto que desea mostrar">

          <input name="foto" type="file"/>

          <br><br>

           <label>Color</label>

           <input type="color" id="colorslideimagen" name="colorslideimagen">

           <div class="form-group">

             <div class="range-slider">

               <b>Opacidad Imagen</b> <input class="range-slider__range" type="range" id="opacidadslideimagen" name="opacidadslideimagen" min="0" max="1" step="0.1">

                <span class="range-slider__value">1</span>

             </div>

           </div>

           <input type="submit" value="Guardar Slide de Imagen" name="submit" style="width: 300px;" />

        </form>

      </div>

      <br>

      <div id="DivMuestraSlideVideo" style="display:none">

        <form action="?view=slide" method="POST">

          <input type="hidden" name="validar" id="validar" value="1">

          <br><label>Descripción del Video:</label>

          <input type="text" required=""  class="form-control" id="descripcion" name="descripcion" placeholder="Escribir descripción del video">

          <label>Título que se mostrará sobre el video:</label>

          <input type="text" class="form-control" id="titulo_slide" name="titulo_slide" placeholder="Escribir título que desea mostrar">

          <label>Texto que se mostrará sobre el video</label>

          <input type="text" class="form-control" id="texto_slide" name="texto_slide" placeholder="Escribir texto que desea mostrar">

          <label>Video de Youtube</label>

          <input type="text" required=""  class="form-control" id="video" name="video" placeholder="Escribir dirección de Youtube">

          <br><br>

           <label>Color</label>

           <input type="color" id="colorslidevideo" name="colorslidevideo">

           <div class="form-group">

             <div class="range-slider">

               <b>Opacidad Video</b> <input class="range-slider__range" type="range" id="opacidadslidevideo" name="opacidadslidevideo" min="0" max="1" step="0.1">

                <span class="range-slider__value">1</span>

             </div>

           </div>

           <input type="submit" value="Guardar Slide de Video" name="submit" style="width: 300px;" />

        </form>

      </div>

      <br>

      <div class="table-responsive">

        <div id="resultado" class="alert alert-warning" role="alert" style="width: 980px"></div>

				<table class="table table-striped table-hover" style="width: 80%;">

					<thead>

						<tr>

							<th style="width: 5%;">Id</th>

							  <th style="width: 40%;">Descripción Slide</th>

                <th style="width: 35%;">Video</th>

                <th style="width: 10%;">Color</th>

                <th style="width: 5%;">Opacidad</th>

							  <th style="width: 5%;">Eliminar</th>

                <th style="width: 5%;">Editar</th>

						  </tr>

                    </thead>

                  <tbody>

					    <?php if (isset($_smarty_tpl->tpl_vars['slide']->value)) {?>

					  	  <?php
$_from = $_smarty_tpl->tpl_vars['slide']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['sl'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['sl']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['sl']->value) {
$_smarty_tpl->tpl_vars['sl']->_loop = true;
$foreach_sl_Sav = $_smarty_tpl->tpl_vars['sl'];
?>

					        <tr>

                    <td><?php echo $_smarty_tpl->tpl_vars['sl']->value['idslide'];?>
</td>

                    <td><?php echo $_smarty_tpl->tpl_vars['sl']->value['descripcion'];?>
</td>

                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['sl']->value['videoslide'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['sl']->value['videoslide'];?>
</a></td>

                    <td bgcolor="<?php echo $_smarty_tpl->tpl_vars['sl']->value['colorslide'];?>
"><?php echo $_smarty_tpl->tpl_vars['sl']->value['colorslide'];?>
</td>

                    <td><?php echo $_smarty_tpl->tpl_vars['sl']->value['opacidadslide'];?>
</td>

                    <input type='hidden' name='id_cliente' value='".$fila["id_cliente"]."'>

                    <td style="text-align: center;"><a href="#" onclick="pasarparametros(<?php echo $_smarty_tpl->tpl_vars['sl']->value['idslide'];?>
);return false;"><img src="styles/image/delete.png"></a></td>

                    <td style="text-align: center;"><a class="mbr-buttons__link btn text-white" data-toggle="modal" value="<?php echo $_smarty_tpl->tpl_vars['sl']->value['idslide'];?>
" data-target="#editarslide"><img src="styles/image/editar.png"></a></td>

                  </tr>

				        <?php
$_smarty_tpl->tpl_vars['sl'] = $foreach_sl_Sav;
}
?>

			         <?php } else { ?>

			            <tr>

			  	          <td colspan="4">No hay imagenes para mostrar</td>

			            </tr>

		          <?php }?>

                  </tbody>

                </table>

            </div>



    </div>

    <div id="DivMuestraOpacidad" style="display:none">

      <div class="form-group">

        <div class="range-slider">

          <b>Opacidad Imagen- Video</b> <input class="range-slider__range" type="range" id="opacidad" value="<?php echo $_smarty_tpl->tpl_vars['opacidad']->value;?>
" min="0" max="1" step="0.1">

          <span class="range-slider__value">1</span>

        </div>

      </div>

      <hr>

    </div>



    <div class="form-group">

      <div class="col-lg-10 col-lg-offset-2"><br>

        <button class="btn btn-primary btn-block" id="send_request" type="button">Guardar Cambios</button>

      </div>

    </div>

  </fieldset>

</div>



<?php echo $_smarty_tpl->getSubTemplate ('overall/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php echo $_smarty_tpl->getSubTemplate ('public/editarslide.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>




<?php echo '<script'; ?>
 src="styles/js/jquery.min.js.descarga"><?php echo '</script'; ?>
>



    <?php echo '<script'; ?>
>

    var rangeSlider = function () {

    var slider = $('.range-slider'), range = $('.range-slider__range'), value = $('.range-slider__value');

    slider.each(function () {

        value.each(function () {

            var value = $(this).prev().attr('value');

            $(this).html(value);

        });

        range.on('input', function () {

            $(this).next(value).html(this.value);

        });

    });

};

rangeSlider();

  //# sourceURL=pen.js

  <?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 type="text/javascript">

  function selecstyles(elemento){

    if(elemento.value=="5") {

      document.getElementById('DivMuestraSlide').style.display='none';

      document.getElementById('DivMuestraCargarSlide').style.display='block';

  }else{

    document.getElementById('DivMuestraSlide').style.display='block';

    document.getElementById('DivMuestraCargarSlide').style.display='none';

  }



  if(elemento.value=="1"){

    document.getElementById("imagen").disabled=false;

    document.getElementById("color").disabled=true;

    document.getElementById("video").disabled=true;

  }else if(elemento.value=="2"){

    document.getElementById("imagen").disabled=true;

    document.getElementById("color").disabled=true;

    document.getElementById("video").disabled=false;

  }else if(elemento.value=="3"){

    document.getElementById("imagen").disabled=false;

    document.getElementById("color").disabled=true;

    document.getElementById("video").disabled=true;

  }else if(elemento.value=="4"){

    document.getElementById("imagen").disabled=true;

    document.getElementById("color").disabled=true;

    document.getElementById("video").disabled=false;

  }else if(elemento.value=="6"){

    document.getElementById("imagen").disabled=true;

    document.getElementById("color").disabled=false;

    document.getElementById("video").disabled=true;

  }

}

<!--

function mostrarReferencia(elemento){

  //Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >     y a la vez dentro del array de Conocido) esta activada

  if (elemento.value=="opcion1") {

    //muestra (cambiando la propiedad display del estilo) el div con id 'desdeotro'

    document.getElementById('DivMuestraCargImage').style.display='block';

    document.getElementById('DivMuestraVideo').style.display='none';

    document.getElementById('DivMuestraOpacidad').style.display='block';

    document.getElementById('DivMuestraColor').style.display='none';

  //por el contrario, si no esta seleccionada

  } else if (elemento.value=="opcion2") {

    document.getElementById('DivMuestraColor').style.display='block';

    document.getElementById('DivMuestraCargImage').style.display='none';

    document.getElementById('DivMuestraVideo').style.display='none';

    document.getElementById('DivMuestraOpacidad').style.display='none';

  } else if (elemento.value=="opcion3") {

    document.getElementById('DivMuestraColor').style.display='none';

    document.getElementById('DivMuestraCargImage').style.display='none';

    document.getElementById('DivMuestraVideo').style.display='block';

    document.getElementById('DivMuestraOpacidad').style.display='block';

  }

  else {

    alert("....");

  }

}



function mostrarReferencia2(elemento){

  //Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >     y a la vez dentro del array de Conocido) esta activada

  if (elemento.value=="imagen") {

    //muestra (cambiando la propiedad display del estilo) el div con id 'desdeotro'

    document.getElementById('DivMuestraSlideImagen').style.display='block';

    document.getElementById('DivMuestraSlideVideo').style.display='none';

  //por el contrario, si no esta seleccionada

} else if (elemento.value=="video") {

    document.getElementById('DivMuestraSlideImagen').style.display='none';

    document.getElementById('DivMuestraSlideVideo').style.display='block';

  }

  else {

    alert("....");

  }

}

<?php echo '</script'; ?>
>



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



       var form, result, styles, titulo, texto, derecha, posicion, size, imagen, color, video,

       colorimage, colorvideo, colorcolor, opacidad, inputYoutube, idstyles;



       styles     = document.getElementById('styles').value;

       titulo     = document.getElementById('titulo').checked ? true : false;

       if(titulo == true){

         titulo = 1;

       }else{

         titulo = 2;

       }

       texto      = document.getElementById('texto').checked ? true : false;

       if(texto == true){

         texto = 1;

       }else{

         texto = 2;

       }

       derecha    = document.getElementById('derecha').checked ? true : false;

       if(derecha == true){

         posicion = 1;

       }else{

         posicion = 2;

       }

       size   = document.getElementById('size').value;

       imagen = document.getElementById('imagen').checked ? true : false;

       if(imagen == true){

         imagen = 1;

       }else{

         imagen = 2;

       }

       color = document.getElementById('color').checked ? true : false;

       if(color == true){

         color = 1;

       }else{

         color = 2;

       }

       video = document.getElementById('video').checked ? true : false;

       if(video == true){

         video = 1;

       }else{

         video = 2;

       }

       inputYoutube = document.getElementById('inputYoutube').value;

       colorimage   = document.getElementById('colorimage').value;

       colorvideo   = document.getElementById('colorvideo').value;

       colorcolor   = document.getElementById('colorcolor').value;

       opacidad     = document.getElementById('opacidad').value;

       idstyles     = <?php echo $_smarty_tpl->tpl_vars['idstyles']->value;?>
;

      /*-------Validamos que los campos no esten vacíos--------*/

           if(inputYoutube != ''){



               /*------Concatenamos y Pasamos los datos de forma manual------*/

             /*--------------a través del metodo POST a PHP---------------*/

             form = 'styles=' + styles + '&titulo=' + titulo + '&texto=' + texto

             + '&posicion=' + posicion + '&size=' + size + '&imagen=' + imagen

             + '&color=' + color + '&video=' + video + '&colorimage=' + colorimage

             + '&colorvideo=' + colorvideo + '&colorcolor=' + colorcolor

             + '&opacidad=' + opacidad + '&inputYoutube=' + inputYoutube

             + '&idstyles=' + idstyles;

             //Objeto XMLHttpRequest creado por la función.

               objetoAjax=creaObjetoAjax();

               //Preparar el envio  con Open

               objetoAjax.open('POST','?view=updatestyles',true);

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

            result += '<strong>ERROR:</strong> El campo Youtube no puede estar Vacío.';

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

        result2 += '<strong>MUY BIEN:</strong>Cambios realizados.';

  result2 += '</div>';

  //se redirecciona

  //location.href = '?view=paneldecontrol';//window.location = '?view=index';

  /*------Mostramos el error en pantalla en este caso dentro del id AJAX----*/

  /*----innerHTML permite modificar el valor que esta dentro del id AJAX----*/

  document.getElementById('_AJAX_').innerHTML = result2;

}else{

  result2 = '<div class="alert alert-dismissible alert-danger" style="width: 500px">';

  result2 += '<button type="button" class="close" data-dismiss="alert">&times;</button>';

  result2 += '<strong>ERROR:</strong>Vuelve a Intentarlo.';

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



<?php echo '<script'; ?>
>

function pasarparametros(valor){



        var parametros = {

                "idslide" : valor,

                "validar" : 7

        };

        $.ajax({

                data:  parametros,

                url:   '?view=slide',

                type:  'post',

                beforeSend: function () {

                        $("#resultado").html("Procesando, espere por favor...");

                },

                success:  function (response) {

                        $("#resultado").html(response);

                        location.href ="?view=styles";

                }

        });

}

<?php echo '</script'; ?>
>

<?php }
}
?>