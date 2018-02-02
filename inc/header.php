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

 <!-- Add your content of header -->
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
        <!-- <li><a href="./hakkimizda.php" title="">Hakkımızda</a></li> -->
        <li><a href="<?php echo URL_ILETISIM ?>" title="">İletişim</a></li>
        <li class="nav-siparisler"><a href="#" id="siparislerim" init="false">Siparişlerim</a></li>

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
        <p>© Sucuoğlu Granit 2018 <a href="#" title="obarey inc.">obarey</a></p>
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
                        <li class="siparis-item" id="sipID">
                            <div class="row">
                                <div class="siparis-top col-md-12 col-sm-12 col-xs-12">
                                    <!-- <img src="<?php echo URL_UPLOADS_PORSELEN ?>SGP3_XN08fOwFmTMK0mgsq5VoknfDW6bNXB.png" /> -->
                                </div>
                                <div class="sip-display col-md-12 col-sm-12 col-xs-12">
                                    <span class="text-muted">Porselen Baskı</span>
                                    <span class="text-danger">Daire</span>
                                    <span class="text-info">2 adet 9x12 cm</span>
                                </div>
                                <div class="siparisler-nav col-md-12 col-sm-12 col-xs-12">
                                    <div class="sip-display">
                                      <i class="fa fa-edit sip-duzenle" parent="sipID" title="Düzenle"></i>
                                      <i class="fa fa-remove sip-sil" parent="sipID" title="Sil"></i>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
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

<script type="text/template">  
  <li class="siparis-item" id="sip%%ITEM_ID%%">
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
                <i class="fa fa-remove sip-sil" parent="sip%%ITEM_ID%%" title="Sil"></i>
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
            sip_list  = $("#siparisler_list");
        $("#siparislerim").click(function(){
            var _this = this;
            if( this.getAttribute("init") == "false" ){

                REQ.ACTION("inc/global_ajax.php", {req:"siparis_download"}, function( res ){

                    

                    _this.setAttribute("init", true);
                });

            } else {

            }
            sip_modal.modal('show');

        });

       

    });

</script>

