<?php


function templatecontacto($mensaje, $email) {
  $HTML = '
  <html>
  <body style="background: #FFFFFF;font-family: Verdana; font-size: 14px;color:#1c1b1b;">
  <div style="">
      <h2>Hola este es un mensaje enviado desde la página web</h2>
      <p>Enviado el día '. date('d/m/Y', time()). ' <br/> Correo de contacto : '.$email.'
	</p>
  	<p style="padding:15px;background-color:#ECF8FF;">
  			'.$mensaje.'</p>
      <p style="font-size: 9px;">&copy; '. date('Y',time()) .' '.APP_TITLE.'. Todos los derechos reservados.</p>
  </div>
  </body>
  </html>
  ';
      return $HTML;

}



?>
