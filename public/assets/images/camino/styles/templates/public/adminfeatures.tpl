{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">
</head>
<body>
{include 'overall/admin-nav.tpl'}

<br><br><br><br><br><br><br><center>
<h3 class="mbr-section-title display-2"><U>Actualización en el Feature</U></h3></center>
{if isset($smarty.get.error)}
  {if $smarty.get.error == '1'}
    <div class="alert alert-warning" role="alert" style="width: 500px">Datos Actualizados.</div>
  {/if}
{/if}

<br><br>
<div>
  <label>Cargar imagen del Video 1 <span style="color: #FF0000">*</span></label>
  <form enctype="multipart/form-data" action="?view=cargarimagenvideos" method="POST">
    <input id="cualvideo" name="cualvideo" type="hidden" value="1">
    <input name="foto" type="file"/>
    <input type="submit" value="Cargar Foto" name="submit" style="width: 120px;" />
  </form><br>
</div>

<div>
  <label>Cargar imagen del Video 2 <span style="color: #FF0000">*</span></label>
  <form enctype="multipart/form-data" action="?view=cargarimagenvideos" method="POST">
    <input id="cualvideo" name="cualvideo" type="hidden" value="2">
    <input name="foto" type="file"/>
    <input type="submit" value="Cargar Foto" name="submit" style="width: 120px;" />
  </form><br>
</div>

<div class="form-horizontal range-form">
  <div class="form-signin">
    <form action="?view=updatefeatures" method="POST">
      <legend>Títulos del Módulo</legend>
      <label>Nombre del Módulo <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 10px;" type="text" class="form-control" name="modulo" id="modulo" placeholder="Escribir Nombre del Módulo" required="" value="{$modulo}" />
      <label>Descripción del Módulo <span style="color: #FF0000">*</span></label>
      <textarea class="form-control" required="" id="descripcionmodulo" name="descripcionmodulo" placeholder="Escribir descripcion...">{$descripcion_modulo}</textarea>
      <br><br>
      <legend>Para video 1</legend>
      <label>Título del Video <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 10px;" type="text" class="form-control" name="titulovideo1" id="titulovideo1" placeholder="Escribir Título" required="" value="{$titulo_video1}" />
      <label>Subtítulo del Video <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 10px;" type="text" class="form-control" name="subtitulovideo1" id="subtitulovideo1" placeholder="Escribir Subtítulo" required="" value="{$subtitulo_video1}" />
      <label>Descripción del Video <span style="color: #FF0000">*</span></label>
      <textarea class="form-control" required="" id="descripcionvideo1" name="descripcionvideo1" placeholder="Escribir descripcion...">{$descripcion_video1}</textarea>
      <label>Dirección del Video <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 10px;" type="text" class="form-control" name="direccionvideo1" id="direccionvideo1" placeholder="Escribir dirección de Youtube" required="" value="{$direccion_video1}" />

     <br><br>
      <legend>Para video 2</legend>
      <label>Título del Video <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="text" class="form-control" name="titulovideo2" id="titulovideo2" placeholder="Escribir Título" required="" value="{$titulo_video2}" />
      <label>Subtítulo del Video <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="text" class="form-control" name="subtitulovideo2" id="subtitulovideo2" placeholder="Escribir Subtítulo" required="" value="{$subtitulo_video2}" />
      <label>Descripción del Video <span style="color: #FF0000">*</span></label>
      <textarea class="form-control" required="" id="descripcionvideo2" name="descripcionvideo2" placeholder="Escribir descripcion...">{$descripcion_video2}</textarea>
      <label>Dirección del Video <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="text" class="form-control" name="direccionvideo2" id="direccionvideo2" placeholder="Escribir dirección de Youtube" required="" value="{$direccion_video2}" />

      <br><br>
      <legend>Datos de la Empresa</legend>
      <label>Teléfono <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="text" class="form-control" name="telefono" id="telefono" placeholder="Escribir Teléfono" required="" value="{$telefono}" />
      <label>Móvil <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="text" class="form-control" name="movil" id="movil" placeholder="Escribir Teléfono Móvil" required="" value="{$movil}" />
      <label>Email <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="email" class="form-control" name="email" id="email" placeholder="Escribir Email" required="" value="{$email}" />
      <label>Dirección <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="text" class="form-control" name="direccion" id="direccion" placeholder="Escribir Dirección" required="" value="{$direccion}" />
      <label>Ciudad <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Escribir Ciudad" required="" value="{$ciudad}" />
      <label>Copyright <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 20px;" type="text" class="form-control" name="copyright" id="copyright" placeholder="Escribir Copyright" required="" value="{$copyright}" />
        <br><br>
      <center><button class="btn btn-primary btn-block"  type="submit" id="submit" name="submit">Guardar Cambios</button></center>
    </form>
  </div>
</div>

  {include 'overall/footer.tpl'}
