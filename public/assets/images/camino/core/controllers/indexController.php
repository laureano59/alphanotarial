<?php

$templates= new Smarty();
require('core/functions/core.php');
require_once("core/models/class.Consultas.php");
$db = new Consultas();
$sql = $db->tv_online_home(2);

$templates->assign('src',$sql[0]);
$templates->assign('autoplay',$sql['autoplay']);
$templates->assign('ancho',$sql['width']);
$templates->assign('alto',$sql['height']);
$templates->assign('borde',$sql['frameborder']);
$templates->assign('scroll',$sql['scrolling']);

$sql2=$db->cargar_styles_head(1);
$templates->assign('id',$sql2['id']);
$templates->assign('styles',$sql2['styles']);
$templates->assign('titulo',$sql2['titulo']);
$templates->assign('texto',$sql2['texto']);
$templates->assign('opacidad',$sql2['opacidad']);
$templates->assign('posicion',$sql2['posicion']);
$templates->assign('media_size',$sql2['media_size']);
$templates->assign('mostrar_titulo',$sql2['mostrar_titulo']);
$templates->assign('mostrar_texto',$sql2['mostrar_texto']);
$templates->assign('img_bacground_uso',$sql2['img_bacground_uso']);
$templates->assign('video_bacground',$sql2['video_bacground']);
$templates->assign('video_bacground_uso',$sql2['video_bacground_uso']);
$templates->assign('color_bacground_uso',$sql2['color_bacground_uso']);

$colorimage = hex2rgb($sql2['colorimage']);
$colorvideo = hex2rgb($sql2['colorvideo']);
$colorcolor = hex2rgb($sql2['colorcolor']);
$templates->assign('colorimage',$colorimage[0] . ',' . $colorimage[1] . ',' . $colorimage[2]);
$templates->assign('colorvideo',$colorvideo[0] . ',' . $colorvideo[1] . ',' . $colorvideo[2]);
$templates->assign('colorcolor',$colorcolor[0] . ',' . $colorcolor[1] . ',' . $colorcolor[2]);

$templates->assign('ext',$sql2['ext']);
$templates->assign('nombrefoto',$sql2['nombrefoto']);

$sql3 = $db->ListarSlide();

if(!empty($sql3)){
	$j=0;
	foreach($sql3 as $row){
		$j = $j+1;
    $color_slide = hex2rgb($row['backgroundcolor']);
		$slide[] = array(
		'id'=>$row['id'],
		'descripcion'=>$row['descripcion'],
		'ext'=>$row['ext'],
    'video'=>$row['video'],
    'backgroundcolor'=>$color_slide[0] . ',' . $color_slide[1] . ',' . $color_slide[2],
    'opacidad'=>$row['opacidad'],
    'titulo_slide'=>$row['titulo_slide'],
    'texto_slide'=>$row['texto_slide']
		);
	}
  $templates->assign('slide',$slide);
	$i=0;
	$templates->assign('i',$i);
	$j=$j-1;
	$templates->assign('j',$j);
}


/*----------FEATURES---------------*/

$sql4 = $db->cargar_features(1);

$templates->assign('modulo',$sql4['modulo']);
$templates->assign('descripcion_modulo',$sql4['descripcion_modulo']);
$templates->assign('titulo_video1',$sql4['titulo_video1']);
$templates->assign('subtitulo_video1',$sql4['subtitulo_video1']);
$templates->assign('descripcion_video1',$sql4['descripcion_video1']);
$templates->assign('direccion_video1',$sql4['direccion_video1']);
$templates->assign('imgvideo1',$sql4['imgvideo1']);
$templates->assign('extvideo1',$sql4['extvideo1']);

$templates->assign('titulo_video2',$sql4['titulo_video2']);
$templates->assign('subtitulo_video2',$sql4['subtitulo_video2']);
$templates->assign('descripcion_video2',$sql4['descripcion_video2']);
$templates->assign('direccion_video2',$sql4['direccion_video2']);
$templates->assign('imgvideo2',$sql4['imgvideo2']);
$templates->assign('extvideo2',$sql4['extvideo2']);

/*-----------------FOOTER-------------------*/

$sql5 = $db->Cargar_Footer(1);

$templates->assign('telefono',$sql5['telefono']);
$templates->assign('movil',$sql5['movil']);
$templates->assign('email',$sql5['email']);
$templates->assign('direccion',$sql5['direccion']);
$templates->assign('ciudad',$sql5['ciudad']);
$templates->assign('copyright',$sql5['copyright']);

$galtitulos =  $db->Cargar_Titulo_Gal(1);
$templates->assign('titulogal',$galtitulos['titulo']);
$templates->assign('descripciongal',$galtitulos['descripcion']);

$sql6 = $db->GalFotos();

if(!empty($sql6)){
	$i=0;
	foreach($sql6 as $row){
	  $gal[] = array(
		'id'=>$row['id'],
		'ext'=>$row['ext']
    );
		$i= $i + 1;
	}
  $templates->assign('gal',$gal);
	$i= $i-1;
	$x= $i;
	$templates->assign('i',$i);
	$templates->assign('x',$x);
	$j=0;
	$templates->assign('j',$j);
}


$templates->display('home/index.tpl');

?>
