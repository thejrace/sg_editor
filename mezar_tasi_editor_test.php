<?php
    require 'inc/defs.php';
    require CLASS_DIR . "CanvasUpload.php";
    require CLASS_DIR . "ImageUpload.php";
    require CLASS_DIR . "TempUpload.php";
    require CLASS_DIR . "AH_Editor_Image.php";
    require CLASS_DIR . "PorselenSiparis.php";
    require CLASS_DIR . "BaslikSiparis.php";

    if( $_POST ){

        $OK = 1;
        $TEXT = "";
        $DATA = array();


        switch( Input::get("req") ){

            case 'ah_editor':
                $Image = new AH_Editor_Image( Input::get("text"), Input::get("font"), Input::get("old_img"), Input::get("text_color"), Input::get("bg_color"));
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

            case 'ah_delete_img':
                AH_Editor_Image::delete_img( Input::get("src") );
            break;

            case 'siparis_kaydet_old':

              $BaslikSiparis = new BaslikSiparis();
              if( !$BaslikSiparis->ekle($_FILES, Input::escape($_POST)) ) $OK = 0;
              $TEXT = $BaslikSiparis->get_return_text();

            break;

            case 'siparis_kaydet':

              $BaslikSiparis = new BaslikSiparis();
              if( !$BaslikSiparis->ekle(Input::escape($_POST)) ) $OK = 0;
              $TEXT = $BaslikSiparis->get_return_text();

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
              <button class="btn btn-sm btn-default modal-init" data-target="porselen_cropper_modal" ><i class="fa fa-image"></i> Porselen Resim</button>
              <button class="btn btn-sm btn-default modal-init" data-target="engrave_resim_modal"><i class="fa fa-image"></i> Kazıma Resim</button>
              <button class="btn btn-sm btn-default modal-init" data-target="yazi_ekleme_modal"><i class="fa fa-italic"></i> Yazı</button>
              
         </div>
      </div>
      <div class="porselen-gruplar" >
         <div class="btn-group well well-sm" role="group" aria-label="...">
            <button class="btn btn-sm btn-success" id="finito"><i class="fa fa-check"></i> Tamamla</button>
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
                     <span>Bilgisayarınızdan Resim Seçin</span>
                     <input type="file" class="upload_img"  item-type="engrave"/>
                  </div>
                  <div style="height:500px">
                     <img id="eng_cropper_img" src="">
                  </div>
               </div>
               <div class="modal-footer">
                   <button class="btn btn-sm btn-default cropper-btn" ayar="ropperreset"  item-id="engrave"><i class="fa fa-refresh"></i> Reset</button>
                   <button class="btn btn-sm btn-primary cropper-btn" ayar="cropperrleft" item-id="engrave"><i class="fa fa-rotate-left"></i></button>
                   <button class="btn btn-sm btn-primary cropper-btn" ayar="cropperrright" item-id="engrave"><i class="fa fa-rotate-right"></i></button>
                   <button class="btn btn-sm btn-success cropper-btn" ayar="eng_cropperok"><i class="fa fa-check"></i> Tamam</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
               </div>
            </div>
         </div>
      </div>

      <div id="porselen_cropper_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Porselen Resim Yükle & Düzenle</h4>
               </div>
               <div class="modal-body">
                  <div id="cropper_form">
                     <span>Bilgisayarınızdan Resim Seçin</span>
                     <input type="file" class="upload_img" item-type="porselen" />
                  </div>
                  <div style="height:500px">
                     <img id="por_cropper_img" src="">
                  </div>
               </div>
               <div class="modal-footer">
                   <button class="btn btn-sm btn-default cropper-btn" ayar="cropperreset" item-id="porselen" ><i class="fa fa-refresh"></i> Reset</button>
                   <button class="btn btn-sm btn-primary cropper-btn" ayar="cropperrleft" item-id="porselen"><i class="fa fa-rotate-left"></i></button>
                   <button class="btn btn-sm btn-primary cropper-btn" ayar="cropperrright" item-id="porselen"><i class="fa fa-rotate-right"></i></button>
                   <button class="btn btn-sm btn-success cropper-btn" ayar="por_cropperok"><i class="fa fa-check"></i> Tamam</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
               </div>
            </div>
         </div>
      </div>

      <div id="porselen_editor_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Porselen Resim Editör</h4>
               </div>
               <div class="modal-body">
                  
                    <div class="row porselen-crop-grup section-container-spacer">
                       <div class="porselen-crop-container oval" activeclass="oval">
                          <div class="porselen-draggable-init porselen-draggable">
                             <img id="por_uploaded" class="img-responsive" alt="" src="">

                          </div>
                       </div>
                    </div>
                    <div class="porselen-editor-ayarlar" >
                        <h4>Ayarlar</h4>
                    </div>
                    <div class="porselen-gruplar portable-hide" >
                       <div class="btn-group well well-sm" role="group" aria-label="...">

                           <button class="btn btn-sm btn-success grup-btn" seri="oval"><i class="fa fa-angle-double-right"></i> Oval</button>
                           <button class="btn btn-sm btn-danger grup-btn"  seri="kare"><i class="fa fa-angle-double-right"></i> Kare</button>
                           <button class="btn btn-sm btn-danger grup-btn"  seri="dikdortgen"><i class="fa fa-angle-double-right"></i> Dikdörtgen</button>
                           <button class="btn btn-sm btn-danger grup-btn"  seri="daire"><i class="fa fa-angle-double-right"></i> Daire</button>
                           <button class="btn btn-sm btn-danger grup-btn"  seri="kubbe"><i class="fa fa-angle-double-right"></i> Oval Kubbe</button>
                       </div>
                    </div>
                    <div class="porselen-gruplar" >
                       <div class="btn-group well well-sm" role="group" aria-label="...">
                            <span id="arkaplanbtn" data-color="#ff0000"></span>
                       </div>
                    </div>
                    <div class="porselen-gruplar">
                      <div class="btn-group well well-sm" role="group" aria-label="...">
                         
                         <button class="btn btn-sm btn-primary ayar-btn" ayar="resimupload"><i class="fa fa-upload"></i> Resim Yükle & Düzenle</button>
                         <button class="btn btn-sm btn-default ayar-btn" ayar="resimreset"><i class="fa fa-refresh"></i> Resim Reset</button>
                         <button class="btn btn-sm btn-default ayar-btn portable-hide" ayar="tasrrotate"><i class="fa fa-rotate-right"></i> </button>
                       </div>
                    </div>
                    <div class="porselen-gruplar">
                        <div class="btn-group well well-sm" role="group" aria-label="...">
                           <button class="btn btn-sm btn-warning ayar-btn" ayar="kesimok"><i class="fa fa-check"></i> Kesimi Tamamla</button>
                           <button class="btn btn-sm btn-success ayar-btn" ayar="editorfinito"><i class="fa fa-check"></i> Tamam</button>
                        </div>
                    </div>
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
                      <div class="col-md-3 col-sm-6 col-xs-12 porselen-secim-item">
                          <div class="title-part">Porselen Bayrak</div>
                          <div class="prev-part"><img src="<?php echo URL_IMGS  ?>por_bayrak.png" /></div>
                          
                          <div class="nav-part">
                              <button class="btn btn-xs btn-success genel-urun-ekle" data-type="porselen" data-content="Türk Bayrağı Oval" data-ebat="9x12 cm" data-seri="oval" data-rotated="true" ><i class="fa fa-plus"></i> Ekle</button>
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
                        <img src="<?php echo URL_IMGS . "ah_editor_placeholder.png" ?>" id="editor-preview-img" alt="hege" />
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
                                        <a href="" class="font-selected" id="variant_1" value="24">
                                            <img alt="Script Sans" src="http://ahsaphobby.net/v2/res/img/static/font_prev/font_24.png"/>
                                        </a>
                                        <ul class="font-list">
                                           <li class="foption" value="23" id="variant_1"><img alt="Airmole Strip" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_23.png"/></li>
                                           <li class="foption  selected" value="24" id="variant_1"><img alt="Script Sans" src="<?php echo URL_AH_EDITOR_FONT_PREVS ?>font_24.png"/></li>
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
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Yazı Rengi</label>
                                  <div class="col-md-7 col-sm-12 col-xs-12">
                                      <span class="ah-text-cp" ></span>
                                      <input type="text" class="form-control" id="ah_text_color" value="#000000" />
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Arka Plan Rengi</label>
                                  <div class="col-md-5 col-sm-12 col-xs-12">
                                      <span class="ah-bg-cp"></span>
                                      <input type="text" class="form-control" id="ah_bg_color" value="YOK" />
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-xs-12" style="margin-top: 6px;">
                                      <input type="checkbox"  id="ah_bg_transparent" checked />
                                      <label for="ah_bg_transparent">Renk Yok</label>
                                      
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

      <script type="text/template" id="yazi_template" >
          <div class="yazi_template" item-index="%%ITEM_INDEX%%" data-bg-color="%%DATA_BG_COLOR%%" data-text-color="%%DATA_TEXT_COLOR%%" data-yazi="%%DATA_YAZI%%" data-font="%%DATA_FONT%%">
                <img src="%%PREV_SRC%%" />
                <i action="yazi_duzenle"  tip="yazi" class="fa fa-edit"  title="Düzenle"></i>
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

      <script type="text/template" id="porselen_template">
          <div item-index="%%ITEM_INDEX%%" style="width:120px; height:90px; position:absolute; top:0; left:0;">
              <i action="ebat-degistir" tip="porselen" ebat-bool="0" class="fa fa-minus" title="Taşı Küçült"></i>
              <i action="ebat-degistir" tip="porselen" ebat-bool="1" class="fa fa-plus" title="Taşı Büyüt"></i>
              <div class="porselen-crop-container oval" activeclass="oval" style="background-color: rgb(255, 0, 0); overflow: hidden; width: 120px; height: 90px;">
                  <div class="porselen-draggable" style="top:-3px; left:0">
                      <img id="por_uploaded" src="<?php echo URL_IMGS ?>por_bayrak_org.png" style="margin: 0px; resize: none; position: static; zoom: 1; display: block; height: 94.2248px; width: 138.366px; opacity: 1;">
                  </div>
              </div>
              <i action="sil"  tip="porselen" class="fa fa-remove" title="Kaldır"></i>
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
                croppers = {},
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
                temp_files = { engrave: null, porselen: null },
                // finito önizleme ss
                temp_canvas_list = { finito: null, porselen: null };
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
                
                cropper_imgs = { engrave: $("#eng_cropper_img"), porselen: $("#por_cropper_img") },
                modals = { finito_modal:$("#finito_modal"), porselen_resim_modal: $("#porselen_resim_modal"), engrave_resim_modal:$("#engrave_resim_modal"), yazi_ekleme_modal: $("#yazi_ekleme_modal"), genel_urunler_modal:$("#genel_urunler_modal"), porselen_resim_upload_modal:$("#porselen_resim_upload_modal"), porselen_cropper_modal:$("#porselen_cropper_modal"), porselen_editor_modal:$("#porselen_editor_modal") },
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
                porselen_files: {},
                yazilar:      {},
                sekiller:     {},
                porselen_item_index: 0,
                engrave_item_index: 0,
                yazi_item_index: 0,
                sekil_item_index: 0,
                finito_upload_check: null,
                finito_cb_notified: false,
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
                    form_data.append("preview", temp_canvas_list["finito"].toDataURL("image/png") );
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
                },
                finito_upload_cb: function( init ){
                    for( var item_index in Siparis.porselenler ){
                        if( !Siparis.porselen_files[item_index].upload_ok ){
                            siparis_yukle_btn.get(0).disabled = true;
                            if( !Siparis.finito_cb_notified ){
                                PamiraNotify("warning", "Lütfen bekleyin..", "Resimler siteye yükleniyor. Yükleme bittikten sonra siparişinizi gönderebilirsiniz.", false );
                                Siparis.finito_cb_notified = true;
                            }
                            return false;
                        }
                    }
                    for( var item_index in Siparis.engraveler ){
                        if( !Siparis.engrave_files[item_index].upload_ok ){
                            siparis_yukle_btn.get(0).disabled = true;

                            if( !Siparis.finito_cb_notified ){
                                PamiraNotify("warning", "Lütfen bekleyin..", "Resimler siteye yükleniyor. Yükleme bittikten sonra siparişinizi gönderebilirsiniz.", false );
                                Siparis.finito_cb_notified = true;
                            }
                            return false;
                        }
                    }
                    clearInterval(Siparis.finito_upload_check);
                    siparis_yukle_btn.get(0).disabled = false;
                    // sadece interval de callback calistircaz
                    if( init == undefined ) finito_success_callback();
                    return true;
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
                var _target = this.getAttribute("data-target");
                if( _target == 'engrave_resim_modal' || _target == 'porselen_cropper_modal' ){
                    modals[_target].modal({
                        backdrop:'static' // arkadaki siyahliga basinca kapatmasin, cropper da sorun oluyor
                    });
                } else {
                    modals[_target].modal('show');
                }
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
                    elem.attr("data-yazi", AHEditor.text);
                    elem.attr("data-font", AHEditor.Font_Select.selected_font);
                    elem.attr("data-text-color", AHEditor.text_color_input.value);
                    elem.attr("data-bg-color", AHEditor.bg_color_input.value);
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
                                                    replace("%%DATA_BG_COLOR%%", AHEditor.bg_color_input.value ).
                                                    replace("%%DATA_TEXT_COLOR%%", AHEditor.text_color_input.value ).
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
                    bg_color: AHEditor.bg_color_input.value,
                    text_color: AHEditor.text_color_input.value
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
                        
                        // engrave resmini de sil
                        if( this.getAttribute("tip") == "engrave" ){
                            delete_temp_file( parent_node.attr("item-index") );
                            delete Siparis.engrave_files[parent_node.attr("item-index")];
                        }
                        if( this.getAttribute("tip") == "porselen" ){
                            delete_temp_file( parent_node.attr("item-index") );
                            delete Siparis.porselen_files[parent_node.attr("item-index")];
                        }
                        // yazinin editor resminide siliyoruz
                        if( this.getAttribute("tip") == "yazi" ){
                            AHEditor.delete_img( siparis_data_obj[parent_node.attr("item-index")].prev_src );
                        }
                        delete siparis_data_obj[parent_node.attr("item-index")];
                        parent_node.remove();
                    break;

                    // sadece porselende var
                    case 'ebat-degistir':
                        var yeni_ebat = ebat_bul(Siparis.porselenler[parent_node.attr("item-index")].seri, Siparis.porselenler[parent_node.attr("item-index")].ebat, this.getAttribute("ebat-bool"));
                        PorselenEditor.ebat_degistir( parent_node, yeni_ebat, Siparis.porselenler[parent_node.attr("item-index")].rotated );
                    break;

                    case 'yazi_duzenle':
                        // yaziyi duzenleme
                        AHEditor.text = parent_node.attr("data-yazi");
                        AHEditor.Font_Select.select( $("[value='"+parent_node.attr("data-font")+"']").get(0) );
                        AHEditor.text_color_input.value = parent_node.attr("data-text-color");
                        AHEditor.bg_color_input.value = parent_node.attr("data-bg-color");
                        AHEditor.editor_input.value = parent_node.attr("data-yazi");
                        AHEditor.refresh_cps();

                        // bastaki url i sil
                        AHEditor.old_img = parent_node.find("img").get(0).src.substring( AHEditor.url_prefix.length, AHEditor.url_prefix.length+36 );
                        AHEditor.update_preview();
                        // butona düzenleme yapilacagi bilgisini ver
                        yazi_ekle_btn.attr("duzenleme", 1).attr("d-item-index", parent_node.attr("item-index"));
                        modals["yazi_ekleme_modal"].modal('show');
                    break;

                    // @DEPRECATED
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

            // engrave-porselen croppper modal daki ayar butonlari
            $(".cropper-btn").click(function(){
               var req = this.getAttribute("ayar");
               switch(req){
                   // engrave resmi ekleme
                   case 'eng_cropperok':
                      var cropped_img = croppers["engrave"].getCroppedCanvas({fillColor: '#fff'}).toDataURL('image/png'); 
                      var item_id = "ENG"+Siparis.engrave_item_index,
                          template = engrave_template.html().replace("%%ITEM_INDEX%%", item_id ).
                                                        replace("%%ITEM_INDEX%%", item_id ). // inner icin
                                                        replace("%%ID_INFO%%", item_id ).
                                                        replace("%%IMG_SRC%%", cropped_img );
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
                            top:0, // [!!ÖNEMLİ!!] top ve left engrave-inner in css detaylari, resmin değil [!!ÖNEMLİ!!]
                            left:0,
                            width:temp_crop_data.w,
                            height:temp_crop_data.h,
                            ext: temp_files["engrave"].type.toLowerCase()
                      });
                      // json stringify kullaniyorum, o yuzden upload lari ayrica listeliyorum
                      Siparis.engrave_files[item_id] = temp_files["engrave"];
                      // temp file i resetle
                      temp_files["engrave"] = null;
                      // cropper i resetle
                      if( croppers["engrave"] != undefined ) croppers["engrave"].destroy();
                      // cropper resmini uçur
                      cropper_imgs["engrave"].attr("src", "");
                      // upload a basla
                      temp_upload( Siparis.engrave_files[item_id], cropped_img, item_id, function(res){
                        Siparis.engrave_files[item_id]["upload_ok"] = res.ok;
                      });
                      
                      if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                      PamiraNotify("success", "Eklendi", "Kazıma resim editöre eklendi.");  

                   break;

                   case 'por_cropperok':
                      var item_id = "POR"+Siparis.porselen_item_index;
                      // cropper modalı kapatıp, porselen editor cropper i acicaz
                      modals["porselen_cropper_modal"].modal('hide');
                      PorselenEditor.temp_canvas = croppers["porselen"].getCroppedCanvas({fillColor: '#fff'}).toDataURL('image/png');
                      PorselenEditor.uploaded_img.attr("src", PorselenEditor.temp_canvas );
                      // kesim ayarlarini taşa uygula
                      PorselenEditor.crop_to_tas();
                      PorselenEditor.kesim_baslat();

                      // json stringify kullaniyorum, o yuzden upload lari ayrica listeliyorum
                      Siparis.porselen_files[item_id] = temp_files["porselen"];
                      // temp file i resetle
                      temp_files["porselen"] = null;
                      // cropper i resetle
                      if( croppers["porselen"] != undefined ) croppers["porselen"].destroy();
                      // cropper resmini uçur
                      cropper_imgs["porselen"].attr("src", "");
                      modals["porselen_editor_modal"].modal('show');
                   break;
     
                   case 'cropperreset':
                       croppers[this.getAttribute("item-id")].reset();
                   break;
     
                   case 'cropperrleft':
                       croppers[this.getAttribute("item-id")].rotate(-90);
                   break;
     
                   case 'cropperrright':
                       croppers[this.getAttribute("item-id")].rotate(90);
                   break;
               }
            });
          
            $("#finito").click(function(){
                //console.log(Siparis);
                // editor boşsa kontrol ediyoruz
                if( Object.size(Siparis.porselenler) == 0 && Object.size(Siparis.yazilar) == 0 && Object.size(Siparis.sekiller) == 0 && Object.size(Siparis.engraveler) == 0 ){
                    if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                    PamiraNotify("error", "Hata", "Editöre hiçbirşey eklenmemiş.");  
                    return;
                }
                // upload lar bitmiş mi kontrol ediyoruz
                if( !Siparis.finito_upload_cb( true ) ){
                    Siparis.finito_upload_check = setInterval( Siparis.finito_upload_cb , 1000 );
                    return;
                }
                finito_success_callback();
            });

            function finito_success_callback(){
               $("[action]").hide();
                  html2canvas(tas.get(0), { async:false, width:tas.outerWidth() + 20 }).then(function(canvas) {
                      temp_canvas_list["finito"] = canvas;
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

                        var item_id = "POR"+Siparis.porselen_item_index,
                            tema = porselen_template.html().replace("%%ITEM_INDEX%%", item_id ),
                            elem = $(tema);
                        tas.append( elem );
                        elem.draggable({
                            stop:function(){
                                if( Siparis.porselenler[item_id] != undefined ){
                                    Siparis.porselenler[item_id].top = elem.css("top");
                                    Siparis.porselenler[item_id].left = elem.css("left");
                                }
                            }
                        });
                        Siparis.porselen_files[item_id] = {"src":"Türk Bayrağı", upload_ok:true};
                        Siparis.urun_ekle( 'porselen', {
                            seri: this.getAttribute("data-seri"),
                            ebat: this.getAttribute("data-ebat"),
                            varyant: this.getAttribute("data-content"),
                            item_index: item_id,
                            rotated:this.getAttribute("data-rotated"),
                            top:0,
                            left:0
                        });  

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
                var aktif_index = 0;
                    //seri_substr = seri.substring(0, seri.indexOf("-")); // oval-seri seklinde geliyor, -seri kismini atiyoruz
                for( var k = 0; k < ebat_options[seri].length; k++ ){
                    if( ebat == ebat_options[seri][k] ){
                        aktif_index = k;
                        break;
                    }
                }
                ( buyutme == "1" ) ? aktif_index++ : aktif_index--;
                if( ebat_options[seri][aktif_index] != undefined ) return ebat_options[seri][aktif_index];
                // eger önceki veya sonraki yoksa aktif olanı dön
                return ebat;
            }

            // cropper modal file input
            $(".upload_img").change(function(ev){
                 upload_img( this.getAttribute("item-type"), this );
            });

            // yazi modali resetliyoruz kapandiginda
            modals["yazi_ekleme_modal"].on('hidden.bs.modal', function () {
                AHEditor.reset();
                yazi_ekle_btn.attr("duzenleme", 0).attr("d-item-index", -1);
            });

            function upload_img( type, data ){
                  if( !window.FileReader ){
                    alert("Sistemimiz kullandığınız tarayıcı versiyonunu desteklemiyor. Lütfen tarayıcınızı güncelleyin.");
                    return false;
                  }
                  var img, html,
                      reader = new FileReader(),
                      file = data.files[0];
                  if( file != undefined ) {
                       // resim uzanti kontrolu yapiyoruz
                       if( !in_array( file.type, allowed_exts ) )  return false;
                       // tempe resim yuklemesi bittiginde
                       reader.onloadend = function(e){
                           // onizlemeyi ekle
                           cropper_imgs[type].attr("src", e.target.result );
                           // eger resim yuklenmisse, bir onceki cropper i yok edip, yeni init ediyoruz
                           if( croppers[type] != undefined ) croppers[type].destroy();
                           croppers[type] = new Cropper(cropper_imgs[type].get(0), cropper_init_data);
                       };
                       // tempden resim url i al
                       reader.readAsDataURL( file );
                       temp_files[type] = file;
                       // input u resetle
                       data.value = "";
                  } 
            }

            function temp_upload( temp_file, temp_canvas, item_id, cb ){
                if( !window.FormData ){
                    alert("Sitemiz kullandığınız tarayıcı versiyonunu desteklemiyor. Lütfen tarayıcınızı güncelleyin.");
                    return false;
                }
                //console.log("Temp upload başladi");
                var form_data = new FormData();
                form_data.append("req", "temp_upload");
                form_data.append("img", temp_file );
                form_data.append("img_cropped", temp_canvas );
                form_data.append("parent_gid", Siparis.gid );
                form_data.append("item_id", item_id );
                $.ajax({
                    url: "inc/global_ajax.php",
                    data: form_data,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function( obj ){
                        var res = JSON.parse(obj);
                        if( typeof cb == 'function' ) cb( res );
                        //console.log(res);
                        ///console.log("Temp upload tamamlandı.");
                    }
                });
            }

            function delete_temp_file( item_id ){
                //console.log("Delete temp file başladı");
                REQ.ACTION("inc/global_ajax.php", { req:"delete_temp_file", item_id:item_id, parent_gid:Siparis.gid }, function(res){
                    //console.log(res);
                    //console.log("Delete temp file ok");
                });
            }
         
            // cm to 5px cevir ( 1cm = 10px )
            function cm_to_px( val ){
                return val * 10;
            }

            // taş ebatini parcalama
            // 11x15 cm -> [11], [15]
            function cm_explode( data ){
                return data.substring(-3, 5).split("x");
            }

            // 3px -> 3
            function parse_css( data ){
                return parseFloat(data.substring(0, data.indexOf("px") ));
            }

            var PorselenEditor = {
                kesim_devam_ediyor: true,
                kesim_bitti_btn: null,
                uploaded_img: null,
                draggable_img: null,
                crop_container: null,
                tasrleft: null,
                tasrright: null,
                aktif_seri: "oval",
                aktif_ebat: "9x12 cm",
                porselen_aci: 0,
                tas_donuk: false,
                temp_canvas: null,
                init:function(){
                    this.kesim_bitti_btn  = $("[ayar='kesimok']");
                    this.crop_container   = $(".porselen-crop-container");
                    this.draggable_img    = $(".porselen-draggable-init");
                    this.tasrright        = $('[ayar="tasrrotate"]');
                    this.uploaded_img     = $("#por_uploaded");

                    // jquery ui hareketleri
                    this.draggable_img.draggable({
                      drag: function(event, ui){
                          PorselenEditor.kesim_baslat();
                      }
                    });
                    // aspect ratio seçenek olarak koyulabilir
                    this.uploaded_img.resizable();

                    $("#arkaplanbtn").colorpicker({
                        inline: true,
                        container: true
                    }).on('colorpickerChange colorpickerCreate', function (e) {
                        PorselenEditor.crop_container.css({"background-color":e.color.toString("hex") + "!important"});
                    });

                    // ana ekran ayar butonlari
                    $(".ayar-btn").click(function(){
                         var tip = this.getAttribute("ayar");
                         switch(tip){
                           case 'kesimok':
                                if( PorselenEditor.kesim_devam_ediyor ){
                                    PorselenEditor.kesim_bitir();
                                } else {
                                    PorselenEditor.kesim_baslat();
                                }
                           break;

                           case 'tasrrotate':
                                PorselenEditor.porselen_aci += 90;
                                if( PorselenEditor.porselen_aci == 180 || PorselenEditor.porselen_aci == 0 ){
                                    PorselenEditor.crop_container.removeClass(PorselenEditor.aktif_seri+"-porselen-rotate");
                                    PorselenEditor.crop_container.addClass(PorselenEditor.aktif_seri);
                                    PorselenEditor.porselen_aci = 0;
                                    PorselenEditor.tas_donuk = false;
                                } else {
                                    PorselenEditor.crop_container.addClass(PorselenEditor.aktif_seri+"-porselen-rotate");
                                    PorselenEditor.crop_container.removeClass(PorselenEditor.aktif_seri);
                                    PorselenEditor.tas_donuk = true;
                                }
                           break;
               
                           case 'resimreset':
                               // sağ alttaki jqueryui icon, css degisiminde eski yerinde kaliyor
                               // o yuzden resizable i reset ediyoruz
                               PorselenEditor.uploaded_img.resizable("destroy");
                               PorselenEditor.uploaded_img.css({width:PorselenEditor.uploaded_img.attr("def-width")+"px", height:PorselenEditor.uploaded_img.attr("def-height")+"px"});
                               PorselenEditor.uploaded_img.parent().css({ left:0+"px", top:0+"px"});
                               PorselenEditor.draggable_img.css({ left:0+"px", top:0+"px"});
                               PorselenEditor.uploaded_img.resizable();
                               PorselenEditor.kesim_baslat();
                           break;

                           case 'editorfinito':
                               modals["porselen_editor_modal"].modal('hide');  
                               tas.append(PorselenEditor.clone_porselen());
                               if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                               PamiraNotify("success", "Eklendi", "Porselen editöre eklendi.");  
                           break;
                         }
                    });

                    // seri değiştirme butonlari
                    $(".grup-btn").click(function(){
                        PorselenEditor.seri_sec($(this));
                    });

                },
                // clone_porselen metoduyla ayni mantik, fakat degisiklik yaptigimiz dom elementleri farklli
                // TODO: standart bir hale getirebiliriz belki ?
                ebat_degistir: function( elem, ebat, donuk ){
                    var crop_cont = $(elem.find(".porselen-crop-container").get(0)),
                        img = $(elem.find("img").get(0)),
                        porselen_draggable = $(elem.find(".porselen-draggable").get(0)),
                        ui_wrapper = $(elem.find(".ui-wrapper").get(0));
                    var dims     = cm_explode(ebat),
                        old_cm_w = elem.outerWidth(),
                        old_cm_h = elem.outerHeight();
                    if( donuk ){
                        // taş ebatı
                        var dim_cm_w = cm_to_px(parseInt(dims[1])),
                            dim_cm_h = cm_to_px(parseInt(dims[0]));
                    } else {
                        var dim_cm_w = cm_to_px(parseInt(dims[0])),
                            dim_cm_h = cm_to_px(parseInt(dims[1]));
                    }
                    var clone_dims = { width:dim_cm_w+"px", height:dim_cm_h+"px" };
                     // yeni ebata gore inner elementlerin pozisyonlarini ve ebatlarini oranlama
                    var draggable_top   = parse_css(porselen_draggable.css("top"))   * dim_cm_h / old_cm_h,
                        draggable_left  = parse_css(porselen_draggable.css("left"))  * dim_cm_w / old_cm_w,
                        por_img_width   = parse_css(img.css("width"))  * dim_cm_w / old_cm_w,
                        por_img_height  = parse_css(img.css("height")) * dim_cm_h / old_cm_h;
                    elem.css(clone_dims);
                    crop_cont.css(clone_dims);
                    ui_wrapper.css({ width:por_img_width+"px", height:por_img_height+"px"});
                    porselen_draggable.css({ top:draggable_top+"px", left:draggable_left+"px" });
                    img.css({  width:por_img_width+"px", height:por_img_height+"px" });
                    Siparis.porselenler[elem.attr("item-index")].ebat = ebat;
                },
                clone_porselen: function(){
                    this.kesim_bitir();
                    var clone_porselen = PorselenEditor.crop_container.clone();
                    var img = $(clone_porselen.find("img").get(0)),
                        porselen_draggable = $(clone_porselen.find(".porselen-draggable").get(0)),
                        ui_wrapper = $(clone_porselen.find(".ui-wrapper").get(0)),
                        resizable_handler = $(clone_porselen.find(".ui-resizable-handle"));
                    // resizable ikonlarini uçur
                    resizable_handler.remove();
                    var dims = cm_explode(this.aktif_ebat);
                        old_cm_w = PorselenEditor.crop_container.outerWidth(),
                        old_cm_h = PorselenEditor.crop_container.outerHeight();
                        // action btnlari koyabilmek için dışa container yapicaz
                        create_element = document.createElement("div"),
                        outer = $(create_element),
                        item_id = "POR"+Siparis.porselen_item_index;
                    outer.attr("item-index", item_id );
                    // taş donukse w,h yi swap yapiyoruz
                    if( this.tas_donuk ){
                        // taş ebatı
                        var dim_cm_w = cm_to_px(parseInt(dims[1])),
                            dim_cm_h = cm_to_px(parseInt(dims[0]));
                    } else {
                        var dim_cm_w = cm_to_px(parseInt(dims[0])),
                            dim_cm_h = cm_to_px(parseInt(dims[1]));
                    }
                    // yeni ebata gore inner elementlerin pozisyonlarini ve ebatlarini oranlama
                    var clone_dims = { width:dim_cm_w+"px", height:dim_cm_h+"px" },
                        draggable_top   = parse_css(PorselenEditor.draggable_img.css("top"))   * dim_cm_h / old_cm_h,
                        draggable_left  = parse_css(PorselenEditor.draggable_img.css("left"))  * dim_cm_w / old_cm_w,
                        por_img_width   = parse_css(PorselenEditor.uploaded_img.css("width"))  * dim_cm_w / old_cm_w,
                        por_img_height  = parse_css(PorselenEditor.uploaded_img.css("height")) * dim_cm_h / old_cm_h;    
                    clone_porselen.css(clone_dims);
                    outer.css(clone_dims);
                    ui_wrapper.css({ width:por_img_width+"px", height:por_img_height+"px"});
                    porselen_draggable.css({ top:draggable_top+"px", left:draggable_left+"px" });
                    img.css({  width:por_img_width+"px", height:por_img_height+"px" });
                    outer.append(clone_porselen);
                    outer.css({ position:"absolute", top:0, left:0});
                    outer.prepend('<i action="ebat-degistir" tip="porselen" ebat-bool="0" class="fa fa-minus" title="Taşı Küçült"></i>');
                    outer.prepend('<i action="ebat-degistir" tip="porselen" ebat-bool="1" class="fa fa-plus" title="Taşı Büyüt"></i>');
                    outer.append('<i action="sil"  tip="porselen" class="fa fa-remove" title="Kaldır"></i>');
                    outer.draggable({
                        // @BUG - 10.02.2018 - editore birden fazla porselen eklendikten sonra, bir kaçını sildiğimiz zaman
                        // kalan porseleni taşındığında item_id ile porselenin item-index ayni olmuyor nedense
                        // outer' i kontrol ettigimizde aktif porselenden farklı bir div i gösteriyor
                        // jquery exception atiyor drag sıçıyor, o yuzden sıçsa bile drag işlemi yapabilmek için kontrol yaptim şimdilik
                        // su an problem yok fakat sipariş düzenlemede problem
                        stop:function(){
                            //console.log(outer);
                            // duzenleme için editordeki pozisyonlarini güncelleiyor her drag da
                            if( Siparis.porselenler[item_id] != undefined ){
                                Siparis.porselenler[item_id].top = outer.css("top");
                                Siparis.porselenler[item_id].left = outer.css("left");
                            } else {
                                //console.log(item_id + " drag patladi.");
                            }
                        }
                    });
                    Siparis.urun_ekle( 'porselen', {
                        seri: PorselenEditor.aktif_seri,
                        ebat: PorselenEditor.aktif_ebat,
                        item_index: item_id,
                        rotated:this.tas_donuk,
                        top:0,
                        left:0,
                        ext: Siparis.porselen_files[item_id].name.substr( Siparis.porselen_files[item_id].name.lastIndexOf(".")+1 )
                    });  
                    temp_upload( Siparis.porselen_files[item_id], PorselenEditor.temp_canvas, item_id, function(res){
                        Siparis.porselen_files[item_id]["upload_ok"] = res.ok;
                    });
                    return outer;
                },
                // editor de çeşitli hareketler yaptiysa kullanici, kesim modunu baslatiyoruz
                kesim_baslat:function(){
                    this.uploaded_img.css({opacity:0.5});
                    this.crop_container.css({overflow:"unset"});
                    this.kesim_devam_ediyor = true;
                    this.kesim_bitti_btn.html("<i class=\"fa fa-check\"></i> Kesimi Tamamla");
                },
                kesim_bitir: function(){
                    this.uploaded_img.css({opacity:1});
                    this.crop_container.css({overflow:"hidden"});
                    this.kesim_devam_ediyor = false;
                    this.kesim_bitti_btn.html("<i class=\"fa fa-edit\"></i> Kesime Devam Et");
                },
                // seri degistirme fonksiyonu
                seri_sec: function( _this ){
                   // aktif serinin butonunu kirmizi yap
                   $("[seri='"+this.crop_container.attr("activeclass")+"']").removeClass("btn-success").addClass("btn-danger");
                   // yeni serinin butonunu yesil yap
                   _this.removeClass("btn-danger").addClass("btn-success");
                   // onceki seride taşı döndürüyse geri çekebilmek için 
                   var old_seri = this.aktif_seri;
                   // onizleme container i guncelle
                   this.crop_container.removeClass(this.crop_container.attr("activeclass")).addClass(_this.attr("seri")).attr("activeclass", _this.attr("seri"));
                   this.aktif_seri = _this.attr("seri");
                   this.crop_container.removeClass(old_seri+"-porselen-rotate");
                   // aciyi her turlu sifirliyoruz
                   this.porselen_aci = 0;
                   this.tas_donuk = false;
                   // taş döndürme her seri de yapilmayacak, onu kontrol et
                   if( this.aktif_seri == "kare" || this.aktif_seri == "daire" || this.aktif_seri == "kubbe" ){
                      this.tasrright.get(0).disabled = true;
                   } else {
                      this.tasrright.get(0).disabled = false;
                   }
                   this.aktif_ebat = ebat_options[this.aktif_seri][0];
                },
                // crop islemi onaylandiktan sonra taşa uygula
                crop_to_tas: function (){
                   // resme uygula, resize yapmasi kolay olsun diye küçültü
                   this.uploaded_img.css({width:temp_crop_data.w+"px", height:temp_crop_data.h+"px"});
                   // jqueryui nin olusturdugu div lere de uyguluyoruz
                   this.uploaded_img.parent().css({width:temp_crop_data.w+"px", height:temp_crop_data.h+"px"});
                   // ana sayfadan reset butonu için degerleri kaydediyor attr olarak
                   this.uploaded_img.attr("def-width", temp_crop_data.w);
                   this.uploaded_img.attr("def-height", temp_crop_data.h);
                }
            };
            PorselenEditor.init();
             
            // yazi ekleme editoru
            // ahsaphobbynet icin yaptigim editor, common.js ile calisiyor jquery yok
            var AHEditor = {
                text:"Sucuoglu",
                editor_input:null,
                old_img:null,
                preview:null,
                url_prefix: "<?php echo URL_AH_EDITOR_PREVS ?>",
                color_pickers: null,
                cp_settings: {

                },
                ah_bg_transparent_cb:null,
                init: function(){
                  this.editor_input     = $AH('editor-text');
                  this.preview      = $AH('editor-preview-img');
                  this.text_color_input = $AH('ah_text_color');
                  this.bg_color_input = $AH("ah_bg_color");
                  this.Font_Select.init();
                  this.ah_bg_transparent_cb = $("#ah_bg_transparent");

                  $(this.bg_color_input).colorpicker(this.cp_settings).on('colorpickerChange', debounce(function (e) {
                      AHEditor.request_preview();
                      AHEditor.ah_bg_transparent_cb.get(0).checked = false;
                  }, 500, false) );

                  $(this.text_color_input).colorpicker(this.cp_settings).on('colorpickerChange', debounce(function (e) {
                      AHEditor.request_preview();
                  }, 500, false) );

                  this.bg_color_input.value = "YOK";

                  this.ah_bg_transparent_cb.change(function(){
                      if( this.checked ){
                          AHEditor.bg_color_input.value = "YOK";
                      } else {
                          AHEditor.bg_color_input.value = "#FFFFFF";
                      }
                      AHEditor.request_preview();
                  });

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
                      text_color: this.text_color_input.value,
                      bg_color:   this.bg_color_input.value
                    }),
                    function( r ){
                      //console.log(r);
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
                refresh_cps: function(){
                    $(this.text_color_input).trigger("change");
                    // eger arka plan rengi yok degilse, colorpicker i resetliyoruz renge göre
                    if( this.bg_color_input.value != "YOK" ){
                        // duzenleme
                        $(this.bg_color_input).trigger("change");
                        this.ah_bg_transparent_cb.get(0).checked = false;
                    } else {
                        // init olayı 
                        this.ah_bg_transparent_cb.get(0).checked = true;
                    }       
                },
                reset: function(){
                    this.text = "Sucuoglu";
                    this.editor_input.value = "";
                    this.old_img = null;
                    this.preview.src = "<?php echo URL_IMGS . "ah_editor_placeholder.png" ?>";
                    this.text_color_input.value = "#000000";
                    this.bg_color_input.value = "YOK";
                    this.refresh_cps();
                },
                // editorden yaziyi sildiginde, sunucudan da sil
                delete_img: function( src ){
                    REQ.ACTION("", { req:"ah_delete_img", src:src }, function(res){
                        //console.log(res);
                    });
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

              add_event( AHEditor.bg_color_input, "change", function(e){
                AHEditor.update_preview();
              });


         
         });
      </script>
   </body>
</html>