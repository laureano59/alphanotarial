<?php

class Acceso {
  private $usuario;
  private $pass;
	private $email;
	private $session;
	private function Encrypt($string) {
    /*--------Código para encriptar pass----------*/

		$sizeof = strlen($string) - 1;//se resta 1 debido a que los arreglos inician desde cero
		$result = '';
		for($x = $sizeof; $x>=0; $x--) {
      $result .= $string{$x};
		}
		$result = md5($result);
		return $result;
	}

  public function Login() {
    try {
      if(!empty($_POST['usuario']) and !empty($_POST['pass']) and !empty($_POST['session'])) {
        require_once("core/models/class.Consultas.php");
    		$db = new Consultas();
    		$this->usuario = $_POST['usuario'];
    		$this->pass = $this->Encrypt($_POST['pass']);
    		$sql = $db->getUsers($this->usuario, $this->pass);

        if($sql){
          $online = time() + (60*5);
    			$id = $sql['id'];
    			$_SESSION['id'] = $id;
    			$_SESSION['usuario'] = $sql['usuario'];
    			$_SESSION['email'] = $sql['email'];
          $_SESSION['admin'] = $sql['admin'];
    			//$_SESSION['nombre'] = $sql['nombre'];
    			//$_SESSION['apellido'] = $sql['apellido'];
    			//$_SESSION['fecha'] = $sql['fecha'];
    			//$_SESSION['cambio'] = $sql['cambio'];
    			//$_SESSION['ext'] = $sql['ext'];
    			//$_SESSION['online'] = $online;
    			//$db->update_session($id, $online);
					/*-------Le damos el tiempo que durará la sessión en este caso dos días-----*/

					if($_POST['session'] == true) {
            ini_set('session.cookie_lifetime', time() + (60*60*24*2));
					}
          echo 1;

				}else{
          throw new Exception(2);
					}
	    }else{
        throw new exception('Error: datos vacíos');//solo se cumple cuando alguien no mande los datos por ajax, es decir cuando bugean el código fuente.
        }
    }catch(Exception $login){
      echo $login->getMessage();
      }
  }

  public function Registrar(){
    try {
      if(!empty($_POST['usuario']) and !empty($_POST['pass']) and !empty($_POST['email'])){
        require_once("core/models/class.Consultas.php");
				$db = new Consultas();
				$this->usuario = $_POST['usuario'];
				$this->pass = $this->Encrypt($_POST['pass']);
				$this->email = $_POST['email'];
				$sql = $db->getUsers2($this->usuario, $this->email);
				if(!$sql){
          $online = time() + (60*5);
					$db->inserta_usuarios($this->usuario, $this->pass, $this->email, $online);
					$sql2 = $db->MaxId();
					$id = $sql2['id'];
					$_SESSION['id'] = $id['0'];
					$_SESSION['usuario'] = $this->usuario;
					$_SESSION['email'] = $this->email;
          $_SESSION['admin'] = $sql['admin'];
					//$_SESSION['nombre'] = '';
					//$_SESSION['apellido'] = '';
					//$_SESSION['fecha'] = ''; //date('d-m-Y',time());
					//$_SESSION['cambio'] = 0;
					//$_SESSION['ext'] = 'jpg';
					$_SESSION['online'] = $online;
					echo 1;
				}else{
          if(strtolower($this->usuario)== strtolower($sql['usuario'])){
            throw new Exception(2);//ya exixte el usuario
					}else{
            throw new Exception(3);//ya exixte el email
						}
					}
      }else{
        throw new exception('Error: datos vacíos');//solo se cumple cuando alguien no mande los datos por ajax, es decir cuando bugean el código fuente.
        }
    }catch(Exception $reg){
      echo $reg->getMessage();
      }
  }
}


?>
