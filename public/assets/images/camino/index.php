<?php
session_start();
$view = isset($_GET['view'])? $_GET['view']:'index';
require ('core/libs/smarty/Smarty.class.php');
//require('core/models/class.Conexion.php');

if(file_exists('core/controllers/'. strtolower($view) .'Controller.php')){
	include('core/controllers/'. strtolower($view) .'Controller.php');
}else{
	include('core/controllers/indexController.php');
}

?>
