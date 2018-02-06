<?php

      require '../inc/admin_header.php';
      require '../inc/defs.php';

      if( $_POST ){

          $OK = 1;
          $TEXT = "";
          $DATA = array();

          switch( Input::get("req") ){

             

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

      $PAGE = array(
          'title'     => 'Başlık Sipariş İncele'
      );

      require CLASS_DIR . "PorselenSiparis.php";
      $PorselenSiparis = new PorselenSiparis(Input::get("item_id"));
      if( !$PorselenSiparis->is_ok() || $PorselenSiparis->get_details("parent_gid") != "" ) die("Error obarey");

      require 'inc/header.php';
      require 'inc/body_header.php';



 ?>   
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> <?php echo $PAGE["title"] ?></h3>

              <div class="row mt"> 

                  <div class="col-md-4 col-xs-12 col-sm-12 baslik-prev">
                      <img src="<?php echo URL_UPLOADS_PORSELEN . "SGP" . $PorselenSiparis->get_details("gid") ?>.png" />
                  </div>
                  <div class="col-md-6 col-xs-12 col-sm-12">
                      <ul>
                          <li>Müşteri: <?php echo $PorselenSiparis->get_details("isim") ?></li>
                          <li>Müşteri Telefon: <?php echo $PorselenSiparis->get_details("telefon") ?></li>
                          <li>Müşteri Eposta: <?php echo $PorselenSiparis->get_details("eposta") ?></li>
                          <li>Sipariş Tarihi: <?php echo Common::datetime_reverse($PorselenSiparis->get_details("eklenme_tarihi")) ?></li>
                          <li>Seri: <?php echo $PorselenSiparis->get_details("seri") ?></li>
                          <li>Ebat: <?php echo $PorselenSiparis->get_details("ebat") ?></li>
                          <li>Adet: <?php echo $PorselenSiparis->get_details("adet") ?></li>
                          <li>Notlar: <?php echo $PorselenSiparis->get_details("notlar") ?></li>
                          <li><button type="button" class="btn btn-xs btn-info" org-src="<?php echo URL_UPLOADS_PORSELEN . "SGO" . $PorselenSiparis->get_details("gid") . "." . $PorselenSiparis->get_details("orjinal_resim_ext") ?>"><i class="fa fa-save"></i> Resmi İndir</button></li>
                      </ul>
                  </div>
                
              </div><!-- /row -->

             




		      </section><!--/wrapper -->
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->


      <script type="text/javascript">


          $(document).ready(function(){


          });

      </script>

 <?php


      require 'inc/footer.php';