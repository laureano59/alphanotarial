<?php /* Smarty version 3.1.27, created on 2018-02-19 05:40:22
         compiled from "C:\wamp\www\camino\styles\templates\public\adminaudios.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:299235a8a55364fd517_73599199%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'af9b5f029862af81f179a63efa27c9e578ffe562' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\adminaudios.tpl',
      1 => 1518621819,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '299235a8a55364fd517_73599199',
  'variables' => 
  array (
    'audios' => 0,
    'au' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a5536664d54_95322458',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a5536664d54_95322458')) {
function content_5a8a5536664d54_95322458 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '299235a8a55364fd517_73599199';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">

</head>

<body>

<?php echo $_smarty_tpl->getSubTemplate ('overall/admin-nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>




<br><br><br><br><br><br><br><center>

<h3 class="mbr-section-title display-2"><U>Agregar Prédicas y Audios</U></h3></center>

<br><br>

<?php if (isset($_GET['error'])) {?>

  <?php if ($_GET['error'] == '1') {?>

    <div class="alert alert-success" role="alert" style="width: 500px">Descripción Actualizada</div>

  <?php }?>

  <?php if ($_GET['error'] == '2') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el id del audio</div>

  <?php }?>

  <?php if ($_GET['error'] == '3') {?>

    <div class="alert alert-success" role="alert" style="width: 500px">Audio Eliminado</div>

  <?php }?>

  <?php if ($_GET['error'] == '4') {?>

    <div class="alert alert-success" role="alert" style="width: 500px">Carga Exitosa</div>

  <?php }?>

  <?php if ($_GET['error'] == '5') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">El audio debe ser un formato  (  mp3,  MP3  ).</div>

  <?php }?>

  <?php if ($_GET['error'] == '6') {?>

    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el archivo</div>

  <?php }?>

<?php }?>



<div class="form-horizontal range-form">

  <div class="form-signin">

    <form enctype="multipart/form-data" action="?view=cargarpredica" method="POST">

      <label>Descripción Prédica <span style="color: #FF0000">*</span></label>

      <input type="text" required=""  class="form-control" id="descripcion" name="descripcion" placeholder="Escribir descripción">

      <label>Cargar Archivo de Audio <span style="color: #FF0000">*</span></label>

        <input name="audio" type="file"/>

        <br><br>

      <center><input type="submit" value="Cargar Audio" name="submit" style="width: 300px;" /></center>

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

            <th style="width: 50%;">Descripción Audio</th>

            <th style="width: 10%;">Ext</th>

            <th style="width: 5%;">Eliminar</th>

            <th style="width: 5%;">Editar</th>

          </tr>

                </thead>

              <tbody>

          <?php if (isset($_smarty_tpl->tpl_vars['audios']->value)) {?>

            <?php
$_from = $_smarty_tpl->tpl_vars['audios']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['au'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['au']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['au']->value) {
$_smarty_tpl->tpl_vars['au']->_loop = true;
$foreach_au_Sav = $_smarty_tpl->tpl_vars['au'];
?>

              <tr>

                <td><?php echo $_smarty_tpl->tpl_vars['au']->value['idaudio'];?>
</td>

                <td><?php echo $_smarty_tpl->tpl_vars['au']->value['descripcion'];?>
</td>

                <td><?php echo $_smarty_tpl->tpl_vars['au']->value['ext'];?>
</td>

                <input type='hidden' name='id_cliente' value='".$fila["id_cliente"]."'>

                <td style="text-align: center;"><a href="#" onclick="pasarparametros(<?php echo $_smarty_tpl->tpl_vars['au']->value['idaudio'];?>
);return false;"><img src="styles/image/delete.png"></a></td>

                <td style="text-align: center;"><a class="mbr-buttons__link btn text-white" data-toggle="modal" value="<?php echo $_smarty_tpl->tpl_vars['au']->value['idaudio'];?>
" data-target="#editaraudios"><img src="styles/image/editar.png"></a></td>

              </tr>

            <?php
$_smarty_tpl->tpl_vars['au'] = $foreach_au_Sav;
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


  <?php echo $_smarty_tpl->getSubTemplate ('public/editaraudios.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
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