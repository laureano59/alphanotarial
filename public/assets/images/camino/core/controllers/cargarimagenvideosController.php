<?php

  if ((isset($_POST["submit"])) && ($_POST["submit"] == "Cargar Foto")){
    /*-----------Control de imagenes AVATAR-------------*/

    $nombrefoto = $_FILES['foto']['name'];
    $cualvideo = $_POST["cualvideo"];

    if($nombrefoto != ''){
      if($cualvideo == 1){
        $nombrefile = $_SESSION['imgvideo1'] + 1;
      }
      if($cualvideo == 2){
        $nombrefile = $_SESSION['imgvideo2'] + 1;
      }

      $ext = explode('.',$nombrefoto);
      $ext = end($ext);
      $extensiones = array('JPG','PNG','JPEG','GIF','jpg','png','jpeg','gif');
      $_SESSION['ext'] = $ext;

    /*-----------Control de Error de  AVATAR-------------*/

      if(!in_array($ext,$extensiones)){
          header('location: ?view=styles&error=1');
        exit;
      }

        if($cualvideo == 1){
          $ruta = 'uploads/imgvideos/1/'.$nombrefile .'.'.$_SESSION['ext'];
          $borrarfoto = $nombrefile - 1;
        }

        if($cualvideo == 2){
          $ruta = 'uploads/imgvideos/2/'.$nombrefile .'.'.$_SESSION['ext'];
          $borrarfoto = $nombrefile - 1;
        }
      $i=0;
     while($i <= 7){
       if($cualvideo == 1){
         $ruta = 'uploads/imgvideos/1/'.$borrarfoto .'.'.$extensiones[$i];
       }
       if($cualvideo == 2){
         $ruta = 'uploads/imgvideos/2/'.$borrarfoto .'.'.$extensiones[$i];
       }

       if(file_exists($ruta)){
         unlink($ruta);//borra un archivo
       }
       $i = $i+1;
     }

     if($cualvideo == 1){
       $ruta = 'uploads/imgvideos/1/' .$nombrefile . '.' . $ext;
     }

     if($cualvideo == 2){
       $ruta = 'uploads/imgvideos/2/' .$nombrefile . '.' . $ext;
     }

      move_uploaded_file($_FILES['foto']['tmp_name'],$ruta);//Mueve un archivo

      require_once("core/models/class.Consultas.php");
      $db = new Consultas();

      if($cualvideo == 1){
        $db->updatefeaturevideo1(1,$nombrefile,$ext);
      }
      if($cualvideo == 2){
        $db->updatefeaturevideo2(1,$nombrefile,$ext);
      }

    header('location: ?view=features&error=1');
      exit;
    }else{
      header('location: ?view=styles&error=3');
    }
  }else{
    header('location: ?view=paneldecontrol');
    exit;
    }
?>
