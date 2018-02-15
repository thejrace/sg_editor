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
<link href="<?php echo URL_CSS ?>obarey.css" rel="stylesheet" />
<link href="<?php echo URL_CSS ?>bootstrap.css" rel="stylesheet" />
<link href="<?php echo URL_CSS; ?>pnotify.css" rel="stylesheet">
<link href="<?php echo URL_CSS; ?>pnotify.buttons.css" rel="stylesheet">
<link href="<?php echo URL_CSS; ?>pnotify.nonblock.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo URL_JS ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo URL_JS ?>common.js"></script>
<script type="text/javascript" src="<?php echo URL_JS ?>main.85741bff.js"></script>
<script type="text/javascript" src="<?php echo URL_JS ?>bootstrap.js"></script>

<script src="<?php echo URL_JS; ?>pnotify.js"></script>
<script src="<?php echo URL_JS; ?>pnotify.buttons.js"></script>
<script src="<?php echo URL_JS; ?>pnotify.nonblock.js"></script>



<body>

<header class="">
  <div class="navbar navbar-default visible-xs">
    <button type="button" class="navbar-toggle collapsed">
      <span class="sr-only">Menü</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a href="./index.html" class="navbar-brand">Sucuoğlu Granit</a>
  </div>

  <nav class="sidebar">
    <div class="navbar-collapse" id="navbar-collapse">
      <div class="site-header hidden-xs">
          <a class="site-brand" href="./index.html" title="">
            <img class="img-responsive site-logo" alt="" src="./assets/images/logo.png">
            Sucuoğlu Granit
          </a>
          <p>Granit & Mermer & Porselen Baskı.</p>
      </div>
      <ul class="nav">
        <li><a href="<?php echo URL_MAIN ?>" title="">Ana Sayfa</a></li>
        <li><a href="<?php echo URL_HIZMETLER ?>" title="">Hizmetler</a></li>

        <li><a href="<?php echo URL_BASLIK_EDITOR ?>" title="">Mezar Tasarım Editörü</a></li>
        <li><a href="<?php echo URL_PORSELEN_BASKI_SIPARIS ?>" title="">Porselen Baskı Editörü</a></li>
        
        <!-- <li><a href="./hakkimizda.php" title="">Hakkımızda</a></li> -->
        <li><a href="<?php echo URL_ILETISIM ?>" title="">İletişim</a></li>
        <li class="nav-siparisler"><a href="#" id="siparislerim" refresh-tetik="true">Sepetim</a></li>

      </ul>

      <nav class="nav-footer">
        <p class="nav-footer-social-buttons">
          <a class="fa-icon" href="#" title="Instagram">
            <i class="fa fa-instagram"></i>
          </a>
          <a class="fa-icon" href="#" title="Facebook">
            <i class="fa fa-facebook"></i>
          </a>
        </p>
        <p>© Sucuoğlu Granit 2018 <a href="#" title="obarey inc."></a></p>
      </nav>  
    </div> 
  </nav>
</header>

<div id="siparisler_modal" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Siparişler ve Hesap Detayları</h4>
         </div>
         <div class="modal-body">
              

            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#global_siparisler">Siparişlerim</a></li>
              <!-- <li><a data-toggle="tab" href="#global_hesap">Hesap Detayları</a></li> -->
            </ul>

            <div class="tab-content">
              <div id="global_siparisler" class="tab-pane fade in active">
                  

                  <div class="row">
                    <ul class="clearfix" id="siparisler_list">
                        
                        
                    </ul>
                    
                  </div>


              </div>
              <div id="global_hesap" class="tab-pane fade">
                <h3>Hesap</h3>
                <p>Some content in menu 1.</p>
              </div>
            </div>


         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-success" id="siparisleri_gonder_global">Siparişleri Gönder</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
          </div>
      </div>
   </div>
</div>

<script type="text/template" id="siparis_tema">  
  <li class="siparis-item %%TYPE%%" id="sip%%ITEM_ID%%">
      <div class="row">
          <div class="siparis-top col-md-12 col-sm-12 col-xs-12">
              <img src="%%IMGSRC%%" />
          </div>
          <div class="sip-display col-md-12 col-sm-12 col-xs-12">
              <span class="text-muted">%%V1%%</span>
              <span class="text-danger">%%V2%%</span>
              <span class="text-info">%%V3%%</span>
          </div>
          <div class="siparisler-nav col-md-12 col-sm-12 col-xs-12">
              <div class="sip-display">
                <i class="fa fa-edit sip-duzenle" parent="sip%%ITEM_ID%%" title="Düzenle"></i>
                <i class="fa fa-remove sip-sil" type="%%TYPE%%" parent="sip%%ITEM_ID%%" title="Sil"></i>
              </div>
          </div>
      </div>
  </li>
