<?php
   require 'inc/defs.php';
  require 'inc/header.php';

?>

<main class="" id="main-collapse">

<a href="<?php echo URL_ILETISIM ?>?konu=Porselen Baskı" class="btn btn-primary" title=""> Bizimle İletişime Geçin</a>
<div class="row">

 
  <div class="col-xs-12 col-md-8 col-sm-12">
    <div class="section-container-spacer">
        <h1>Granit - Mermer İşleme</h1>
        <p>Editörümüzle nasıl birşey istediğinize karar verin veya direk bizimle iletişime geçin.</p>
    </div>


    <iframe src="mezar_tasi_editor.php" id="baslik_editor_frame"></iframe>

  </div>

  <div class="col-xs-12 col-md-4 col-sm-12">


  

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
