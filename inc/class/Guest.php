<?php

	class Guest {

		private static $st_return_text;
		private static $data = array();
		private static function create(){
			do {
				$randcookie = (string)time().Common::generate_random_string(30);
				$check_query = DB::getInstance()->query("SELECT * FROM " . DBT_MISAFIRLER ." WHERE cookie = ?", array($randcookie))->count();
			} while( $check_query > 0 );
			
			DB::getInstance()->insert(DBT_MISAFIRLER, array(
				"eposta" 			=> "",
				"isim"   			=> "",
				"cookie" 			=> $randcookie,
				"kayit_tarihi" 		=> Common::get_current_datetime(),
				"son_giris" 		=> Common::get_current_datetime()
			));
			if( DB::getInstance()->error() ){
				self::$st_return_text = "Hata oluştu.[1][".DB::getInstance()->get_error_message()."]";
				return false;
			}
			self::$data["user_id"] = DB::getInstance()->lastInsertedId();
			self::$data["user_email"] = "";
			self::$data["user_name"] = "";
			setCookie("sgguestck", $randcookie, time()+86400*365, "/");
		}

		// misafir cookie kontrol
		public static function check(){
			if( isset($_COOKIE["sgguestck"] ) ){
				$query = DB::getInstance()->query("SELECT * FROM " . DBT_MISAFIRLER ." WHERE cookie = ?",array( $_COOKIE["sgguestck"]))->results();
				if( count($query) == 0 ){
					self::create();
				} else {
					self::$data["user_id"] = $query[0]["id"];
					self::$data["user_email"]  = $query[0]["eposta"];
					self::$data["user_name"]    = $query[0]["isim"];
				}
			} else {
				self::create();
			}
		}

		public static function get_return_text(){
			return self::$st_return_text;
		}

		public static function get_data( $key = null ){
			if(isset($key)) return self::$data[$key];
			return self::$data;
		}

	}