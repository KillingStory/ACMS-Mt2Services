<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
$mail = new PHPMailer(true);
try
{
	$mail->SMTPDebug = 0;
	$mail->isSMTP();
	$mail->Host= MAIL_HOST;
	$mail->SMTPAuth = true;
	$mail->Username = MAIL_USER;
	$mail->Password = MAIL_PASS;
	$mail->SMTPSecure = MAIL_SECU;
	$mail->Port= MAIL_PORT; 

	$mail->setFrom(MAIL_USER, $servername.$title_add);             
	$mail->addAddress($receiver_mail);

	$mail->isHTML(true);                                                                                            
	$mail->Subject = $servername.$title_add; 
	$mail->Body = $mail_message;
	$mail->AltBody = '';
	$mail->send();
	$mail_response = "<div class='alert alert-success'>Mail has been sent successfully!</div>";
}
catch (Exception $e) 
{
	$mail_response = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}









?>