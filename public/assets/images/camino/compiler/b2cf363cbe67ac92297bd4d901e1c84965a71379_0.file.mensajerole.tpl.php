<?php /* Smarty version 3.1.27, created on 2018-02-18 18:28:12
         compiled from "C:\wamp\www\camino\styles\templates\public\mensajerole.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:192045a89b7ac2029c7_00957252%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b2cf363cbe67ac92297bd4d901e1c84965a71379' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\mensajerole.tpl',
      1 => 1518974890,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '192045a89b7ac2029c7_00957252',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a89b7ac279704_70425972',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a89b7ac279704_70425972')) {
function content_5a89b7ac279704_70425972 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '192045a89b7ac2029c7_00957252';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionaloracion.css" type="text/css">
</head>

<body>

<?php echo $_smarty_tpl->getSubTemplate ('overall/admin-nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>



<br><br>
<section class="mbr-cards mbr-section mbr-section-nopadding" id="features3-2f" style="background-color: rgb(255, 255, 255); padding-top: 120px; padding-bottom: 120px;">

  <div class="col-xs-12 text-xs-center">

    <center><h3 class="mbr-section-title display-2">No tiene los permisos para acceder</h3>
</center>
  </div>



</section>





<?php echo $_smarty_tpl->getSubTemplate ('overall/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php }
}
?>