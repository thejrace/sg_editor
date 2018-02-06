<?php
   require 'inc/defs.php';
   require 'inc/header.php';

    // js flag
    $DUZENLEME_FLAG = isset($_GET["item_id"]);

?>

<main class="" id="main-collapse">


<div class="row">

  <a href="<?php echo URL_ILETISIM ?>?konu=Porselen Baskı" class="btn btn-primary" title=""> Bizimle İletişime Geçin</a>


  
  <div class="col-xs-12 col-md-8 col-sm-12">
    <div class="section-container-spacer">
        <h1>Porselen Baskı</h1>
        <p>Farklı ebatlarda ve şekillerde porselen üzerine birebir resim baskı hizmeti sunuyoruz. Ebat ve şekil detayları aşağıdadır.</p>
    </div>
    <div class="row section-container-spacer">
        <?php if($DUZENLEME_FLAG){ ?>
            <iframe src="porselen_baski_editor.php?item_id=<?php echo $_GET["item_id"] ?>" id="editor_frame"></iframe>
        <?php } else { ?>
            <iframe src="porselen_baski_editor.php" id="editor_frame"></iframe>
        <?php } ?>
        


    </div>

  </div>
  <div class="col-xs-12 col-md-4 col-sm-12">

       <iframe id="ytplayer" class="yt-tutorial" type="text/html" width="100%"
            src="https://www.youtube.com/embed/ewu-ls8iG8k" 
            frameborder="0" allowfullscreen></iframe>

      <ul class="porselen-klavuz">  

        <li class="text-primary">
            <button class="btn btn-sm btn-primary disabled"><i class="fa fa-upload"></i> Resim Yükle & Düzenle</button>
            butonuna basarak resim yükleme penceresini açın.
        </li>

        <li>
            <button type="button" disabled>Dosya Seç</button> butonuna basın.
            Açılan pencereden yüklemek istediğiniz resmi seçin.
            Resmi seçtikten sonra, pencerenin altına resim eklenecektir.<br>
            Burada resmi kesebilir, çevirebilirsiniz.
            İşleminizi tamamladıktan sonra  <button class="btn btn-sm btn-success disabled"><i class="fa fa-tick"></i> Tamam</button> butonuna basın.<br>
        </li>
        <li>
            Resmi tekrar düzenlemek veya değiştirmek istediğinizde,
             <button class="btn btn-sm btn-primary disabled"><i class="fa fa-upload"></i> Resim Yükle & Düzenle</button> butonuna basarak bu pencereyi tekrar açabilirsiniz.
        </li>
        <li  class="text-info">
            Resim yükleme ve düzenleme işlemi bittikten sonra resim şeffaf olarak
            ana ekrana eklenmiş olacaktır.

        </li>
        <li  class="text-info">
            Resmi sürükleyebilir, boyutunu sağ alt köşesindeki ikona basılı tutarak
            değiştirebilirsiniz. Eğer resmin oranını korumak isterseniz, <b>“shift”</b> tuşuna 
            basılı tutarak boyutlandırma işlemi yapın.
        </li>
        <li class="text-muted">
            Taş şeklini değiştirmek için en üstteki buton grubunu kullanın.
        </li>
        <li class="text-muted">
            Taşın arka plan rengini ikinci gruptaki renk seçiciden yapabilirsiniz. Bu özellikle taşın boşluk kalan kısımlarını, resme uygun olarak ayarlayabilirsiniz.
            Bu boşluklar, tarafımızdan baskı esnasında seçtiğiniz renge göre düzenlenecektir.
        </li>
        <li>
            İkinci buton grubunda sonda bulunan 
            <button class="btn btn-sm btn-default disabled"><i class="fa fa-rotate-left"></i> </button>
            <button class="btn btn-sm btn-default disabled"><i class="fa fa-rotate-right"></i> </button>
            butonlarıyla ile taşı çevirebilirsiniz.
        </li>
        <li class="text-muted">
            Taşı önizlemek için üçüncü grupta bulunan <button class="btn btn-sm btn-warning disabled"><i class="fa fa-check"></i> Kesimi Tamamla</button>
            butonuna basın. Tekrar düzenleme moduna geçmek aynı butona tekrar
            basabilirsiniz.
        </li>
        <li class="text-warning">
            Resmi taşıdığınızda, değiştirdiğinizde, taş tipini
            değiştirdiğinizde, editör düzenleme moduna otomatik geçer.
        </li>
        <li class="text-success">
            <button class="btn btn-sm btn-success disabled"><i class="fa fa-download"></i> Kaydet</button> butonuna bastığınızda önizleme ve form içeren pencere açılacaktır.
            Burada taşın ebatını seçin ve tekrar <button class="btn btn-sm btn-success disabled"><i class="fa fa-check"></i> Tamam</button> butonuna basın.
            Siparişiniz sepetinize eklenecektir.
        </li>

        <li class="text-danger">
            Sepetinizdeki siparişleri göndermek için, ana menüden "Sepetim" butonuna basın ve açılan pencerenin altındaki "Siparişleri Gönder" butonunu kullanın.
        </li>
      <ul>
  
  </div>

</main>
<script>
$(document).ready(function(){
    navbarToggleSidebar();
    navActivePage();
});
</script>
<?php

  require 'inc/footer.php';
