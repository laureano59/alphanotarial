<?php /* Smarty version 3.1.27, created on 2018-02-19 04:57:40
         compiled from "C:\wamp\www\camino\styles\templates\radiomvn\radioelcamino.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:283365a8a4b34b07939_94475448%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54e8c9cbbe7e0e61f131fa12e1c2e60b99651831' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\radiomvn\\radioelcamino.tpl',
      1 => 1518542280,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '283365a8a4b34b07939_94475448',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a4b34bc98c5_31868898',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a4b34bc98c5_31868898')) {
function content_5a8a4b34bc98c5_31868898 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '283365a8a4b34b07939_94475448';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalradio.css" type="text/css">
<link rel="stylesheet" href="styles/css/tvonline.css" />
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ('overall/nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<br><br>
<section class="mbr-section content5 cid-qJyrMgqDtD" id="content5-u" style="background-image: url(styles/assets/images/sonido.jpg);">
  <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(0, 0, 0);"></div>
  <div class="container">
    <div class="media-container-row">
      <div class="title col-12 col-md-8">
        <h2 class="align-center mbr-bold mbr-white pb-3 mbr-fonts-style display-2">
          EMISORA RADIAL EL CAMINO CALI</h2>
        <h3 class="mbr-section-subtitle align-center mbr-light mbr-white pb-3 mbr-fonts-style display-5">
          Disfruta de toda nuestra programación: música, predicación de la palabra, estudios bíblicos y mucho más</h3>
      </div>
    </div>
  </div>
</section>

<section class="mbr-section info1 cid-qJythReaGa" id="info1-v">
  <div class="container">
    <div class="row justify-content-center content-row">
      <?php echo $_smarty_tpl->getSubTemplate ('overall/radioonline.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    </div>
  </div>
</section>

<?php echo $_smarty_tpl->getSubTemplate ('overall/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>