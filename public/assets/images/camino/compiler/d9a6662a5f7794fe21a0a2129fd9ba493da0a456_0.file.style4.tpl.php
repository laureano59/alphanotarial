<?php /* Smarty version 3.1.27, created on 2018-02-19 05:19:30
         compiled from "C:\wamp\www\camino\styles\templates\overall\style4.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:72755a8a5052999dc1_68434712%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9a6662a5f7794fe21a0a2129fd9ba493da0a456' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\style4.tpl',
      1 => 1518467383,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72755a8a5052999dc1_68434712',
  'variables' => 
  array (
    'video_bacground' => 0,
    'opacidad' => 0,
    'colorvideo' => 0,
    'mostrar_titulo' => 0,
    'titulo' => 0,
    'mostrar_texto' => 0,
    'texto' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a5052a81490_98332713',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a5052a81490_98332713')) {
function content_5a8a5052a81490_98332713 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '72755a8a5052999dc1_68434712';
?>
<section class="header6 cid-qJt6THruDK mbr-fullscreen" data-bg-video="<?php echo $_smarty_tpl->tpl_vars['video_bacground']->value;?>
" id="header6-8">
  <div class="mbr-overlay" style="opacity: <?php echo $_smarty_tpl->tpl_vars['opacidad']->value;?>
; background-color: rgb(<?php echo $_smarty_tpl->tpl_vars['colorvideo']->value;?>
);"></div>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="mbr-white col-md-10">
        <h1 class="mbr-section-title align-center mbr-bold pb-3 mbr-fonts-style display-1">
          <?php if ($_smarty_tpl->tpl_vars['mostrar_titulo']->value == 1) {
echo $_smarty_tpl->tpl_vars['titulo']->value;
} elseif ($_smarty_tpl->tpl_vars['mostrar_titulo']->value == 0) {
}?>
        </h1>
          <p class="mbr-text align-center pb-3 mbr-fonts-style display-5">
            <?php if ($_smarty_tpl->tpl_vars['mostrar_texto']->value == 1) {
echo $_smarty_tpl->tpl_vars['texto']->value;
} elseif ($_smarty_tpl->tpl_vars['mostrar_texto']->value == 0) {
}?>
          </p>
      </div>
    </div>
  </div>
</section>
<?php echo '<script'; ?>
 src="styles/assets/web/assets/jquery/jquery2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="styles/assets/theme/js/script2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="styles/assets/ytplayer/jquery.mb.ytplayer.min.js"><?php echo '</script'; ?>
>
<?php }
}
?>