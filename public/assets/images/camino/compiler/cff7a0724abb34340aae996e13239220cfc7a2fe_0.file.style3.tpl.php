<?php /* Smarty version 3.1.27, created on 2018-02-16 03:28:12
         compiled from "C:\wamp\www\camino\styles\templates\overall\style3.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:259695a8641bc8e1a45_37596897%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cff7a0724abb34340aae996e13239220cfc7a2fe' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\style3.tpl',
      1 => 1518531448,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '259695a8641bc8e1a45_37596897',
  'variables' => 
  array (
    'nombrefoto' => 0,
    'ext' => 0,
    'opacidad' => 0,
    'colorimage' => 0,
    'mostrar_titulo' => 0,
    'titulo' => 0,
    'mostrar_texto' => 0,
    'texto' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8641bc91b168_04731817',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8641bc91b168_04731817')) {
function content_5a8641bc91b168_04731817 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '259695a8641bc8e1a45_37596897';
?>
<section class="cid-qJxKwSjeXd mbr-fullscreen" id="header2-k" style="background-image: url(uploads/fondos/<?php echo $_smarty_tpl->tpl_vars['nombrefoto']->value;?>
.<?php echo $_smarty_tpl->tpl_vars['ext']->value;?>
);">
  <div class="mbr-overlay" style="opacity: <?php echo $_smarty_tpl->tpl_vars['opacidad']->value;?>
; background-color: rgb(<?php echo $_smarty_tpl->tpl_vars['colorimage']->value;?>
);"></div>
  <div class="container align-center">
    <div class="row justify-content-md-center">
      <div class="mbr-white col-md-10">
        <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">
          <?php if ($_smarty_tpl->tpl_vars['mostrar_titulo']->value == 1) {
echo $_smarty_tpl->tpl_vars['titulo']->value;
} elseif ($_smarty_tpl->tpl_vars['mostrar_titulo']->value == 0) {
}?>
        </h1>
        <p class="mbr-text pb-3 mbr-fonts-style display-5">
          <?php if ($_smarty_tpl->tpl_vars['mostrar_texto']->value == 1) {
echo $_smarty_tpl->tpl_vars['texto']->value;
} elseif ($_smarty_tpl->tpl_vars['mostrar_texto']->value == 0) {
}?>
        </p>
      </div>
    </div>
  </div>
  <div class="mbr-arrow hidden-sm-down" aria-hidden="true">
    <a href="#next">
      <i class="mbri-down mbr-iconfont"></i>
    </a>
  </div>
</section>
<?php }
}
?>