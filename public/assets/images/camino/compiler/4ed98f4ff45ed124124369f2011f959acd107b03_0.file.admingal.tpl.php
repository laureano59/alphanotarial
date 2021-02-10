<?php /* Smarty version 3.1.27, created on 2018-02-19 05:37:22
         compiled from "C:\wamp\www\camino\styles\templates\public\admingal.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:196135a8a5482890ff5_79237598%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ed98f4ff45ed124124369f2011f959acd107b03' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\admingal.tpl',
      1 => 1518620608,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '196135a8a5482890ff5_79237598',
  'variables' => 
  array (
    'titulo' => 0,
    'descripcion' => 0,
    'gal' => 0,
    'gl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a5482af51d8_67789681',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a5482af51d8_67789681')) {
function content_5a8a5482af51d8_67789681 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '196135a8a5482890ff5_79237598';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">

</head>

<body>

<?php echo $_smarty_tpl->getSubTemplate ('overall/admin-nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>




<br><br><br><br><br><br><br><center>

<h3 class="mbr-section-title display-2"><U>Galería de Fotos</U></h3></center>

<?php if (isset($_GET['error'])) {?>

  <?php if ($_GET['error'] == '1') {?>

    <div class="alert alert-success" role="alert" style="width: 500px">Actualización Realizada</div>

  <?php }?>

  <?php if ($_GET['error'] == '2') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el id de la foto</div>

  <?php }?>

  <?php if ($_GET['error'] == '3') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">La foto debe ser un formato  (  jpg,  JPG, png, PNG, gif, GIF  ).</div>

  <?php }?>

  <?php if ($_GET['error'] == '4') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el archivo</div>

  <?php }?>

<?php }?>

<br>

<div class="form-horizontal range-form">

  <div class="form-signin">

    <form action="?view=gal" method="POST">

      <legend>Títulos del Módulo</legend>

      <label>Nombre del Módulo <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 10px;" type="text" class="form-control" name="titulo" id="titulo" placeholder="Escribir Nombre del Módulo" required="" value="<?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
" />

      <label>Descripción del Módulo <span style="color: #FF0000">*</span></label>

      <textarea class="form-control" required="" id="descripcion" name="descripcion" placeholder="Escribir descripcion..."><?php echo $_smarty_tpl->tpl_vars['descripcion']->value;?>
</textarea>

      <br>

      <center><button class="btn btn-primary btn-block"  type="submit" id="submit" name="submit">Guardar Cambios</button></center>

    </form>

  </div>

</div>



<hr><br>

<center>

  <div class="table-responsive">

    <div id="resultado" class="alert alert-warning" role="alert" style="width: 980px"></div>

    <table class="table table-striped table-hover" style="width: 50%;">

      <thead>

        <tr>

          <th style="width: 5%;">Id</th>

            <th style="width: 7%;">Foto</th>

            <th style="width: 5%;">Editar</th>

          </tr>

                </thead>

              <tbody>

          <?php if (isset($_smarty_tpl->tpl_vars['gal']->value)) {?>

            <?php
$_from = $_smarty_tpl->tpl_vars['gal']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['gl'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['gl']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['gl']->value) {
$_smarty_tpl->tpl_vars['gl']->_loop = true;
$foreach_gl_Sav = $_smarty_tpl->tpl_vars['gl'];
?>

              <tr>

                <td><?php echo $_smarty_tpl->tpl_vars['gl']->value['id'];?>
</td>

                <td><img src="uploads/gal/<?php echo $_smarty_tpl->tpl_vars['gl']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['gl']->value['ext'];?>
" width="60" height="40"></td>

                <td style="text-align: center;"><a class="mbr-buttons__link btn text-white" data-toggle="modal" data-target="#editargalfotos"><img src="styles/image/editar.png"></a></td>

              </tr>

            <?php
$_smarty_tpl->tpl_vars['gl'] = $foreach_gl_Sav;
}
?>

           <?php } else { ?>

              <tr>

                <td colspan="4">No hay archivos para mostrar</td>

              </tr>

          <?php }?>

              </tbody>

            </table>

        </div>

</center>



<hr>

  <?php echo $_smarty_tpl->getSubTemplate ('overall/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


  <?php echo $_smarty_tpl->getSubTemplate ('public/editargalfotos.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>




  <?php echo '<script'; ?>
>

  function pasarparametros(valor){



          var parametros = {

                  "idaudio" : valor,

          };

          $.ajax({

                  data:  parametros,

                  url:   '?view=borraraudio',

                  type:  'post',

                  beforeSend: function () {

                          $("#resultado").html("Procesando, espere por favor...");

                  },

                  success:  function (response) {

                          $("#resultado").html(response);

                          location.href ="?view=audios";

                  }

          });

  }

  <?php echo '</script'; ?>
>

<?php }
}
?>