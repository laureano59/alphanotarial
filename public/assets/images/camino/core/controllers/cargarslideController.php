<?php

  if ((isset($_POST["submit"])) && ($_POST["submit"] == "Cargar Foto")){
    /*-----------Control de imagenes AVATAR-------------*/

    $nombrefoto = $_FILES['foto']['name'];

    if($nombrefoto != ''){
      $idslide = $_SESSION['idslide'];
      $ext = explode('.',$nombrefoto);
      $ext = end($ext);
      $extensiones = array('JPG','PNG','JPEG','GIF','jpg','png','jpeg','gif');
      $_SESSION['ext'] = $ext;

    /*-----------Control de Error de  AVATAR-------------*/

      if(!in_array($ext,$extensiones)){
          header('location: ?view=styles&error=1');
        exit;
      }

      $ruta = 'uploads/slides/'.$idslide .'.'.$_SESSION['ext'];

      if(file_exists($ruta)){
        unlink($ruta);//borra un archivo
      }

      $ruta = 'uploads/slides/' .$idslide . '.' . $ext;
      move_uploaded_file($_FILES['foto']['tmp_name'],$ruta);//Mueve un archivo
      header('location: ?view=styles&error=2');
      exit;
    }else{
      header('location: ?view=styles&error=3');
    }
  }else{
    header('location: ?view=paneldecontrol');
    exit;
    }
?>