</script>



<script type="text/javascript">

    // ebat seçenekleri
    var ebat_options = {  oval:["8x10 cm", "9x12 cm", "11x15 cm", "13x18 cm", "18x24 cm", "24x30 cm"],
                      dikdortgen:["9x12 cm", "11x15 cm", "13x18 cm", "18x24 cm", "24x30 cm"],
                      daire:["10x10 cm", "15x15 cm", "20x20 cm", "25x25 cm"],
                      kare:["10x10 cm", "15x15 cm", "20x20 cm"],
                      kubbe:[ "10x14 cm", "15x20 cm", "18x24 cm"]};



    $(document).ready(function(){
        var sip_modal = $("#siparisler_modal"),
            sip_list  = $("#siparisler_list"),
            sip_tema  = $("#siparis_tema");
        $("#siparislerim").click(function(){
            var _this = this, html = "";

            REQ.ACTION("inc/global_ajax.php", {req:"siparis_download"}, function( res ){
                //console.log(res);
                for( var k = 0; k < res.data.baslik_siparisleri.length; k++ ){
                    html += sip_tema.html().replace("%%V1%%", "Başlık Siparis").
                                            replace("%%V2%%", "").
                                            replace("%%V3%%", res.data.baslik_siparisleri[k].adet + " adet" ).
                                            replace("%%IMGSRC%%", "<?php echo URL_UPLOADS_BASLIK?>" + res.data.baslik_siparisleri[k].gid + "/PREV.png" ).
                                            replace("%%ITEM_ID%%", res.data.baslik_siparisleri[k].id ).
                                            replace("%%ITEM_ID%%", res.data.baslik_siparisleri[k].id ).
                                            replace("%%ITEM_ID%%", res.data.baslik_siparisleri[k].id ).
                                            replace("%%TYPE%%", "bassip" ).
                                            replace("%%TYPE%%", "bassip" );
                }
                for( var k = 0; k < res.data.porselen_siparisleri.length; k++ ){
                    html += sip_tema.html().replace("%%V1%%", "Porselen Sipariş").
                                            replace("%%V2%%", res.data.porselen_siparisleri[k].seri ).
                                            replace("%%V3%%", res.data.porselen_siparisleri[k].adet + " adet " + res.data.porselen_siparisleri[k].ebat ).
                                            replace("%%IMGSRC%%", "<?php echo URL_UPLOADS_PORSELEN?>" + res.data.porselen_siparisleri[k].gid + "/SGP.png" ).
                                            replace("%%ITEM_ID%%", res.data.porselen_siparisleri[k].id ).
                                            replace("%%ITEM_ID%%", res.data.porselen_siparisleri[k].id ).
                                            replace("%%ITEM_ID%%", res.data.porselen_siparisleri[k].id ).
                                            replace("%%TYPE%%", "porssip" ).
                                            replace("%%TYPE%%", "porssip" );
                }
                sip_list.html(html);
            });
            sip_modal.modal('show');
        });

        $(document).on("click", ".sip-duzenle", function(){
            window.open("<?php echo URL_PORSELEN_BASKI_SIPARIS ?>?item_id="+this.getAttribute("parent").substring(3), "_blank");
        });
        $(document).on("click", ".sip-sil", function(){
            var alert = confirm("Siparişi silmek istediğinize emin misiniz?"),
                parent = $("#"+this.getAttribute("parent"));
            if( alert ){
                REQ.ACTION("inc/global_ajax.php", { req:"siparis_sil", type:this.getAttribute("type"), item_id:this.getAttribute("parent").substring(3) }, function(res){
                    //console.log(res);
                    PamiraNotify("success", "İşlem Başarılı", res.text);
                    parent.remove();
                });
            }
        });

        $("#siparisleri_gonder_global").click(function(){
            if( $(document).find(".siparis-item").length == 0 ) return;
            PamiraNotify("info", "İşlem Yapılıyor", "Siparişleriniz gönderiliyor...");
            REQ.ACTION("inc/global_ajax.php", {req:"siparisleri_onayla"}, function(res){
                if( res.ok ){
                    sip_list.html("");
                    if( PNotify.notices.length > 0 ) PNotify.notices[0].remove();
                    PamiraNotify("success", "İşlem Başarılı", res.text);
                } else {
                    PamiraNotify("error", "Bir hata oluştu.", res.text);
                }
            });

        });

    });

</script>

