<?php
	
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
	

	class EpostaBildirim {

		public static function yap( $to_data, $data ){
			$mail = new PHPMailer(true);
            try {
	              //$mail->SMTPDebug = 2;
	              $mail->isSMTP();
	              $mail->Host = 'mail.sucuoglugranit.com';
	              $mail->SMTPAuth = true;
	              $mail->Username = 'admin@sucuoglugranit.com';
	              $mail->Password = 'WAzzabii308*';
	              $mail->SMTPAuth = true;
	              $mail->CharSet = 'UTF-8';
	              $mail->Port = 587;
	              $mail->SMTPOptions = array(
	                  'ssl' => array(
	                      'verify_peer' => false,
	                      'verify_peer_name' => false,
	                      'allow_self_signed' => true
	                  )
	              );

	              //Recipients
	              $mail->setFrom('admin@sucuoglugranit.com', 'Sucuoğlu Granit');
	              $mail->addAddress('ahmetkanbur@gmail.com', 'Ahmet Kanbur');     

	              //Content
	              $mail->isHTML(true);                                  
	              $mail->Subject = $data["subject"];
	              $mail->Body    = $data["body"];

	              $mail->send();
	              return true;
	        } catch (Exception $e) {
	            return false;
	        }
		}

	}