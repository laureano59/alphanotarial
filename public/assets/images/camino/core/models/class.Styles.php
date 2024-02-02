<?php
class Styles {
  private $uno;
  private $dos;
  private $tres;
  private $cuatro;
  private $cinco;
  private $seis;
  private $derecha;
  private $izquierda;
  private $check;
  private $fondoimagen;
  private $fondovideo;
  private $fondocolor;

  public function Styles(){
    $templates= new Smarty();
    require_once("core/models/class.Consultas.php");
    $db = new Consultas();
    $sql = $db->cargar_styles_head(1);

    $_SESSION['idstyles'] = $sql['id'];
    $templates->assign('idstyles',$_SESSION['idstyles']);

    $templates->assign('opacidad',$sql['opacidad']);

    if($sql['styles']==1){
      $this->uno    = 'selected';
      $this->dos    = '';
      $this->tres   = '';
      $this->cuatro = '';
      $this->cinco  = '';
      $this->seis   = '';
      $templates->assign('selected1',$this->uno);
      $templates->assign('selected2',$this->dos);
      $templates->assign('selected3',$this->tres);
      $templates->assign('selected4',$this->cuatro);
      $templates->assign('selected5',$this->cinco);
      $templates->assign('selected6',$this->seis);
    }elseif($sql['styles']==2){
      $this->uno    = '';
      $this->dos    = 'selected';
      $this->tres   = '';
      $this->cuatro = '';
      $this->cinco  = '';
      $this->seis   = '';
      $templates->assign('selected1',$this->uno);
      $templates->assign('selected2',$this->dos);
      $templates->assign('selected3',$this->tres);
      $templates->assign('selected4',$this->cuatro);
      $templates->assign('selected5',$this->cinco);
      $templates->assign('selected6',$this->seis);
    }elseif($sql['styles']==3){
      $this->uno    = '';
      $this->dos    = '';
      $this->tres   = 'selected';
      $this->cuatro = '';
      $this->cinco  = '';
      $this->seis   = '';
      $templates->assign('selected1',$this->uno);
      $templates->assign('selected2',$this->dos);
      $templates->assign('selected3',$this->tres);
      $templates->assign('selected4',$this->cuatro);
      $templates->assign('selected5',$this->cinco);
      $templates->assign('selected6',$this->seis);
    }elseif($sql['styles']==4){
      $this->uno    = '';
      $this->dos    = '';
      $this->tres   = '';
      $this->cuatro = 'selected';
      $this->cinco  = '';
      $this->seis   = '';
      $templates->assign('selected1',$this->uno);
      $templates->assign('selected2',$this->dos);
      $templates->assign('selected3',$this->tres);
      $templates->assign('selected4',$this->cuatro);
      $templates->assign('selected5',$this->cinco);
      $templates->assign('selected6',$this->seis);
    }elseif($sql['styles']==5){
      $this->uno    = '';
      $this->dos    = '';
      $this->tres   = '';
      $this->cuatro = '';
      $this->cinco  = 'selected';
      $this->seis   = '';
      $templates->assign('selected1',$this->uno);
      $templates->assign('selected2',$this->dos);
      $templates->assign('selected3',$this->tres);
      $templates->assign('selected4',$this->cuatro);
      $templates->assign('selected5',$this->cinco);
      $templates->assign('selected6',$this->seis);
    }elseif($sql['styles']==6){
      $this->uno    = '';
      $this->dos    = '';
      $this->tres   = '';
      $this->cuatro = '';
      $this->cinco  = '';
      $this->seis   = 'selected';
      $templates->assign('selected1',$this->uno);
      $templates->assign('selected2',$this->dos);
      $templates->assign('selected3',$this->tres);
      $templates->assign('selected4',$this->cuatro);
      $templates->assign('selected5',$this->cinco);
      $templates->assign('selected6',$this->seis);
    }

    if ($sql['posicion']== 1){
      $this->derecha   = 'checked';
      $this->izquierda = '';
      $templates->assign('derecha',$this->derecha);
      $templates->assign('izquierda',$this->izquierda);
    }else{
      $this->derecha   = '';
      $this->izquierda = 'checked';
      $templates->assign('derecha',$this->derecha);
      $templates->assign('izquierda',$this->izquierda);
    }

    $templates->assign('mediasize',$sql['media_size']);
    if ($sql['mostrar_titulo']== 1){
      $this->check = 'checked';
      $templates->assign('mostrartitulo',$this->check);
    }else{
        $this->check = '';
      $templates->assign('mostrartitulo',$this->check);
    }
    if ($sql['mostrar_texto']== 1){
      $this->check = 'checked';
      $templates->assign('mostrartexto',$this->check);
    }else{
      $this->check = '';
      $templates->assign('mostrartexto',$this->check);
    }

    if ($sql['img_bacground_uso']== 1){
      $this->fondoimagen  = 'checked';
      $this->fondovideo   = '';
      $this->fondocolor   = '';
      $templates->assign('fondoimagenuso',$this->fondoimagen);
      $templates->assign('fondovideouso',$this->fondovideo);
      $templates->assign('fondocoloruso',$this->fondocolor);

    }elseif ($sql['video_bacground_uso']== 1){
      $this->fondoimagen  = '';
      $this->fondovideo   = 'checked';
      $this->fondocolor   = '';
      $templates->assign('fondoimagenuso',$this->fondoimagen);
      $templates->assign('fondovideouso',$this->fondovideo);
      $templates->assign('fondocoloruso',$this->fondocolor);
    }elseif ($sql['color_bacground_uso']== 1){
      $this->fondoimagen  = '';
      $this->fondovideo   = '';
      $this->fondocolor   = 'checked';
      $templates->assign('fondoimagenuso',$this->fondoimagen);
      $templates->assign('fondovideouso',$this->fondovideo);
      $templates->assign('fondocoloruso',$this->fondocolor);
      }

    $templates->assign('videobacground',$sql['video_bacground']);

    $templates->assign('colorimage',$sql['colorimage']);
    $templates->assign('colorvideo',$sql['colorvideo']);
    $templates->assign('colorcolor',$sql['colorcolor']);


    $sql2 = $db->ListarSlide();

    if(!empty($sql2)){
      foreach($sql2 as $row){
        $slide[] = array(
          'idslide'=>$row['id'],
		      'descripcion'=>$row['descripcion'],
          'videoslide'=>$row['video'],
          'colorslide'=>$row['backgroundcolor'],
          'opacidadslide'=>$row['opacidad']
		      );
	    }
	     $templates->assign('slide',$slide);
    }

    $templates->display('public/adminstyles.tpl');
  }
}

?>
