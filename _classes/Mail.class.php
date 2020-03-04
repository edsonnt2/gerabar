<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';

	class Mail{
	
	  public function sendMail($emailCliente,$nomeCliente,$assunto,$msgHTML,$msgTXT,$solicitacao=false,$anexo=false){

		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
			//Server settings
			$mail->SMTPDebug = 0;                                 // Enable verbose debug output
			$mail->isSMTP();
			$mail->CharSet='UTF-8';                                      // Set mailer to use SMTP
			$mail->Host = 'gerabar.com.br';  // HOST SITE: smtp.mailtrap.io
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'gerabar@gerabar.com.br'; // USUARIO: 8a8e694cb614c9
			$mail->Password = 'a1b2c3gerabargb'; // SENHA: 44b947e5964f21
			$mail->SMTPSecure = 'ssl'; //tls                           // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 465; // 2525                                  // TCP port to connect to
			
			if($solicitacao==false){
			//Recipients
			$mail->setFrom('no-reply@gerabar.com.br', 'Gerabar');
			$mail->addAddress($emailCliente, $nomeCliente);     // Add a recipient
			//$mail->addAddress('edson_nt2@hotmail.com', 'Edson Moda Royale');               // Name is optional
			//$mail->addReplyTo('no-reply@gerabar.com.br', 'Gerabar');
			//$mail->addCC('edson_nt2@hotmail.com');
			//$mail->addBCC('bcc@example.com');			
			}else{
			$mail->setFrom($emailCliente,$nomeCliente);
			$mail->addAddress('contato@gerabar.com.br','Solicitação');     // Add a recipient
			}
		
			if($anexo<>false){
			//Attachments
			$mail->addAttachment($anexo['tmp_name'],$anexo['name']);         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			}
		
			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = $assunto;
			$mail->Body    = $msgHTML;
			$mail->AltBody = $msgTXT;
		
			if($mail->send()){
			return true;
			}else{
			return false;
			}			
		}catch (Exception $e) {
			logError($mail->ErrorInfo);
			return false;
			//echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
				
		}
}