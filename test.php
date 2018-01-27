<?php
    require 'inc/defs.php';
    require CLASS_DIR . "AH_Editor_Image.php";
    
    $IMGDATA = array();
    $Image = new AH_Editor_Image( "Test", "25", "dYwmvnVMqfddQyYn6Liv1QNhYgxXN08f.gif" );
    if( !$Image->generate() ){
      $OK = 0;
      $TEXT = $Image->get_return_text();
    } else {
      $IMGDATA = array(
        "src" => $Image->get_url(),
        "old_img" => $Image->get_old_img(),
        "letter_count" => $Image->get_letter_count()
      );
      // $DATA = array(
      //  "price_each_letter" => 
      //  "final_price" =>
      // );
    }

    echo '<pre>';
    print_r($IMGDATA);