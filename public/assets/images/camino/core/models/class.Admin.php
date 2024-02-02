<?php

class Admin {
  private $src1;
  private $src2;
	private $autoplay1;
	private $autoplay2;

  public function Guardar(){
    try {
      if(!empty($_POST['src1']) and !empty($_POST['src2']) and !empty($_POST['autoplay1']) and !empty($_POST['autoplay2'])){
        require_once("core/models/class.Consultas.php");
				$db = new Consultas();
				$this->src1 = $_POST['src1'];
				$this->src2 = $_POST['src2'];
        if ($_POST['autoplay1'] == 2){
          $this->autoplay1 = 0;
        }else{
          $this->autoplay1 = $_POST['autoplay1'];
        }
        if ($_POST['autoplay2'] == 2){
          $this->autoplay2 = 0;
        }else{
          $this->autoplay2 = $_POST['autoplay2'];
        }

			  $db->update_tv_online($this->src1, $this->autoplay1);
        $db->update_tv_home($this->src2, $this->autoplay2);

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
