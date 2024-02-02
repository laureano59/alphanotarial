<?php
unset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['online'],$_SESSION['admin'],
$_SESSION['imgvideo1'],$_SESSION['imgvideo2'],$_SESSION['idstyles'],$_SESSION['nombrefoto']);
session_destroy();
header('location: ?view=login');
?>
