<?php

	class EpostaBildirim {

		public static function yap( $to_data, $header, $data ){


			$mail = new phpmailer; 
		    $mail->IsSMTP(); 
		    $mail->SMTPDebug = 2; 
		    $mail->SMTPAuth = true; 
		    $mail->SMTPSecure = 'ssl'; 
		    $mail->Host = "smtp.gmail.com";
		    $mail->CharSet  = 'utf-8';
		    $mail->Port = 465; 
		    $mail->IsHTML(true);
		    $mail->Username = "ahmetkanbur@gmail.com";
		    $mail->Password = "iafxlhcstmkjwwfp";
		    $mail->setFrom('ahmetkanbur@gmail.com', 'Ahmet Kanbur');
		    $mail->addAddress('ahmetkanbur@gmail.com', 'Ahmet Kanbur');
		    //$mail->addAddress('hkanbur@gmail.com', 'Halim Kanbur');
		    $mail->isHTML(true); 
		    $mail->Subject = "Konu1";
            $mail->Body    = "obarey";

			 if(!$mail->Send()) {
			    return "Mailer Error: " . $mail->ErrorInfo;
			 } else {
			    return "Message has been sent";
			 }

		}

	}