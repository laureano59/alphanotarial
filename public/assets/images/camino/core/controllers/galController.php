<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();
  require_once("core/models/class.Consultas.php");
  $db = new Consultas();

    if($_SESSION['admin'] == 1){
      if(!empty($_POST['titulo']) and !empty($_POST['descripcion'])){
        $db->UpdateTitulosGal(1,$_POST['titulo'],$_POST['descripcion']);
        header('location: ?view=gal&error=1');
        exit;

      }else{
        $sql =  $db->Cargar_Titulo_Gal(1);
        $templates->assign('titulo',$sql['titulo']);
        $templates->assign('descripcion',$sql['descripcion']);

        $sqlgal = $db->GalFotos();
        if(!empty($sqlgal)){
          foreach($sqlgal as $row){
            $gal[] = array(
              'id'=>$row['id'],
    		      'ext'=>$row['ext']
            );
    	    }
    	     $templates->assign('gal',$gal);
        }


        $sql = $db->Cargar_Footer(1);

    		$templates->assign('telefono',$sql['telefono']);
    		$templates->assign('movil',$sql['movil']);
    		$templates->assign('email',$sql['email']);
    		$templates->assign('direccion',$sql['direccion']);
    		$templates->assign('ciudad',$sql['ciudad']);
    		$templates->assign('copyright',$sql['copyright']);

        $templates->display('public/admingal.tpl');
      }
    }else{
        /*-----------------FOOTER-------------------*/

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
