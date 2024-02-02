<?php

class Caption {
  private $titulo;
  private $texto;
	private $idstyles;

  public function Caption() {
    try{
      if(!empty($_POST['titulo']) and !empty($_POST['texto'])){
        require_once("core/models/class.Consultas.php");
        $db = new Consultas();

        $this->titulo   = $_POST['titulo'];
        $this->texto    = $_POST['texto'];
        $this->idstyles = 1;

        $db->UpdateCaption($this->titulo, $this->texto, $this->idstyles);
        header('location: ?view=caption&error=1');
        exit;

  }else{
    throw new exception('Error: datos vacíos');//solo se cumple cuando alguien no mande los datos por ajax, es decir cuando bugean el código fuente.
    }
  }catch(Exception $reg){
  echo $reg->getMessage();
  }





  }
}


?>
