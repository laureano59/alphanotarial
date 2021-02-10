<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){
  $templates= new Smarty();

  if($_SESSION['admin'] == 1  OR $_SESSION['admin'] == 3){
    if(!empty($_POST['idaudio'])){
      include('core/models/class.Consultas.php');
      $db = new Consultas();
      $idaudio = $_POST['idaudio'];
      $sql = $db->ConsultarExtAudios($idaudio);
      $_SESSION['ext'] = $sql['ext'];
      $ruta = 'uploads/audios/'.$idaudio .'.'.$_SESSION['ext'];
      if(file_exists($ruta)){
        unlink($ruta);//borra un archivo
      }

      $db->BorrarAudios($idaudio);
      echo "Audio Eliminado";
    }else{
      $templates->display('public/paneldecontrol.tpl');
      }
  }else{
      $templates->display('public/mensajerole.tpl');
    }
}else{
	header('location: ?view=login');
}
 ?>
