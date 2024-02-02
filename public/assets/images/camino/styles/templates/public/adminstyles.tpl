{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">
</head>
<body>
{include 'overall/admin-nav.tpl'}

<br><br><br><br><br><br><br><center>
<h3 class="mbr-section-title display-2"><U>Modulo Header</U></h3></center>
{if isset($smarty.get.error)}
  {if $smarty.get.error == '1'}
    <div class="alert alert-danger" role="alert" style="width: 500px">La foto debe ser una imagen con formato  (  jpg,  png,  gif,  jpeg  ).</div>
  {/if}
  {if $smarty.get.error == '2'}
    <div class="alert alert-success" role="alert" style="width: 500px">Carga Exitosa</div>
  {/if}
  {if $smarty.get.error == '3'}
    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el archivo</div>
  {/if}
  {if $smarty.get.error == '4'}
    <div class="alert alert-warning" role="alert" style="width: 500px">Imagen Eliminada</div>
  {/if}
  {if $smarty.get.error == '5'}
    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el id de la imagen</div>
  {/if}
{/if}
<div id="_AJAX_"></div>
<div class="form-horizontal range-form">
  <fieldset>
    <legend>Styles</legend>
    <select class="form-control" id="styles" onclick="selecstyles(this);">
      <option value="1" {$selected1}>Style 1 : TV + Fondo Imagen</option>
      <option value="2" {$selected2}>Style 2 : TV + Fondo Video</option>
      <option value="3" {$selected3}>Style 3 : Fondo Imagen</option>
      <option value="4" {$selected4}>Style 4 : Fondo Video</option>
      <option value="5" {$selected5}>Style 5 : Slide</option>
    </select><br>
     <div id="DivMuestraSlide" style="display:block">
    <legend>Caption</legend>
    <div class="form-group">
      <div class="checkbox">
        <label>
          <input type="checkbox" id="titulo"{$mostrartitulo}> Mostrar Título
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" id="texto"{$mostrartexto}> Mostrar Texto
        </label>
      </div>
    </div>
<hr>
    <legend>Posición</legend>
    <div class="form-group">
      <div class="radio">
        <label>
          <input type="radio" name="posicion" id="derecha" value="1"{$derecha}> Derecha
        </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="posicion" id="izquierda" value="2"{$izquierda}> Izquierda
        </label>
      </div>
    </div>
    <hr>
    <div class="form-group">
      <div class="range-slider">
        <label><b>Media Size</b></label><input class="range-slider__range" type="range" value="{$mediasize}" min="20" max="70" id="size">
        <span class="range-slider__value">70</span>
      </div>
    </div>
    <hr>
    <div class="form-group">
      <div class="radio">
        <label>
          <input type="radio" name="tipofondo" id="imagen" value="opcion1" onclick="mostrarReferencia(this);" {$fondoimagenuso}> <b>Background Image</b>
        </label>
      </div>
      <div id="DivMuestraCargImage" style="display:none">
        <label for="inputimage" class="col-lg-2 control-label">Cargar Imagen</label>
        <form enctype="multipart/form-data" action="?view=cargarimagen" method="POST">
          <input name="foto" type="file"/>
          <input type="submit" value="Cargar Foto" name="submit" style="width: 120px;" />
        </form><br>
        <label>Color</label>
        <input type="color" id="colorimage" value="{$colorimage}">
      </div>

      <div class="radio">
        <label>
          <input type="radio" name="tipofondo" id="color" value="opcion2" onclick="mostrarReferencia(this);" {$fondocoloruso}> <b>Background Color</b>
        </label>
      </div>
      <div id="DivMuestraColor" style="display:none">
        <label>Color</label>
        <input type="color" id="colorcolor" value="{$colorcolor}">
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="tipofondo" id="video" value="opcion3" onclick="mostrarReferencia(this);" {$fondovideouso}> <b>Background Video</b>
        </label>
      </div>
      <div id="DivMuestraVideo" style="display:none">
        <label><b>Youtube</b></label>
        <input type="text" class="form-control" id="inputYoutube" placeholder="youtube" value="{$videobacground}"><br>
        <label><b>Color</b></label>
        <input type="color" id="colorvideo" value="{$colorvideo}">
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
					    {if isset($slide)}
					  	  {foreach from=$slide item=sl}
					        <tr>
                    <td>{$sl.idslide}</td>
                    <td>{$sl.descripcion}</td>
                    <td><a href="{$sl.videoslide}" target="_blank">{$sl.videoslide}</a></td>
                    <td bgcolor="{$sl.colorslide}">{$sl.colorslide}</td>
                    <td>{$sl.opacidadslide}</td>
                    <input type='hidden' name='id_cliente' value='".$fila["id_cliente"]."'>
                    <td style="text-align: center;"><a href="#" onclick="pasarparametros({$sl.idslide});return false;"><img src="styles/image/delete.png"></a></td>
                    <td style="text-align: center;"><a class="mbr-buttons__link btn text-white" data-toggle="modal" value="{$sl.idslide}" data-target="#editarslide"><img src="styles/image/editar.png"></a></td>
                  </tr>
				        {/foreach}
			         {else}
			            <tr>
			  	          <td colspan="4">No hay imagenes para mostrar</td>
			            </tr>
		          {/if}
                  </tbody>
                </table>
            </div>

    </div>
    <div id="DivMuestraOpacidad" style="display:none">
      <div class="form-group">
        <div class="range-slider">
          <b>Opacidad Imagen- Video</b> <input class="range-slider__range" type="range" id="opacidad" value="{$opacidad}" min="0" max="1" step="0.1">
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

{include 'overall/footer.tpl'}
{include 'public/editarslide.tpl'}

<script src="styles/js/jquery.min.js.descarga"></script>

    <script>
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
  </script>
  <script type="text/javascript">
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
</script>

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
       idstyles     = {$idstyles};
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
  </script>

<script>
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
</script>
