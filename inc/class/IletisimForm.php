<?php

	class IletisimForm extends DataCommon {

		public function __construct( $id = null ){
			$this->pdo = DB::getInstance();
         	$this->dt_table = DBT_ILETISIM_FORMLARI;
        	if( isset($id) ) $this->check(array("id" ), $id );
		}

		public function ekle( $postdata ){

			$this->pdo->insert($this->dt_table, array(
				"eposta" 		=> $postdata["eposta"],
				"konu" 			=> $postdata["konu"],
				"mesaj" 		=> $postdata["mesaj"],
				"tarih" 		=> Common::get_current_datetime(),
				"kullanici" 	=> User::get_data("user_id")
			));

			$html = "<b>Konu:</b>".$postdata["konu"]."<br>
					 <b>Eposta:</b>".$postdata["eposta"]."<br>
					 <b>Mesaj:</b>".$postdata["mesaj"]."<br>";

			//if( !EpostaBildirim::yap(array("email" => "ahmetkanbur@gmail.com", "isim" => "Amo"), "SG İletişim Form Test", $html ) ) return false;
			$this->return_text = "Mesajınız alındı. Teşekkürler.";
			return true;

		}

		public function sil(){
			$this->pdo->query("DELETE FROM " . $this->dt_table . " WHERE id = ?", array($this->details["id"]));
			$this->return_text = "Mesaj silindi.";
		}

	}