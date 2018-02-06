<?php
   require 'inc/defs.php';
  require 'inc/header.php';

?>

<main class="" id="main-collapse">

<div class="row">


  <a href="<?php echo URL_ILETISIM ?>?konu=Porselen Baskı" class="btn btn-primary" title=""> Bizimle İletişime Geçin</a>
 
  <div class="col-xs-12 col-md-8 col-sm-12">
    <div class="section-container-spacer">
        <h1>Granit - Mermer İşleme</h1>
        <p>Editörümüzle nasıl birşey istediğinize karar verin veya direk bizimle iletişime geçin.</p>
    </div>


    <iframe src="mezar_tasi_editor.php" id="baslik_editor_frame"></iframe>

  </div>

  <div class="col-xs-12 col-md-4 col-sm-12">

       <iframe id="ytplayer" class="yt-tutorial" type="text/html" width="100%"
            src="https://www.youtube.com/embed/fDFVEeAqKMY"
            frameborder="0" allowfullscreen></iframe>


      <ul class="porselen-klavuz">  

        <li class="text-primary">
            "Taş Ayarları" kısmından taşın türünü, eninin ve boyunun ölçüsünü değiştirebilirsiniz. Taşında ölçülerini yazdıktan sonra
            <button class="btn btn-sm btn-success disabled"><i class="fa fa-check"></i> Uygula</button> butonuna basarak değişiklikleri kaydedin.
        </li>

        <li>
            "Seçenekler" kısmında, taşa ekleyebileceğiniz ürünlerin listesi bulabilirsiniz. Açılan listede ürünlerin altında bulunan
              <button class="btn btn-xs btn-success disabled" ><i class="fa fa-plus"></i> Ekle</button> butona basarak, istediğiniz ürünü taşa ekleyin.
        </li>
        <li>
            <button class="btn btn-sm btn-default disabled"><i class="fa fa-square"></i> Sık Kullanılan Ürünler</button> menüsünde taşlarda sık kullanılan ürünleri bulabilirsiniz.
        </li>
        <li  class="text-info">
           <button class="btn btn-sm btn-default disabled"><i class="fa fa-image"></i> Porselen Resim</button> menüsünü kullanarak taşınıza değişik seri ve ebatlarda porselen resim ekleyebilirsiniz.
           <br>
           Listelenen serilerin altındaki ebat listesinden, istediğiniz ölçüyü seçip <button class="btn btn-xs btn-success disabled" ><i class="fa fa-plus"></i> Ekle</button> butonuna basıp porseleni taşa ekleyin.
           <br>
           Porselen taşın üzerine eklenecektir. Porselenin altında ve üstünde bulunan <br>
           <i class="fa fa-image"></i> butonuyla porselene bastırmak istediğiniz resmi açılan editörle seçip, ayarlayabilirsiniz.<br>
           <i class="fa fa-remove"></i> butonuyla porseleni kaldırabilirsiniz.<br>
           <i class="fa fa-refresh"></i> butonuyla taşı çevirebilirsiniz. ( Bu işlem sonrasında resmi editörden tekrar düzenlemeniz önerilir )<br>
           <i class="fa fa-minus"></i> ve <i class="fa fa-plus"></i> butonularıyla taşın ebatını seriye uygun olarak küçültüp, büyütebilirsiniz. 
           
        </li>
        <li  class="text-info">
            <button class="btn btn-sm btn-default"><i class="fa fa-image disabled"></i> Kazıma Resim</button> butonuyla taşınıza kazıma resim ekleyebilirsiniz.
            Açılan pencerede bulunan <button type="button" disabled>Dosya Seç</button> butonuna basın 
            ve yüklemek istediğiniz resmi seçin.
            Resmi seçtikten sonra, pencerenin altına resim eklenecektir.<br>
            Burada resmi kesebilir, çevirebilirsiniz.
            İşleminizi tamamladıktan sonra  <button class="btn btn-sm btn-success disabled"><i class="fa fa-tick"></i> Tamam</button> butonuna basın.
            <br>Resim taşa eklenecektir. Taşın yerini ve ebatını değiştirebilirsiniz.
        </li>
        <li>
            <button class="btn btn-sm btn-default disabled"><i class="fa fa-italic"></i> Yazı</button> butonunu kullanarak açılan pencereden; taşa, istediğiniz yazıyı font ve renk seçerek ekleyebilirsiniz.
        </li>

        <li>
            Tasarımınızı tamamladıktan sonra <button class="btn btn-sm btn-success disabled"><i class="fa fa-check"></i> Tamamla</button> butonuna basın. Açılan pencerede tasarımınızın önizlemesi ve form olacaktır.
            <br>
            Formda zorunlu kısımları(*) doldurduktan sonra <button class="btn btn-sm btn-success disabled">Tamam</button> butonuna basıp siparişinizi sepete ekleyin.
        </li>

        <li class="text-danger">
            Sepetinizdeki siparişleri göndermek için, ana menüden "Sepetim" butonuna basın ve açılan pencerenin altındaki "Siparişleri Gönder" butonunu kullanın.
        </li>
      <ul>
  
  </div>
  
</div>
  <a href="<?php echo URL_ILETISIM ?>?konu=Porselen Baskı" class="btn btn-primary" title=""> Bizimle İletişime Geçin</a>
    
</main>

<div id="testmodal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tamamla</h4>
         </div>
         <div class="modal-body" id="testmodalcontent">
         </div>
      </div>
   </div>
</div>

<script src="<?php echo URL_JS ?>jquery-ui.js"></script>
<link href="<?php echo URL_CSS ?>jquery-ui.css" rel="stylesheet">
<script src="<?php echo URL_JS ?>html2canvas.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function (event) {
    navbarToggleSidebar();
    navActivePage();
});
</script>
<?php

  require 'inc/footer.php';
