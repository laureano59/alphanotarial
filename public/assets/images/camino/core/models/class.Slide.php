<?php

class Slide {
  private $idslide;
  private $descripcion;
  private $ext;
  private $backgroundcolor;
  private $video;
  private $opacidad;
  private $titulo_slide;
  private $texto_slide;

  public function AgregarSlide() {

      if ((isset($_POST["submit"])) && ($_POST["submit"] == "Guardar Slide de Imagen")){
        /*-----------Control de imagenes AVATAR-------------*/

        $nombrefoto = $_FILES['foto']['name'];

        if($nombrefoto != ''){

          if(!empty($_POST['descripcion']) and !empty($_POST['colorslideimagen']) and
            !empty($_POST['opacidadslideimagen'])) {
            require_once("core/models/class.Consultas.php");
          	$db = new Consultas();
          	$this->descripcion     = $_POST['descripcion'];
            $this->backgroundcolor = $_POST['colorslideimagen'];
            $this->opacidad        = $_POST['opacidadslideimagen'];
            $this->video           = "";
            $this->titulo_slide    = $_POST['titulo_slide'];
            $this->texto_slide     = $_POST['texto_slide'];
          	$db->AgregarSlide($this->descripcion, $this->video, $this->backgroundcolor, $this->opacidad, $this->titulo_slide, $this->texto_slide);
      		}else{
            throw new Exception(2);
      			}

            $sql = $db->MaxIdSlide() ;
            $idslide = $sql['id'];

            $ext = explode('.',$nombrefoto);
            $ext = end($ext);
            $extensiones = array('JPG','PNG','JPEG','GIF','jpg','png','jpeg','gif');
            $_SESSION['ext'] = $ext;

            $db->UpdateExtslide($idslide, $_SESSION['ext']);

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
        }else if ((isset($_POST["submit"])) && ($_POST["submit"] == "Guardar Slide de Video")){

          if(!empty($_POST['descripcion']) and !empty($_POST['video']) and !empty($_POST['colorslidevideo']) and
            !empty($_POST['opacidadslidevideo']) and !empty($_POST['titulo_slide']) and !empty($_POST['texto_slide']) ) {
            require_once("core/models/class.Consultas.php");
            $db = new Consultas();
            $this->descripcion      = $_POST['descripcion'];
            $this->backgroundcolor  = $_POST['colorslidevideo'];
            $this->opacidad         = $_POST['opacidadslidevideo'];
            $this->video            = $_POST['video'];
            $this->titulo_slide    = $_POST['titulo_slide'];
            $this->texto_slide     = $_POST['texto_slide'];
            $db->AgregarSlide($this->descripcion, $this->video, $this->backgroundcolor, $this->opacidad, $this->titulo_slide, $this->texto_slide);
            header('location: ?view=styles&error=2');
            exit;
          }else{
            throw new Exception(2);
            }
        }else{
          header('location: ?view=paneldecontrol');
          exit;
        }
  }

  public function DeleteSlide($idslide) {
    require_once("core/models/class.Consultas.php");
    $db = new Consultas();
    $sql = $db->ConsultarExtSlide($idslide);
    $_SESSION['ext'] = $sql['ext'];
    $ruta = 'uploads/slides/'.$idslide .'.'.$_SESSION['ext'];
    if(file_exists($ruta)){
      unlink($ruta);//borra un archivo
    }
    $db->DeleteSlide($idslide);
    $resultado = "Imagen Eliminada";
    echo $resultado;
  }

  public function ListarSlide() {
    require_once("core/models/class.Consultas.php");
    $db = new Consultas();
    $db->ListarSlide();
  }

}


?>
