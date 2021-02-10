<?php
class Conexion extends PDO {
	private $database;
	private $host;
	private $dbuser;
  private $dns;
	private $pass;
	//private $port;
  private $dbh;

    public function __construct(){
		try{
			$db_cfg = require_once("config/database.php");
      $this->dns = $db_cfg["dns"];
      $this->database	=$db_cfg["database"];
			$this->host 	=$db_cfg["host"];
  		$this->dbuser		=$db_cfg["user"];
			$this->pass		=$db_cfg["pass"];
  		//$this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena
      $this->dbh = parent::__construct($this->dns.':host='.$this->host.';dbname='.$this->database, $this->dbuser, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));

	    } catch(PDOException $e){
 	        echo  $e->getMessage();
 	    }
    }

    //función para cerrar una conexión pdo
	public function close_con(){
     	$this->dbh = null;
 	}
}

?>
