<?php

	class TempUpload extends DataCommon {

		public function __construct( $id = null ){
          	$this->pdo = DB::getInstance();
         	$this->dt_table = DBT_TEMP_UPLOADS; 
         	if( is_array($id) ){
         		$query = $this->pdo->query("SELECT * FROM " . $this->dt_table . " WHERE parent_gid = ? && item_id = ?", array( $id["parent_gid"], $id["item_id"]))->results();
         		if( count($query) > 0 ){
	                $this->details = $query;
	                $this->ok = true;
	            } else {
	                $this->return_text = "Böyle bir kayıt yok.[2]";
	            }
         	} else {
         		if( isset($id) ) $this->check(array("id" ), $id );
         	}
		}

		public function ekle_cropped( $postdata, $filesdata, $check = false ){
			// siparişin önceki kayitlarini siliyoruz
			if( $check ){
				$this->overwrite( $postdata["parent_gid"] );
			}

			$random_fix = "TMP" . User::get_data("user_id") ."_" . Common::generate_random_string(30);
			 // cropped upload
			if( !CanvasUpload::action( $postdata["img_cropped"], UPLOADS_TEMP . $random_fix  . ".png")){
			  	$this->return_text = "Bir hata oluştu.[2]";
			  	return false;
			}
			$this->db_insert( $postdata["parent_gid"], $random_fix, "png", "cropped", $postdata["item_id"]  );
			$random_fix = "TMP" . User::get_data("user_id") ."_" . Common::generate_random_string(30);
			// orjinal resmi upload et
			if( !ImageUpload::action( $filesdata["img"], UPLOADS_TEMP . $random_fix ) ){
			  $this->return_text = "Bir hata oluştu.[3]";
			  return false;
			}
			$this->db_insert( $postdata["parent_gid"], $random_fix, ImageUpload::$ext, "orjinal", $postdata["item_id"] );
			$this->return_text = "TempUpload ok";
			return true;
		}

		private function db_insert( $parent_gid, $random_fix, $ext, $type, $item_id ){
			$this->pdo->insert($this->dt_table, array(
				"parent_gid" 	=> $parent_gid,
				"file_name"  	=> $random_fix,
				"ext" 			=> $ext,
				"type" 			=> $type,
				"item_id"		=> $item_id,
				"tarih" 		=> Common::get_current_datetime()
			));
		}

		// porselende resmi degistirdiginde önceki resmi uçur
		public function overwrite( $parent_gid ){
			$query = $this->pdo->query("SELECT * FROM " . $this->dt_table . " WHERE parent_gid = ?", array($parent_gid))->results();
			foreach( $query as $kayit ){
				unlink( UPLOADS_TEMP . $kayit["file_name"] . "." . $kayit["ext"] );
				$this->pdo->query("DELETE FROM " . $this->dt_table . " WHERE id = ?", array( $kayit["id"] ) );
			}
		}

		public function sil(){
			unlink( UPLOADS_TEMP . $this->details[0]["file_name"] . ".png"  );
			unlink( UPLOADS_TEMP . $this->details[1]["file_name"] . "." . $this->details[1]["ext"] );
			$this->pdo->query("DELETE FROM " . $this->dt_table . " WHERE id = ?", array( $this->details[0]["id"]));
			$this->pdo->query("DELETE FROM " . $this->dt_table . " WHERE id = ?", array( $this->details[1]["id"]));
			$this->return_text = "Temp dosya silindi.";
			return true;
		}

		public function transfer( $new_src ){
			rename( UPLOADS_TEMP . $this->details[0]["file_name"] . ".png", $new_src . $this->details[0]["item_id"] . "_cropped.png" );
			rename( UPLOADS_TEMP . $this->details[1]["file_name"] . "." . $this->details[1]["ext"], $new_src . $this->details[0]["item_id"] . "." . $this->details[1]["ext"] );
			// db kayitlarini sil
			$this->delete_db();
		}

		public function delete_db(){
			$this->pdo->query("DELETE FROM " . $this->dt_table . " WHERE id = ?", array( $this->details[0]["id"]));
			$this->pdo->query("DELETE FROM " . $this->dt_table . " WHERE id = ?", array( $this->details[1]["id"]));
		}

		public function get_org_ext(){
			return $this->details[1]["ext"];
		}

	}