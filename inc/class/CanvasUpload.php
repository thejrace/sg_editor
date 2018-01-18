<?php

	class CanvasUpload{
        public static function action( $img, $fileurl ){
            if (strpos($img, 'data:image/png;base64') === 0) {
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                return file_put_contents($fileurl, $data);
            } else {
              return false;
            }
            return false;
        }
    }