<?php /* Smarty version 3.1.27, created on 2018-02-19 05:13:28
         compiled from "C:\wamp\www\camino\styles\templates\overall\onlinetv.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:55625a8a4ee8992320_36606193%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90ed4a785ce566d1e5990d516e51db178fd8ce62' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\onlinetv.tpl',
      1 => 1518530628,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55625a8a4ee8992320_36606193',
  'variables' => 
  array (
    'video_bacground' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a4ee8999fd3_32590074',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a4ee8999fd3_32590074')) {
function content_5a8a4ee8999fd3_32590074 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '55625a8a4ee8992320_36606193';
?>
<iframe
  class="mbr-embedded-video" width="1280" height="720" src="<?php echo $_smarty_tpl->tpl_vars['video_bacground']->value;?>
"
  frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
</iframe>
<?php }
}
?>