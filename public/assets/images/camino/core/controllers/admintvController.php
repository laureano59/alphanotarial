<?php

if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){
  include('core/models/class.Consultas.php');
  $templates= new Smarty();
  if($_SESSION['admin'] == 1  OR $_SESSION['admin'] == 2){
    if($_POST){
      include('core/models/class.Admin.php');
      $admin = new Admin();
      $admin->Guardar();
      exit;
    }else{
      $db = new Consultas();
      $sql = $db->Cargar_Footer(1);
      $templates->assign('telefono',$sql['telefono']);
      $templates->assign('movil',$sql['movil']);
      $templates->assign('email',$sql['email']);
      $templates->assign('direccion',$sql['direccion']);
      $templates->assign('ciudad',$sql['ciudad']);
      $templates->assign('copyright',$sql['copyright']);

      $sqltv1 = $db->tv_online_direccion1(1);
      $sqltv2 = $db->tv_online_direccion2(2);

      $templates->assign('dir1',$sqltv1['src']);
      $templates->assign('dir2',$sqltv2['src']);

      $templates->display('public/admintv.tpl');
      }
  }else{
    $db = new Consultas();
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
