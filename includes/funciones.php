<?php

class Utils {
	
	public static function enviarEmail($subject, $content, $listOfAdress) {
		
		$mail = new PHPMailer ( true );
		$mail->IsSMTP ();

		try {
			$mail->Host = "mail.barbosahuerga.com.mx"; // SMTP server
			$mail->SMTPDebug = 1; // enables SMTP debug information (for testing)
			$mail->SMTPAuth = true; // enable SMTP authentication
			$mail->Host = "mail.barbosahuerga.com.mx"; // sets the SMTP server
			$mail->Port = 25; // set the SMTP port for the GMAIL server
			$mail->Username = "sendmail@barbosahuerga.com.mx"; // SMTP account username
			$mail->Password = "GCJRwaKGp{Xs"; // SMTP account password
			$mail->AddReplyTo ( 'contacto@barbosahuerga.com.mx', 'Barbosa Huerga' );
			$mail->SetFrom ( 'contacto@barbosahuerga.com.mx', 'Barbosa Huerga' );
			$mail->Subject = $subject;
			$mail->CharSet = 'UTF-8';
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			$mail->MsgHTML ( $content );
			
			foreach ( $listOfAdress as $adress ) {
				$mail->AddAddress ( $adress['correo'], $adress['nombre'] );
			}
			
			$mail->Send ();
		} catch ( phpmailerException $e ) {
			echo $e->errorMessage (); //Pretty error messages from PHPMailer
		} catch ( Exception $e ) {
			echo $e->getMessage (); //Boring error messages from anything else!
		}
	}
}
?>