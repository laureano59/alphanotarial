<?php /* Smarty version 3.1.27, created on 2018-02-19 04:59:55
         compiled from "C:\wamp\www\camino\styles\templates\overall\style1.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:237265a8a4bbb679766_82286888%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db0592526e44903d5f6fba53b5a2ce16c85fe1f3' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\style1.tpl',
      1 => 1518267061,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '237265a8a4bbb679766_82286888',
  'variables' => 
  array (
    'nombrefoto' => 0,
    'ext' => 0,
    'opacidad' => 0,
    'colorimage' => 0,
    'media_size' => 0,
    'mostrar_titulo' => 0,
    'titulo' => 0,
    'mostrar_texto' => 0,
    'texto' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a4bbb718d69_72506304',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a4bbb718d69_72506304')) {
function content_5a8a4bbb718d69_72506304 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '237265a8a4bbb679766_82286888';
?>
<br><br>

<section class="engine"><a href="https://mobirise.ws/n">best website builder app</a></section>
<section class="header3 cid-qJ0LXHV7Vf mbr-fullscreen" id="header3-9" style="background-image: url(uploads/fondos/<?php echo $_smarty_tpl->tpl_vars['nombrefoto']->value;?>
.<?php echo $_smarty_tpl->tpl_vars['ext']->value;?>
);">


    <div class="mbr-overlay" style="opacity:  <?php echo $_smarty_tpl->tpl_vars['opacidad']->value;?>
; background-color: rgb(<?php echo $_smarty_tpl->tpl_vars['colorimage']->value;?>
);">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="mbr-figure" style="width: <?php echo $_smarty_tpl->tpl_vars['media_size']->value;?>
%;">
                <?php echo $_smarty_tpl->getSubTemplate ('overall/onlinehome.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

            </div>

            <div class="media-content">
                <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-1">
                      <?php if ($_smarty_tpl->tpl_vars['mostrar_titulo']->value == 1) {
echo $_smarty_tpl->tpl_vars['titulo']->value;
} elseif ($_smarty_tpl->tpl_vars['mostrar_titulo']->value == 0) {
}?>
                </h1>

                <div class="mbr-section-text mbr-white pb-3 ">
                    <p class="mbr-text mbr-fonts-style display-5">
                        <?php if ($_smarty_tpl->tpl_vars['mostrar_texto']->value == 1) {
echo $_smarty_tpl->tpl_vars['texto']->value;
} elseif ($_smarty_tpl->tpl_vars['mostrar_texto']->value == 0) {
}?>
                    </p>
                </div>

            </div>
        </div>
    </div>

</section>
<?php }
}
?>