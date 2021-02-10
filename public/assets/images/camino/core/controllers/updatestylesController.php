<?php

if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){
	if($_POST){
		include('core/models/class.Updatestyles.php');
        $update = new Update();
        $update->UpdateStyles();
	    exit;
    }else{
      $templates= new Smarty();
      $templates->display('public/paneldecontrol.tpl');
    }
}else{
	header('location: ?view=login');
}

?>
