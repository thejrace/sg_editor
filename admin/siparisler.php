<?php
      require '../inc/admin_header.php';
      require '../inc/defs.php';

      if( $_POST ){

          $OK = 1;
          $TEXT = "";
          $DATA = array();

          switch( Input::get("req") ){

              case 'siparis_data_download':

                if( Input::get("item_type") == "porselen"){
                    require CLASS_DIR . "PorselenSiparis.php";
                    $PorselenSiparis = new PorselenSiparis( Input::get("item_id") );
                    $DATA = $PorselenSiparis->get_details();
                } else if( Input::get("item_type") == "baslik"){
                    require CLASS_DIR . "BaslikSiparis.php";
                    $BaslikSiparis = new BaslikSiparis( Input::get("item_id") );
                    $DATA = $BaslikSiparis->get_details();
                }

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

      $PAGE = array(
          'title'     => 'Siparişler'
      );


      $p_siparisler = DB::getInstance()->query("SELECT eklenme_tarihi, isim, durum, id, adet FROM " . DBT_PORSELEN_SIPARISLERI . " WHERE durum = ? || durum = ? ORDER BY eklenme_tarihi DESC", array( Common::$SIPARIS_VERILDI, Common::$SIPARIS_ONAYLANDI))->results();
      $b_siparisler = DB::getInstance()->query("SELECT eklenme_tarihi, isim, durum, id, adet FROM " . DBT_BASLIK_SIPARISLERI . " WHERE durum = ? || durum = ?  ORDER BY eklenme_tarihi DESC ",array( Common::$SIPARIS_VERILDI, Common::$SIPARIS_ONAYLANDI))->results();




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
                  <div class="col-md-6 col-xs-12 col-sm-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
                              <thead>
                                <tr>
                                    <th><i class="fa fa-bullhorn"></i> Tip</th>
                                    <th class="hidden-phone"><i class="fa fa-question-circle"></i> Tarih</th>
                                    <th><i class="fa fa-qty"></i> Adet</th>
                                    <th><i class="fa fa-bookmark"></i> Müşteri</th>
                                    <th><i class=" fa fa-edit"></i> Durum</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php

                                    foreach( $p_siparisler as $siparis ){

                                        echo '

                                            <tr>
                                              <td>Porselen Sipariş</td>
                                              <td class="hidden-phone">'.Common::datetime_reverse($siparis["eklenme_tarihi"]).'</td>
                                              <td>'.$siparis["adet"].' </td>
                                              <td><span>'.$siparis["isim"].'</span></td>
                                              <td><span class="label label-info label-mini">'.Common::$SIPARIS_DURUM_STR[$siparis["durum"]].'</span></td>
                                              <td>
                                                  <button class="btn btn-primary btn-xs data-download" item-id="'.$siparis["id"].'" item-type="porselen"><i class="fa fa-search"></i></button>
                                              </td>
                                          </tr>';

                                    }


                                ?>


                                
                              </tbody>
                          </table>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->


                  <div class="col-md-6 col-xs-12 col-sm-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  
                              <thead>
                                <tr>
                                      <th><i class="fa fa-bullhorn"></i> Tip</th>
                                      <th class="hidden-phone"><i class="fa fa-question-circle"></i> Tarih</th>
                                      <th><i class="fa fa-qty"></i> Adet</th>
                                      <th><i class="fa fa-bookmark"></i> Müşteri</th>
                                      <th><i class=" fa fa-edit"></i> Durum</th>
                                      <th></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    
                                      <?php

                                        foreach( $b_siparisler as $siparis ){

                                            echo '

                                                <tr>
                                                  <td>Başlık Sipariş</td>
                                                  <td class="hidden-phone">'.Common::datetime_reverse($siparis["eklenme_tarihi"]).'</td>
                                                  <td>'.$siparis["adet"].' </td>
                                                  <td><span>'.$siparis["isim"].'</span></td>
                                                  <td><span class="label label-info label-mini">'.Common::$SIPARIS_DURUM_STR[$siparis["durum"]].'</span></td>
                                                  <td>
                                                      <button class="btn btn-primary btn-xs data-download" item-id="'.$siparis["id"].'" item-type="baslik"><i class="fa fa-search"></i></button>
                                                  </td>
                                              </tr>';

                                        }


                                    ?>

                              </tbody>
                          </table>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
      <!--main content end-->

      <div id="siparis_ozet_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Sipariş İncele</h4>
               </div>
               <div class="modal-body" id="ozet_modal_content">
                    
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
               </div>
            </div>
         </div>
      </div>
      <script type="text/template" id="baslik_ozet_tema">
          <div class="row">
              <div class="col-md-12 col-xs-12 col-sm-12" style="text-align:center">
                <img src="%%IMG_SRC%%" style="display:inline-block" />
              </div>
          </div>

          <div class="row" style="margin-top:20px">
              <div class="col-md-6">
                  <ul>
                      <li>Taş: %%TAS%%</li>
                      <li>Yükseklik: %%TASW%% cm</li>
                      <li>En: %%TASH%% cm</li>
                      <li>Adet: %%ADET%%</li>
                      <li>Notlar: %%NOTLAR%%</li>
                  </ul>
              </div>
              <div class="col-md-6">
                  <ul>
                      <li>İsim: %%MISIM%%</li>
                      <li>Eposta: %%MEPOSTA%%</li>
                      <li>Telefon: %%MTELEFON%%</li>
                      <li>Tarih: %%TARIH%%</li>
                  </ul>
              </div>
          </div>
          <button type="button" class="btn btn-info siparis_detay_git" detay-src="<?php echo URL_ADMIN_BASLIK_SIPARIS_DETAY ?>%%SIP_ID%%">Detayları Gör</button>
      </script>

       <script type="text/template" id="porselen_ozet_tema">
          <div class="row">
              <div class="col-md-12 col-xs-12 col-sm-12" style="text-align:center">
                <img src="%%IMG_SRC%%" style="display:inline-block" />
              </div>
          </div>

          <div class="row" style="margin-top:20px">
              <div class="col-md-6">
                  <ul>
                      <li>Seri: %%SERI%%</li>
                      <li>Ebat: %%EBAT%%</li>
                      <li>Adet: %%ADET%%</li>
                      <li>Notlar: %%NOTLAR%%</li>
                  </ul>
              </div>
              <div class="col-md-6">
                  <ul>
                      <li>İsim: %%MISIM%%</li>
                      <li>Eposta: %%MEPOSTA%%</li>
                      <li>Telefon: %%MTELEFON%%</li>
                      <li>Tarih: %%TARIH%%</li>
                  </ul>
              </div>
          </div>
          <button type="button" class="btn btn-info siparis_detay_git" detay-src="<?php echo URL_ADMIN_PORSELEN_SIPARIS_DETAY ?>%%SIP_ID%%">Detayları Gör</button>
      </script>

      <script type="text/javascript">

          $(document).ready(function(){
              var ozet_modal = $("#siparis_ozet_modal"),
                  ozet_modal_content = $("#ozet_modal_content"),
                  baslik_ozet_tema = $("#baslik_ozet_tema"),
                  porselen_ozet_tema = $("#porselen_ozet_tema");
              $(".data-download").click(function(){
                  var item_type = this.getAttribute("item-type"),
                      tema;
                  REQ.ACTION("", {req:"siparis_data_download", item_id: this.getAttribute("item-id"), item_type:item_type}, function(res){
                      console.log(res);
                      if( item_type == "baslik" ){
                          var tas_data = JSON.parse(res.data.tas_data);
                          tema = baslik_ozet_tema.html().replace("%%IMG_SRC%%", "<?php echo URL_UPLOADS_BASLIK ?>" + res.data.gid + "/PREV.png" ).
                                                                 replace("%%TAS%%", tas_data.tas ).
                                                                 replace("%%TASW%%", tas_data.w).
                                                                 replace("%%TASH%%", tas_data.h ).
                                                                 replace("%%ADET%%", res.data.adet ).
                                                                 replace("%%NOTLAR%%", res.data.notlar).
                                                                 replace("%%MISIM%%", res.data.isim).
                                                                 replace("%%MEPOSTA%%", res.data.eposta ).
                                                                 replace("%%MTELEFON%%", res.data.telefon ).
                                                                 replace("%%TARIH%%", res.data.eklenme_tarihi ).
                                                                 replace("%%SIP_ID%%", res.data.id );
                      } else {
                          tema = porselen_ozet_tema.html().replace("%%IMG_SRC%%", "<?php echo URL_UPLOADS_PORSELEN?>" + "SGP" + res.data.gid + ".png" ).
                                                       replace("%%EBAT%%", res.data.ebat ).
                                                       replace("%%SERI%%", res.data.seri).
                                                       replace("%%ADET%%", res.data.adet ).
                                                       replace("%%NOTLAR%%", res.data.notlar).
                                                       replace("%%MISIM%%", res.data.isim).
                                                       replace("%%MEPOSTA%%", res.data.eposta ).
                                                       replace("%%MTELEFON%%", res.data.telefon ).
                                                       replace("%%TARIH%%", res.data.eklenme_tarihi ).
                                                       replace("%%SIP_ID%%", res.data.id );
                      }
                      ozet_modal_content.html( tema );
                      ozet_modal.modal('show');
                  });

              });

              $(document).on("click", ".siparis_detay_git", function(){
                  window.open(this.getAttribute("detay-src"), "_blank");
              });

          });

      </script>

 <?php


      require 'inc/footer.php';