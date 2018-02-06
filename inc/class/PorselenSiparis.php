<?php
  
  class PorselenSiparis extends DataCommon {
      public function __construct( $id = null ){
          $this->pdo = DB::getInstance();
          $this->dt_table = DBT_PORSELEN_SIPARISLERI;
          if(  is_array( $id ) ) {
              // portable porselen editor için constructor
              // id: parent_gid
              // pid: parent_item_id 
              $query = $this->pdo->query("SELECT * FROM " . $this->dt_table . " WHERE parent_gid = ? && parent_item_id = ?", array($id["parent_gid"], $id["parent_item_id"]))->results();
              if( count($query) == 1 ){
                  $this->details = $query[0];
                  $this->ok = true;
              } else {
                  $this->return_text = "Böyle bir kayıt yok.[2]";
              }
          } else {
              $this->check(array("id" ), $id );
          }
      }

      public function ekle( $postdata, $filesdata ){

          $random_fix = User::get_data("user_id") ."_" . Common::generate_random_string(30);

          // preview upload
          if( !CanvasUpload::action( $postdata["preview"], UPLOADS_DIR_PORSELEN . "SGP" . $random_fix . ".png" ) ){
              $this->return_text = "Bir hata oluştu.[1]";
              return false;
          }

          // cropped upload
          if( !CanvasUpload::action($postdata["cropped_img"], UPLOADS_DIR_PORSELEN . "SGC" . $random_fix . ".png" )){
              $this->return_text = "Bir hata oluştu.[2]";
              return false;
          }

          // orjinal resmi upload et
          if( !ImageUpload::action( $filesdata["resim"], UPLOADS_DIR_PORSELEN . "SGO" . $random_fix  ) ){
              $this->return_text = "Bir hata oluştu.[3]";
              return false;
          }

          if( $this->pdo->error()){
              $this->return_text = "Bir hata oluştu.[4]";
              return false;
          }

          $db_data_array = array(
              "kullanici"           => User::get_data("user_id"),
              "seri"                => $postdata["seri"],
              "ebat"                => $postdata["ebat"],
              "adet"                => $postdata["adet"],
              "notlar"              => $postdata["notlar"],
              "eposta"              => $postdata["eposta"],
              "telefon"             => $postdata["telefon"],
              "isim"                => $postdata["isim"],
              "gid"                 => $random_fix,
              "orjinal_resim_ext"   => ImageUpload::$ext,
              "edit_data"           => str_replace("&quot;", '"', $postdata["edit_data"]),
              "eklenme_tarihi"      => Common::get_current_datetime()
          );

          if( isset($postdata["parent_gid"]) && isset($postdata["parent_item_id"])){
              $db_data_array["parent_gid"] = $postdata["parent_gid"];
              $db_data_array["parent_item_id"] = $postdata["parent_item_id"];
          }

          // db kaydi
          $this->pdo->insert($this->dt_table, $db_data_array );
          if( $this->pdo->error()){
              $this->return_text = "Bir hata oluştu.[0]";
              return false;
          }

          // misafirin db bilgilerini guncelle
          Guest::temp_update_register( $postdata["telefon"], $postdata["eposta"], $postdata["isim"] );

          $this->return_text = "Sipariş Sepete Eklendi.";
          return true;

      }

      public function duzenle( $postdata, $filesdata ){

          if( count($filesdata) > 0 ){
              // değiştirlen resmin uzantisi, oncekiyle ayni degilse uzerine yazma yapamiyoruz
              // o yuzden once siliyoruz
              unlink( UPLOADS_DIR_PORSELEN . "SGO" . $this->details["gid"] . "." . $this->details["orjinal_resim_ext"] );

              // orjinal resmi upload et
              if( !ImageUpload::action( $filesdata["resim"], UPLOADS_DIR_PORSELEN . "SGO" . $this->details["gid"]  ) ){
                  $this->return_text = "Bir hata oluştu.[3]";
                  return false;
              }
              // yeni resmin uzantısı farklıysa db yi guncelle
              $orjinal_resim_ext = ImageUpload::$ext;
          } else {
              // resim aynı
              $orjinal_resim_ext = $this->details["orjinal_resim_ext"];
          }

          // cropped ve onizlemeyi her turlu guncelliyoruz
          if( !CanvasUpload::action( $postdata["preview"], UPLOADS_DIR_PORSELEN . "SGP" . $this->details["gid"] . ".png" ) ){
              $this->return_text = "Bir hata oluştu.[1]";
              return false;
          }


          // cropped upload ( cropper ile ugrasmadan kaydederse null geliyor )
          if( isset($postdata["cropped_img"])){
              if( !CanvasUpload::action($postdata["cropped_img"], UPLOADS_DIR_PORSELEN . "SGC" . $this->details["gid"] . ".png" )){
                  $this->return_text = "Bir hata oluştu.[2]";
                  return false;
              }
          }
          
          // db query
          $this->pdo->query("UPDATE " . $this->dt_table . " SET 
              seri = ?,
              ebat = ?,
              adet = ?,
              eposta = ?,
              telefon = ?,
              isim = ?,
              notlar = ?,
              orjinal_resim_ext = ?,
              edit_data = ? WHERE id = ?", array(
                $postdata["seri"],
                $postdata["ebat"],
                $postdata["adet"],
                $postdata["eposta"],
                $postdata["telefon"],
                $postdata["isim"],
                $postdata["notlar"],
                $orjinal_resim_ext,
                str_replace("&quot;", '"', $postdata["edit_data"]),
                $this->details["id"]
          ));
          if( $this->pdo->error()){
              $this->return_text = "Bir hata oluştu.[4][".$this->pdo->get_error_message()."]";
              return false;
          }
          $this->return_text = "Sipariş güncellendi.";
          return true;

      }

      public function sil(){
           // db den sil
           $this->pdo->query("DELETE FROM " . $this->dt_table . " WHERE id = ?",array( $this->details["id"]));

           // resimleri sil
           unlink( UPLOADS_DIR_PORSELEN . "SGO" . $this->details["gid"] . "." . $this->details["orjinal_resim_ext"] );
           unlink( UPLOADS_DIR_PORSELEN . "SGC" . $this->details["gid"] . ".png" );
           unlink( UPLOADS_DIR_PORSELEN . "SGP" . $this->details["gid"] . ".png" );

           $this->return_text = "Sipariş silindi.";
           return true;
      }

      public function ebat_guncelle( $yeniebat ){
          $this->pdo->query("UPDATE " . $this->dt_table ." SET ebat = ? WHERE id = ?",array( $yeniebat, $this->details["id"]));
          $this->details["ebat"] = $yeniebat;
      }

    }