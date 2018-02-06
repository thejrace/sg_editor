<?php

      require '../inc/admin_header.php';
      require '../inc/defs.php';

      if( $_POST ){

          $OK = 1;
          $TEXT = "";
          $DATA = array();

          require CLASS_DIR . "IletisimForm.php";

          switch( Input::get("req") ){

              case 'data_download':

                  $Mesaj = new IletisimForm( Input::get("item_id") );
                  $DATA = $Mesaj->get_details();

              break;

              case 'data_remove':

                  $Mesaj = new IletisimForm( Input::get("item_id") );
                  $Mesaj->sil();
                  $TEXT = $Mesaj->get_return_text();

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
          'title'     => 'Siteden Mesajlar'
      );

      $m_data = DB::getInstance()->query("SELECT * FROM " . DBT_ILETISIM_FORMLARI . " ORDER BY tarih DESC")->results();

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
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  
                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Eposta</th>
                                  <th class="hidden-phone"><i class="fa fa-question-circle"></i> Konu</th>
                                  <th><i class="fa fa-clock"></i> Mesaj</th>
                                  <th><i class=" fa fa-edit"></i> Tarih</th>
                                  <th></th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                                foreach( $m_data as $md ){
                                  echo '<tr>
                                          <td>'.$md["eposta"].'</td>
                                          <td class="hidden-phone">'.$md["konu"].'</td>
                                          <td>'.substr($md["mesaj"], 0, 20 ).'...</td>
                                          <td>'.Common::datetime_reverse($md["tarih"]).'</td>
                                          <td>
                                              <button class="btn btn-success btn-xs data-download" item-id="'.$md["id"].'"><i class="fa fa-search"></i></button>
                                              <button class="btn btn-danger btn-xs data-remove" item-id="'.$md["id"].'"><i class="fa fa-times"></i></button>
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

      <div id="ozet_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Mesaj İncele</h4>
               </div>
               <div class="modal-body" id="ozet_modal_content">
                    
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
               </div>
            </div>
         </div>
      </div>

      <script type="text/template" id="mesaj_tema">
          <div class="row">
              <div>Eposta:</div>
              <div><input type="text" disabled class="form-control disabled" value="%%EPOSTA%%"/></div>
          </div>
          <div class="row">
              <div>Konu:</div>
              <div><input type="text" disabled class="form-control disabled" value="%%KONU%%"/></div>
          </div>
          <div class="row">
              <div>MESAJ:</div>
              <div><textarea disabled class="form-control disabled">%%MESAJ%%</textarea></div>
          </div>
      </script>

      <script type="text/javascript">

          $(document).ready(function(){
              var ozet_modal = $("#ozet_modal"),
                  ozet_modal_content = $("#ozet_modal_content"),
                  mesaj_tema = $("#mesaj_tema");

              $(".data-download").click(function(){
                  REQ.ACTION("", { req:"data_download", item_id:this.getAttribute("item-id")}, function(res){
                      //console.log(res);
                      var tema = mesaj_tema.html().replace("%%EPOSTA%%", res.data.eposta ).
                                            replace("%%KONU%%", res.data.konu ).
                                            replace("%%MESAJ%%", res.data.mesaj );
                      ozet_modal_content.html( tema );
                      ozet_modal.modal('show');
                  });
              });

              $(".data-remove").click(function(){
                  var c = confirm("Mesajı silmek istediğinize emin misiniz?");
                  if( !c ) return;
                  var _this = $(this);
                  REQ.ACTION("", { req:"data_remove", item_id:this.getAttribute("item-id")}, function(res){
                      //console.log(res);
                      _this.parent().parent().remove();
                      PamiraNotify("success", "İşlem Tamamlandı", res.text);
                  });

              });

          });

      </script>

 <?php


      require 'inc/footer.php';