<?php

	class Admin {
		private static $st_return_text = "";
		public static function register( $input ){
			// salt olustur
			$salt = utf8_encode( mcrypt_create_iv( 64, MCRYPT_DEV_URANDOM ) );
			$hash = hash( 'sha256', $salt . $input["pass"] );
			DB::getInstance()->insert( DBT_ADMIN, array(
				"isim" 			=> $input["isim"],
				"eposta" 		=> $input["eposta"],
				"salt" 			=> $salt,
				"pass" 			=> $hash,
				"durum" 		=> 1,
				"son_giris" 	=> Common::get_current_datetime(),
				"kayit_tarihi" 	=> Common::get_current_datetime()
			));
			if( DB::getInstance()->error() ){
				self::$st_return_text = "Hata oluştu[1][".DB::getInstance()->get_error_message()."]";
				return false;
			}
			self::$st_return_text = "Kayıt başarılı.";
			return true;
		}

		public static function login( $input ){

			$email_query = DB::getInstance()->query("SELECT * FROM " . DBT_ADMIN . " WHERE eposta = ?", array( $input["eposta"]));
			if( $email_query->count() ==  1 ){
				$user_data = $email_query->results();
				$user_salt = $user_data[0]["salt"];
				$user_pass = $user_data[0]["pass"];
				$user_id   = $user_data[0]["id"];
			} else {	
				self::$st_return_text = "Eposta veya şifre yanlış.";
				return false;
			}
			// sifre kontrolu
			$input_pass = hash( 'sha256', $user_salt . $input["pass"] );
			if( $input_pass != $user_pass ){
				self::$st_return_text = "Eposta veya şifre yanlış.";
				return false;
			}

			$_SESSION["admin_id"] 	= $user_id;
			$_SESSION["admin_name"] 	= $user_data[0]["isim"];
			$_SESSION["admin_email"] = $input["eposta"];

			self::$st_return_text = "Giriş başarılı.";
			return true;
		}

		public static function check_login(){
			return isset($_SESSION["admin_id"]) && isset($_SESSION["admin_name"]) && isset($_SESSION["admin_email"]);
		}

		public static function get_return_text(){
			return self::$st_return_text;
		}

		public static function logout(){
			if( isset($_SESSION["admin_id"])) unset($_SESSION["admin_id"]);
			if( isset($_SESSION["admin_name"])) unset($_SESSION["admin_name"]);
			if( isset($_SESSION["admin_email"])) unset($_SESSION["admin_email"]);
		}
	}