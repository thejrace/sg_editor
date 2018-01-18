<?php

	 class ImageUpload{
        public static $ext;
        public static function action( $data, $fileurl ){
            $allowed_exts = array("image/jpeg", "image/png", "image/bmp", "image/gif");
            if( $data["error"] != 0 ) return false;
            $extarray = explode('.', $data["name"]);
            self::$ext = $extarray[count($extarray)-1];
            if( !in_array( $data["type"], $allowed_exts ) ) return false;
            return copy( $data["tmp_name"], $fileurl . "." . strtolower(self::$ext) );
        }
    }