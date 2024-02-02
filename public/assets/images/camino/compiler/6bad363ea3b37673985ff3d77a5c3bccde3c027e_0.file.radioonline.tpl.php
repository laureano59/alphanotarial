<?php /* Smarty version 3.1.27, created on 2018-02-19 04:57:40
         compiled from "C:\wamp\www\camino\styles\templates\overall\radioonline.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:289695a8a4b34be9226_19944471%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6bad363ea3b37673985ff3d77a5c3bccde3c027e' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\radioonline.tpl',
      1 => 1515826057,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '289695a8a4b34be9226_19944471',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a4b34c35799_39189703',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a4b34c35799_39189703')) {
function content_5a8a4b34c35799_39189703 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '289695a8a4b34be9226_19944471';
?>
<center>

  <!-- BEGINS: AUTO-GENERATED MUSES RADIO PLAYER CODE -->

  <?php echo '<script'; ?>
 type="text/javascript" src="https://hosted.muses.org/mrp.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 type="text/javascript">

  MRP.insert({

  'url':'http://50.22.219.97:4289/;',

  'lang':'es',

  'codec':'mp3',

  'volume':100,

  'autoplay':true,

  'forceHTML5':true,

  'jsevents':true,

  'buffering':0,

  'title':'Radio Vino Nuevo',

  'welcome':'Bienvenidos',

  'wmode':'transparent',

  'skin':'faredirfare',

  'width':269,

  'height':52

  });

  <?php echo '</script'; ?>
>

  <!-- ENDS: AUTO-GENERATED MUSES RADIO PLAYER CODE -->

  <div id="player-vu-meter"><img src="http://player.srvstm.com/img/img-player-vu-meter.gif" width="260" height="30" /></div></div>

</center>

<?php }
}
?>