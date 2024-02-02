<?php

require('core/functions/core.php');

if(!empty($_POST['name']) and !empty($_POST['email']) and !empty($_POST['message'])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $mensaje = $_POST['message'];



  $mail = new PHPMailer;

  $mail->CharSet = "UTF-8";
  $mail->Enconding = "quoted-printable";
  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->SMTPDebug = 0;
  $mail->Host = PHPMAILER_HOST;  // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = PHPMAILER_USER;                 // SMTP username
  $mail->Password = PHPMAILER_PASS;                           // SMTP password
  $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
  $mail->Port = PHPMAILER_PORT;                                    // TCP port to connect to

  $mail->setFrom(PHPMAILER_USER, APP_TITLE);         // Quien manda el correo
  $mail->addAddress(MIEMAIL, $email);     // A quien le llega el correo

  $mail->isHTML(true);                                  // Si queremos mandar el correo con html compatible

  $mail->Subject = 'Petición de Oración Recibida de www.elcaminocali.org';
  $mail->Body    = templateoracion($name, $email, $phone, $mensaje);
  $mail->AltBody = 'Petición de Oración: ' . $email .' Petición recibida de www.elcaminocali.org:' . $mensaje;

  if(!$mail->send()) {

  	$HTML = '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <strong>ERROR:</strong>'. $mail->ErrorInfo .'</div>';
            echo $HTML;
   } else {



     $mail = new PHPMailer;
  	 $mail->CharSet = "UTF-8";
  	 $mail->Enconding = "quoted-printable";
  	 $mail->isSMTP();                                      // Set mailer to use SMTP
  	 $mail->SMTPDebug = 0;
  	 $mail->Host = PHPMAILER_HOST;  // Specify main and backup SMTP servers
  	 $mail->SMTPAuth = true;                               // Enable SMTP authentication
  	 $mail->Username = PHPMAILER_USER;                 // SMTP username
  	 $mail->Password = PHPMAILER_PASS;                           // SMTP password
  	 $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
  	 $mail->Port = PHPMAILER_PORT;                                    // TCP port to connect to

  	 $mail->setFrom(PHPMAILER_USER, APP_TITLE);         // Quien manda el correo
  	 $mail->addAddress($email, $name);     // A quien le llega el correo

  	 $mail->isHTML(true);                                  // Si queremos mandar el correo con html compatible

  	 $mail->Subject = 'Iglesia El Camino Cali';
  	 $mail->Body    = templateoracionrespuesta($name);
  	 $mail->AltBody = ''.$name.'Su petición ha sido recibida, un grupo de intersesores estarán orando por tu necesidad';
  	 if(!$mail->send()) {
  	 	$HTML = '<div class="alert alert-dismissible alert-danger">
  	           <button type="button" class="close" data-dismiss="alert">X</button>
  	           <strong>ERROR:</strong>'. $mail->ErrorInfo .'</div>';
  	  } else {


  	  header('location:?view=index');

  	}

   }

}else{
  header('location:?view=index');
}



?>
