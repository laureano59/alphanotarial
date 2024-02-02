<?php

if(!isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'])){
	if($_POST){
		include('core/models/class.Acceso.php');
        $acceso = new Acceso();
        $acceso->Login();
	    exit;
    }else{
		$templates= new Smarty();
		include('core/models/class.Consultas.php');
		$db = new Consultas();
		$sql = $db->Cargar_Footer(1);

		$templates->assign('telefono',$sql['telefono']);
		$templates->assign('movil',$sql['movil']);
		$templates->assign('email',$sql['email']);
		$templates->assign('direccion',$sql['direccion']);
		$templates->assign('ciudad',$sql['ciudad']);
		$templates->assign('copyright',$sql['copyright']);
		$templates->display('public/login.tpl');
    }

}else{
	header('location: ?view=paneldecontrol');
}

?>
