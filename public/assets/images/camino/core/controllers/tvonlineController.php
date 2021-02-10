<?php

$templates= new Smarty();
require_once("core/models/class.Consultas.php");
$db = new Consultas();
$sql = $db->tv_online_home(1);
$var = $sql[0];
$res = explode('=',$var);
$res = $res[1];
$res = explode('&',$res);
$templates->assign('src',$res[0]);
$templates->assign('autoplay',$sql['autoplay']);
$templates->assign('ancho',$sql['width']);
$templates->assign('alto',$sql['height']);
$templates->assign('borde',$sql['frameborder']);
$templates->assign('scroll',$sql['scrolling']);

$sql2 = $db->Cargar_Footer(1);

$templates->assign('telefono',$sql2['telefono']);
$templates->assign('movil',$sql2['movil']);
$templates->assign('email',$sql2['email']);
$templates->assign('direccion',$sql2['direccion']);
$templates->assign('ciudad',$sql2['ciudad']);
$templates->assign('copyright',$sql2['copyright']);

$templates->display('tvonline/tvonline.tpl');

?>
