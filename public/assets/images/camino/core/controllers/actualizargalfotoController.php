<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();
  require_once("core/models/class.Consultas.php");
  $db = new Consultas();

    if($_SESSION['admin'] == 1){
      if ((isset($_POST["submit"])) && ($_POST["submit"] == "Guardar Cambios")){
        $nombrefoto = $_FILES['foto']['name'];

        if($nombrefoto != ''){

          if(!empty($_POST['idgalfoto'])) {

            $ext = explode('.',$nombrefoto);
            $ext = end($ext);
            $extensiones = array('JPG','PNG','JPEG','GIF','jpg','png','jpeg','gif');
            $_SESSION['ext'] = $ext;
            $idgalfoto = $_POST['idgalfoto'];

            $db->UpdateGalFotoExt($idgalfoto,$ext);

            /*-----------Control de Error de  AVATAR-------------*/

                if(!in_array($ext,$extensiones)){
                    header('location: ?view=gal&error=3');
                  exit;
                }
                  $ruta = 'uploads/gal/'.$idgalfoto .'.'.$_SESSION['ext'];

                  $i=0;
	               while($i <= 7){
                   $ruta = 'uploads/gal/'.$idgalfoto .'.'.$extensiones[$i];
                   if(file_exists($ruta)){
                     unlink($ruta);//borra un archivo
                   }
                   $i = $i+1;
                 }

                $ruta = 'uploads/gal/' .$idgalfoto . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'],$ruta);//Mueve un archivo
                header('location: ?view=gal&error=1');
                exit;


      		}else{
            throw new Exception(2);
      			}

          }else{
            header('location: ?view=gal&error=4');
          }
      }else{
        header('location: ?view=paneldecontrol');
        exit;
      }
    }else{
      /*-----------------FOOTER-------------------*/

      $sql = $db->Cargar_Footer(1);

      $templates->assign('telefono',$sql['telefono']);
      $templates->assign('movil',$sql['movil']);
      $templates->assign('email',$sql['email']);
      $templates->assign('direccion',$sql['direccion']);
      $templates->assign('ciudad',$sql['ciudad']);
      $templates->assign('copyright',$sql['copyright']);
      $templates->display('public/mensajerole.tpl');
    }
}else{
	header('location: ?view=login');
}

?>
