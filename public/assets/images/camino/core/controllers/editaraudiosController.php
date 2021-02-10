<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();

    if($_SESSION['admin'] == 1 or $_SESSION['admin'] == 3){
      if(!$_POST){
        $templates->display('public/adminaudios.tpl');
        exit;
      }else{

        if ((isset($_POST["submit"])) && ($_POST["submit"] == "Guardar Cambios")){
          if(!empty($_POST['descripcion'])){
              include('core/models/class.Consultas.php');
              $db = new Consultas();
              $db->EditarAudio($_POST['idaudio'], $_POST['descripcion']);
              header('location: ?view=audios&error=1');
              exit;
            }else{
              header('location: ?view=audios&error=2');
              exit;
            }

        }else{
          header('location: ?view=paneldecontrol');
          exit;
        }


      }
    }else{
      $templates->display('public/mensajerole.tpl');
    }
}else{
	header('location: ?view=login');
}

?>
