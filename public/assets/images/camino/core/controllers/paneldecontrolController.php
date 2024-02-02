<?php

if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

    $templates= new Smarty();
		require_once("core/models/class.Consultas.php");
		$db = new Consultas();
		$sql = $db->Cargar_Footer(1);

		$templates->assign('telefono',$sql['telefono']);
		$templates->assign('movil',$sql['movil']);
		$templates->assign('email',$sql['email']);
		$templates->assign('direccion',$sql['direccion']);
		$templates->assign('ciudad',$sql['ciudad']);
		$templates->assign('copyright',$sql['copyright']);
		
    $templates->display('public/paneldecontrol.tpl');

}else{
	header('location: ?view=login');
}

?>
