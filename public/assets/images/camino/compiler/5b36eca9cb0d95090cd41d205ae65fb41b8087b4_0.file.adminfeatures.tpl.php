<?php /* Smarty version 3.1.27, created on 2018-02-19 05:32:54
         compiled from "C:\wamp\www\camino\styles\templates\public\adminfeatures.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:326285a8a5376a83238_41294155%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b36eca9cb0d95090cd41d205ae65fb41b8087b4' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\adminfeatures.tpl',
      1 => 1518633425,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '326285a8a5376a83238_41294155',
  'variables' => 
  array (
    'modulo' => 0,
    'descripcion_modulo' => 0,
    'titulo_video1' => 0,
    'subtitulo_video1' => 0,
    'descripcion_video1' => 0,
    'direccion_video1' => 0,
    'titulo_video2' => 0,
    'subtitulo_video2' => 0,
    'descripcion_video2' => 0,
    'direccion_video2' => 0,
    'telefono' => 0,
    'movil' => 0,
    'email' => 0,
    'direccion' => 0,
    'ciudad' => 0,
    'copyright' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a5376c0a358_32933027',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a5376c0a358_32933027')) {
function content_5a8a5376c0a358_32933027 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '326285a8a5376a83238_41294155';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">

</head>

<body>

<?php echo $_smarty_tpl->getSubTemplate ('overall/admin-nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>




<br><br><br><br><br><br><br><center>

<h3 class="mbr-section-title display-2"><U>Actualización en el Feature</U></h3></center>

<?php if (isset($_GET['error'])) {?>

  <?php if ($_GET['error'] == '1') {?>

    <div class="alert alert-warning" role="alert" style="width: 500px">Datos Actualizados.</div>

  <?php }?>

<?php }?>


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

      <input style="margin-bottom: 10px;" type="text" class="form-control" name="modulo" id="modulo" placeholder="Escribir Nombre del Módulo" required="" value="<?php echo $_smarty_tpl->tpl_vars['modulo']->value;?>
" />

      <label>Descripción del Módulo <span style="color: #FF0000">*</span></label>

      <textarea class="form-control" required="" id="descripcionmodulo" name="descripcionmodulo" placeholder="Escribir descripcion..."><?php echo $_smarty_tpl->tpl_vars['descripcion_modulo']->value;?>
</textarea>

      <br><br>
      <legend>Para video 1</legend>

      <label>Título del Video <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 10px;" type="text" class="form-control" name="titulovideo1" id="titulovideo1" placeholder="Escribir Título" required="" value="<?php echo $_smarty_tpl->tpl_vars['titulo_video1']->value;?>
" />

      <label>Subtítulo del Video <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 10px;" type="text" class="form-control" name="subtitulovideo1" id="subtitulovideo1" placeholder="Escribir Subtítulo" required="" value="<?php echo $_smarty_tpl->tpl_vars['subtitulo_video1']->value;?>
" />

      <label>Descripción del Video <span style="color: #FF0000">*</span></label>

      <textarea class="form-control" required="" id="descripcionvideo1" name="descripcionvideo1" placeholder="Escribir descripcion..."><?php echo $_smarty_tpl->tpl_vars['descripcion_video1']->value;?>
</textarea>

      <label>Dirección del Video <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 10px;" type="text" class="form-control" name="direccionvideo1" id="direccionvideo1" placeholder="Escribir dirección de Youtube" required="" value="<?php echo $_smarty_tpl->tpl_vars['direccion_video1']->value;?>
" />



     <br><br>
      <legend>Para video 2</legend>

      <label>Título del Video <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="text" class="form-control" name="titulovideo2" id="titulovideo2" placeholder="Escribir Título" required="" value="<?php echo $_smarty_tpl->tpl_vars['titulo_video2']->value;?>
" />

      <label>Subtítulo del Video <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="text" class="form-control" name="subtitulovideo2" id="subtitulovideo2" placeholder="Escribir Subtítulo" required="" value="<?php echo $_smarty_tpl->tpl_vars['subtitulo_video2']->value;?>
" />

      <label>Descripción del Video <span style="color: #FF0000">*</span></label>

      <textarea class="form-control" required="" id="descripcionvideo2" name="descripcionvideo2" placeholder="Escribir descripcion..."><?php echo $_smarty_tpl->tpl_vars['descripcion_video2']->value;?>
</textarea>

      <label>Dirección del Video <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="text" class="form-control" name="direccionvideo2" id="direccionvideo2" placeholder="Escribir dirección de Youtube" required="" value="<?php echo $_smarty_tpl->tpl_vars['direccion_video2']->value;?>
" />


      <br><br>
      <legend>Datos de la Empresa</legend>

      <label>Teléfono <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="text" class="form-control" name="telefono" id="telefono" placeholder="Escribir Teléfono" required="" value="<?php echo $_smarty_tpl->tpl_vars['telefono']->value;?>
" />

      <label>Móvil <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="text" class="form-control" name="movil" id="movil" placeholder="Escribir Teléfono Móvil" required="" value="<?php echo $_smarty_tpl->tpl_vars['movil']->value;?>
" />

      <label>Email <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="email" class="form-control" name="email" id="email" placeholder="Escribir Email" required="" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" />

      <label>Dirección <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="text" class="form-control" name="direccion" id="direccion" placeholder="Escribir Dirección" required="" value="<?php echo $_smarty_tpl->tpl_vars['direccion']->value;?>
" />

      <label>Ciudad <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Escribir Ciudad" required="" value="<?php echo $_smarty_tpl->tpl_vars['ciudad']->value;?>
" />

      <label>Copyright <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 20px;" type="text" class="form-control" name="copyright" id="copyright" placeholder="Escribir Copyright" required="" value="<?php echo $_smarty_tpl->tpl_vars['copyright']->value;?>
" />

        <br><br>

      <center><button class="btn btn-primary btn-block"  type="submit" id="submit" name="submit">Guardar Cambios</button></center>

    </form>

  </div>

</div>



  <?php echo $_smarty_tpl->getSubTemplate ('overall/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php }
}
?>