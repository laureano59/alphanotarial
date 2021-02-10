<?php /* Smarty version 3.1.27, created on 2018-02-17 18:47:02
         compiled from "C:\wamp\www\camino\styles\templates\predicas\predicas.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:35565a886a966412f6_40376804%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b28c4780a04058191d652e10ec942ca843f4f7aa' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\predicas\\predicas.tpl',
      1 => 1518538994,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '35565a886a966412f6_40376804',
  'variables' => 
  array (
    'audios' => 0,
    'i' => 0,
    'au' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a886a967fdc93_25514683',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a886a967fdc93_25514683')) {
function content_5a886a967fdc93_25514683 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '35565a886a966412f6_40376804';
echo $_smarty_tpl->getSubTemplate ('overall/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

  <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpredicas.css" type="text/css">
  <link href="styles/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
  <?php echo '<script'; ?>
 type="text/javascript" src="styles/assets/web/assets/jquery/jquery.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 type="text/javascript" src="styles/js/jquery.jplayer.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 type="text/javascript" src="styles/add-on/jplayer.playlist.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 type="text/javascript">
  //<![CDATA[
  $(document).ready(function(){

  	new jPlayerPlaylist({
  		jPlayer: "#jquery_jplayer_1",
  		cssSelectorAncestor: "#jp_container_1"
  	}, [

      <?php if (isset($_smarty_tpl->tpl_vars['audios']->value)) {?>
        <?php
$_from = $_smarty_tpl->tpl_vars['audios']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['au'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['au']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['au']->value) {
$_smarty_tpl->tpl_vars['au']->_loop = true;
$foreach_au_Sav = $_smarty_tpl->tpl_vars['au'];
?>
          <?php if ($_smarty_tpl->tpl_vars['i']->value > 0) {?>
            {
        			title:"<?php echo $_smarty_tpl->tpl_vars['au']->value['descripcion'];?>
",
        			mp3:"uploads/audios/<?php echo $_smarty_tpl->tpl_vars['au']->value['idaudio'];?>
.<?php echo $_smarty_tpl->tpl_vars['au']->value['ext'];?>
"
        		},
            <?php } else { ?>
            {
        			title:"<?php echo $_smarty_tpl->tpl_vars['au']->value['descripcion'];?>
",
        			mp3:"uploads/audios/<?php echo $_smarty_tpl->tpl_vars['au']->value['idaudio'];?>
.<?php echo $_smarty_tpl->tpl_vars['au']->value['ext'];?>
"
        		}
          <?php }?>
          <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable($_smarty_tpl->tpl_vars['i']->value-1, null, 0);?>
        <?php
$_smarty_tpl->tpl_vars['au'] = $foreach_au_Sav;
}
?>
      <?php }?>
  	], {
  		swfPath: "dist/jplayer",
  		supplied: "oga, mp3",
  		wmode: "window",
  		useStateClassSkin: true,
  		autoBlur: false,
  		smoothPlayBar: true,
  		keyEnabled: true
  	});
  });
  //]]>
  <?php echo '</script'; ?>
>


</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ('overall/nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<section class="header3 cid-qJy5ixHBqy mbr-fullscreen" id="header3-o" style="background-image: url(styles/assets/images/fondopredica.png);">



    <div class="mbr-overlay" style="opacity: 0.3; background-color: rgb(0, 0, 0);">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="mbr-figure" style="width: 70%;">
              <div id="jquery_jplayer_1" class="jp-jplayer"></div>
              <div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
                <div class="jp-type-playlist">
                  <div class="jp-gui jp-interface">
                    <div class="jp-controls">
                      <button class="jp-previous" role="button" tabindex="0">previous</button>
                      <button class="jp-play" role="button" tabindex="0">play</button>
                      <button class="jp-next" role="button" tabindex="0">next</button>
                      <button class="jp-stop" role="button" tabindex="0">stop</button>
                    </div>
                    <div class="jp-progress">
                      <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                      </div>
                    </div>
                    <div class="jp-volume-controls">
                      <button class="jp-mute" role="button" tabindex="0">mute</button>
                      <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                      <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                      </div>
                    </div>
                    <div class="jp-time-holder">
                      <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                      <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                    </div>
                    <div class="jp-toggles">
                      <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                      <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                    </div>
                  </div>
                  <div class="jp-playlist">
                    <ul>
                      <li>&nbsp;</li>
                    </ul>
                  </div>
                  <div class="jp-no-solution">
                    <span>Update Required</span>
                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                  </div>
                </div>
              </div>
            </div>

            <div class="media-content">
                <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-1">Prédicas Online</h1>

                <div class="mbr-section-text mbr-white pb-3 ">
                    <p class="mbr-text mbr-fonts-style display-5">
                        Disfruta de la palabra de Dios.
                    </p>
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