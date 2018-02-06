<?php
    require 'inc/defs.php';
    require CLASS_DIR . "CanvasUpload.php";
    require CLASS_DIR . "ImageUpload.php";
    require CLASS_DIR . "AH_Editor_Image.php";
    require CLASS_DIR . "PorselenSiparis.php";
    require CLASS_DIR . "BaslikSiparis.php";

    
    if( $_POST ){

        $OK = 1;
        $TEXT = "";
        $DATA = array();


        switch( Input::get("req") ){

            case 'ah_editor':
                $Image = new AH_Editor_Image( Input::get("text"), Input::get("font"), Input::get("old_img"), Input::get("text_color"));
                if( !$Image->generate() ){
                    $OK = 0;
                    $TEXT = $Image->get_return_text();
                } else {
                    $DATA = array(
                        "img_src"     => $Image->get_url(),
                        "old_img"     => $Image->get_old_img()
                    );
                }
            break;

            case 'siparis_kaydet':

              $BaslikSiparis = new BaslikSiparis();
              if( !$BaslikSiparis->ekle($_FILES, Input::escape($_POST)) ) $OK = 0;
              $TEXT = $BaslikSiparis->get_return_text();

            break;

            case 'porselen_resim_kontrol':
                $pors_items = explode("#", $_POST["pors_items"]);
                $resimsiz_porselenler = array();
                foreach( $pors_items as $pors_item_parent_id ){
                    $PorselenSiparis = new PorselenSiparis( array("parent_gid" => Input::get("parent_gid"), "parent_item_id" => $pors_item_parent_id )); 
                    if( !$PorselenSiparis->is_ok() ){
                        $resimsiz_porselenler[] = $pors_item_parent_id;
                    }
                }
                if( count($resimsiz_porselenler) > 0 ){
                    $OK = 0;
                    $TEXT = implode(", ", $resimsiz_porselenler ) . " kodlu porselen(ler)e resim eklenmemiş.";
                }
            break;

        }
       
        $output = json_encode(array(
            "ok"           => $OK,           
            "text"         => $TEXT,         
            "data"         => $DATA,
            "oh"           => Input::escape($_POST),
            "foh"          => $_FILES
        ));

        echo $output;
        die;

    }
    // porselenler icin siparis gid
    $SIPARIS_ID = time().Common::generate_random_string(30);
    // js flag
    $DUZENLEME_FLAG = isset($_GET["item_id"]);

   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta content="IE=edge" http-equiv="X-UA-Compatible">
      <meta content="width=device-width,initial-scale=1" name="viewport">
      <meta content="description" name="description">
      <meta name="google" content="notranslate" />
      <meta content="Sucuoğlu Granit" name="author">
      <meta name="msapplication-tap-highlight" content="no">
      <link href="./assets/apple-icon-180x180.png" rel="apple-touch-icon">
      <link href="./assets/favicon.ico" rel="icon">
      <title>Sucuoğlu Granit</title>
      <link href="<?php echo URL_CSS ?>main.82cfd66e.css" rel="stylesheet" />
      <link href="<?php echo URL_CSS ?>/obarey.css" rel="stylesheet" />
      <link href="<?php echo URL_CSS ?>/bootstrap.css" rel="stylesheet" />
      <script type="text/javascript" src="<?php echo URL_JS ?>common.js"></script>
      <script type="text/javascript" src="<?php echo URL_JS ?>jquery.js"></script>
      <script type="text/javascript" src="<?php echo URL_JS ?>main.85741bff.js"></script>
      <script type="text/javascript" src="<?php echo URL_JS ?>bootstrap.js"></script>
      <script type="text/javascript" src="<?php echo URL_JS ?>colorpicker.js"></script>
      <link href="<?php echo URL_CSS; ?>pnotify.css" rel="stylesheet">
      <link href="<?php echo URL_CSS; ?>pnotify.buttons.css" rel="stylesheet">
      <link href="<?php echo URL_CSS; ?>pnotify.nonblock.css" rel="stylesheet">
      <link  href="<?php echo URL_CSS ?>cropper.css" rel="stylesheet">
      <script src="<?php echo URL_JS ?>cropper.js"></script>
      <script src="<?php echo URL_JS ?>jquery-ui.js"></script>
      <script src="<?php echo URL_JS ?>html2canvas.min.js"></script>
      <link href="<?php echo URL_CSS ?>jquery-ui.css" rel="stylesheet">
      <link href="<?php echo URL_CSS ?>colorpicker.css" rel="stylesheet">

      <script src="<?php echo URL_JS; ?>pnotify.js"></script>
      <script src="<?php echo URL_JS; ?>pnotify.buttons.js"></script>
      <script src="<?php echo URL_JS; ?>pnotify.nonblock.js"></script>
   </head>
   <body>
      <div class="row porselen-crop-grup section-container-spacer">
            <div class="tas siyah_granit">
            </div>
      </div>
      <div class="porselen-editor-ayarlar" >
          <h4>Taş Ayarları</h4>
      </div>
      <div class="porselen-gruplar" >
         <div class="btn-group well well-sm" role="group" aria-label="...">
              <div class="input-group">
                  <span class="input-group-addon">Taş</span>
                  <select id="tas_tip" class="form-control">
                      <option value="siyah_granit">Granit</option>
                      <option value="beyaz_mermer">Mermer</option>
                  </select>
              </div>
              <div class="input-group">
                  <span class="input-group-addon">En (cm)</span>
                  <input type="text" class="form-control" id="tas_w" value="50"/>
              </div>
              <div class="input-group">
                  <span class="input-group-addon">Boy (cm)</span>
                  <input type="text" class="form-control" id="tas_h" value="50"/>
              </div>
         </div>
         <button class="btn btn-sm btn-success" id="tas_ayar_uygula"><i class="fa fa-check"></i> Uygula</button>
      </div>
      <div class="porselen-editor-ayarlar" >
          <h4>Seçenekler</h4>
      </div>
      <div class="porselen-gruplar" >
         <div class="btn-group well well-sm" role="group" aria-label="...">
              <button class="btn btn-sm btn-default modal-init" data-target="genel_urunler_modal"><i class="fa fa-square"></i> Sık Kullanılan Ürünler</button>
              <button class="btn btn-sm btn-default modal-init" data-target="porselen_resim_modal" ><i class="fa fa-image"></i> Porselen Resim</button>
              <button class="btn btn-sm btn-default modal-init" data-target="engrave_resim_modal"><i class="fa fa-image"></i> Kazıma Resim</button>
              <button class="btn btn-sm btn-default modal-init" data-target="yazi_ekleme_modal"><i class="fa fa-italic"></i> Yazı</button>
              
         </div>
      </div>
      <div class="porselen-gruplar" >
         <div class="btn-group well well-sm" role="group" aria-label="...">
            <button class="btn btn-sm btn-success" id="finito"><i class="fa fa-check"></i> Tamamla</button>
         </div>
      </div>
      
      <div id="porselen_resim_modal" class="secim-modal modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Porselen Resim Ekle</h4>
               </div>
              <div class="modal-body">
                  <div class="row">
                      
                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Oval</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>porselen_oval.png" /></div>
                          <div class="form-part">
                              <select class="form-control ebat-select oval-seri" data="oval">
                               
                              </select> 
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success porselen-ekle" data="oval-seri" prev-src="<?php echo URL_IMGS ?>porselen_oval.png"><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Dikörtgen</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>porselen_dikdortgen.png" /></div>
                          <div class="form-part">
                              <select class="form-control ebat-select dikdortgen-seri" data="dikdortgen" >
                              
                              </select> 
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success porselen-ekle" data="dikdortgen-seri" prev-src="<?php echo URL_IMGS ?>porselen_dikdortgen.png" ><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Kare</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>porselen_kare.png" /></div>
                          <div class="form-part">
                              <select class="form-control ebat-select kare-seri"  data="kare"  >
                               
                              </select> 
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success porselen-ekle" data="kare-seri" prev-src="<?php echo URL_IMGS ?>porselen_kare.png"><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Daire</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>porselen_daire.png" /></div>
                          <div class="form-part">
                              <select class="form-control ebat-select daire-seri" data="daire"  >
                               
                              </select> 
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success porselen-ekle" data="daire-seri" prev-src="<?php echo URL_IMGS ?>porselen_daire.png"><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div>

                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Oval Kubbe</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>porselen_kubbe.png" /></div>
                          <div class="form-part">
                              <select class="form-control ebat-select kubbe-seri" data="kubbe"  >
                                
                              </select> 
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success porselen-ekle" data="kubbe-seri" prev-src="<?php echo URL_IMGS ?>porselen_kubbe.png"><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div>

                      <!-- <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Kalp</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>porselen_kalp.png" /></div>
                          <div class="form-part">
                              <select class="form-control ebat-select kalp-seri" data="kalp"  >
                                
                              </select> 
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success porselen-ekle" data="kalp-seri" prev-src="<?php echo URL_IMGS ?>porselen_kalp.png" ><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div> -->

                  </div>

              </div>
              <div class="modal-footer">
                    <!-- <button class="btn btn-sm btn-success" ><i class="fa fa-check"></i> Tamam</button> -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
              </div>
            </div>
         </div>
      </div>

      <div id="porselen_resim_upload_modal" class="modal fade" role="dialog">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Porselen Resim Ekleme</h4>
               </div>
               <div class="modal-body">
                    <div class="row" style="margin-bottom:20px">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                          <span>Resmi taşa yerleştirme işleminiz bittikten sonra <button type="button" disabled class="disabled btn btn-xs btn-success"><i class="fa fa-save"></i> Kaydet</button> butonuna basıp, işleminizi kaydedin.</span>
                        </div>
                    </div>
                    <iframe def-src="porselen_baski_editor.php" src="porselen_baski_editor.php" id="portable_porselen_editor_frame"></iframe>
               </div>
               <div class="modal-footer">
                   <button class="btn btn-sm btn-success" data-dismiss="modal"><i class="fa fa-check"></i> Bitir</button>
                   <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
               </div>
            </div>
         </div>
      </div>

      <div id="engrave_resim_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Kazım Resim Ekle</h4>
               </div>
              <div class="modal-body">
                  <div id="cropper_form">
                     <input type="file" id="upload" />
                  </div>
                  <div style="height:500px">
                     <img id="cropper_img" src="">
                  </div>
               </div>
               <div class="modal-footer">
                   <button class="btn btn-sm btn-default cropper-btn" ayar="cropperreset"><i class="fa fa-refresh"></i> Reset</button>
                   <button class="btn btn-sm btn-primary cropper-btn" ayar="cropperrleft"><i class="fa fa-rotate-left"></i></button>
                   <button class="btn btn-sm btn-primary cropper-btn" ayar="cropperrright"><i class="fa fa-rotate-right"></i></button>
                   <button class="btn btn-sm btn-success cropper-btn" ayar="cropperok"><i class="fa fa-check"></i> Tamam</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
               </div>
            </div>
         </div>
      </div>

      <div id="genel_urunler_modal" class="secim-modal modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Sık Kullanılan Ürünler</h4>
               </div>
              <div class="modal-body">
                      
                  <div class="row">

                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Bismillah Siyah</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>bsm_siyah.png" /></div>
                          <div class="form-part">
                            <select class="form-control varyant-select">
                                <option value="Siyah" prev-src="<?php echo URL_IMGS  ?>bsm_siyah.png">Siyah</option>
                                <option value="Beyaz" prev-src="<?php echo URL_IMGS  ?>bsm_beyaz.png">Beyaz</option>
                                <option value="Altın" prev-src="<?php echo URL_IMGS  ?>bsm_altin.png">Altın</option>
                             </select> 
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success genel-urun-ekle" init-width="350" init-height="68" data-type="resim" variant="1" data-content="Bismillah"><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Ay Yıldız Kumalama</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>ayyildiz_beyaz.png" /></div>
                          <div class="form-part">
                              
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success genel-urun-ekle" init-width="93" init-height="76" data-type="resim" variant="0" data-content="Ay Yıldız Kumlama" prev-src="<?php echo URL_IMGS  ?>ayyildiz_beyaz.png"><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Kumlama Bayrak</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>kumlama_bayrak.png" /></div>
                          <div class="form-part">
                              
                          </div>
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success genel-urun-ekle" init-width="93" init-height="76" data-type="resim" variant="0" data-content="Bayrak Kumlama" prev-src="<?php echo URL_IMGS  ?>kumlama_bayrak.png"><i class="fa fa-plus"></i> Ekle</button>
                          </div>
                      </div>
                  </div>


               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
               </div>
            </div>
         </div>
      </div>

      <div id="yazi_ekleme_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Yazı Ekle</h4>
               </div>
               <div class="modal-body">
                   <div class="info-col">
                    <div class="ah-editor-form">
                      <div class="preview-cont">
                        <img src="<?php echo URL_AH_EDITOR_PREVS . "editor_placeholder.png" ?>" id="editor-preview-img" alt="hege" />
                      </div>
                      <div class="form-cont">
                        <form class="form-horizontal form-label-left" action="" method="post" id="editor-form">
                          <div class="input-grup">
                            <input type="text" id="editor-text" class="editor-text" name="editor-text" placeholder="Sucuoğlu" />
                          </div>  
                              <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Font</label>
                                  <div class="col-md-7 col-sm-12 col-xs-12">
                                      <div class="font-select clearfix" >
                                        <a href="" class="font-selected" id="variant_1" value="23">
                                            <img alt="Airmole Strip" src="http://ahsaphobby.net/v2/res/img/static/font_prev/font_23.png"/>
                                        </a>
                                        <ul class="font-list">
                                           <li class="foption selected" value="23" id="variant_1"><img alt="Airmole Strip" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_23.png"/></li>
                                           <li class="foption" value="24" id="variant_1"><img alt="Script Sans" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_24.png"/></li>
                                           <li class="foption" value="25" id="variant_1"><img alt="Times New Roman" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_25.png"/></li>
                                           <li class="foption" value="27" id="variant_1"><img alt="Harabara" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_27.png"/></li>
                                           <li class="foption" value="28" id="variant_1"><img alt="Corsiva" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_28.png"/></li>
                                           <li class="foption" value="29" id="variant_1"><img alt="Allegro" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_29.png"/></li>
                                           <li class="foption" value="30" id="variant_1"><img alt="Firenze" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_30.png"/></li>
                                           <li class="foption" value="31" id="variant_1"><img alt="Jupiter" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_31.png"/></li>
                                        </ul>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Renk</label>
                                  <div class="col-md-7 col-sm-12 col-xs-12">
                                      <select class="form-control" id="ah_text_color">
                                        <option value="siyah">Siyah</option>
                                        <option value="beyaz">Beyaz</option>
                                        <option value="altin">Altın</option>
                                        <option value="kirmizi">Kırmızı</option>
                                    </select>
                                  </div>
                              </div>
                        </form>
                      </div>
                    </div>
                  </div>
               </div>
               <div class="modal-footer">
                   <button class="btn btn-sm btn-success" id="yazi_ekle" duzenleme="0" d-item-index="-1"><i class="fa fa-check"></i> Tamam</button>
                   <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
               </div>
            </div>
         </div>
      </div>

      <div id="finito_modal" class="modal fade" role="dialog">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Siparişi Tamamla</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                      <div class="col-md-7 col-xs-12 col-sm-12"> 
                          <div id="modal_preview"></div>
                      </div>
                      <div class="col-md-4 col-xs-12 col-sm-12" id="modal_form">
                          <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Adet *</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="adet" value="1" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">İsim *</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="isim" value="<?php echo Guest::get_data("user_name") ?>" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefon</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="telefon" value="<?php echo Guest::get_data("user_telefon") ?>" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Eposta</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="eposta" value="<?php echo Guest::get_data("user_email") ?>" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Notlar</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea class="form-control" id="not"></textarea> 
                                </div>
                            </div>
                          </form>
                      </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-success" id="siparis_yukle">Tamam</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                </div>
            </div>
         </div>
      </div>

      <script type="text/template" id="porselen_template">
          <div class="porselen-template %%SERI_CLASS%%" item-index="%%ITEM_INDEX%%" style="width: %%WIDTH%%px; height:%%HEIGHT%%px">
              <i action="ebat-degistir" tip="porselen" ebat-bool="0" class="fa fa-minus" title="Taşı Küçült"></i>
              <i action="ebat-degistir" tip="porselen" ebat-bool="1" class="fa fa-plus" title="Taşı Büyüt"></i>
              <img src="%%PREV_SRC%%" />
              <span class="porselen-id-info">#%%ID_INFO%%</span>
              <i action="resim_ekle"  tip="porselen" class="fa fa-image" title="Resim Ekle"></i>
              <i action="sil"  tip="porselen" class="fa fa-remove" title="Kaldır"></i>
              <i action="cevir"  tip="porselen" class="fa fa-refresh" title="Çevir"></i>
          </div>
      </script>

      <script type="text/template" id="yazi_template" >
          <div class="yazi_template" item-index="%%ITEM_INDEX%%" data-renk="%%DATA_RENK%%" data-yazi="%%DATA_YAZI%%" data-font="%%DATA_FONT%%">
                <img src="%%PREV_SRC%%" />
                <i action="duzenle"  tip="yazi" class="fa fa-edit"  title="Düzenle"></i>
                <i action="sil"  tip="yazi" class="fa fa-remove" title="Kaldır"></i>
          </div>
      </script>

      <script type="text/template" id="sekil_template">
          <div class="sekil_template" item-index="%%ITEM_INDEX%%">
              <img src="%%PREV_SRC%%" />
              <i action="sil"  tip="sekil" class="fa fa-remove" title="Kaldır"></i>
          </div>
      </script>

      <script type="text/template" id="engrave_template">
          <div class="engrave_template" item-index="%%ITEM_INDEX%%">
              <div class="engrave-inner" item-index="%%ITEM_INDEX%%">
                <img src="%%IMG_SRC%%" />
                <span class="engrave-id-info">#%%ID_INFO%%</span>
                <i action="sil"  tip="engrave" class="fa fa-remove" title="Kaldır"></i>
              </div>
          </div>
      </script>

      <script>
         $(document).ready(function(){
            var // porselen ebat listesi
                ebat_options = {    oval:["8x10 cm", "9x12 cm", "11x15 cm", "13x18 cm", "18x24 cm", "24x30 cm"],
                                    dikdortgen:["9x12 cm", "11x15 cm", "13x18 cm", "18x24 cm", "24x30 cm"],
                                    daire:["10x10 cm", "15x15 cm", "20x20 cm", "25x25 cm"],
                                    kare:["10x10 cm", "15x15 cm", "20x20 cm"],
                                    kubbe:[ "10x14 cm", "15x20 cm", "18x24 cm"],
                                    kalp:[ "15x15 cm", "20x20 cm"]
                },
                // global - engrave resim için cropper
                cropper = null,
                allowed_exts = ["image/jpeg", "image/png", "image/bmp", "image/gif"],
                temp_crop_data = {},
                cropper_init_data = {
                  aspectRatio: NaN,  // free olarak crop edebilsin
                  viewMode: 1, // height e uygun küçült resmi
                  crop: function(e) {
                     // aspect ratio bozmadan 230 width e denk gelen height i hesapla
                     var ar_height = 230 * e.detail.height / e.detail.width;
                     temp_crop_data = {w:230, h:ar_height};
                   }
                },
                // engrave upload temp file
                engrave_temp_file = null,
                // finito önizleme ss
                temp_canvas = null;
            var // editor taş elementi
                tas = $(".tas"),
                // porselen item template
                porselen_template = $("#porselen_template"),
                // engrave item template
                engrave_template = $("#engrave_template"),
                // yazi temp
                yazi_template = $("#yazi_template"),
                // sekil temp
                sekil_template = $("#sekil_template"),
                // granit - mermer seçim selecti
                tas_tip_input = $("#tas_tip"),
                // taş ebat inputlari
                tas_w_input = $("#tas_w"),
                tas_h_input = $("#tas_h"),
                // upload sonrasi tempten alip, cropper aksiyonlari yaptigimiz resim ( modal da )
                cropper_img = $("#cropper_img"),
                modals = { finito_modal:$("#finito_modal"), porselen_resim_modal: $("#porselen_resim_modal"), engrave_resim_modal:$("#engrave_resim_modal"), yazi_ekleme_modal: $("#yazi_ekleme_modal"), genel_urunler_modal:$("#genel_urunler_modal"), porselen_resim_upload_modal:$("#porselen_resim_upload_modal") },
                yazi_ekle_btn = $("#yazi_ekle"),
                porselen_editor_iframe = $("#portable_porselen_editor_frame"),
                siparis_yukle_btn = $("#siparis_yukle");

            var Siparis = {
                // siparis gid ( porselenler icin )
                gid:"<?php echo $SIPARIS_ID ?>",
                tas: 'siyah_granit',
                tas_ebat: { w:50, h:50 },
                porselenler:  {},
                engraveler:    {},
                engrave_files: {},
                yazilar:      {},
                sekiller:     {},
                porselen_item_index: 0,
                engrave_item_index: 0,
                yazi_item_index: 0,
                sekil_item_index: 0,
                /*
                  @tip: siparis tipi
                  @elem: item in editordeki dom elementi
                  @data: item in verisi
                */
                urun_ekle: function( tip, data ){
                    switch( tip ){
                        case 'porselen':
                            this.porselenler["POR"+this.porselen_item_index] = data;
                            this.porselen_item_index++;
                        break;

                        case 'engrave':
                            this.engraveler["ENG"+this.engrave_item_index] = data;
                            this.engrave_item_index++;
                        break;

                        case 'yazi':
                            this.yazilar["YAZI"+this.yazi_item_index] = data;
                            this.yazi_item_index++;
                        break;

                        case 'sekil':
                            this.sekiller["SEK"+this.sekil_item_index] = data;
                            this.sekil_item_index++;
                        break;
                    }
                },
                kaydet: function(){
                    if( !window.FormData ){
                        // form data yoksa error vericez
                        // önizlemeyi bi sekilde ulastirabilirsek guzel olur
                        alert("Sitemiz kullandığınız tarayıcı versiyonunu desteklemiyor. Yalnızca önizleme yapabilirsiniz.");
                        return false;
                    }
                    var isim_val = $("#isim").val(), telefon_val = $("#telefon").val(), eposta_val = $("#eposta").val();
                    if( trim(isim_val) == "" ){
                        if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                        PamiraNotify("error", "Hata", "İsim boş bırakılamaz." );  
                        return;
                    }
                    if( trim(telefon_val) == "" && trim(eposta_val) == "" ){
                        if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                        PamiraNotify("error", "Hata", "Telefon veya Eposta bilgilerinden en az birini girmelisiniz." );  
                        return;
                    }
                    if( trim(eposta_val) != "" && !FormValidation.email(eposta_val) ){
                        if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                        PamiraNotify("error", "Hata", "Lütfen geçerli bir eposta adresi giriniz.");  
                        return;
                    }
                    siparis_yukle_btn.get(0).disabled = true;
                    var form_data = new FormData();
                    form_data.append("req", "siparis_kaydet");
                    form_data.append("gid", Siparis.gid );
                    form_data.append("tas_data", JSON.stringify({ tas:Siparis.tas, w:Siparis.tas_ebat.w, h:Siparis.tas_ebat.h }));
                    form_data.append("porselenler", JSON.stringify(Siparis.porselenler) );
                    form_data.append("engraveler", JSON.stringify(Siparis.engraveler) );
                    form_data.append("yazilar", JSON.stringify(Siparis.yazilar) );
                    form_data.append("sekiller", JSON.stringify(Siparis.sekiller) );
                    form_data.append("notlar", $("#not").val());
                    form_data.append("adet", $("#adet").val());
                    form_data.append("isim", isim_val);
                    form_data.append("telefon", telefon_val);
                    form_data.append("eposta", eposta_val);
                    form_data.append("preview", temp_canvas.toDataURL("image/png") );
                    for( var key in Siparis.engrave_files )  form_data.append(key+"_file", Siparis.engrave_files[key] );
                    $.ajax({
                      url: "",
                      data: form_data,
                      processData: false,
                      contentType: false,
                      type: 'POST',
                      success: function( res ){
                          // contenttype false oldugu icin, parse ediyoruz json responsu manuel olarak
                          var obj = JSON.parse(res);
                          //console.log(obj);
                          if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                          PamiraNotify("success", "İşlem Tamam", obj.text );  
                          setTimeout(function(){ location.reload(); }, 750);
                      }
                    });
                }
            };

            // granit - mermer select input
            tas_tip_input.change(function(){
                tas.removeClass(Siparis.tas);
                tas.addClass( this.value );
                Siparis.tas = this.value;
            });

            // tas ebat uygulama
            $("#tas_ayar_uygula").click(function(){
                tas.css({ width: cm_to_px(tas_w_input.val())+"px", height:cm_to_px(tas_h_input.val())+"px"});
                Siparis.tas_ebat = { w: tas_w_input.val(), h:tas_h_input.val() };
            });

            $(".modal-init").click(function(){
                if( this.getAttribute("data-target") == 'engrave_resim_modal' ){
                    modals[this.getAttribute("data-target")].modal({
                        backdrop:'static' // arkadaki siyahliga basinca kapatmasin, cropper da sorun oluyor
                    });
                } else {
                    modals[this.getAttribute("data-target")].modal('show');
                }
            });

            $(".porselen-ekle").click(function(){
                var select_val = $("."+this.getAttribute("data")).val(),
                    dims = cm_explode( select_val ),
                    item_id = "POR"+Siparis.porselen_item_index,
                    template = porselen_template.html().replace("%%SERI_CLASS%%", this.getAttribute("data") + "-item").
                                                        replace("%%ITEM_INDEX%%", item_id ).
                                                        replace("%%ID_INFO%%", item_id ).
                                                        replace("%%PREV_SRC%%", this.getAttribute("prev-src")).
                                                        replace("%%WIDTH%%", cm_to_px(parseInt(dims[0]))).
                                                        replace("%%HEIGHT%%", cm_to_px(parseInt(dims[1])));
                tas.append( template );
                var elem = $("[item-index='"+item_id+"']");
                elem.draggable({
                    stop:function(){
                        // duzenleme için editordeki pozisyonlarini güncelleiyor her drag da
                        Siparis.porselenler[item_id].top = elem.css("top");
                        Siparis.porselenler[item_id].left = elem.css("left");
                    }
                });
                Siparis.urun_ekle( 'porselen', {
                    seri: this.getAttribute("data"),
                    ebat:select_val,
                    item_index: item_id,
                    rotated:false,
                    top:0,
                    left:0
                });
                if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                PamiraNotify("success", "Eklendi", "Porselen editöre eklendi.");  
            });

            // modaldan yaziyi editore ekleme btn
            yazi_ekle_btn.click(function(){

                // duzenleme yapma
                if( yazi_ekle_btn.attr("duzenleme") == "1" && yazi_ekle_btn.attr("d-item-index") != "-1" ){
                    // veriyi guncelle
                    Siparis.yazilar[yazi_ekle_btn.attr("d-item-index")].text = AHEditor.text;
                    Siparis.yazilar[yazi_ekle_btn.attr("d-item-index")].font = AHEditor.Font_Select.selected_font;
                    Siparis.yazilar[yazi_ekle_btn.attr("d-item-index")].color = AHEditor.text_color_input.value;
                    Siparis.yazilar[yazi_ekle_btn.attr("d-item-index")].prev_src = AHEditor.preview.src;
                    var elem = $("[item-index='"+yazi_ekle_btn.attr("d-item-index")+"']");
                    elem.attr("data-renk", AHEditor.text_color_input.value);
                    elem.attr("data-yazi", AHEditor.text);
                    elem.attr("data-font", AHEditor.Font_Select.selected_font);
                    // editordeki resmi guncelle
                    elem.find("img").get(0).src = AHEditor.preview.src;
                    // ekleme butonunu resetle
                    yazi_ekle_btn.attr("duzenleme", 0).attr("d-item-index", -1);
                    // modali kapat
                    modals["yazi_ekleme_modal"].modal('hide');
                    // ah editoru resetle
                    AHEditor.reset();
                    return;
                }
                var item_id = "YAZI"+Siparis.yazi_item_index,
                    template = yazi_template.html().replace("%%ITEM_INDEX%%", item_id ).
                                                    replace("%%PREV_SRC%%", AHEditor.preview.src ).
                                                    replace("%%DATA_YAZI%%", AHEditor.text ).
                                                    replace("%%DATA_RENK%%", AHEditor.text_color_input.value ).
                                                    replace("%%DATA_FONT%%", AHEditor.Font_Select.selected_font );
                tas.append( template );
                var elem = $("[item-index='"+item_id+"']"),
                    img = $(elem.find("img").get(0));
                elem.css({width:(cm_to_px(Siparis.tas_ebat.w)/3)+"px"});
                elem.draggable({
                    stop:function(){
                        Siparis.yazilar[item_id].top = elem.css("top");
                        Siparis.yazilar[item_id].left = elem.css("left");
                    }
                });
                img.resizable({
                    resize: function( event, ui ) {
                        elem.css({width:ui.size.width+"px", height:ui.size.height+"px"});
                        // siparis verisini update et
                        Siparis.yazilar[item_id].width = ui.size.width;
                        Siparis.yazilar[item_id].height = ui.size.height;
                    }
                });
                 // modali kapat
                 modals["yazi_ekleme_modal"].modal('hide');
                 Siparis.urun_ekle('yazi', {
                    item_index: item_id,
                    prev_src: AHEditor.preview.src,
                    top:0,
                    left:0,
                    width:0,
                    height:0,
                    text: AHEditor.text,
                    font: AHEditor.Font_Select.selected_font,
                    color: AHEditor.text_color_input.value
                 });
                 // ah editoru resetle
                 AHEditor.reset();
            });
            // editore eklenen itemlerin çevirme - silme butonlari
            $(document).on("click", "[action]", function(){
                var parent_node = $(this).parent(),
                    siparis_data_obj = action_btn_data_array( this.getAttribute("tip") );
                switch( this.getAttribute("action") ){

                    case 'cevir':
                        parent_node.toggleClass("rotated");
                        siparis_data_obj[parent_node.attr("item-index")].rotated = true;
                    break;

                    case 'sil':
                        parent_node.remove();
                        delete siparis_data_obj[parent_node.attr("item-index")];
                        // engrave resmini de sil
                        if( this.getAttribute("tip") == "engrave" ) delete Siparis.engrave_files[parent_node.attr("item-index")];
                    break;

                    // sadece porselende var
                    case 'ebat-degistir':
                        var yeni_ebat = ebat_bul(Siparis.porselenler[parent_node.attr("item-index")].seri, Siparis.porselenler[parent_node.attr("item-index")].ebat, this.getAttribute("ebat-bool")),
                            w_h_data = cm_explode( yeni_ebat );
                        // itemin verilerini guncelle
                        Siparis.porselenler[parent_node.attr("item-index")].ebat = yeni_ebat;
                        Siparis.porselenler[parent_node.attr("item-index")].width = cm_to_px(w_h_data[0]);
                        Siparis.porselenler[parent_node.attr("item-index")].height = cm_to_px(w_h_data[1]);
                        // dom elementine değişikligi uygula
                        parent_node.css({ width:Siparis.porselenler[parent_node.attr("item-index")].width+"px", height:Siparis.porselenler[parent_node.attr("item-index")].height+"px" });
                    break;

                    case 'duzenle':
                        // yaziyi duzenleme
                        AHEditor.text = parent_node.attr("data-yazi");
                        AHEditor.Font_Select.select( $("[value='"+parent_node.attr("data-font")+"']").get(0) );
                        AHEditor.text_color_input.value = parent_node.attr("data-renk");
                        AHEditor.editor_input.value = parent_node.attr("data-yazi");
                        // bastaki url i sil
                        AHEditor.old_img = parent_node.find("img").get(0).src.substring( AHEditor.url_prefix.length, AHEditor.url_prefix.length+36 );
                        AHEditor.update_preview();
                        // butona düzenleme yapilacagi bilgisini ver
                        yazi_ekle_btn.attr("duzenleme", 1).attr("d-item-index", parent_node.attr("item-index"));
                        modals["yazi_ekleme_modal"].modal('show');
                    break;

                    case 'resim_ekle':
                        // porselen resim ekleme
                        // bu porselene resim eklenmişse, butona attr çakıp düzenleme olup olmadigina bakicaz
                        var seri_str = Siparis.porselenler[parent_node.attr("item-index")].seri;
                        var ped_src = porselen_editor_iframe.attr("def-src") + "?portable=true&"+
                                                                            "seri="+seri_str.substring(0, seri_str.indexOf("-"))+"&"+
                                                                            "ebat="+Siparis.porselenler[parent_node.attr("item-index")].ebat+"&"+
                                                                            "parent_gid="+Siparis.gid+"&"+
                                                                            "parent_item_id="+parent_node.attr("item-index");
                        if( this.getAttribute("uploaded") == 1 ) ped_src += "&uploaded=true"
                        //console.log(ped_src);
                        porselen_editor_iframe.attr("src", ped_src);
                        modals["porselen_resim_upload_modal"].modal('show');

                    break;

                } 
            });

            // engrave croppper modal daki ayar butonlari
            $(".cropper-btn").click(function(){
               var req = this.getAttribute("ayar");
               switch(req){
                   // engrave resmi ekleme
                   case 'cropperok':
                      var item_id = "ENG"+Siparis.engrave_item_index,
                          template = engrave_template.html().replace("%%ITEM_INDEX%%", item_id ).
                                                        replace("%%ITEM_INDEX%%", item_id ). // inner icin
                                                        replace("%%ID_INFO%%", item_id ).
                                                        replace("%%IMG_SRC%%", cropper.getCroppedCanvas({fillColor: '#fff'}).toDataURL('image/jpeg') );
                      tas.append( template );
                      var elem = $($("[item-index='"+item_id+"']").get(0)),   // buyuk parent ( engrave_template )
                          img = $(elem.find("img").get(0)),   // resim
                          inner = $(elem.find(".engrave-inner").get(0)); // resim ve butonlarin oldugu inner parent
                      
                      // resmi crop sonrasi 230px genislik olacak sekilde ratio ya uygun boyutlandir
                      img.css({width:temp_crop_data.w+"px", height:temp_crop_data.h+"px"});
                      // resim resizable init
                      img.resizable({
                          resize: function( event, ui ) {
                              // resimi resize ettigimiz için, alt üst butonlarin saçmalamaması için parent elementi de resize ediyoruz paralel olarak
                              inner.css({width:ui.size.width+"px", height:ui.size.height+"px"});
                              elem.css({width:ui.size.width+"px", height:ui.size.height+"px"});
                              // siparis verisini update et
                              Siparis.engraveler[item_id].width = ui.size.width;
                              Siparis.engraveler[item_id].height = ui.size.height;
                          }
                      });
                      elem.css({width:temp_crop_data.w+"px", height:temp_crop_data.h+"px"}).draggable({
                          stop:function(){
                              // engrave inner in pozisyon verisini guncelle ( duzenleme icin )
                              Siparis.engraveler[item_id].top = elem.css("top");
                              Siparis.engraveler[item_id].left = elem.css("left");
                          }
                      });
                      // modali kapat
                      modals["engrave_resim_modal"].modal('hide');
                      // verileri kaydet
                      Siparis.urun_ekle('engrave', {
                            item_index:item_id,
                            cropper_img:cropper.getCroppedCanvas({fillColor: '#fff'}).toDataURL('image/png'),
                            top:0, // [!!ÖNEMLİ!!] top ve left engrave-inner in css detaylari, resmin değil [!!ÖNEMLİ!!]
                            left:0,
                            width:temp_crop_data.w,
                            height:temp_crop_data.h,
                            ext: engrave_temp_file.type.toLowerCase()
                      });
                      // json stringify kullaniyorum, o yuzden upload lari ayrica listeliyorum
                      Siparis.engrave_files[item_id] = engrave_temp_file;
                      // temp file i resetle
                      engrave_temp_file = null;
                      // cropper i resetle
                      if( cropper != undefined ) cropper.destroy();
                      // cropper resmini uçur
                      cropper_img.attr("src", "");
                      if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                      PamiraNotify("success", "Eklendi", "Kazıma resim editöre eklendi.");  

                   break;
     
                   case 'cropperreset':
                       cropper.reset();
                   break;
     
                   case 'cropperrleft':
                       cropper.rotate(-90);
                   break;
     
                   case 'cropperrright':
                       cropper.rotate(90);
                   break;
               }
            });
          
            $("#finito").click(function(){
                console.log(Siparis);
                // editor boşsa kontrol ediyoruz
                if( Object.size(Siparis.porselenler) == 0 && Object.size(Siparis.yazilar) == 0 && Object.size(Siparis.sekiller) == 0 && Object.size(Siparis.engraveler) == 0 ){
                    if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                    PamiraNotify("error", "Hata", "Editöre hiçbirşey eklenmemiş.");  
                    return;
                }
                // tüm porselenlere resim eklenmiş mi kontrol ediyoruz önce
                var pors_items = [];
                for( var key in Siparis.porselenler ) pors_items.push(key);
                // eger hic porselen eklenmemişse kontrol etmiyoruz
                if( pors_items.length == 0 ){
                    finito_success_callback();
                    return;
                }
                // tüm porselenlere resim eklenmiş mi kontrol ediyoruz
                REQ.ACTION("", { req:"porselen_resim_kontrol", parent_gid:Siparis.gid, pors_items:pors_items.join("#") }, function(res){
                    //console.log(res);
                    if( res.ok ){
                        finito_success_callback();
                    } else {
                        if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                        PamiraNotify("error", "Hata", res.text );  
                    }
                });
            });

            function finito_success_callback(){
               $("[action]").hide();
                  html2canvas(tas.get(0), { async:false }).then(function(canvas) {
                      temp_canvas = canvas;
                      // onizleme init
                      $("#modal_preview").html( canvas );
                      canvas.style.width = "400px";
                      canvas.style.height = (400 * Siparis.tas_ebat.h / Siparis.tas_ebat.w)+"px";
                      modals["finito_modal"].modal("show");
                      $("[action]").show();
                });
            }
          
            siparis_yukle_btn.click(function(){
                Siparis.kaydet();
            });

            $(".genel-urun-ekle").click(function(){
                var _this = $(this);
                switch( _this.attr("data-type") ){
                    case 'yazi':

                    break;

                    case 'porselen':

                    break;

                    case 'resim':
                        var item_id = "SEK"+Siparis.sekil_item_index,
                            prev_src = null,
                            extra_data = {};
                        if( _this.attr("variant") == "0" ){
                            // varyant yok
                            prev_src = _this.attr("prev-src");
                        } else {
                            // varyantli
                            var var_option = $($(_this.parent().parent().find(".varyant-select").get(0)).find(":selected").get(0));
                            prev_src = var_option.attr("prev-src");
                            extra_data["varyant"] = var_option.val();
                        }
                        var template = sekil_template.html().replace("%%ITEM_INDEX%%", item_id ).
                                                             replace("%%PREV_SRC%%", prev_src );
                        tas.append(template);
                        var elem = $("[item-index='"+item_id+"']"),
                            img = $(elem.find("img").get(0));
                        elem.css({width:_this.attr("init-width")+"px",height:_this.attr("init-height")+"px"});
                        img.css({width:_this.attr("init-width")+"px",height:_this.attr("init-height")+"px"});
                        elem.draggable({
                            stop:function(){
                                // engrave inner in pozisyon verisini guncelle ( duzenleme icin )
                                Siparis.sekiller[item_id].top = elem.css("top");
                                Siparis.sekiller[item_id].left = elem.css("left");
                            }
                        });
                        img.resizable({
                            resize: function( event, ui ) {
                                // resimi resize ettigimiz için, alt üst butonlarin saçmalamaması için parent elementi de resize ediyoruz paralel olarak
                                elem.css({width:ui.size.width+"px", height:ui.size.height+"px"});
                                // siparis verisini update et
                                Siparis.sekiller[item_id].width = ui.size.width;
                                Siparis.sekiller[item_id].height = ui.size.height;
                            }
                        });
                        Siparis.urun_ekle('sekil', extend({
                            item_index:item_id,
                            top:0,
                            left:0,
                            data_type:_this.attr("data-type"),
                            data_content:_this.attr("data-content"),
                            width:_this.attr("init-width"),
                            height:_this.attr("init-height")
                        }, extra_data));
                        if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                        PamiraNotify("success", "Eklendi", "Şekil editöre eklendi.");  


                    break;
                }
            });

            // ebatlarin js den selectlerini ekleme
            foreach( $AHC("ebat-select"), function(item){
                add_options( item, true, ebat_options[item.getAttribute("data")], false, true );
            });
            
            // [action] butonlarinda düzenlenecek Siparis objesini dönen fonksiyon
            function action_btn_data_array( tip ){
                switch(tip){
                  case 'porselen':
                      return Siparis.porselenler;
                  break;

                  case 'engrave':
                      return Siparis.engraveler;
                  break;

                  case 'sekil':
                      return Siparis.sekiller;
                  break;

                  case 'yazi':
                      return Siparis.yazilar;
                  break;
                }
            }

            // porselen tas buyutme, kucultmede önceki veya sonraki ebatı bulma
            function ebat_bul( seri, ebat, buyutme ){
                var aktif_index = 0,
                    seri_substr = seri.substring(0, seri.indexOf("-")); // oval-seri seklinde geliyor, -seri kismini atiyoruz
                for( var k = 0; k < ebat_options[seri_substr].length; k++ ){
                    if( ebat == ebat_options[seri_substr][k] ){
                        aktif_index = k;
                        break;
                    }
                }
                ( buyutme == "1" ) ? aktif_index++ : aktif_index--;
                if( ebat_options[seri_substr][aktif_index] != undefined ) return ebat_options[seri_substr][aktif_index];
                // eger önceki veya sonraki yoksa aktif olanı dön
                return ebat;
            }

            // cropper modal file input
            $("#upload").change(function(ev){
               if( !window.FileReader ){
                  alert("Sistemimiz kullandığınız tarayıcı versiyonunu desteklemiyor. Lütfen tarayıcınızı güncelleyin.");
                  return false;
               }
               var img, html,
                   reader = new FileReader(),
                   file = this.files[0];
               if( file != undefined ) {
                     // resim uzanti kontrolu yapiyoruz
                     if( !in_array( file.type, allowed_exts ) )  return false;
                     // tempe resim yuklemesi bittiginde
                     reader.onloadend = function(e){
                         // onizlemeyi ekle
                         cropper_img.attr("src", e.target.result );
                         // eger resim yuklenmisse, bir onceki cropper i yok edip, yeni init ediyoruz
                         if( cropper != undefined ) cropper.destroy();
                         cropper = new Cropper(cropper_img.get(0), cropper_init_data);
                     };
                     // tempden resim url i al
                     reader.readAsDataURL( file );
                     engrave_temp_file = file;
                 } 
            });
         
            // cm to 5px cevir ( 1cm = 10px )
            function cm_to_px( val ){
                return val * 10;
            }

            // taş ebatini parcalama
            // 11x15 cm -> [11], [15]
            function cm_explode( data ){
                return data.substring(-3, 5).split("x");
            }


            // yazi ekleme editoru
            // ahsaphobbynet icin yaptigim editor, common.js ile calisiyor jquery yok
            var AHEditor = {
                text:"Sucuoglu",
                editor_input:null,
                old_img:null,
                preview:null,
                url_prefix: "<?php echo URL_AH_EDITOR_PREVS ?>",
                init: function(){
                  this.editor_input     = $AH('editor-text');
                  this.preview      = $AH('editor-preview-img');
                  this.text_color_input = $AH('ah_text_color');
                  this.Font_Select.init();
                },
                is_empty: function(){
                  return trim( get_val( this.editor_input ) ).length == 0;
                },
                request_preview: function(){

                  yazi_ekle_btn.get(0).disabled = true;
                  AHAJAX_V3.req( 
                    "",
                    manual_serialize({
                      req:        "ah_editor",
                      text:       this.text,
                      old_img:    this.old_img,
                      font:       this.Font_Select.selected_font,
                      text_color: this.text_color_input.value
                    }),
                    function( r ){
                      AHEditor.old_img                    = r.data.old_img;
                      AHEditor.preview.src                = r.data.img_src;
                      yazi_ekle_btn.get(0).disabled = false;
                    }
                  );
                },
                get_form_data: function(){
                  return {
                    text: this.text,
                    img: this.preview.src
                  }
                },
                update_preview: function(){
                  // editordeki yaziyi sildiginde karakter basi falan siliniyor
                  this.text = get_val( this.editor_input );
                  this.request_preview();
                },
                reset: function(){
                    this.text = "Sucuoglu";
                    this.editor_input.value = "";
                    this.old_img = null;
                    //this.request_preview();
                },
                Font_Select: {
                  init: function(){
                    this.toggle_btn     = $AHC("font-select");
                    this.selected_font_cont = $AHC("font-selected");
                    this.selected_font    = this.selected_font_cont.getAttribute("value");
                    this.font_list      = $AHC("font-list");
                    this.font_option    = $AHC("foption");
                  },
                  toggle: function( hide ){
                    // select harici bir yere basinda kapat selecti
                    if( hide ){
                      removeClass( this.font_list, "open");
                      return;
                    }
                    // klasik toggle
                    toggle_class( this.font_list, "open" );
                  },
                  // fontu seçme
                  select: function( font ){
                    // ilk aciliş seciminde AHEditor.init etmedigim icin
                    // this.font_option yerine AHC kullaniyorum
                    // selected divine resmi koyuyoruz
                    set_html( this.selected_font_cont, get_html( font ) );
                    this.selected_font = font.getAttribute("value");
                    foreach( $AHC("foption"), function(fopt){ removeClass( fopt, "selected") });
                    addClass(font, "selected" );
                  }
                }
              };
              AHEditor.init();
              // ilk fonta göre updated resmi al
              AHEditor.update_preview();
              // editor keyup
              add_event( AHEditor.editor_input, "keyup", debounce( function(){
                AHEditor.update_preview();
              }, 500, false ));
              add_event_on( document, false, "click", function(){
                AHEditor.Font_Select.toggle( true );
              });
              add_event( AHEditor.Font_Select.toggle_btn, "click", function(e){
                AHEditor.Font_Select.toggle();
                event_prevent_default(e);
                event_stop_propagation(e);
              });

              add_event( AHEditor.Font_Select.font_option, "click", function(e){
                // once varyant sec ( urun sayfasi default a donecek )
                // sonra fontu seç
                AHEditor.Font_Select.select( this );
                // en son preview
                AHEditor.update_preview();    
                event_prevent_default(e);
              });

              add_event( AHEditor.text_color_input, "change", function(e){
                AHEditor.update_preview();
              });


         
         });
      </script>
   </body>
</html>