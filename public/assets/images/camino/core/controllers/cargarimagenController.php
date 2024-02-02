<?php

  if ((isset($_POST["submit"])) && ($_POST["submit"] == "Cargar Foto")){
    /*-----------Control de imagenes AVATAR-------------*/

    $nombrefoto = $_FILES['foto']['name'];

    if($nombrefoto != ''){
      $nombrefile = $_SESSION['nombrefoto'] + 1;
      $ext = explode('.',$nombrefoto);
      $ext = end($ext);
      $extensiones = array('JPG','PNG','JPEG','GIF','jpg','png','jpeg','gif');
      $_SESSION['ext'] = $ext;

    /*-----------Control de Error de  AVATAR-------------*/

      if(!in_array($ext,$extensiones)){
          header('location: ?view=styles&error=1');
        exit;
      }

      $ruta = 'uploads/fondos/'.$nombrefile .'.'.$_SESSION['ext'];
      $borrarfoto = $nombrefile - 1;
      $i=0;
     while($i <= 7){
       $ruta = 'uploads/fondos/'.$borrarfoto .'.'.$extensiones[$i];
       if(file_exists($ruta)){
         unlink($ruta);//borra un archivo
       }
       $i = $i+1;
     }

      $ruta = 'uploads/fondos/' .$nombrefile . '.' . $ext;
      move_uploaded_file($_FILES['foto']['tmp_name'],$ruta);//Mueve un archivo

      require_once("core/models/class.Consultas.php");
      $db = new Consultas();
      $db->updatestylesext(1,$nombrefile,$ext);

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
