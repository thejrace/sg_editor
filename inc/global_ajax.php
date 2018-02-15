<?php
	
	require 'defs.php';  



	if( $_POST ){

        $OK = 1;
        $TEXT = "";
        $DATA = array();

        switch( Input::get("req") ){

            case 'siparis_download':
                $DATA = User::siparisler_download();
            break;

            case 'siparis_sil':

                if( Input::get("type") == "porssip"){
                    require CLASS_DIR . "PorselenSiparis.php";
                    $PorselenSiparis = new PorselenSiparis( Input::get("item_id") );
                    $PorselenSiparis->sil();
                    $TEXT = $PorselenSiparis->get_return_text();
                } else if( Input::get("type") == "bassip"){
                    require CLASS_DIR . "BaslikSiparis.php";
                    $BaslikSiparis = new BaslikSiparis( Input::get("item_id") );
                    $BaslikSiparis->sil();
                    $TEXT = $BaslikSiparis->get_return_text();
                }

            break;

            case 'siparisleri_onayla':

                require CLASS_DIR_PHPMAIL . 'Exception.php';
                require CLASS_DIR_PHPMAIL . 'PHPMailer.php';
                require CLASS_DIR_PHPMAIL . 'SMTP.php';
                require CLASS_DIR . 'EpostaBildirim.php';
                require CLASS_DIR . "PorselenSiparis.php";
                require CLASS_DIR . "BaslikSiparis.php";
                $TEXT = User::siparisleri_onayla();

            break;

            case 'iletisim_formu':

                require CLASS_DIR_PHPMAIL . 'Exception.php';
                require CLASS_DIR_PHPMAIL . 'PHPMailer.php';
                require CLASS_DIR_PHPMAIL . 'SMTP.php';
                require CLASS_DIR . 'EpostaBildirim.php';
                require CLASS_DIR . 'IletisimForm.php';
                
                $Form = new IletisimForm;
                if( !$Form->ekle( Input::escape($_POST) ) ){
                    $OK = 0;
                }
                $TEXT = $Form->get_return_text();

            break;

            case 'temp_upload':
                require CLASS_DIR . "ImageUpload.php";
                require CLASS_DIR . "CanvasUpload.php";
                require CLASS_DIR . "TempUpload.php";

                $TempUpload = new TempUpload();
                if( Input::get("item_id") == "PORX" ){
                    if( !$TempUpload->ekle_cropped( $_POST, $_FILES, true ) ) $OK = 0;
                } else {
                    if( !$TempUpload->ekle_cropped( $_POST, $_FILES ) ) $OK = 0;
                }
                $TEXT = $TempUpload->get_return_text();

            break;

            case 'delete_temp_file':

                require CLASS_DIR . "TempUpload.php";
                $TempUpload = new TempUpload( array( "parent_gid" => Input::get("parent_gid"), "item_id" => Input::get("item_id")));
                if( $TempUpload->is_ok() ){
                    if( !$TempUpload->sil() ){
                        $OK = 0;
                    }
                } else {
                    $OK = 0;
                }
                
                $TEXT = $TempUpload->get_return_text();

            break;

        }
       
        $output = json_encode(array(
            "ok"           => $OK,           
            "text"         => $TEXT,         
            "data"         => $DATA,
            "oh"           => Input::escape($_POST)
        ));

        echo $output;
        die;

    }