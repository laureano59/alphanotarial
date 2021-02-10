<?php

if(!isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'])){
	if($_POST){
		include('core/models/class.Acceso.php');
        $acceso = new Acceso();
        $acceso->Registrar();
	    exit;
    }else{
		$templates= new Smarty();
        $templates->display('public/registro.tpl');
    }

}else{
	header('location: ?view=index');
}

?>
