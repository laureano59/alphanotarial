<?php /* Smarty version 3.1.27, created on 2018-02-19 05:41:58
         compiled from "C:\wamp\www\camino\styles\templates\tvonline\tvonline.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:945a8a5596364077_67126881%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a926e6e6b03addf18ca6f2671276787aa7dd9339' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\tvonline\\tvonline.tpl',
      1 => 1518540670,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '945a8a5596364077_67126881',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a55963fbba4_69693847',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a55963fbba4_69693847')) {
function content_5a8a55963fbba4_69693847 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '945a8a5596364077_67126881';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionaltelevision.css" type="text/css">
<link rel="stylesheet" href="styles/css/tvonline.css" />

</head>

<body>

<?php echo $_smarty_tpl->getSubTemplate ('overall/nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>



<br><br>
<section class="mbr-section content5 cid-qJyk86oHvv" id="content5-q" style="background-image: url(styles/assets/images/jumbotron.jpg);">

    <div class="mbr-overlay" style="opacity: 0.2; background-color: rgb(0, 0, 0);">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center mbr-bold mbr-white pb-3 mbr-fonts-style display-1">
                    TRANSMISIÓN EN VIVO</h2>
                <h3 class="mbr-section-subtitle align-center mbr-light mbr-white pb-3 mbr-fonts-style display-5">Reuniones completas en vivo, acompáñanos desde cualquier lugar del mundo: Viernes 6:45 PM y Domingos 8:00 AM&nbsp;</h3>


            </div>
        </div>
    </div>
</section>

<section class="cid-qJylJBkGwE" id="video2-r">



    <figure class="mbr-figure align-center container">
        <div class="video-block" style="width: 100%;">
            <div>  <?php echo $_smarty_tpl->getSubTemplate ('overall/online.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

</div>
        </div>
    </figure>
</section>

<?php echo $_smarty_tpl->getSubTemplate ('overall/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php }
}
?>