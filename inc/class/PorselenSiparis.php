<?php
  
  class PorselenSiparis extends DataCommon {

      public function __construct( $id = null ){
        $this->pdo = DB::getInstance();
        $this->dt_table = DBT_PORSELEN_SIPARISLERI;
        if( isset($id) ) $this->check(array("id" ), $id );
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

          // db kaydi
          $this->pdo->insert($this->dt_table, array(
              "kullanici"           => User::get_data("user_id"),
              "seri"                => $postdata["seri"],
              "ebat"                => $postdata["ebat"],
              "adet"                => $postdata["adet"],
              "notlar"              => $postdata["notlar"],
              "gid"                 => $random_fix,
              "orjinal_resim_ext"   => ImageUpload::$ext,
              "edit_data"           => str_replace("&quot;", '"', $postdata["edit_data"]),
              "eklenme_tarihi"      => Common::get_current_datetime()
          ));
          if( $this->pdo->error()){
              $this->return_text = "Bir hata oluştu.[0]";
              return false;
          }

          $this->return_text = "Sipariş Eklendi.";
          return true;

      }

      public function duzenle( $postdata, $filesdata ){

          if( count($filesdata) > 0 ){
              // resmi değiştirilmiş, onceki resimlerin üzerine yazicaz yenileri
              // preview upload
              if( !CanvasUpload::action( $postdata["preview"], UPLOADS_DIR_PORSELEN . "SGP" . $this->details["gid"] . ".png" ) ){
                  $this->return_text = "Bir hata oluştu.[1]";
                  return false;
              }

              // cropped upload
              if( !CanvasUpload::action($postdata["cropped_img"], UPLOADS_DIR_PORSELEN . "SGC" . $this->details["gid"] . ".png" )){
                  $this->return_text = "Bir hata oluştu.[2]";
                  return false;
              }

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
          // db query
          $this->pdo->query("UPDATE " . $this->dt_table . " SET 
              seri = ?,
              ebat = ?,
              adet = ?,
              notlar = ?,
              orjinal_resim_ext = ?,
              edit_data = ? WHERE id = ?", array(
                $postdata["seri"],
                $postdata["ebat"],
                $postdata["adet"],
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

    }