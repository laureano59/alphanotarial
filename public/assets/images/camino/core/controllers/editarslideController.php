<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();

    if($_SESSION['admin'] == 1){
      if(!$_POST){
        $templates->display('public/adminstyles.tpl');
        exit;
      }else{

        if ((isset($_POST["submit"])) && ($_POST["submit"] == "Guardar Cambios")){
          if(!empty($_POST['idslide']) and !empty($_POST['colorslide']) and !empty($_POST['opacidad'])){
              include('core/models/class.Consultas.php');
              $db = new Consultas();
              $db->EditarSlide($_POST['idslide'], $_POST['titulo_slide'], $_POST['texto_slide'], $_POST['colorslide'], $_POST['opacidad']);
              header('location: ?view=styles&error=2');
              exit;
            }else{
              header('location: ?view=styles&error=5');
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
