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