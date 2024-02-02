<?php /* Smarty version 3.1.27, created on 2018-02-19 05:11:29
         compiled from "C:\wamp\www\camino\styles\templates\public\caption.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:178845a8a4e71448cf9_42451384%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e3850a783683bd499c095adc7d4df69216cb2b37' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\caption.tpl',
      1 => 1518620800,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '178845a8a4e71448cf9_42451384',
  'variables' => 
  array (
    'titulo' => 0,
    'texto' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a4e71538339_70948718',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a4e71538339_70948718')) {
function content_5a8a4e71538339_70948718 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '178845a8a4e71448cf9_42451384';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">

</head>

<body>

<?php echo $_smarty_tpl->getSubTemplate ('overall/admin-nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>




<br><br><br><br><br><br><br><center>

<h3 class="mbr-section-title display-2"><U>Actualización de los Textos</U></h3></center>

<?php if (isset($_GET['error'])) {?>

  <?php if ($_GET['error'] == '1') {?>

    <div class="alert alert-warning" role="alert" style="width: 500px">Textos Actualizados.</div>

  <?php }?>

<?php }?>

<div class="form-horizontal range-form">

  <div class="form-signin">

    <form action="?view=caption" method="POST">

      <legend>Textos del Head</legend>

      <label>Título Head <span style="color: #FF0000">*</span></label>

      <input style="margin-bottom: 10px;" type="text" class="form-control" name="titulo" id="titulo" placeholder="Escribir Título" required="" value="<?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
" />

      <label>Texto Head <span style="color: #FF0000">*</span></label>

      <textarea class="form-control" required="" id="texto" name="texto" placeholder="Escribir Contenido..."><?php echo $_smarty_tpl->tpl_vars['texto']->value;?>
</textarea>

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