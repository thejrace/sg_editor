<?php

	abstract class DataCommon{

		protected $pdo, $details = array(), $ok = false, $return_text, $dt_table;

		protected function check( $db_keys = array(), $val ){
			$val_array = array();
			foreach( $db_keys as $key ) $val_array[] = $val;
			$query = $this->pdo->query("SELECT * FROM " . $this->dt_table . " WHERE " . implode( $db_keys, " = ? || ") . " = ?", $val_array )->results();
			if( count($query) == 1 ){
				$this->details = $query[0];
				$this->ok = true;
			} else {
				$this->return_text = "Böyle bir kayıt yok[1].";
			}
		}

		public function get_return_text(){
			return $this->return_text;
		}

		public function is_ok(){
			return $this->ok;
		}

		public function get_details( $key = null ){
			if( isset($key) ) return $this->details[$key];
			return $this->details;
		}

		public function durum_degistir( $durum ){
			$this->pdo->query("UPDATE " . $this->dt_table ." SET durum = ? WHERE id = ?", array( $durum, $this->details["id"]));
		}

	}