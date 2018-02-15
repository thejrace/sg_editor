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

      require CLASS_DIR . "BaslikSiparis.php";
      $BaslikSiparis = new BaslikSiparis(Input::get("item_id"));
      if( !$BaslikSiparis->is_ok() ) die("Error obarey");


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
                      <img src="<?php echo URL_UPLOADS_BASLIK . $BaslikSiparis->get_details("gid") ?>/PREV.png" />
                  </div>
                  <div class="col-md-6 col-xs-12 col-sm-12">
                      <ul>
                          <li>Müşteri: <?php echo $BaslikSiparis->get_details("isim") ?></li>
                          <li>Müşteri Telefon: <?php echo $BaslikSiparis->get_details("telefon") ?></li>
                          <li>Müşteri Eposta: <?php echo $BaslikSiparis->get_details("eposta") ?></li>
                          <li>Sipariş Tarihi: <?php echo Common::datetime_reverse($BaslikSiparis->get_details("eklenme_tarihi")) ?></li>
                          <li>Notlar: <?php echo $BaslikSiparis->get_details("notlar") ?></li>
                      </ul>
                  </div>
                
              </div><!-- /row -->

              <div class="row mt sipincele-item"> 
                  <div class="secheader">Porselenler</div>
                  <div class="row porcontent">

                      <?php

                          foreach( json_decode($BaslikSiparis->get_details("porselenler"), true)  as $key => $val ){
                              if( !isset($val["varyant"]) ) $val["varyant"] = "YOK";
                              if( !isset($val["ext"])) $val["ext"] = "png";
                              
                              echo '<div class="col-md-4 sipitem">
                                      <div class="col-md-3 col-xs-12 col-sm-12 prev-cont">
                                          <img src="'.URL_UPLOADS_BASLIK.$BaslikSiparis->get_details("gid")."/".$key.'_cropped.png" />
                                      </div>
                                      <div class="col-md-9 col-xs-12 col-sm-12">
                                          <ul>
                                              <li>Seri: '.$val["seri"].'</li>
                                              <li>Ebat: '.$val["ebat"].'</li>
                                              <li>Varyant: '.$val["varyant"].'</li>
                                              <li><button type="button" class="btn btn-xs btn-info" org-src="'.URL_UPLOADS_BASLIK.$BaslikSiparis->get_details("gid")."/".$key.'.'.$val["ext"].'"><i class="fa fa-save"></i> Resmi İndir</button></li>
                                          </ul>
                                      </div>
                                  </div>';
                          }

                      ?>

                      
                  </div>
              </div><!-- /row -->

              <div class="row mt sipincele-item"> 
                  <div class="secheader">Engraveler</div>
                  <div class="row engcontent ">
                      <?php

                          foreach( json_decode($BaslikSiparis->get_details("engraveler"), true) as $key => $val ){

                              echo '<div class="col-md-4 sipitem">
                                      <div class="col-md-6 col-xs-12 col-sm-12 prev-cont">
                                          <img src="'.URL_UPLOADS_BASLIK.$BaslikSiparis->get_details("gid")."/".$key.'_cropped.png" />
                                      </div>
                                      <div class="col-md-6 col-xs-12 col-sm-12">
                                          <ul>
                                              <li>Kod: '.$key.'</li>
                                              <li><button type="button" class="btn btn-xs btn-info" org-src="'.URL_UPLOADS_BASLIK.$BaslikSiparis->get_details("gid")."/".$key.'.'.$val["ext"].'"><i class="fa fa-save"></i> Resmi İndir</button></li>
                                          </ul>
                                      </div>
                                  </div>';

                          }

                      ?>

                  </div>
                  
              </div><!-- /row -->

              <div class="row mt sipincele-item"> 
                  <div class="secheader">Yazılar</div>
                  <div class="row yazicontent">
                        <?php

                            foreach( json_decode($BaslikSiparis->get_details("yazilar"), true) as $key => $val ){

                                echo '<div class="col-md-4 sipitem">
                                          <div class="col-md-6 col-xs-12 col-sm-12 prev-cont">
                                              <img src="'.URL_UPLOADS_BASLIK.$BaslikSiparis->get_details("gid").'/'.$key.'.png" />
                                          </div>
                                          <div class="col-md-6 col-xs-12 col-sm-12">
                                              <ul>
                                                  <li>Kod: '.$key.'</li>
                                                  <li>Yazı: '.$val["text"].'</li>
                                                  <li>Arka Plan Renk: '.$val["bg_color"].'</li>
                                                  <li>Yazı Renk: '.$val["text_color"].'</li>
                                                  <li>Font: '.$val["font"].'</li>
                                              </ul>
                                          </div>
                                      </div>';


                            }


                        ?>


                  </div>
              </div><!-- /row -->

              <div class="row mt sipincele-item"> 
                  <div class="secheader">Diğer</div>
                  <div class="row digcontent">
                      <?php

                          foreach( json_decode($BaslikSiparis->get_details("sekiller"), true) as $key => $val ){
                              if( !isset($val["varyant"] ) ) $val["varyant"] = "Yok";
                              echo '<div class="col-md-4 sipitem">
                                      <div class="col-md-6 col-xs-12 col-sm-12">
                                          <ul>
                                              <li>Kod: '.$key.'</li>
                                              <li>Ürün: '.$val["data_content"].'</li>
                                              <li>Varyant: '.$val["varyant"].'</li>
                                          </ul>
                                      </div>
                                   </div>';

                          }


                      ?>


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