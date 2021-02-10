<?php /* Smarty version 3.1.27, created on 2018-02-19 05:13:28
         compiled from "C:\wamp\www\camino\styles\templates\overall\style2.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:304375a8a4ee8888187_93253896%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47622bb66e189e62066ca8d26503fe6f6b65c6c5' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\style2.tpl',
      1 => 1518492538,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '304375a8a4ee8888187_93253896',
  'variables' => 
  array (
    'nombrefoto' => 0,
    'ext' => 0,
    'opacidad' => 0,
    'colorvideo' => 0,
    'mostrar_titulo' => 0,
    'titulo' => 0,
    'mostrar_texto' => 0,
    'texto' => 0,
    'media_size' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a4ee897ad33_24490216',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a4ee897ad33_24490216')) {
function content_5a8a4ee897ad33_24490216 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '304375a8a4ee8888187_93253896';
?>
<section class="header7 cid-qJuTrd9uzP mbr-fullscreen" id="header7-h" style="background-image: url(uploads/fondos/<?php echo $_smarty_tpl->tpl_vars['nombrefoto']->value;?>
.<?php echo $_smarty_tpl->tpl_vars['ext']->value;?>
);">
  <div class="mbr-overlay" style="opacity: <?php echo $_smarty_tpl->tpl_vars['opacidad']->value;?>
; background-color: rgb(<?php echo $_smarty_tpl->tpl_vars['colorvideo']->value;?>
);"></div>
  <div class="container">
    <div class="media-container-row">
      <div class="media-content align-right">
        <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-1">
          <?php if ($_smarty_tpl->tpl_vars['mostrar_titulo']->value == 1) {
echo $_smarty_tpl->tpl_vars['titulo']->value;
} elseif ($_smarty_tpl->tpl_vars['mostrar_titulo']->value == 0) {
}?>
        </h1>
        <div class="mbr-section-text mbr-white pb-3">
          <p class="mbr-text mbr-fonts-style display-5">
            <?php if ($_smarty_tpl->tpl_vars['mostrar_texto']->value == 1) {
echo $_smarty_tpl->tpl_vars['texto']->value;
} elseif ($_smarty_tpl->tpl_vars['mostrar_texto']->value == 0) {
}?>
          </p>
        </div>
      </div>
      <div class="mbr-figure" style="width: <?php echo $_smarty_tpl->tpl_vars['media_size']->value;?>
%;"><?php echo $_smarty_tpl->getSubTemplate ('overall/onlinetv.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
</div>
    </div>
  </div>
</section>
<?php }
}
?>