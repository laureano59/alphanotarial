<?php


function templatecontactorespuesta($email) {
  $HTML = '
  <html>
  <body style="background: #FFFFFF;font-family: Verdana; font-size: 14px;color:#1c1b1b;">
  <div style="">
      <h2>Hola! '.$email.'</h2>
      <p>Gracias por escribirnos
	</p>
  	<p style="padding:15px;background-color:#ECF8FF;">
  			Pronto nos pondremos en contacto contigo.<br/>Bendiciones.</p>
      <p style="font-size: 9px;">&copy; '. date('Y',time()) .' '.APP_TITLE.'. Todos los derechos reservados.</p>
  </div>
  </body>
  </html>
  ';
      return $HTML;

}



?>
