<?php
    require 'inc/defs.php';
    require CLASS_DIR . "CanvasUpload.php";
    require CLASS_DIR . "ImageUpload.php";
    require CLASS_DIR . "TempUpload.php";  
    require CLASS_DIR . "PorselenSiparis.php";  

    if( $_POST ){

        $OK = 1;
        $TEXT = "";
        $DATA = array();


        switch( Input::get("req") ){

            case 'porselen_siparis_yukle':

                $PorselenSiparis = new PorselenSiparis;
                if( !$PorselenSiparis->ekle( Input::escape($_POST), $_FILES ) ){
                    $OK = 0;
                }
                $TEXT = $PorselenSiparis->get_return_text();

            break;

            case 'porselen_siparis_duzenle':

                if( isset($_GET["parent_gid"]) && isset($_GET["parent_item_id"])) {
                  $PorselenSiparis = new PorselenSiparis( array( "parent_gid" => $_GET["parent_gid"],  "parent_item_id" => $_GET["parent_item_id"] ));
                } else {
                    $PorselenSiparis = new PorselenSiparis( $_GET["item_id"] );
                }
                if( $PorselenSiparis->is_ok()){
                    if( !$PorselenSiparis->duzenle( Input::escape($_POST), $_FILES ))  {
                        $OK = 0;
                    }
                } else {
                    $OK = 0;
                }
                $TEXT = $PorselenSiparis->get_return_text();


            break;  

            case 'data_download':
              
              if( isset($_GET["parent_gid"]) && isset($_GET["parent_item_id"])) {
                  $PorselenSiparis = new PorselenSiparis( array( "parent_gid" => $_GET["parent_gid"],  "parent_item_id" => $_GET["parent_item_id"] ));
              } else {
                  $PorselenSiparis = new PorselenSiparis( $_POST["item_id"] );
              }
              if( !$PorselenSiparis->is_ok() || $PorselenSiparis->get_details("kullanici") != User::get_data("user_id") ){
                  $OK = 0;
                  $TEXT = $PorselenSiparis->get_return_text();
              } else {
                  $DATA = $PorselenSiparis->get_details();
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

    // js flag
    $DUZENLEME_FLAG = isset($_GET["item_id"]);

    // baslik editorden resim ekleme
    $PORTABLE_FLAG = isset($_GET["portable"]);

    if( !$DUZENLEME_FLAG ){
        $GID = User::get_data("user_id") ."_" . Common::generate_random_string(30);
    } else {
        $GID = "";
    }
    

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
         <div class="porselen-crop-container oval" activeclass="oval">
            <div id="porselen-draggable">
               <img id="uploaded" class="img-responsive" alt="" src="">

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
             <!-- <button class="btn btn-sm btn-danger grup-btn"  seri="kalp"><i class="fa fa-angle-double-right"></i> Kalp</button> -->
         </div>
         
         <!-- <button class="btn btn-sm btn-danger" id="ayar-btn" seri="kalp">Kalp</button> -->
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
             <button class="btn btn-sm btn-success ayar-btn" ayar="indir"><i class="fa fa-save"></i> Kaydet</button>
          </div>

      </div>
      <div id="crop_modal" class="modal fade" role="dialog">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Siparişinizi Kaydedin</h4>
               </div>
               <div class="modal-body" id="crop_modal_body">
                  <div class="row">
                      <div class="col-md-5 col-xs-12 col-sm-12" id="modal_preview"> 

                      </div>
                      <div class="col-md-4 col-xs-12 col-sm-12" id="modal_form">
                          <form class="form-horizontal form-label-left">
                            <div class="form-group portable-hide" >
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ebat *</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control" id="ebat_select">
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group portable-hide">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Adet *</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="adet" value="1" /> 
                                </div>
                            </div>

                            <div class="form-group portable-hide">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">İsim *</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="isim" value="<?php echo Guest::get_data("user_name") ?>" /> 
                                </div>
                            </div>
                            <div class="form-group portable-hide">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefon</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="telefon" value="<?php echo Guest::get_data("user_telefon") ?>" /> 
                                </div>
                            </div>
                            <div class="form-group portable-hide">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Eposta</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="eposta" value="<?php echo Guest::get_data("user_email") ?>" /> 
                                </div>
                            </div>

                            <div class="form-group ">
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
      <div id="cropper_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Resim Yükle & Düzenle</h4>
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

</svg> 

      <script>  
         $(document).ready(function(){

               // editor de çeşitli hareketler yaptiysa kullanici, kesim modunu baslatiyoruz
               function kesim_baslat(){
                  uploaded_img.css({opacity:0.5});
                  crop_container.css({overflow:"unset"});
                  kesim_devam_ediyor = true;
                  kesim_bitti_btn.html("<i class=\"fa fa-check\"></i> Kesimi Tamamla");
               }

               function kesim_bitir(){
                  uploaded_img.css({opacity:1});
                  crop_container.css({overflow:"hidden"});
                  kesim_devam_ediyor = false;
                  kesim_bitti_btn.html("<i class=\"fa fa-edit\"></i> Kesime Devam Et");
               }

               // seri degistirme fonksiyonu
               function seri_sec( _this ){
                   // aktif serinin butonunu kirmizi yap
                   $("[seri='"+crop_container.attr("activeclass")+"']").removeClass("btn-success").addClass("btn-danger");
                   // yeni serinin butonunu yesil yap
                    _this.removeClass("btn-danger").addClass("btn-success");
                   var old_seri = aktif_seri;
                   // onizleme container i guncelle
                   crop_container.removeClass(crop_container.attr("activeclass")).addClass(_this.attr("seri")).attr("activeclass", _this.attr("seri"));
                   aktif_seri = _this.attr("seri");
                   crop_container.removeClass(old_seri+"-porselen-rotate");
                   // aciyi her turlu sifirliyoruz
                   porselen_aci = 0;
                   tas_donuk = false;
                   // taş döndürme her seri de yapilmayacak, onu kontrol et
                   if( aktif_seri == "kare" || aktif_seri == "daire" || aktif_seri == "kubbe" ){
                      tasrright.get(0).disabled = true;
                   } else {
                      tasrright.get(0).disabled = false;
                   }
                   aktif_ebat = ebat_options[aktif_seri][0];
               }


               // crop islemi onaylandiktan sonra taşa uygula
               function crop_to_tas(){
                   // resme uygula, resize yapmasi kolay olsun diye küçültü
                   uploaded_img.css({width:temp_crop_data.w+"px", height:temp_crop_data.h+"px"});
                   // jqueryui nin olusturdugu div lere de uyguluyoruz
                   uploaded_img.parent().css({width:temp_crop_data.w+"px", height:temp_crop_data.h+"px"});
                   // ana sayfadan reset butonu için degerleri kaydediyor attr olarak
                   uploaded_img.attr("def-width", temp_crop_data.w);
                   uploaded_img.attr("def-height", temp_crop_data.h);
               }

               // duzenleme - portable data download func
               function data_download( data ){
                  PamiraNotify("warning", "Lütfen bekleyin", "Sipariş verisi indiriliyor." );
                  REQ.ACTION("", extend( {req:"data_download"}, data ), function(res){
                      if(!res.ok){
                          PNotify.notices[0].remove();
                          return;
                      }
                      // portable duzenleme kontrolü
                      if( portable && res.ok ) portable_edit_flag = true;
                      //console.log(res);
                      var js_data = JSON.parse(res.data.edit_data);
                      //console.log(js_data);
                      kesim_baslat();
                      // cropper resim init
                      cropper_img.attr("src", resim_url_prefix+res.data.gid+"/PORX."+res.data.orjinal_resim_ext);
                      // modal larda garip hareketler yapiyor cropper o yuzden, modal acildiktan sonra init ediyoruz
                      cropper_modal.on('shown.bs.modal', function () {
                          if( !duzenleme && !portable ) return; // duzenleme sonrasi, yeni sipariş falan verirse bu eventi calistirmicaz
                          if( cropper == undefined ) cropper = new Cropper( cropper_img.get(0), extend( cropper_init_data, { data:js_data.cropper_data.data } ) );
                      });
                      // editor resim init
                      uploaded_img.attr("src", resim_url_prefix+res.data.gid+"/PORX_cropped.png");
                      // editor resim boyutlandirma
                      uploaded_img.css({ height:js_data.img_data.height, width:js_data.img_data.width });
                      // resim reset verileri 
                      uploaded_img.attr("def-width", js_data.img_data.def_width);
                      uploaded_img.attr("def-height", js_data.img_data.def_height);
                      // resim container boyutlandirma
                      uploaded_img.parent().css({ width:js_data.img_data.width, height:js_data.img_data.height });
                      // resmin taş üzerindeki pozisyonu
                      draggable_img.css({ top:js_data.img_data.top, left:js_data.img_data.left});
                      // arka plan
                      crop_container.css({"background-color":js_data.img_data.tas_bg_color});
                      // taş açısı init
                      porselen_aci = js_data.img_data.tas_aci;
                      tas_donuk = js_data.img_data.tas_donuk_flag;
                      if( tas_donuk ) crop_container.addClass("porselen-rotate");
                      // taş seri init
                      seri_sec($("[seri='"+res.data.seri+"']"));
                      // edit datayi init et
                      edit_data = js_data;
                      siparis_gid = res.data.gid;
                      // siparis form doldur
                      crop_modal_adet_input.val(res.data.adet);
                      // portable da $_GET ile aliyoruz ebatı
                      if( !portable ){
                          crop_modal_ebat_select.val(res.data.ebat);
                          aktif_ebat = res.data.ebat;
                      }
                      crop_modal_not_input.val(res.data.notlar);
                      PNotify.notices[0].remove();
                  });
               }
  
               var siparis_gid = "<?php echo $GID ?>",
                   duzenleme = <?php echo (int)$DUZENLEME_FLAG ?>,
                   portable  = <?php echo (int)$PORTABLE_FLAG ?>,
                   // portable da editorden yeni mi eklenecek, yoksa eklenmiş olan mı düzeltilecek bayragi
                   portable_edit_flag = false,
                   allowed_exts = ["image/jpeg", "image/png", "image/bmp", "image/gif"],
                   // ebat seçenekleri
                   ebat_options = { oval:["8x10 cm", "9x12 cm", "11x15 cm", "13x18 cm", "18x24 cm", "24x30 cm"],
                                    dikdortgen:["9x12 cm", "11x15 cm", "13x18 cm", "18x24 cm", "24x30 cm"],
                                    daire:["10x10 cm", "15x15 cm", "20x20 cm", "25x25 cm"],
                                    kare:["10x10 cm", "15x15 cm", "20x20 cm"],
                                    kubbe:[ "10x14 cm", "15x20 cm", "18x24 cm"]
                   },
                   // kesim için taş ebatlari [ w, h ]
                   seri_dimensions = {
                      oval: [240, 327],
                      kare: [327, 327],
                      dikdortgen:[250, 327],
                      daire:[327, 327],
                      kubbe:[240, 327]
                   },
                   // db icin javascript verileri
                   edit_data = {},
                   // singleton cropper objesi
                   cropper,
                   // ana onizleme elementi - ss aldigimiz element
                   crop_container = $(".porselen-crop-container"),
                   // ana ekrandaki resim, crop container in içindeki
                   uploaded_img = $("#uploaded"),
                   // draggable div, uploaded_img in parenti ( resizable ve draggable i ayni anda uygulamak için )
                   draggable_img = $("#porselen-draggable");
                   // tamamla indir sonrasi acilan form modal
                   crop_modal = $("#crop_modal"),
                   // crop_container modal in içerik elementi
                   crop_modal_body = $("#crop_modal_body"),
                   // modal önizleme resmin eklenecegi sol taraf
                   crop_modal_preview = $("#modal_preview"),
                   // siparis formu
                   crop_modal_form = $("#modal_form"),
                   // aktif seriye gore option lari degisecek select input
                   crop_modal_ebat_select = $("#ebat_select"),
                   // adet input
                   crop_modal_adet_input = $("#adet"),
                   // not input
                   crop_modal_not_input = $("#not"),
                   // upload sonrasi tempten alip, cropper aksiyonlari yaptigimiz resim ( modal da )
                   cropper_img = $("#cropper_img"),
                   // cropper aksiyonlarinin modal i
                   cropper_modal = $("#cropper_modal"),
                   // kesimi işlemi tamamlanip - tamamlanmadi mi flag i
                   kesim_devam_ediyor = true,
                   // kesip bitme - devam etme butonu
                   kesim_bitti_btn = $("[ayar='kesimok']"),
                   // taşın dönme açısı
                   porselen_aci = 0,
                   // aktif seri
                   aktif_seri = "oval",
                   // secili ebat, her form init te ilk options u seçmesin diye
                   aktif_ebat = "8x10",
                   // tas dondurme butonlari
                   tasrright =  $('[ayar="tasrrotate"]'),
                   // tekli siparis upload icin kullanilacak formdata objesi
                   siparis_form_data = null,
                   // editore upload edilen resim objecsi
                   temp_file = null,
                   // preview canvas
                   temp_canvas = null,
                   // tasin donme durumu ( keserken dimensions swap icin )
                   tas_donuk = false,
                   // resim url prefixleri,
                   resim_url_prefix = "<?php echo URL_UPLOADS_PORSELEN ?>",
                   // cropper init objesi
                   cropper_init_data = {
                       aspectRatio: NaN,  // free olarak crop edebilsin
                       viewMode: 1, // height e uygun küçült resmi
                       crop: function(e) {
                         // aspect ratio bozmadan 230 width e denk gelen height i hesapla
                         var ar_height = 230 * e.detail.height / e.detail.width;
                         temp_crop_data = {w:230, h:ar_height};
                       }
                   },
                   // cropper le kesme islemi yapildiginda, taşa uygulanacak hareketleri tuttugumuz degisken
                   // crop(e) metodundan alinan veriler
                   temp_crop_data = {};
               // jquery ui hareketleri
               draggable_img.draggable({
                drag: function(event, ui){
                      kesim_baslat();
                  }
               });
               // aspect ratio seçenek olarak koyulabilir
               uploaded_img.resizable();

               $("#arkaplanbtn").colorpicker({
                    inline: true,
                    container: true
               }).on('colorpickerChange colorpickerCreate', function (e) {
                    crop_container.css({"background-color":e.color.toString("hex") + "!important"});
               });

               if( portable ){
                    data_download({});
                    <?php if( isset($_GET["tas_donuk"]) ){ ?>
                        tas_donuk = true;
                        crop_container.addClass("porselen-rotate");
                        porselen_aci = 90;
                    <?php } ?>
                    <?php if( isset($_GET["seri"])) { ?>
                        seri_sec($("[seri='<?php echo $_GET["seri"] ?>']"));
                    <?php } ?>

                    <?php if( isset($_GET["ebat"])) { ?>
                        aktif_ebat = "<?php echo $_GET["ebat"] ?>";
                        crop_modal_ebat_select.val(aktif_ebat);
                    <?php } ?>
                    // final formda ebat ve adeti gizle
                    crop_modal_adet_input.val(1);
                    $(".portable-hide").hide();
               }

               // duzenleme yapiliyorsa ayarlamalari yap
               if( duzenleme ){
                    <?php if(isset($_GET["item_id"])){ ?>
                        data_download( {item_id:"<?php echo $_GET["item_id"] ?>"});
                    <?php } ?>
               }

               // seri değiştirme butonlari
               $(".grup-btn").click(function(){
                   seri_sec($(this));
               });
         
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
                         temp_file = file;
                     } 
               });

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
                  form_data.append("parent_gid", siparis_gid );
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
                          //console.log("Temp upload tamamlandı.");
                      }
                  });
               }

               // croppper modal daki ayar butonlari
               $(".cropper-btn").click(function(){
                   var req = this.getAttribute("ayar");
                   switch(req){
                       case 'cropperok':
                         var canvas = cropper.getCroppedCanvas({fillColor: '#fff'}).toDataURL('image/png');
                         uploaded_img.attr("src", canvas );
                         cropper_modal.modal('hide');
                         // kesim ayarlarini taşa uygula
                         crop_to_tas();
                         kesim_baslat();
                         // resmi upload et, (server-side da eski resmi siliyor)
                         temp_upload( temp_file, canvas, "PORX", false);
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

               // sipariş tamamlama formundaki ebat select value sunu tutmak için
               crop_modal_ebat_select.change(function(){
                  aktif_ebat = this.value;
               });
              
               $("#siparis_yukle").click(function(){
                  if( !window.FormData ){
                      // form data yoksa error vericez
                      // önizlemeyi bi sekilde ulastirabilirsek guzel olur
                      alert("Sitemiz kullandığınız tarayıcı versiyonunu desteklemiyor. Yalnızca önizleme yapabilirsiniz.");
                      return false;
                  }

                  var isim_val = $("#isim").val(), telefon_val = $("#telefon").val(), eposta_val = $("#eposta").val();
                  if( !portable ){
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
                  }

                  // form kontrolleri yapiyoruz
                  form_data = new FormData();
                  var adet_val = crop_modal_adet_input.val();
                  if( !FormValidation.req(adet_val) || !FormValidation.numeric(adet_val) || !FormValidation.not_zero(adet_val) || !FormValidation.int_only(adet_val) ){
                      PamiraNotify("error", "Hata", "Formda hatalar var." );
                      return;
                  }

                  if( portable ){
                      <?php if( isset($_GET["parent_gid"])){ ?>
                        form_data.append("parent_gid", "<?php echo $_GET["parent_gid"] ?>");
                      <?php } ?>
                      <?php if( isset($_GET["parent_item_id"])){ ?>
                        form_data.append("parent_item_id", "<?php echo $_GET["parent_item_id"] ?>");
                      <?php } ?>
                  }

                  PamiraNotify("info", "İşlem Yapılıyor", "Siparişiniz siteye yükleniyor.. Lütfen bekleyin.");
                  var _this = this;
                  _this.disabled = true;
                  // siparis duzenlerken, editoru init edecegimiz verileri de kaydediyoruz
                  edit_data["img_data"] = {
                      width: uploaded_img.css("width"),
                      height: uploaded_img.css("height"),
                      left: draggable_img.css("left"),
                      top: draggable_img.css("top"),
                      def_height: uploaded_img.attr("def-height"),
                      def_width: uploaded_img.attr("def-width"),
                      tas_donuk_flag: tas_donuk,
                      tas_bg_color: crop_container.css("background-color"),
                      tas_aci: porselen_aci
                  };
                  // eger duzenleme esnasinda, cropper init edilmemişse adam resimle-cropper la oynamamis demek
                  // o durumda cropper verisini değiştirmiyoruz
                  if( cropper != undefined ){
                      extend( edit_data, {
                          cropper_data:{
                            image_data: cropper.getImageData(),
                            canvas_data: cropper.getCanvasData(),
                            crop_box_data: cropper.getCropBoxData(),
                            container_data: cropper.getContainerData(),
                            data: cropper.getData()
                          }
                      });
                      //form_data.append("cropped_img", cropper.getCroppedCanvas({fillColor: '#fff'}).toDataURL('image/png'));
                  } 
                  form_data.append("gid", siparis_gid);
                  form_data.append("ebat", crop_modal_ebat_select.val());
                  form_data.append("adet", adet_val);
                  form_data.append("notlar", crop_modal_not_input.val());
                  form_data.append("eposta", eposta_val);
                  form_data.append("isim", isim_val);
                  form_data.append("telefon", telefon_val);
                  form_data.append("seri", aktif_seri);
                  form_data.append("preview", temp_canvas.toDataURL("image/png") );
                  //form_data.append("resim", temp_file );
                  form_data.append("edit_data", JSON.stringify(edit_data, null, 2));
                  if( duzenleme || portable_edit_flag ){
                      form_data.append("req", "porselen_siparis_duzenle");
                  } else {
                      form_data.append("req", "porselen_siparis_yukle");
                  }
                  //console.log( edit_data );
                  $.ajax({
                      url: "",
                      data: form_data,
                      processData: false,
                      contentType: false,
                      type: 'POST',
                      success: function( res ){
                          // contenttype false oldugu icin, parse ediyoruz json responsu manuel olarak
                          var obj = JSON.parse(res);
                          console.log(obj);
                          if( obj.ok ){
                              PamiraNotify("success", "İşlem Tamam", obj.text);
                              _this.disabled = false;
                              // sipariş modalini kapat
                              crop_modal.modal("hide");
                              if( duzenleme || portable ) return;
                              // preview ve orjinal dosyalari temizle
                              temp_file = null;
                              temp_canvas = null;
                              // sipariş formunu resetle
                              crop_modal_adet_input.val(1);
                              crop_modal_not_input.val("");
                              // formdata reset
                              form_data = null;
                              // editor ve cropper deki resimleri sıfırla
                              uploaded_img.attr("src", "");
                              cropper_img.attr("src", "");
                              // cropper i destroy et
                              cropper.destroy();
                              // edit datayi sifirla
                              edit_data = {};
                          } else {
                              PamiraNotify("error", "Hata", obj.text);
                          }
                          _this.disabled = false;
                      }
                  });
               });

               // ana ekran ayar butonlari
               $(".ayar-btn").click(function(){
                   var tip = this.getAttribute("ayar");
                   switch(tip){
                     case 'resimupload':
                         cropper_modal.modal({
                           backdrop:'static' // arkadaki siyahliga basinca kapatmasin, cropper da sorun oluyor
                         });
                     break;

                     case 'kesimok':
                          if( !duzenleme && !portable && temp_file == undefined ){
                              PamiraNotify("error", "Hata", "Editöre resim yüklenmemiş. \"Resim Yükle & Düzenle\" butonunu kullanarak resim yükleyin.");
                              return false;
                          }
                          if( kesim_devam_ediyor ){
                              kesim_bitir();
                          } else {
                              kesim_baslat();
                          }
                     break;


                     case 'tasrrotate':
                          porselen_aci += 90;
                          if( porselen_aci == 180 || porselen_aci == 0 ){
                              crop_container.removeClass(aktif_seri+"-porselen-rotate");
                              crop_container.addClass(aktif_seri);
                              porselen_aci = 0;
                              tas_donuk = false;
                          } else {
                              crop_container.addClass(aktif_seri+"-porselen-rotate");
                              crop_container.removeClass(aktif_seri);
                              tas_donuk = true;
                          }
                     break;
         
                     case 'resimreset':
                         if( !duzenleme && !portable && temp_file == undefined ){
                            PamiraNotify("error", "Hata", "Editöre resim yüklenmemiş. \"Resim Yükle & Düzenle\" butonunu kullanarak resim yükleyin.");
                            return false;
                         }
                         // sağ alttaki jqueryui icon, css degisiminde eski yerinde kaliyor
                         // o yuzden resizable i reset ediyoruz
                         uploaded_img.resizable("destroy");
                         uploaded_img.css({width:uploaded_img.attr("def-width")+"px", height:uploaded_img.attr("def-height")+"px"});
                         uploaded_img.parent().css({ left:0+"px", top:0+"px"});
                         draggable_img.css({ left:0+"px", top:0+"px"});
                         uploaded_img.resizable();
                         kesim_baslat();
                     break;
         
                     case 'indir':
                        // editor de resim var mi kontrol et
                        if( !duzenleme && !portable && temp_file == undefined ){
                            PamiraNotify("error", "Hata", "Editöre resim yüklenmemiş. \"Resim Yükle & Düzenle\" butonunu kullanarak resim yükleyin.");
                            return false;
                        }
                        kesim_bitir();
                        var dimensions_data;
                        // taşı çevirmişse, w ile h yi swap ediyoruz keserken
                        if( tas_donuk ){
                            dimensions_data = { width:seri_dimensions[aktif_seri][1] + 20, height:seri_dimensions[aktif_seri][0] };
                        } else {
                            dimensions_data = { width:seri_dimensions[aktif_seri][0] + 20, height:seri_dimensions[aktif_seri][1]}
                        }
                        html2canvas(crop_container.get(0), extend( { async:false }, dimensions_data )).then(function(canvas) {
                            temp_canvas = canvas;
                            // onizleme init
                            crop_modal_preview.html( canvas );
                            // select i seriye göre ayarla
                            console.log(aktif_ebat);
                            add_options( crop_modal_ebat_select.get(0), true, ebat_options[aktif_seri], aktif_ebat, true );
                            crop_modal.modal("show");
                        });
                     break;
                   }
               });
         
         
         
         });
      </script>
   </body>
</html>