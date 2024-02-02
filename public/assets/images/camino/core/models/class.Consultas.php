<?php
require_once("core/models/class.Conexion.php");

class Consultas {

	private $con;
	public function __construct(){
		//en $this->con tenemos la conexiÃ³n con la bd pruebas
		$this->con = new Conexion();
	}


	public function tv_online_home($id){
 		try{
			$query = $this->con->prepare("SELECT src, autoplay, width, height, frameborder, scrolling FROM tv_online WHERE id = '$id'");
			$query->execute();
			$this->con->close_con();
			//return $query->fetchAll();
			return $query->fetch();
			//return fetchColumn();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function tv_online_direccion1($id){
 		try{
			$query = $this->con->prepare("SELECT src FROM tv_online WHERE id = '$id'");
			$query->execute();
			$this->con->close_con();
			//return $query->fetchAll();
			return $query->fetch();
			//return fetchColumn();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function tv_online_direccion2($id){
 		try{
			$query = $this->con->prepare("SELECT src FROM tv_online WHERE id = '$id'");
			$query->execute();
			$this->con->close_con();
			//return $query->fetchAll();
			return $query->fetch();
			//return fetchColumn();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function cargar_styles_head($id){
 		try{
			$query = $this->con->prepare("SELECT * FROM styles_home WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
			//return $query->fetchAll();
			return $query->fetch();
			//return fetchColumn();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function update_tv_online($src1, $autoplay1){
 		try{
			$query = $this->con->prepare("UPDATE tv_online SET src='$src1', autoplay='$autoplay1'
			WHERE id=1");
			$query->execute();
			$this->con->close_con();
			} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function updatestyleshead($styles, $opacidad, $posicion, $size, $titulo, $texto,
	$imagen, $inputYoutube, $video, $color, $colorimage, $colorvideo, $colorcolor, $idstyles){
		try{
			$query = $this->con->prepare("UPDATE styles_home SET styles='$styles', opacidad='$opacidad',
				posicion='$posicion', media_size='$size', mostrar_titulo='$titulo', mostrar_texto='$texto',
				img_bacground_uso='$imagen', video_bacground='$inputYoutube', video_bacground_uso='$video',
				color_bacground_uso='$color', colorimage='$colorimage', colorvideo='$colorvideo',
				colorcolor='$colorcolor'
			WHERE id='$idstyles'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
					echo  $e->getMessage();
			}
	}

	public function updatestylesext($idstyles,$nombrefoto,$ext){
 		try{
			$query = $this->con->prepare("UPDATE styles_home SET ext='$ext', nombrefoto='$nombrefoto' WHERE id='$idstyles'");
			$query->execute();
			$this->con->close_con();
			} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function updatefeaturevideo1($idfeature,$imgvideo1,$extvideo1){
 		try{
			$query = $this->con->prepare("UPDATE features SET extvideo1='$extvideo1', imgvideo1='$imgvideo1' WHERE id='$idfeature'");
			$query->execute();
			$this->con->close_con();
			} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function updatefeaturevideo2($idfeature,$imgvideo2,$extvideo2){
 		try{
			$query = $this->con->prepare("UPDATE features SET extvideo2='$extvideo2', imgvideo2='$imgvideo2' WHERE id='$idfeature'");
			$query->execute();
			$this->con->close_con();
			} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function UpdateCaption($titulo, $texto, $idstyles){
		try{
			$query = $this->con->prepare("UPDATE styles_home SET titulo='$titulo', texto='$texto'
			WHERE id='$idstyles'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
					echo  $e->getMessage();
			}
	}

	public function update_tv_home($src2, $autoplay2){
 		try{
			$query = $this->con->prepare("UPDATE tv_online SET src='$src2', autoplay='$autoplay2'
			WHERE id=2");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function getUsers($usuario, $password){
	 		try{
				$query = $this->con->prepare("SELECT * FROM users WHERE usuario='$usuario' AND pass = '$password'");
				$query->execute();
				$this->con->close_con();
				//return $query->fetchAll();
				return $query->fetch();
				//return fetchColumn();
			} catch(PDOException $e) {
	 	        echo  $e->getMessage();
	 	    }
		}

	public function getUsers2($usuario, $email){
 		try{
			$query = $this->con->prepare("SELECT * FROM users WHERE usuario='$usuario' OR email='$email'");
			$query->execute();
			$this->con->close_con();
			return $query->fetch();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function MaxId(){
 		try{
			$query = $this->con->prepare("SELECT MAX(id) AS id FROM users");
			$query->execute();
			$this->con->close_con();
			return $query->fetch();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function MaxIdAudio(){
 		try{
			$query = $this->con->prepare("SELECT MAX(id) AS id FROM audios");
			$query->execute();
			$this->con->close_con();
			return $query->fetch();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function inserta_usuarios($usuario,$password,$email,$online){
			try{
				$query = $this->con->prepare('INSERT INTO users (usuario,pass,email, estado) values (?,?,?,?)');
				$query->bindParam(1,$usuario);
				$query->bindParam(2,$password);
				$query->bindParam(3,$email);
				$query->bindParam(4,$online);
				$query->execute();
				$this->con->close_con();

			} catch(PDOException $e){
				echo  $e->getMessage();
	 	    }
		}

	public function AgregarSlide($descripcion,$video,$backgroundcolor,$opacidad,$titulo_slide,$texto_slide){
			try{
				$query = $this->con->prepare('INSERT INTO slide (descripcion,video,backgroundcolor,opacidad,titulo_slide,texto_slide) values (?,?,?,?,?,?)');
				$query->bindParam(1,$descripcion);
				$query->bindParam(2,$video);
				$query->bindParam(3,$backgroundcolor);
				$query->bindParam(4,$opacidad);
				$query->bindParam(5,$titulo_slide);
				$query->bindParam(6,$texto_slide);

				$query->execute();
				$this->con->close_con();
			} catch(PDOException $e){
				echo  $e->getMessage();
		 	  }
	}

	public function AgregarAudio($descripcion){
			try{
				$query = $this->con->prepare('INSERT INTO audios (descripcion) values (?)');
				$query->bindParam(1,$descripcion);
				$query->execute();
				$this->con->close_con();
			} catch(PDOException $e){
				echo  $e->getMessage();
		 	  }
	}

	public function ListarAudios(){
 		try{
			$query = $this->con->prepare("SELECT * FROM audios ORDER BY id DESC LIMIT 11");
			$query->execute();
			$this->con->close_con();
			return $query->fetchAll();
		} catch(PDOException $e){
 	        echo  $e->getMessage();
 	    }
	}

	public function BorrarAudios($idaudio){
 		try{
			$query = $this->con->prepare("DELETE FROM audios WHERE id ='$idaudio'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function UpdateExtslide($idslide, $ext){
 		try{
			$query = $this->con->prepare("UPDATE slide SET ext='$ext' WHERE id='$idslide'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function UpdateAudioExt($idaudio,$ext){
 		try{
			$query = $this->con->prepare("UPDATE audios SET ext='$ext' WHERE id='$idaudio'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function EditarSlide($idslide, $titulo_slide, $texto_slide, $colorslide, $opacidad){
 		try{
			$query = $this->con->prepare("UPDATE slide SET titulo_slide='$titulo_slide',
				texto_slide='$texto_slide', backgroundcolor='$colorslide', opacidad='$opacidad'
				WHERE id='$idslide'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function EditarAudio($idaudio, $descripcion){
 		try{
			$query = $this->con->prepare("UPDATE audios SET descripcion='$descripcion' WHERE id='$idaudio'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function ConsultarExtSlide($idslide){
 		try{
			$query = $this->con->prepare("SELECT ext FROM slide WHERE id='$idslide'");
			$query->execute();
			$this->con->close_con();
			return $query->fetch();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function ConsultarExtAudios($idaudio){
 		try{
			$query = $this->con->prepare("SELECT ext FROM audios WHERE id='$idaudio'");
			$query->execute();
			$this->con->close_con();
			return $query->fetch();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function DeleteSlide($idslide){
 		try{
			$query = $this->con->prepare("DELETE FROM slide WHERE id ='$idslide'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function ListarSlide(){
 		try{
			$query = $this->con->prepare("SELECT * FROM slide ORDER BY id DESC");
			$query->execute();
			$this->con->close_con();
			return $query->fetchAll();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function MaxIdSlide(){
 		try{
			$query = $this->con->prepare("SELECT MAX(id) AS id FROM slide");
			$query->execute();
			$this->con->close_con();
			return $query->fetch();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function cargar_features($id){
 		try{
			$query = $this->con->prepare("SELECT * FROM features WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
			//return $query->fetchAll();
			return $query->fetch();
			//return fetchColumn();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function UpdateFeatures($id,$modulo,$descripcionmodulo,$titulovideo1,$subtitulovideo1,
										$descripcionvideo1,$direccionvideo1,$titulovideo2,$subtitulovideo2,
										$descripcionvideo2,$direccionvideo2){
		try{
			$query = $this->con->prepare("UPDATE features SET modulo='$modulo', descripcion_modulo='$descripcionmodulo',
				titulo_video1='$titulovideo1', subtitulo_video1='$subtitulovideo1', descripcion_video1='$descripcionvideo1',
				direccion_video1='$direccionvideo1', titulo_video2='$titulovideo2', subtitulo_video2='$subtitulovideo2',
				descripcion_video2='$descripcionvideo2', direccion_video2='$direccionvideo2'
			WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
					echo  $e->getMessage();
			}
	}

	public function Cargar_Footer($id){
 		try{
			$query = $this->con->prepare("SELECT * FROM empresa WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
			//return $query->fetchAll();
			return $query->fetch();
			//return fetchColumn();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function UpdateEmpresa($id,$telefono,$movil,$email,$direccion,$ciudad,$copyright){
		try{
			$query = $this->con->prepare("UPDATE empresa SET telefono='$telefono', movil='$movil',
				email='$email', direccion='$direccion', ciudad='$ciudad', copyright='$copyright'
			WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
					echo  $e->getMessage();
			}
	}

	public function GalFotos(){
 		try{
			$query = $this->con->prepare("SELECT * FROM galfotos ORDER BY id ASC");
			$query->execute();
			$this->con->close_con();
			return $query->fetchAll();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function UpdateGalFotoExt($id,$ext){
 		try{
			$query = $this->con->prepare("UPDATE galfotos SET ext='$ext' WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function Cargar_Titulo_Gal($id){
 		try{
			$query = $this->con->prepare("SELECT * FROM titulos_gal WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
			//return $query->fetchAll();
			return $query->fetch();
			//return fetchColumn();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function Cargar_Titulo_Head($id){
 		try{
			$query = $this->con->prepare("SELECT titulo,texto FROM styles_home WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
			//return $query->fetchAll();
			return $query->fetch();
			//return fetchColumn();
		} catch(PDOException $e) {
 	        echo  $e->getMessage();
 	    }
	}

	public function UpdateTitulosGal($id,$titulo,$descripcion){
		try{
			$query = $this->con->prepare("UPDATE titulos_gal SET titulo='$titulo', descripcion='$descripcion'
				WHERE id='$id'");
			$query->execute();
			$this->con->close_con();
		} catch(PDOException $e) {
					echo  $e->getMessage();
			}
	}

}
?>
