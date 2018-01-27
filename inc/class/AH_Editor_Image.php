<?php

	// 23.01.16 
	class AH_Editor_Image {
		private $pdo, $text, $img_name, $img_src, $img_url, $letter_count, $font, $ext = '.png',
				$width, $height, $font_size, $x, $y, $text_color,
				$font_folder, $src_folder,
				$return_text,
				$img_box = array();
		public function __construct( $text, $font, $prev_img, $textcolor ){
			$this->text = $text;
			// default, yazinin uzunluguna gore scale edicem
			$this->font_size = 50;
			$this->height    = 80;
			$this->x         = 5;
			$this->y         = 55;
			$this->src_folder  =  AH_EDITOR_IMGS_DIR;
			$this->font = AH_EDITOR_FONTS_DIR . $font . ".ttf";
			$this->text_color = $textcolor;
			if( $prev_img != "default" ) $this->delete_prev_image( $prev_img );
		}
		// her keyup da bir onceki preview resmin adini js den aliyorum ve
		// siliyorum dosyayi
		private function delete_prev_image( $prev_img ){
			$img_src = $this->src_folder . $prev_img;
			if( file_exists( $img_src ) ) unlink( $img_src );
		}
		// gelen text ile harf sayisi ayni mi kontrol et
		// eger ayni degilse burada yapilan sayiyi kabul et
		private function check_length(){
			// bosluklari kaldir
			$this->letter_count = strlen( preg_replace( "/\s/", "", $this->text ) );
			if( $this->letter_count == 0 ){
				$this->text = "Sucuoğlu";
			}
			return true; 
		}
		// fontlari varyantlar listesinden kontrol et
		// font form klasorunde font var mi, this->font direk dosya ismi ile ayni olmali
		private function check_font(){
			if( !file_exists( $this->font ) ){
				$this->return_text = "Font dosyasi yok.";
				return false;
			}
			return true;
		}
		// ayni isimli resim varsa tekrar isimlendirme icin
		private function check_name_collision(){
			return file_exists( $this->src_folder . $this->img_name . $this->ext );
		}
		// 32 karakterlik rastgele isim olustur
		private function create_name(){
			// ayni isimde var mi diye kontrol et her ihtimale karsi
			$this->img_name = Common::generate_random_string( 32 );
			if( !$this->check_name_collision() ){
				return true;
			} else {
				$this->create_name();
			}
		}
		private function calculate_img_size(){
			$max_width = 580;
			// eger maxwidth i gecmezsek resmin genisligi yazi kadar olacak
			$this->img_box = imagettfbbox( $this->font_size, 0, $this->font, $this->text );
			// 10 eklemeyince resim kucuk kaliyor yaziya
			$this->width = $this->img_box[2] + 10;
			// max width 580 i astigimiz durum
			if( $this->width > $max_width ){
				// resmin boyutu max genislige esit gecmeyecek
				$this->width = $max_width;
				// her bir karakterin tuttugu width kadar olacak font (deneysel ama tutuyor)
				if( $this->letter_count == 0 ) $this->letter_count = 34;
				$this->font_size = ( $max_width + 5 ) / $this->letter_count;
				// fontu size degistirdigimiz icin ortalama hesaplamak icim
				// yazinin koordinatlarini tekrar aliyoruz
				$this->img_box = imagettfbbox( $this->font_size, 0, $this->font, $this->text );
				// ortala beybe
				$this->x = ceil( ($this->width - $this->img_box[2] )/ 2 );
			}
		}
		// resmi olustur
		public function generate(){
			// harf sayisi kontrolu
			$this->check_length();
			// font kontrolü
			if( !$this->check_font() ) return false;
			// boyut hesaplamalari
			$this->calculate_img_size();
			if( !$this->create_name() ) return false; 
			// kaydedilecek hosting yolunu ve
			// resmi goruntulemek icin url olustur
			$this->img_url = URL_AH_EDITOR_PREVS . $this->img_name . $this->ext;
			$this->img_src = $this->src_folder . $this->img_name . $this->ext;
			// resim objesi
			$img = imagecreatetruecolor($this->width, $this->height);
			imagesavealpha( $img, true );

			// beyaz
			$bg_color = imagecolorallocatealpha( $img, 255, 255, 255, 127);
			// siyah
			switch( $this->text_color ){
				case 'siyah':
					$text_color = imagecolorallocate( $img, 0,0,0);
				break;

				case 'beyaz':
					$text_color = imagecolorallocate( $img, 255,255,255);
				break;

				case 'altin':
					$text_color = imagecolorallocate( $img, 255,189, 91);
				break;

				case 'kirmizi':
					$text_color = imagecolorallocate( $img, 255,0, 0);
				break;

				default:
					$text_color = imagecolorallocate( $img, 0,0,0);
				break;
			}
			imagefill( $img, 0, 0, $bg_color );
			// resme yaziyi yaz
			imagettftext( $img, $this->font_size, 0, $this->x, $this->y, $text_color, $this->font, $this->text);
			// patlat beybe
			imagepng( $img, $this->img_src );
			return true;
		}
		public function get_old_img(){
			return $this->img_name . $this->ext;
		}
		public function get_letter_count(){
			return $this->letter_count;
		}
		public function get_url(){
			return $this->img_url;
		}
		public function get_return_text(){
			return $this->return_text;
		}
	}