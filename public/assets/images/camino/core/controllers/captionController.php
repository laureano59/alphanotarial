<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();

    if($_SESSION['admin'] == 1){
      if(!$_POST){
        require_once("core/models/class.Consultas.php");
        $db = new Consultas();
        $sql5 = $db->Cargar_Footer(1);
        $templates->assign('telefono',$sql5['telefono']);
        $templates->assign('movil',$sql5['movil']);
        $templates->assign('email',$sql5['email']);
        $templates->assign('direccion',$sql5['direccion']);
        $templates->assign('ciudad',$sql5['ciudad']);
        $templates->assign('copyright',$sql5['copyright']);

        $sqltitulos =  $db->Cargar_Titulo_Head(1);
        $templates->assign('titulo',$sqltitulos['titulo']);
        $templates->assign('texto',$sqltitulos['texto']);

        $templates->display('public/caption.tpl');
        exit;
      }else{
        include('core/models/class.Caption.php');
            $caption = new Caption();
            $caption->Caption();
          exit;
      }

    }else{
        require_once("core/models/class.Consultas.php");
        $db = new Consultas();
        $sql5 = $db->Cargar_Footer(1);
        $templates->assign('telefono',$sql5['telefono']);
        $templates->assign('movil',$sql5['movil']);
        $templates->assign('email',$sql5['email']);
        $templates->assign('direccion',$sql5['direccion']);
        $templates->assign('ciudad',$sql5['ciudad']);
        $templates->assign('copyright',$sql5['copyright']);
      $templates->display('public/mensajerole.tpl');
    }
}else{
	header('location: ?view=login');
}

?>
