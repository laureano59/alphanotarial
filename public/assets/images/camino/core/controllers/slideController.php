<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();

    if($_SESSION['admin'] == 1){
      if(!$_POST){
        $templates->display('public/adminstyles.tpl');
        exit;
      }else{
        include('core/models/class.Slide.php');
        $slide = new Slide();

        if($_POST['validar'] == 7){
          $idslide = $_POST['idslide'];
          $slide->DeleteSlide($idslide);
          exit;
        }else{
          $slide->AgregarSlide();
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
