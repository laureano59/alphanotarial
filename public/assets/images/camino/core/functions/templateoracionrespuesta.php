<?php


function templateoracionrespuesta($name) {
  $HTML = '
  <html>
  <body style="background: #FFFFFF;font-family: Verdana; font-size: 14px;color:#1c1b1b;">
  <div style="">
      <h2>Hola! '.$name.'</h2>
      <p> Ésta es la confianza que tenemos al acercarnos a Dios: que si pedimos conforme a su voluntad, él nos oye. 1 Juan 5:14</p>
  	<p style="padding:15px;background-color:#ECF8FF;">
  		Un equipo de intersesores estarán orando por tu necesidad. <br/>Dios te bendiga.</p>
      <p style="font-size: 9px;">&copy; '. date('Y',time()) .' '.APP_TITLE.'. Todos los derechos reservados.</p>
  </div>
  </body>
  </html>
  ';
      return $HTML;

}



?>
