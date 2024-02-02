<?php

require('core/functions/core.php');

if(!empty($_POST['email']) and !empty($_POST['message'])){
	$email = $_POST['email'];
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

	$mail->Subject = 'Mensaje recibido de www.iglesiavinonuevo.org';
	$mail->Body    = templatecontacto($mensaje, $email);
	$mail->AltBody = 'Hola ' . $email .' Mensaje recibido de iglesiavinonuevo.org:' . $mensaje;
	if(!$mail->send()) {
		$HTML = '<div class="alert alert-dismissible alert-danger">
	          <button type="button" class="close" data-dismiss="alert">X</button>
	          <strong>ERROR:</strong>'. $mail->ErrorInfo .'</div>';
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
		 $mail->addAddress($email, $email);     // A quien le llega el correo

		 $mail->isHTML(true);                                  // Si queremos mandar el correo con html compatible

		 $mail->Subject = 'Iglesia Vino Nuevo';
		 $mail->Body    = templatecontactorespuesta($email);

		 $mail->AltBody = 'Hola ' . $email .' Gracias por escribirnos';
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
