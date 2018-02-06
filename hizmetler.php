<?php

  require 'inc/defs.php';
  require 'inc/header.php';

?>


<main class="" id="main-collapse">


<div class="row">
  <div class="col-xs-12 section-container-spacer">
    <h1>Hizmetler</h1>
    <p>Sucuoğlu Granit olarak aşağıdaki hizmetleri müşterilerimize en kaliteli şekilde sunmaktayız.</p>
  </div>

  <div class="col-xs-12 col-md-4 section-container-spacer">
    <img class="img-responsive" alt="" src="./assets/images/granithizmet.png">
    <h2>Granit & Mermer İşleme - Engrave Baskı</h2>
    <p>Granit, mermer mezar başlıkları, apartman yazıları, bilgilendirme tabelaları vb. ürünlere kumlama, renklendirme ve engrave baskı hizmeti sunuyoruz.</p>
    <a href="<?php echo URL_BASLIK_EDITOR ?>" class="btn btn-info" title=""> Detaylar</a>
    <a href="<?php echo URL_ILETISIM ?>?konu=Granit - Mermer İşleme" class="btn btn-primary" title=""> Bizimle İletişime Geçin</a>
  </div>

  <div class="col-xs-12 col-md-4 section-container-spacer">
    <img class="img-responsive" alt="" src="./assets/images/porselenhizmet.png">
    <h2>Porselen Baskı</h2>
    <p>Farklı ebatlarda ve şekillerde porselen üzerine birebir resim baskı yapıyoruz.</p>
    
    <a href="<?php echo URL_PORSELEN_BASKI ?>" class="btn btn-info" title=""> Detaylar</a>
    <a href="<?php echo URL_ILETISIM ?>?konu=Porselen Baskı" class="btn btn-primary" title=""> Bizimle İletişime Geçin</a>
  </div>

</div>


</main>

<script>
document.addEventListener("DOMContentLoaded", function (event) {
  navbarToggleSidebar();
  navActivePage();
});
</script>

<?php

  require 'inc/footer.php';