<?php

	class User {

		public static $st_return_text;


		// formla login
		public static function login( $input ){

			$email_query = DB::getInstance()->query("SELECT * FROM " . DBT_KULLANICILAR . " WHERE eposta = ?", array( $input["eposta"]));
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

			// remember me kontrolu
			if( isset( $input["remember_me"] ) ){
				if( !self::update_remember_me_token($user_id) ){
					self::$st_return_text = "Bir hata oluştu[3].";
					return false;
				}
			}

			$_SESSION["user_id"] 	= $user_id;
			$_SESSION["user_name"] 	= $user_data[0]["isim"];
			$_SESSION["user_email"] = $input["eposta"];
			$_SESSION["user_telefon"] = $input["telefon"];

			self::$st_return_text = "Giriş başarılı.";
			return true;
		}

		public static function remember(){

			if( !isset($_COOKIE["sggtoken"] ) ) return false;
			$cookie = $_COOKIE["sggtoken"];
			$selector  = substr($cookie, 0, 12 );
			$validator = substr($cookie, 12 );
			
			// selector kontrolu
			$selector_query = DB::getInstance()->query("SELECT * FROM " . DBT_COOKIE_TOKENS . " WHERE selector = ? ", array($selector) )->results();
			if( count($selector_query) != 1 ) {
				self::$st_return_text = "Selector DB de yok yalanji var gene.";
				return false;
			}

			// cookie deki validator den token olustur, dbki ile karsilastir
			$cookie_token = hash( 'sha256', $validator );
			$auth_token = $selector_query[0]["token"];
			$user_id = $selector_query[0]["user_id"];
			if( !Common::hash_equals( $auth_token, $cookie_token) ){
				self::$st_return_text = "Tokenlar uyusmuyor. Yalanji var.";
				return false;
			}
			if( !self::update_remember_me_token( $selector_query[0]["user_id"] ) ){
				self::$st_return_text = "Bir hata oluştu[3].";
				return false;
			}

			$query = DB::getInstance()->query("SELECT * FROM " . DBT_KULLANICILAR . " WHERE id = ?",array( $user_id) )->results();
			$_SESSION["user_id"] 	= $query[0]["id"];
			$_SESSION["user_name"] 	= $query[0]["isim"];
			$_SESSION["user_email"] = $query[0]["eposta"];
			$_SESSION["user_telefon"] = $query[0]["telefon"];

			return true;
		}

		public static function register( $input ){
			// salt olustur
			$salt = utf8_encode( mcrypt_create_iv( 64, MCRYPT_DEV_URANDOM ) );
			$hash = hash( 'sha256', $salt . $input["pass"] );
			DB::getInstance()->insert( DBT_KULLANICILAR, array(
				"isim" 			=> $input["isim"],
				"eposta" 		=> $input["eposta"],
				"telefon" 		=> $input["telefon"],
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

		private static function update_remember_me_token( $user_id ){

			$selector  = substr( base64_encode( mcrypt_create_iv( 12, MCRYPT_DEV_URANDOM ) ), 0, 12 );
			$validator = base64_encode( mcrypt_create_iv( 32, MCRYPT_DEV_URANDOM ) );
			$token     = hash( 'sha256', $validator );
			// yeni mi ekleyecegiz yoksa update mi kontrol
			$exists_query = DB::getInstance()->query("SELECT * FROM " . DBT_COOKIE_TOKENS . " WHERE user_id = ?", array($user_id))->results();
			if( count($exists_query) == 1 ){
				DB::getInstance()->query("UPDATE " . DBT_COOKIE_TOKENS . " SET token = ?, selector = ? WHERE user_id = ?", array( $token, $selector, $user_id ) );
				if( DB::getInstance()->error() ) return false;
			} else {	
				DB::getInstance()->insert(DBT_COOKIE_TOKENS, array(
					"user_id"  => $user_id,
					"selector" => $selector,
					"token"    => $token
				));
				if( DB::getInstance()->error() ) return false;
			}
			setCookie("sggtoken", $selector.$validator, time()+86400*365, "/");
			return true;

		}

		public static function logout(){
			setcookie("sggtoken", "", time()-86400*365, "/");
			if( isset($_SESSION["user_id"])) unset($_SESSION["user_id"]);
			if( isset($_SESSION["user_name"])) unset($_SESSION["user_name"]);
			if( isset($_SESSION["user_email"])) unset($_SESSION["user_email"]);
			if( isset($_SESSION["user_telefon"])) unset($_SESSION["user_telefon"]);
		}

		public static function check_login(){
			return isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_email"]);
		}

		// tek class ile kullaniciya ulasmak icin, guest - user ayrimi bu metod içinde yapiyorum
		public static function get_data( $key = null ){
			if( self::check_login() ){
				// session data dön
				return $_SESSION[$key];
			} else {
				if( $key == "user_id" ) return $_COOKIE["sgguestck"];
				return Guest::get_data($key);
			}
		}

		public static function siparisler_download(){
			$data = array();
			$data["porselen_siparisleri"] = DB::getInstance()->query("SELECT id, gid, seri, ebat, adet FROM " . DBT_PORSELEN_SIPARISLERI . " WHERE parent_gid IS NULL && parent_item_id IS NULL && kullanici = ? && durum = ?", array( self::get_data("user_id"), 1))->results();
			// basliklarda, porselenler engraveler falan da olacak
			$data["baslik_siparisleri"] = DB::getInstance()->query("SELECT id, gid, adet FROM " . DBT_BASLIK_SIPARISLERI . " WHERE kullanici = ? && durum = ?", array( self::get_data("user_id"), 1 ))->results();
			return $data;
		}

		public static function siparisleri_onayla(){

			$html = '<table style="font-family:Trebuchet MS">
							<tr>
								<td style="text-align:center; font-size:20px">SucuoğluGranit Sipariş Bildirimi</td>
							</tr>';



			$data = self::siparisler_download();
			foreach( $data["baslik_siparisleri"] as $sip ){
				$Siparis = new BaslikSiparis( $sip["id"] );
				$Siparis->durum_degistir( Common::$SIPARIS_ONAYLANDI );

				$html .= '<tr>
							<td style="color:red">Başlık Sipariş</td>
						</tr>
						<tr>
							<td valign="middle"><img src="'.URL_UPLOADS_BASLIK.$Siparis->get_details("gid").'/PREV.png" width="100" height="100" /></td>
						</tr>
						<tr>
							<td width="100" style="font-size:13px">Müşteri: '.User::get_data("user_email").'</td>
							<td width="100" style="font-size:13px"><a href="'.URL_ADMIN_SIPARISLER.'">İncele</a></td>
						</tr>';

			}
			foreach( $data["porselen_siparisleri"] as $sip ){
				$Siparis = new PorselenSiparis( $sip["id"] );
				$Siparis->durum_degistir( Common::$SIPARIS_ONAYLANDI );

				$html .= '<tr>
							<td style="color:red">Porselen Sipariş</td>
						</tr>
						<tr>
							<td valign="middle"><img src="'.URL_UPLOADS_PORSELEN.$Siparis->get_details("gid").'/SGP.png" width="100" height="100" /></td>
						</tr>
						<tr>
							<td width="100" style="font-size:13px">Müşteri: '.User::get_data("user_email").'</td>
							<td width="100" style="font-size:13px"><a href="'.URL_ADMIN_SIPARISLER.'">İncele</a></td>
						</tr>';

			}

			$html .= "</table>";

			EpostaBildirim::yap( "", array("subject" => "Sipariş Bildirimi", "body" => $html ));


			return "Siparişler onaylandı.";
		}

	}