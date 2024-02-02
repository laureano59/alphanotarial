<?php

class Update {

  private $idstyles;
  private $styles;
  private $titulo;
  private $texto;
  private $posicion;
  private $size;
  private $imagen;
  private $color;
  private $video;
  private $colorimage;
  private $colorvideo;
  private $colorcolor;
  private $inputYoutube;
  private $opacidad;
  public function UpdateStyles(){
    try {
      if(!empty($_POST['styles']) and !empty($_POST['titulo']) and !empty($_POST['texto'])
        and !empty($_POST['posicion']) and !empty($_POST['size'])
        and !empty($_POST['imagen']) and !empty($_POST['color'])
        and !empty($_POST['video']) and !empty($_POST['colorimage'])
        and !empty($_POST['colorvideo']) and !empty($_POST['colorcolor'])
        and !empty($_POST['opacidad']) and !empty($_POST['inputYoutube'])){

        require_once("core/models/class.Consultas.php");
				$db = new Consultas();

        $this->idstyles     = $_POST['idstyles'];
        $this->styles       = $_POST['styles'];
        if($_POST['titulo'] == 2){
          $this->titulo       = 0;
        }else{
          $this->titulo       = $_POST['titulo'];
        }

        if($_POST['texto'] == 2){
          $this->texto        = 0;
        }else{
          $this->texto        = $_POST['texto'];
        }

        if($_POST['posicion'] == 2){
          $this->posicion     = 0;
        }else{
          $this->posicion     = $_POST['posicion'];
        }

        $this->size         = $_POST['size'];

        if($_POST['imagen'] == 2){
            $this->imagen       = 0;
        }else{
            $this->imagen       = $_POST['imagen'];
        }

        if($_POST['color'] == 2){
          $this->color        = 0;
        }else{
          $this->color        = $_POST['color'];
        }

        if($_POST['video'] == 2){
          $this->video        = 0;
        }else{
          $this->video        = $_POST['video'];
        }

        $this->inputYoutube = $_POST['inputYoutube'];

        $this->colorimage = $_POST['colorimage'];
        $this->colorvideo = $_POST['colorvideo'];
        $this->colorcolor = $_POST['colorcolor'];

        $this->opacidad   = $_POST['opacidad'];

        $db->updatestyleshead($this->styles, $this->opacidad, $this->posicion, $this->size,
        $this->titulo, $this->texto, $this->imagen, $this->inputYoutube,
        $this->video, $this->color, $this->colorimage, $this->colorvideo, $this->colorcolor,
        $this->idstyles);
        echo 1;

      }else{
        throw new exception('Error: datos vacíos');//solo se cumple cuando alguien no mande los datos por ajax, es decir cuando bugean el código fuente.
        }
    }catch(Exception $reg){
      echo $reg->getMessage();
      }
  }
}

?>
