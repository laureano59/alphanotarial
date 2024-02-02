<?php
if(isset($_SESSION['id'],$_SESSION['usuario'],$_SESSION['email'],$_SESSION['admin'])){

  $templates= new Smarty();
  require_once("core/models/class.Consultas.php");
  $db = new Consultas();

    if($_SESSION['admin'] == 1){

      $sql = $db->cargar_styles_head(1);

      $_SESSION['nombrefoto'] = $sql['nombrefoto'];

      $_SESSION['idstyles'] = $sql['id'];
      $templates->assign('idstyles',$_SESSION['idstyles']);

      $templates->assign('opacidad',$sql['opacidad']);

      if($sql['styles']==1){
        $uno    = 'selected';
        $dos    = '';
        $tres   = '';
        $cuatro = '';
        $cinco  = '';
        $seis   = '';
        $templates->assign('selected1',$uno);
        $templates->assign('selected2',$dos);
        $templates->assign('selected3',$tres);
        $templates->assign('selected4',$cuatro);
        $templates->assign('selected5',$cinco);
        $templates->assign('selected6',$seis);
      }elseif($sql['styles']==2){
        $uno    = '';
        $dos    = 'selected';
        $tres   = '';
        $cuatro = '';
        $cinco  = '';
        $seis   = '';
        $templates->assign('selected1',$uno);
        $templates->assign('selected2',$dos);
        $templates->assign('selected3',$tres);
        $templates->assign('selected4',$cuatro);
        $templates->assign('selected5',$cinco);
        $templates->assign('selected6',$seis);
      }elseif($sql['styles']==3){
        $uno    = '';
        $dos    = '';
        $tres   = 'selected';
        $cuatro = '';
        $cinco  = '';
        $seis   = '';
        $templates->assign('selected1',$uno);
        $templates->assign('selected2',$dos);
        $templates->assign('selected3',$tres);
        $templates->assign('selected4',$cuatro);
        $templates->assign('selected5',$cinco);
        $templates->assign('selected6',$seis);
      }elseif($sql['styles']==4){
        $uno    = '';
        $dos    = '';
        $tres   = '';
        $cuatro = 'selected';
        $cinco  = '';
        $seis   = '';
        $templates->assign('selected1',$uno);
        $templates->assign('selected2',$dos);
        $templates->assign('selected3',$tres);
        $templates->assign('selected4',$cuatro);
        $templates->assign('selected5',$cinco);
        $templates->assign('selected6',$seis);
      }elseif($sql['styles']==5){
        $uno    = '';
        $dos    = '';
        $tres   = '';
        $cuatro = '';
        $cinco  = 'selected';
        $seis   = '';
        $templates->assign('selected1',$uno);
        $templates->assign('selected2',$dos);
        $templates->assign('selected3',$tres);
        $templates->assign('selected4',$cuatro);
        $templates->assign('selected5',$cinco);
        $templates->assign('selected6',$seis);
      }elseif($sql['styles']==6){
        $uno    = '';
        $dos    = '';
        $tres   = '';
        $cuatro = '';
        $cinco  = '';
        $seis   = 'selected';
        $templates->assign('selected1',$uno);
        $templates->assign('selected2',$dos);
        $templates->assign('selected3',$tres);
        $templates->assign('selected4',$cuatro);
        $templates->assign('selected5',$cinco);
        $templates->assign('selected6',$seis);
      }

      if ($sql['posicion']== 1){
        $derecha   = 'checked';
        $izquierda = '';
        $templates->assign('derecha',$derecha);
        $templates->assign('izquierda',$izquierda);
      }else{
        $derecha   = '';
        $izquierda = 'checked';
        $templates->assign('derecha',$derecha);
        $templates->assign('izquierda',$izquierda);
      }

      $templates->assign('mediasize',$sql['media_size']);
      if ($sql['mostrar_titulo']== 1){
        $check = 'checked';
        $templates->assign('mostrartitulo',$check);
      }else{
          $check = '';
        $templates->assign('mostrartitulo',$check);
      }
      if ($sql['mostrar_texto']== 1){
        $check = 'checked';
        $templates->assign('mostrartexto',$check);
      }else{
        $check = '';
        $templates->assign('mostrartexto',$check);
      }

      if ($sql['img_bacground_uso']== 1){
        $fondoimagen  = 'checked';
        $fondovideo   = '';
        $fondocolor   = '';
        $templates->assign('fondoimagenuso',$fondoimagen);
        $templates->assign('fondovideouso',$fondovideo);
        $templates->assign('fondocoloruso',$fondocolor);

      }elseif ($sql['video_bacground_uso']== 1){
        $fondoimagen  = '';
        $fondovideo   = 'checked';
        $fondocolor   = '';
        $templates->assign('fondoimagenuso',$fondoimagen);
        $templates->assign('fondovideouso',$fondovideo);
        $templates->assign('fondocoloruso',$fondocolor);
      }elseif ($sql['color_bacground_uso']== 1){
        $fondoimagen  = '';
        $fondovideo   = '';
        $fondocolor   = 'checked';
        $templates->assign('fondoimagenuso',$fondoimagen);
        $templates->assign('fondovideouso',$fondovideo);
        $templates->assign('fondocoloruso',$fondocolor);
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


      $sql3 = $db->Cargar_Footer(1);

  		$templates->assign('telefono',$sql3['telefono']);
  		$templates->assign('movil',$sql3['movil']);
  		$templates->assign('email',$sql3['email']);
  		$templates->assign('direccion',$sql3['direccion']);
  		$templates->assign('ciudad',$sql3['ciudad']);
  		$templates->assign('copyright',$sql3['copyright']);

      $templates->display('public/adminstyles.tpl');

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
