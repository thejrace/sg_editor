<?php

class Input {
	public static $POST = "post", $GET = "get";
	public static function exists($type='post', $key) {
		switch($type) {
			case 'post':
				if( empty($_POST)) return false;
				if( isset($_POST[$key] )) return true;
				return false; 
			break;

			case 'get':
				if( empty($_GET)) return false;
				if( isset($_GET[$key] )) return true;
				return false; 
			break;

			default:
				return false;
			break;
		}
	}

	public static function escape($input) {

		if( is_array($input) ){
			$escaped = array();
			foreach ( $input as $i => $val ){
				// array seklinde gelen post inputlar icin
				// ilk versiyonda patliyordu
				if( is_array($val) ){
					// arrayin tum elemanlarini temizledikten sonra
					// kaydetme islemi yapiyoruz
					foreach( $val as $item => $item_val ){
						$val[$item] = htmlspecialchars($item_val, ENT_QUOTES, "UTF-8");
					}
					// array ayni array, elemanlar temizlendi
					$escaped[$i] = $val;
				} else{
					$escaped[$i] = htmlspecialchars($val, ENT_QUOTES, "UTF-8");
				}	
			}
			return $escaped;
		} else {
			return htmlspecialchars($input, ENT_QUOTES, "UTF-8");
		}
		
	}



	public static function get($input) {
		if(isset($_POST[$input]) ) {
			return Input::escape($_POST[$input]);
		} else if(isset($_GET[$input]) ) {
			return Input::escape($_GET[$input]);
		} else {
			throw new Exception($input . " INPUT ERROR");
		}
		// Yoksa input boş dön.
	}

}