<?php /* Smarty version 3.1.27, created on 2018-02-19 05:41:58
         compiled from "C:\wamp\www\camino\styles\templates\overall\online.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:318075a8a559641a393_17543597%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24d13a2ea12d8fe0c9f6cc5e811b4b1e29bb3e86' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\online.tpl',
      1 => 1515826058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '318075a8a559641a393_17543597',
  'variables' => 
  array (
    'src' => 0,
    'autoplay' => 0,
    'ancho' => 0,
    'alto' => 0,
    'borde' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a5596436947_42603305',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a5596436947_42603305')) {
function content_5a8a5596436947_42603305 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '318075a8a559641a393_17543597';
?>
<iframe class="mbr-embedded-video" src="https://www.youtube.com/embed/<?php echo $_smarty_tpl->tpl_vars['src']->value;?>
?rel=0&autoplay=<?php echo $_smarty_tpl->tpl_vars['autoplay']->value;?>
" width="<?php echo $_smarty_tpl->tpl_vars['ancho']->value;?>
" height="<?php echo $_smarty_tpl->tpl_vars['alto']->value;?>
" frameborder="<?php echo $_smarty_tpl->tpl_vars['borde']->value;?>
" allowfullscreen></iframe>

<?php }
}
?>