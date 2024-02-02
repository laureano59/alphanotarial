<?php

if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){
  $templates= new Smarty();
  if($_SESSION['admin'] == 1){
    if(!empty($_POST['modulo']) and !empty($_POST['descripcionmodulo']) and
    !empty($_POST['titulovideo1']) and !empty($_POST['subtitulovideo1']) and
    !empty($_POST['descripcionvideo1']) and !empty($_POST['direccionvideo1']) and
    !empty($_POST['titulovideo2']) and !empty($_POST['subtitulovideo2']) and
    !empty($_POST['descripcionvideo2']) and !empty($_POST['direccionvideo2']) and
    !empty($_POST['telefono']) and !empty($_POST['movil']) and
    !empty($_POST['email']) and !empty($_POST['direccion']) and
    !empty($_POST['ciudad']) and !empty($_POST['copyright'])){

      include('core/models/class.Consultas.php');
      $db = new Consultas();
      $db->UpdateFeatures(1,$_POST['modulo'],$_POST['descripcionmodulo'],$_POST['titulovideo1'],
      $_POST['subtitulovideo1'],$_POST['descripcionvideo1'],$_POST['direccionvideo1'],
      $_POST['titulovideo2'],$_POST['subtitulovideo2'],$_POST['descripcionvideo2'],
      $_POST['direccionvideo2']);

      $db->UpdateEmpresa(1,$_POST['telefono'],$_POST['movil'],$_POST['email'],
      $_POST['direccion'],$_POST['ciudad'],$_POST['copyright']);

      header('location: ?view=features&error=1');

    }else{
      throw new exception('Error: datos vacíos');//solo se cumple cuando alguien no mande los datos por ajax, es decir cuando bugean el código fuente.
      }

  }else{
      $templates->display('public/mensajerole.tpl');
    }
}else{
	header('location: ?view=login');
}

?>
