<?php
   require 'inc/defs.php';
   
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
      <link href="./main.82cfd66e.css" rel="stylesheet" />
      <link href="./obarey.css" rel="stylesheet" />
      <link href="./bootstrap.css" rel="stylesheet" />
      <script type="text/javascript" src="./common.js"></script>
      <script type="text/javascript" src="./jquery.js"></script>
      <script type="text/javascript" src="./main.85741bff.js"></script>
      <script type="text/javascript" src="./bootstrap.js"></script>
      <link  href="./cropper.css" rel="stylesheet">
      <script src="./cropper.js"></script>
   </head>
   <body>
      <div class="row porselen-crop-grup section-container-spacer">
         <div class="porselen-crop-container oval" activeclass="oval">
            <div id="porselen-draggable">
               <img id="uploaded" class="img-responsive" alt="" src="">
            </div>
         </div>
      </div>
      <div class="porselen-gruplar" >
         <button class="btn btn-sm btn-success grup-btn" seri="oval"><i class="fa fa-angle-double-right"></i> Oval</button>
         <button class="btn btn-sm btn-danger grup-btn"  seri="kare"><i class="fa fa-angle-double-right"></i> Kare</button>
         <button class="btn btn-sm btn-danger grup-btn"  seri="dikdortgen"><i class="fa fa-angle-double-right"></i> Dikdörtgen</button>
         <button class="btn btn-sm btn-danger grup-btn"  seri="daire"><i class="fa fa-angle-double-right"></i> Daire</button>
         <button class="btn btn-sm btn-danger grup-btn"  seri="kubbe"><i class="fa fa-angle-double-right"></i> Oval Kubbe</button>
         <!-- <button class="btn btn-sm btn-danger" id="ayar-btn" seri="kalp">Kalp</button> -->
      </div>
      <div class="porselen-gruplar">
         <button class="btn btn-sm btn-primary ayar-btn" ayar="resimupload"><i class="fa fa-upload"></i> Resim Yükle & Düzenle</button>
         <button class="btn btn-sm btn-default ayar-btn" ayar="resimreset"><i class="fa fa-refresh"></i> Resim Reset</button>
         <button class="btn btn-sm btn-default ayar-btn" ayar="taslrotate"><i class="fa fa-rotate-left"></i> </button>
         <button class="btn btn-sm btn-default ayar-btn" ayar="tasrrotate"><i class="fa fa-rotate-right"></i> </button>
         
      </div>
      <div class="porselen-gruplar">
         <button class="btn btn-sm btn-primary ayar-btn" ayar="kesimok"><i class="fa fa-check"></i> Kesimi Tamamla</button>
         <button class="btn btn-sm btn-success ayar-btn" ayar="indir"><i class="fa fa-download"></i> İndir & Gönder</button>
      </div>
      </div>
      <div id="crop_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tamamla</h4>
               </div>
               <div class="modal-body" id="crop_modal_body">
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
                  <div class="row" style="text-align:center; margin-top:15px">
                     <button class="btn btn-sm btn-default cropper-btn" ayar="cropperreset"><i class="fa fa-refresh"></i> Reset</button>
                     <button class="btn btn-sm btn-primary cropper-btn" ayar="cropperrleft"><i class="fa fa-rotate-left"></i></button>
                     <button class="btn btn-sm btn-primary cropper-btn" ayar="cropperrright"><i class="fa fa-rotate-right"></i></button>
                     <button class="btn btn-sm btn-success cropper-btn" ayar="cropperok"><i class="fa fa-check"></i> Tamam</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="jquery-ui.js"></script>
      <script src="html2canvas.min.js"></script>
      <link href="jquery-ui.css" rel="stylesheet">
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
         
               var allowed_exts = ["image/jpeg", "image/png", "image/bmp", "image/gif"],
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
                   // tas dondurme butonlari
                   tasrleft =  $('[ayar="taslrotate"]'),
                   tasrright =  $('[ayar="tasrrotate"]');
               // jquery ui hareketleri
               draggable_img.draggable({
                drag: function(event, ui){
                      kesim_baslat();
                  }
               });
               uploaded_img.resizable();
         
               // seri değiştirme butonlari
               $(".grup-btn").click(function(){
                   var _this = $(this);
                   // aktif serinin butonunu kirmizi yap
                   $("[seri='"+crop_container.attr("activeclass")+"']").removeClass("btn-success").addClass("btn-danger");
                   // yeni serinin butonunu yesil yap
                    _this.removeClass("btn-danger").addClass("btn-success");
                   // onizleme container i guncelle
                   crop_container.removeClass(crop_container.attr("activeclass")).addClass(_this.attr("seri")).attr("activeclass", _this.attr("seri"));
                   aktif_seri = _this.attr("seri");
                   // taş döndürme her seri de yapilmayacak, onu kontrol et
                   if( aktif_seri == "kare" || aktif_seri == "daire" || aktif_seri == "kubbe" ){
                      tasrleft.get(0).disabled = true;
                      tasrright.get(0).disabled = true;
                   } else {
                      tasrleft.get(0).disabled = false;
                      tasrright.get(0).disabled = false;
                   }
               });
         
               // cropper modal file input
               $("#upload").change(function(ev){
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
                             cropper = new Cropper(cropper_img.get(0), {
                             aspectRatio: NaN,  // free olarak crop edebilsin
                             viewMode: 1, // height e uygun küçült resmi
                             crop: function(e) {
                               // aspect ratio bozmadan 230 width e denk gelen height i hesapla
                               var ar_height = 230 * e.detail.height / e.detail.width;
                               // resme uygula, resize yapmasi kolay olsun diye küçültü
                               uploaded_img.css({width:230+"px", height:ar_height+"px"});
                               // jqueryui nin olusturdugu div lere de uyguluyoruz
                               uploaded_img.parent().css({width:230+"px", height:ar_height+"px"});
                               // ana sayfadan reset butonu için degerleri kaydediyor attr olarak
                               uploaded_img.attr("def-width", 230);
                               uploaded_img.attr("def-height", ar_height);
                             }
                           });
                         };
                         // tempden resim url i al
                         reader.readAsDataURL( file );
                     } 
               });
         
               // croppper modal daki ayar butonlari
               $(".cropper-btn").click(function(){
                   var req = this.getAttribute("ayar");
                   switch(req){
                       case 'cropperok':
                         uploaded_img.attr("src", cropper.getCroppedCanvas({fillColor: '#fff'}).toDataURL('image/jpeg') );
                         cropper_modal.modal('hide');
                         kesim_baslat();
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
                          if( kesim_devam_ediyor ){
                              kesim_bitir();
                          } else {
                              kesim_baslat();
                          }
                     break;

                     case 'taslrotate':
                          porselen_aci -= 90;
                          if( porselen_aci == -180 || porselen_aci == 0 ){
                              crop_container.removeClass("porselen-rotate");
                              porselen_aci = 0;
                          } else {
                              crop_container.addClass("porselen-rotate");
                          }
                     break;

                     case 'tasrrotate':
                          porselen_aci += 90;
                          if( porselen_aci == 180 || porselen_aci == 0 ){
                              crop_container.removeClass("porselen-rotate");
                              porselen_aci = 0;
                          } else {
                              crop_container.addClass("porselen-rotate");
                          }
                          //crop_container.css({transform:"rotate("+porselen_aci+"deg)"});
                     break;
         
                     case 'resimreset':
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
                        kesim_bitir();
                        html2canvas(crop_container.get(0), { async:false, width:360, height:330}).then(function(canvas) {
                            crop_modal.modal("show");
                            crop_modal_body.html( canvas );
                        });
         
                     break;
                   }
               });
         
         
         
         });
      </script>
   </body>
</html>