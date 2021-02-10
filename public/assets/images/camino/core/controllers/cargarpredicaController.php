<?php
if ((isset($_POST["submit"])) && ($_POST["submit"] == "Cargar Audio")){

  if(!empty($_POST['descripcion'])){
    /*-----------Control de imagenes AVATAR-------------*/
      include('core/models/class.Consultas.php');
      $db = new Consultas();
      $db->AgregarAudio($_POST['descripcion']);
      $nombreaudio = $_FILES['audio']['name'];

      if($nombreaudio != ''){
        $sql = $db->MaxIdAudio();
        $idaudio = $sql['id'];
        $ext = explode('.',$nombreaudio);
        $ext = end($ext);
        $extensiones = array('mp3','MP3');
        $_SESSION['ext'] = $ext;

      /*-----------Control de Error de  AVATAR-------------*/

        if(!in_array($ext,$extensiones)){
            header('location: ?view=audios&error=5');
          exit;
        }

        $ruta = 'uploads/audios/'.$idaudio .'.'.$_SESSION['ext'];

        /*if(file_exists($ruta)){
          unlink($ruta);//borra un archivo
        }*/

        $ruta = 'uploads/audios/' .$idaudio . '.' . $ext;
        move_uploaded_file($_FILES['audio']['tmp_name'],$ruta);//Mueve un archivo

        $db->UpdateAudioExt($idaudio,$ext);

        header('location: ?view=audios&error=4');
        exit;
      }else{
        header('location: ?view=audios&error=6');
      }
    }else{
      throw new Exception(2);
      }
  }else{
    header('location: ?view=paneldecontrol');
    exit;
    }
?>
