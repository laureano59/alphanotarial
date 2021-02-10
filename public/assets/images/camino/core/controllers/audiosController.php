<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();
  include('core/models/class.Consultas.php');
  $db = new Consultas();

    if($_SESSION['admin'] == 1  OR $_SESSION['admin'] == 3){

      $sql = $db->ListarAudios();

      if(!empty($sql)){
        foreach($sql as $row){
          $audios[] = array(
            'idaudio'=>$row['id'],
            'descripcion'=>$row['descripcion'],
            'ext'=>$row['ext']
            );
        }
         $templates->assign('audios',$audios);
      }

      $sql = $db->Cargar_Footer(1);

      $templates->assign('telefono',$sql['telefono']);
      $templates->assign('movil',$sql['movil']);
      $templates->assign('email',$sql['email']);
      $templates->assign('direccion',$sql['direccion']);
      $templates->assign('ciudad',$sql['ciudad']);
      $templates->assign('copyright',$sql['copyright']);

      $templates->display('public/adminaudios.tpl');

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
