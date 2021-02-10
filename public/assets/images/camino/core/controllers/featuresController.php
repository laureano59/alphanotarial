<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();
  require_once("core/models/class.Consultas.php");
  $db = new Consultas();

    if($_SESSION['admin'] == 1){

      $sql = $db->cargar_features(1);

      $_SESSION['imgvideo1'] = $sql['imgvideo1'];
      $_SESSION['imgvideo2'] = $sql['imgvideo2'];

      $templates->assign('modulo',$sql['modulo']);
      $templates->assign('descripcion_modulo',$sql['descripcion_modulo']);
      $templates->assign('titulo_video1',$sql['titulo_video1']);
      $templates->assign('subtitulo_video1',$sql['subtitulo_video1']);
      $templates->assign('descripcion_video1',$sql['descripcion_video1']);
      $templates->assign('direccion_video1',$sql['direccion_video1']);

      $templates->assign('titulo_video2',$sql['titulo_video2']);
      $templates->assign('subtitulo_video2',$sql['subtitulo_video2']);
      $templates->assign('descripcion_video2',$sql['descripcion_video2']);
      $templates->assign('direccion_video2',$sql['direccion_video2']);

      $sql2 = $db->Cargar_Footer(1);

      $templates->assign('telefono',$sql2['telefono']);
      $templates->assign('movil',$sql2['movil']);
      $templates->assign('email',$sql2['email']);
      $templates->assign('direccion',$sql2['direccion']);
      $templates->assign('ciudad',$sql2['ciudad']);
      $templates->assign('copyright',$sql2['copyright']);

      $templates->display('public/adminfeatures.tpl');

    }else{
      $sql = $db->Cargar_Footer(1);

      $templates->assign('telefono',$sql['telefono']);
      $templates->assign('movil',$sql['movil']);
      $templates->assign('email',$sql['email']);
      $templates->assign('direccion',$sql['direccion']);
      $templates->assign('ciudad',$sql['ciudad']);
      $templates->assign('copyright',$sql['copyright']);
      $templates->display('public/mensajerole.tpl');
    }
}else{
	header('location: ?view=login');
}

?>
