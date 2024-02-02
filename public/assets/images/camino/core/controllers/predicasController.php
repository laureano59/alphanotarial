<?php

$templates= new Smarty();

require_once("core/models/class.Consultas.php");
$db = new Consultas();
$sql = $db->ListarAudios();

if(!empty($sql)){
  $i=0;
  foreach($sql as $row){
    $i++;
    $audios[] = array(
      'idaudio'=>$row['id'],
      'descripcion'=>$row['descripcion'],
      'ext'=>$row['ext']
      );
  }
   $templates->assign('audios',$audios);
   $templates->assign('i',$i);
}


$sql2 = $db->Cargar_Footer(1);

$templates->assign('telefono',$sql2['telefono']);
$templates->assign('movil',$sql2['movil']);
$templates->assign('email',$sql2['email']);
$templates->assign('direccion',$sql2['direccion']);
$templates->assign('ciudad',$sql2['ciudad']);
$templates->assign('copyright',$sql2['copyright']);

$templates->display('predicas/predicas.tpl');

?>
