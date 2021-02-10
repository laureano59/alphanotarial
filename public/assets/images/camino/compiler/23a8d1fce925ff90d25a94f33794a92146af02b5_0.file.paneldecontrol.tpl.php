<?php /* Smarty version 3.1.27, created on 2018-02-18 18:24:57
         compiled from "C:\wamp\www\camino\styles\templates\public\paneldecontrol.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:302275a89b6e9c219b7_84576802%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23a8d1fce925ff90d25a94f33794a92146af02b5' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\paneldecontrol.tpl',
      1 => 1518620303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '302275a89b6e9c219b7_84576802',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a89b6e9d4ce59_30823833',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a89b6e9d4ce59_30823833')) {
function content_5a89b6e9d4ce59_30823833 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '302275a89b6e9c219b7_84576802';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
</head>

<body>

<?php echo $_smarty_tpl->getSubTemplate ('overall/admin-nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>



<br><br>
<section class="mbr-section content4 cid-qJDHdnsuvc" id="content4-10">
  <div class="container">
    <div class="media-container-row">
      <div class="title col-12 col-md-8">
        <h2 class="align-center pb-3 mbr-fonts-style display-2">
          PANEL DE CONTROL
        </h2>
        <div>
          <center>
            <table class="table table-striped table-hover" style="width: 20%;">
              <tr>
                <td style="text-align: center"><a href="?view=styles"><img src="styles/image/iconos/icostyles.png"><br>Styles</a></td>
                <td style="text-align: center"><a href="?view=gal"><img src="styles/image/iconos/icogal.png"><br>Galería</a></td>
              </tr>
              <tr>
                <td style="text-align: center"><a href="?view=features"><img src="styles/image/iconos/icotestimonios.png"><br>Testimonios</a></td>
                <td style="text-align: center"><a href="?view=caption"><img src="styles/image/iconos/icotitulos.png"><br>Títulos</a></td>
              </tr>
              <tr>
                <td style="text-align: center"><a href="?view=admintv"><img src="styles/image/iconos/icotelevision.png"><br>Televisión</a></td>
                <td style="text-align: center"><a href="?view=audios"><img src="styles/image/iconos/icosonido.png"><br>Sonido</a></td>
              </tr>
            </table>
          </center>
        </div>
      </div>
    </div>
  </div>
</section>


<?php echo $_smarty_tpl->getSubTemplate ('overall/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php }
}
?>