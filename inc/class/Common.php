<?php

	class Common {

		public static $SIPARIS_SEPETTE = 1,
					  $SIPARIS_VERILDI = 2,
					  $SIPARIS_SILINDI = 3,
					  $SIPARIS_ONAYLANDI = 4;

		public static $SIPARIS_DURUM_STR = array(
			"", "Sepette", "Aktif", "Silindi", "Onaylandı"
		);

		// array sort ederken, hangi key onun icin tanimli
		protected static $array_key;

		public function calculate_kdv_of( $price ){
			return $price - ($price / 1.18);
		}

		public function iskontolu_fiyat( $price, $isk ){
			return $price - ( $price * $isk / 100 );
		}

		public function utf8_str_split($str='',$len=1){
		    return preg_split('/(?<=\G.{'.$len.'})/u', $str,-1,PREG_SPLIT_NO_EMPTY);
		}

		public function date_reverse( $date ){
			if( trim($date) == "" ) return null;
			$tarih_parcala = explode( "-", $date );
			$tarih_tr_format = "";
			for( $i = count($tarih_parcala)-1; $i > -1; $i-- ){
				if( $i == count($tarih_parcala)-1 ){
					$tarih_tr_format .= $tarih_parcala[$i];
				} else {
					$tarih_tr_format .= "-" . $tarih_parcala[$i];
				}
			}
			return $tarih_tr_format;
		}

		// turkce karakterli otobus hatlarini url uyumlu hale getirme
	    public function hat_turkcelestir( $hat ){
	    	if( strpos($hat, "Ç") > -1 ) $hat = str_replace( "Ç", "C.", $hat );
	    	if( strpos($hat, "Ş") > -1 ) $hat = str_replace( "Ş", "S.", $hat );
	    	if( strpos($hat, "Ü") > -1 ) $hat = str_replace( "Ü", "U.", $hat );
	    	if( strpos($hat, "Ö") > -1 ) $hat = str_replace( "Ö", "O.", $hat );
	    	if( strpos($hat, "İ") > -1 ) $hat = str_replace( "İ", "I.", $hat );
	    	return $hat;
	    }

	    public function javasrc_to_turkce( $str ){
	    	if( strpos($str, "\u011e" ) > -1 ) $str = str_replace( "\u011e", "Ğ", $str);
	    	if( strpos($str, "\u011f" ) > -1 ) $str = str_replace( "\u011f", "ğ", $str);
	    	if( strpos($str, "\u00a0" ) > -1 ) $str = str_replace( "\u00a0", "",  $str );
	    	if( strpos($str, "\u0130" ) > -1 ) $str = str_replace( "\u0130", "İ", $str);
	    	if( strpos($str, "\u0131" ) > -1 ) $str = str_replace( "\u0131", "ı", $str);
	    	if( strpos($str, "\u00fc" ) > -1 ) $str = str_replace( "\u00fc", "ü", $str);
	    	if( strpos($str, "\u00dc" ) > -1 ) $str = str_replace( "\u00dc", "Ü", $str);
	    	if( strpos($str, "\u00d6" ) > -1 ) $str = str_replace( "\u00d6", "Ö", $str);
	    	if( strpos($str, "\u00f6" ) > -1 ) $str = str_replace( "\u00f6", "ö", $str);
	    	if( strpos($str, "\u015e" ) > -1 ) $str = str_replace( "\u015e", "Ş", $str);
	    	if( strpos($str, "\u015f" ) > -1 ) $str = str_replace( "\u015f", "ş", $str);
	    	if( strpos($str, "\u00e7" ) > -1 ) $str = str_replace( "\u00e7", "ç", $str);
	    	if( strpos($str, "\u00c7" ) > -1 ) $str = str_replace( "\u00c7", "Ç", $str);

	    	return $str;
	    }

		public static function datetime_reverse( $datetime ){
			$parcala = explode( " ", $datetime );
			$tarih_tr_format = "";
			$date_parcala = explode( "-", $parcala[0] );
			for( $i = count($date_parcala)-1; $i > -1; $i-- ){
				if( $i == count($date_parcala)-1 ){
					$tarih_tr_format .= $date_parcala[$i];
				} else {
					$tarih_tr_format .= "-" . $date_parcala[$i];
				}
			}
			return $tarih_tr_format . " " . $parcala[1];
		}

		// from - to 1 den başliyor 0 degil
		public function sansur_input( $input, $from, $to ){
			$len = strlen( trim((string)$input) );
			$first_part = substr( $input, 0, $from );
			$stars = "";
			for( $i = 0; $i < $to-$from; $i++ ) $stars .= "*";
			$second_part = substr( $input, $to, $len );

			return $first_part . $stars . $second_part;
		}

		public function virgul_2dig( $price ){
			$price_str = (string)$price;
			$exp = explode(".", $price_str );
			// tam sayi geldiyse noktasiz
			if( count($exp) == 1 ){	
				return (float)( $price_str );
			} 	
			return (float)($exp[0] . '.' . substr($exp[1], 0, 2));
		}

		// floatlarda noktadan sonraki 0lar gozukmuyor nasil koyarsan koy
		// o yuzden sonraki 00 burda str olarak koyuyoruz
		public function dot_to_comma( $price ){
			$str = (string)$price;
			if( !strpos( $str, "." ) ){
				return $str . ",00";
			} else{
				$exp = explode( ".", $str );
				if( strlen($exp[1]) == 1 ){
					$str = $exp[0] . "," . $exp[1] . "0";
				}
			}
			return str_replace( ".", ",", $str );
		}

		// arrayleri sql cumlesi haline getirme
		// @count = kosul sayisi 
		// @key = sutun adi
		// @identifier = OR, AND vs.
		public static function array_to_sql( $count, $key, $identifier ){
			$query_syn = "";
			for( $i = 0; $i < $count; $i++ ){
				( $i == $count - 1 ) ? $query_syn .= " ".$key." = ? " : $query_syn .= " ".$key." = ? " . $identifier;
			}
			return $query_syn;
		}

		public static function array_php_to_js( $var_name, $array ){
			$c = 1;
			$js = "var ".$var_name." = [";
			foreach( $array as $elem ){
				$js .= $elem;
				if( $c < count($array) ) $js .= ', ';
				$c++;
			}
			$js .= "];";
			return $js;
		}

		public static function get_current_datetime(){
			return date("Y-m-d") . " " . date("H:i:s");
		}

		public static function get_current_date(){
			return date("Y-m-d");
		}

		public function get_current_monthyear(){
			return date("Y-m");
		}

		public function get_current_year(){
			return date("Y");
		}

		public static function get_ip(){
			if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    return $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    return $_SERVER['REMOTE_ADDR'];
			}
		}

		public static function get_ip_int(){
			return ip2long( self::get_ip() );
		}


		// kdv ekleme
		public static function kdv_dahil_hesaplama( $percentage, $price ){
			return $price + ( $price * $percentage / 100 );
		}

		// http://php.net/manual/tr/function.hash-equals.php
		public static function hash_equals( $str1, $str2 ){
			if( strlen($str1) != strlen($str2)) {
		    	return false;
		    } else {
		    	$res = $str1 ^ $str2;
		      	$ret = 0;
		     	for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
		     	return !$ret;
		    }
		}

		public static function sef_link($string) {
			$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
			$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
			$string = strtolower(str_replace($find, $replace, $string));
			$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
			$string = trim(preg_replace('/\s+/', ' ', $string));
			$string = str_replace(' ', '-', $string);
			return $string;
		}

		// php 5.2 ve öncesinde anonymouse fonksiyon yemiyo ayrica
		// tanimlayip taniticaksin
		public static function sort_array_key_string( $array, $key ){
			// usort fonksiyonu 2 parametre aliyor
			// ucuncuyu class uzerinden gonderiyorum
			self::$array_key = $key;

			// @array => sort edilecek array
			// @2.param => karsilastirmayi yapacak fonksiyon
			// class icinde oldugu icin array ile class ve fonksiyon ismini yaziyorum
			// eger class icinde degilsen direk fonksiyon tanimla
			usort( $array, array( 'Common', 'compare_strings' ) );

			return $array;

			/*
			php 5.2 ve oncesi icin
			function sort_str($x,$y){
				return strcasecmp( $x[$key] , $y[$key] );
			}
			usort( $array, 'sort_str');

			*/
		}


		public static function array_sort_by_column($arr, $col, $dir = SORT_ASC) {
		    $sort_col = array();
		    foreach ($arr as $key=> $row) {
		        $sort_col[$key] = self::array_key_sef($row[$col]);
		    }
			array_multisort($sort_col, $dir, $arr);
			return $arr;
		}


		// rastgele token olusturma, editor img isimlendirmesinde kullaniyorum,
		// güvenlik için kullanma aman sakın
		public static function generate_random_string( $length = 10 ){
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$chars_len = strlen($chars);
			$str = "";
			for( $i = 0; $i < $length; $i++ ){
				$str .= $chars[ rand(0, $chars_len - 1 ) ];
			}
			return $str;
		}

		public static function generate_unique_random_string( $table, $col, $length ){
			$str = self::generate_random_string( $length );
			if( DB::getInstance()->query("SELECT * FROM ". $table . " WHERE ".$col." = ?", array( $str ) )->count() != 0 ){
				self::generate_unique_random_string( $table, $col, $lenth );
			}
			return $str;
		}

		public static function sef ( $fonktmp ) {
		    $returnstr = "";
		    $turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
		    $turkceto   = array("G","U","S","I","O","C","g","u","s","i","o","c");
		    $fonktmp = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$fonktmp);
		    // Türkçe harfleri ingilizceye çevir
		    $fonktmp = preg_replace($turkcefrom,$turkceto,$fonktmp);
		    // Birden fazla olan boşlukları tek boşluk yap
		    $fonktmp = preg_replace("/ +/"," ",$fonktmp);
		    // Boşukları - işaretine çevir
		    $fonktmp = preg_replace("/ /","-",$fonktmp);
		    // Whitespace
		    $fonktmp = preg_replace("/\s/","",$fonktmp);
		    // Karekterleri küçült

		    // Başta ve sonda - işareti kaldıysa yoket
		    $fonktmp = preg_replace("/^-/","",$fonktmp);
		    $fonktmp = preg_replace("/-$/","",$fonktmp);
		    $returnstr = $fonktmp;
		    return $returnstr;
		}

		// Array key
		public static function array_key_sef ( $fonktmp ) {
			$returnstr = "";
			$turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
			$turkceto   = array("G","U","S","I","O","C","g","u","s","i","o","c");
			
			// Türkçe harfleri ingilizceye çevir
			// sondaki \. noktalari oldugu gibi birakmak icin
			$fonktmp = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç\.]/"," ",$fonktmp);
			$fonktmp = preg_replace($turkcefrom,$turkceto,$fonktmp);

			// Boşluklari kaldir
			$fonktmp = preg_replace("/\s/","",$fonktmp);


		    
		    $returnstr = $fonktmp;
		    return $returnstr;
		}

		// stringleri alfabetik siralama
		// usort fonksiyonu
		public static function compare_strings($x, $y ){
			return strcasecmp( self::array_key_sef($x[self::$array_key]) , self::array_key_sef($y[self::$array_key]) );
		}

		public static function fiyat_yaziyla($sayi) {			 
			$kurusbasamak = 2;
			$parabirimi = "Lira";
			$parakurus = "Kuruş";

			$b1 = array("", "Bir ", "İki ", "Üç ", "Dört ", "Beş ", "Altı ", "Yedi ", "Sekiz ", "Dokuz ");
			$b2 = array("", "On ", "Yirmi ", "Otuz ", "Kırk ", "Elli ", "Altmış ", "Yetmiş ", "Seksen ", "Doksan ");
			$b3 = array("", "Yüz ", "Bin ", "Milyon ", "Milyar ", "Trilyon ", "Katrilyon ");
			
			 
			$say1="";
			$say2 = ""; // say1 virgül öncesi, say2 kuruş bölümü
			$sonuc = "";
			 
			$sayi = str_replace(",", ".",$sayi); //virgül noktaya çevrilir
			 
			$nokta = strpos($sayi,"."); // nokta indeksi
			 
			if ($nokta>0) { // nokta varsa (kuruş)
				$say1 = substr($sayi,0, $nokta); // virgül öncesi
				$say2 = substr($sayi,$nokta, strlen($sayi)); // virgül sonrası, kuruş
			} else {
				$say1 = $sayi; // kuruş yoksa
			}
			 
			$son;
			$w = 1; // işlenen basamak
			$sonaekle = 0; // binler on binler yüzbinler vs. için sona bin (milyon,trilyon...) eklenecek mi?
			$kac = strlen($say1); // kaç rakam var?
			$sonint; // işlenen basamağın rakamsal değeri
			$uclubasamak = 0; // hangi basamakta (birler onlar yüzler gibi)
			$artan = 0; // binler milyonlar milyarlar gibi artışları yapar
			$gecici;
			 
			if ($kac > 0) { // virgül öncesinde rakam var mı?
				for ($i = 0; $i < $kac; $i++) {
					$son = $say1[$kac - 1 - $i]; // son karakterden başlayarak çözümleme yapılır.
					$sonint = $son; // işlenen rakam Integer.parseInt(
			 
					if ($w == 1) { // birinci basamak bulunuyor
			 
						$sonuc = $b1[$sonint] . $sonuc;
			 
					} else if ($w == 2) { // ikinci basamak
					 
						$sonuc = $b2[$sonint] . $sonuc;
					 
					} else if ($w == 3) { // 3. basamak
						if ($sonint == 1) {
							$sonuc = $b3[1] . $sonuc;
						} else if ($sonint > 1) {
							$sonuc = $b1[$sonint] . $b3[1] . $sonuc;
						}
						$uclubasamak++;
					}
			 
					if ($w > 3) { // 3. basamaktan sonraki işlemler
			 
						if ($uclubasamak == 1) {
			 
							if ($sonint > 0) {
								$sonuc = $b1[$sonint] . $b3[2 + $artan] . $sonuc;
								if ($artan == 0) { // birbin yazmasını engelle
									$sonuc = str_replace($b1[1] . $b3[2], $b3[2],$sonuc);
								}
								$sonaekle = 1; // sona bin eklendi
							} else {
								$sonaekle = 0;
							}
							$uclubasamak++;
			 
						} else if ($uclubasamak == 2) {
			 
							if ($sonint > 0) {
								if ($sonaekle > 0) {
									$sonuc = $b2[$sonint] . $sonuc;
									$sonaekle++;
								} else {
									$sonuc = $b2[$sonint] . $b3[2 + $artan] . $sonuc;
									$sonaekle++;
								}
							}
							$uclubasamak++;
			 
						} else if ($uclubasamak == 3) {
			 
							if ($sonint > 0) {
								if ($sonint == 1) {
									$gecici = $b3[1];
								} else {
									$gecici = $b1[$sonint] . $b3[1];
								}
								if ($sonaekle == 0) {
									$gecici = $gecici . $b3[2 + $artan];
								}
								$sonuc = $gecici . $sonuc;
							}
							$uclubasamak = 1;
							$artan++;
						}
			 
					}
			 
					$w++; // işlenen basamak
			 
				}
			} // if(kac>0)
			 
			if ($sonuc=="") { // virgül öncesi sayı yoksa para birimi yazma
				$parabirimi = "";
			}
			 
			$say2 = str_replace(".", "",$say2);
			$kurus = "";
			 
			if ($say2!="") { // kuruş hanesi varsa
			 
				if ($kurusbasamak > 3) { // 3 basamakla sınırlı
					$kurusbasamak = 3;
				}
				$kacc = strlen($say2);
				if ($kacc == 1) { // 2 en az
					$say2 = $say2."0"; // kuruşta tek basamak varsa sona sıfır ekler.
					$kurusbasamak = 2;
				}
				if (strlen($say2) > $kurusbasamak) { // belirlenen basamak kadar rakam yazılır
					$say2 = substr($say2,0, $kurusbasamak);
				}
			 
				$kac = strlen($say2); // kaç rakam var?
				$w = 1;
			 
				for ($i = 0; $i < $kac; $i++) { // kuruş hesabı
			 
					$son = $say2[$kac - 1 - $i]; // son karakterden başlayarak çözümleme yapılır.
					$sonint = $son; // işlenen rakam Integer.parseInt(
			 
					if ($w == 1) { // birinci basamak
			 
						if ($kurusbasamak > 0) {
							$kurus = $b1[$sonint] . $kurus;
						}
			 
					} else if ($w == 2) { // ikinci basamak
						if ($kurusbasamak > 1) {
							$kurus = $b2[$sonint] . $kurus;
						}
			 
					} else if ($w == 3) { // 3. basamak
						if ($kurusbasamak > 2) {
							if ($sonint == 1) { // 'biryüz' ü engeller
								$kurus = $b3[1] . $kurus;
							} else if ($sonint > 1) {
								$kurus = $b1[$sonint] . $b3[1] . $kurus;
							}
						}
					}
					$w++;
				}
				if ($kurus=="") { // virgül öncesi sayı yoksa para birimi yazma
					$parakurus = "";
				} else {
					$kurus = $kurus . " ";
				}
					$kurus = $kurus . $parakurus; // kuruş hanesine 'kuruş' kelimesi ekler
			}
			$sonuc = $sonuc . " " . $parabirimi . " " . $kurus;
			return $sonuc;
		}
	}