<?php

	class BaslikSiparis extends DataCommon {

		public function __construct( $id = null ){
          	$this->pdo = DB::getInstance();
         	$this->dt_table = DBT_BASLIK_SIPARISLERI; 
        	if( isset($id) ) $this->check(array("id" ), $id );
		}

		public function ekle( $postdata ){


			$porselenler_data = json_decode(str_replace("&quot;", '"', $postdata["porselenler"]), true);
			$engraveler_data  = json_decode(str_replace("&quot;", '"', $postdata["engraveler"]), true); 
			$yazilar_data  = json_decode(str_replace("&quot;", '"', $postdata["yazilar"]), true); 

			// siparis klasoru olustur
			$siparis_dir = UPLOADS_DIR_BASLIK . $postdata["gid"];
			mkdir( $siparis_dir , 0777, true);

			foreach( $engraveler_data as $item_id => $item_data ){
				$Upload = new TempUpload( array("parent_gid" => $postdata["gid"], "item_id" => $item_id));
				if( $Upload->is_ok() ) $Upload->transfer( $siparis_dir . "/" );		
			}

			foreach( $porselenler_data as $item_id => $item_data ){
				$Upload = new TempUpload( array("parent_gid" => $postdata["gid"], "item_id" => $item_id));
				if( $Upload->is_ok() ) $Upload->transfer( $siparis_dir . "/" );	
			}

			// ah editor yazilarinin resimlerini sipariş klasorune al
			foreach( $yazilar_data as $item_id => $item_data ){
				rename( AH_EDITOR_IMGS_DIR . str_replace( URL_AH_EDITOR_PREVS, "", $item_data["prev_src"] ), $siparis_dir . "/" . $item_id . ".png" );
			}

			// onizlemeyi upload et
			if( !CanvasUpload::action( $postdata["preview"], $siparis_dir . "/PREV.png" )){
	            $this->return_text = "Bir hata oluştu.[3]";
	            return false;
	        }

	        $this->pdo->insert($this->dt_table, array(
				"gid" 				=> $postdata["gid"],
				"kullanici"   	 	=> User::get_data("user_id"),
				"notlar" 			=> $postdata["notlar"],
				"tas_data" 			=> str_replace("&quot;", '"', $postdata["tas_data"]),
				"adet" 				=> $postdata["adet"],
				"porselenler" 		=> json_encode($porselenler_data),
				"engraveler" 		=> json_encode($engraveler_data),
				"sekiller" 			=> str_replace("&quot;", '"', $postdata["sekiller"]),
				"yazilar" 			=> json_encode($yazilar_data),
				"eklenme_tarihi"    => Common::get_current_datetime(),
				"eposta"            => $postdata["eposta"],
              	"telefon"           => $postdata["telefon"],
              	"isim"              => $postdata["isim"],
				"durum"				=> 1
			));

			if( $this->pdo->error() ){
				$this->return_text = "Bir hata oluştu.[".$this->pdo->get_error_message()."]";
				return false;
			}

			// misafirin db bilgilerini guncelle
			Guest::temp_update_register( $postdata["telefon"], $postdata["eposta"], $postdata["isim"] );

			$this->return_text = "Sipariş sepete eklendi.";
			return true;
		}

		public function get_porselenler(){
			return $this->pdo->query("SELECT * FROM " . DBT_PORSELEN_SIPARISLERI . " WHERE parent_gid = ?", array( $this->details["gid"]))->results();
		}

		public function sil(){
        	// db den sil
        	$this->pdo->query("DELETE FROM " . $this->dt_table ." WHERE id = ?", array($this->details["id"])); 
        	// porselen siparisleri sil
        	$this->pdo->query("DELETE FROM " . DBT_PORSELEN_SIPARISLERI ." WHERE parent_gid = ?", array($this->details["gid"]));
        	// tum klasorü içindekilerle sil
        	array_map('unlink', glob(UPLOADS_DIR_BASLIK . $this->details["gid"]."/*.*"));
        	rmdir(UPLOADS_DIR_BASLIK . $this->details["gid"]);
        	$this->return_text = "Sipariş silindi.";
        	return true;
      	}

      	// @DEPRECATED
		public function ekle_v1( $filesdata, $postdata ){

			$porselenler_data = json_decode(str_replace("&quot;", '"', $postdata["porselenler"]), true);
			$engraveler_data  = json_decode(str_replace("&quot;", '"', $postdata["engraveler"]), true); 
			$yazilar_data  = json_decode(str_replace("&quot;", '"', $postdata["yazilar"]), true); 

			// siparis klasoru olustur
			$siparis_dir = UPLOADS_DIR_BASLIK . $postdata["gid"];
			mkdir( $siparis_dir , 0777, true);

			// engravelerin resimleri upload edicez ( cropped ve orjinal )
			foreach( $engraveler_data as $item_id => $item_data ){
				if( isset($filesdata[$item_id."_file"]) ){
					// orn: ..gid/ENG0.jpg
					if( !ImageUpload::action( $filesdata[$item_id."_file"], $siparis_dir . "/" . $item_id ) ){
			            $this->return_text = "Bir hata oluştu.[ENGUPLOAD]";
			            return false;
			        }
			        // orn: ..gid/ENG0_cropped.jpg
			        // cropped upload
			        if( !CanvasUpload::action( $item_data["cropper_img"], $siparis_dir . "/" . $item_id . "_cropped.png" )){
			            $this->return_text = "Bir hata oluştu.[2]";
			            return false;
			        }
			        $engraveler_data[$item_id]["cropper_img"] = "";
				}
			} 

			// porselenlerin resimlerini taşı
			foreach( $porselenler_data as $item_id => $item_data ){
				$PorselenSiparis = new PorselenSiparis(  array( "parent_gid" => $postdata["gid"],  "parent_item_id" => $item_id ) );
				if( $PorselenSiparis->is_ok() ){
					// porselenin resimlerini, siparis klasorune taşiyoruz
					rename( UPLOADS_DIR_PORSELEN . "SGC" . $PorselenSiparis->get_details("gid") . ".png" , $siparis_dir . "/" . $item_id . "_SGC" . ".png" );
					rename( UPLOADS_DIR_PORSELEN . "SGP" . $PorselenSiparis->get_details("gid") . ".png" , $siparis_dir . "/" . $item_id . "_SGP" . ".png" );
					rename( UPLOADS_DIR_PORSELEN . "SGO" . $PorselenSiparis->get_details("gid") . "." . $PorselenSiparis->get_details("orjinal_resim_ext"), $siparis_dir . "/" . $item_id . "_SGO" . "." . $PorselenSiparis->get_details("orjinal_resim_ext") );
				}
				// eger resmi ekledikten sonra, editörden ebatı değiştirmişse, porselen siparişin db deki kaydını da güncelliyoruz
				if( $item_data["ebat"] != $PorselenSiparis->get_details("ebat") ){
					$PorselenSiparis->ebat_guncelle( $item_data["ebat"] );
				}
			}

			// ah editor yazilarinin resimlerini sipariş klasorune al
			foreach( $yazilar_data as $item_id => $item_data ){
				rename( AH_EDITOR_IMGS_DIR . str_replace( URL_AH_EDITOR_PREVS, "", $item_data["prev_src"] ), $siparis_dir . "/" . $item_id . ".png" );
			}

			// onizlemeyi upload et
			if( !CanvasUpload::action( $postdata["preview"], $siparis_dir . "/PREV.png" )){
	            $this->return_text = "Bir hata oluştu.[3]";
	            return false;
	        }

			$this->pdo->insert($this->dt_table, array(
				"gid" 				=> $postdata["gid"],
				"kullanici"   	 	=> User::get_data("user_id"),
				"notlar" 			=> $postdata["notlar"],
				"tas_data" 			=> str_replace("&quot;", '"', $postdata["tas_data"]),
				"adet" 				=> $postdata["adet"],
				"porselenler" 		=> json_encode($porselenler_data),
				"engraveler" 		=> json_encode($engraveler_data),
				"sekiller" 			=> str_replace("&quot;", '"', $postdata["sekiller"]),
				"yazilar" 			=> json_encode($yazilar_data),
				"eklenme_tarihi"    => Common::get_current_datetime(),
				"eposta"            => $postdata["eposta"],
              	"telefon"           => $postdata["telefon"],
              	"isim"              => $postdata["isim"],
				"durum"				=> 1
			));

			if( $this->pdo->error() ){
				$this->return_text = "Bir hata oluştu.[".$this->pdo->get_error_message()."]";
				return false;
			}

			// misafirin db bilgilerini guncelle
			Guest::temp_update_register( $postdata["telefon"], $postdata["eposta"], $postdata["isim"] );

			$this->return_text = "Sipariş sepete eklendi.";
			return true;
		}


	}