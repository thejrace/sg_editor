<?php
  
   require 'inc/defs.php';
   require 'inc/header.php';

?>


<main class="" id="main-collapse">

<div class="row editor-ilan">
    <div class="col-md-6 col-sm-12 col-xs-12">
          <a href="<?php echo URL_BASLIK_EDITOR ?>"><img src="<?php echo URL_IMGS ?>editor_ilan.png" /></a>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
         <a href="<?php echo URL_PORSELEN_BASKI_SIPARIS ?>"><img src="<?php echo URL_IMGS ?>porselen_editor_ilan.png" /></a>
    </div>

</div>
<div class="hero-full-wrapper">
  <div class="grid">
  <div class="gutter-sizer"></div>
    <div class="grid-sizer"></div>
    
    <div class="grid-item">
      <img class="img-responsive" alt="" src="./assets/images/porselenslider.png">
      <a href="<?php echo URL_PORSELEN_BASKI ?>" class="project-description">
        <div class="project-text-holder">
          <div class="project-text-inner">
            <h3>Porselen Baskı</h3>
          </div>
        </div>
      </a>
    </div>

    
    <div class="grid-item">
      <img class="img-responsive" alt="" src="http://sucuoglugranit.com/res/img/product_imgs/mermer_static/13.jpg">
      <a href="<?php echo URL_BASLIK_EDITOR ?>" class="project-description">
        <div class="project-text-holder">
          <div class="project-text-inner">
            <h3>Granit - Mermer İşleme</h3>
          </div>
        </div>
      </a>
    </div>

    <div class="grid-item">
      <img class="img-responsive" alt="" src="http://sucuoglugranit.com/res/img/product_imgs/porselen_baski_static/2.jpg">
      <a href="<?php echo URL_PORSELEN_BASKI ?>" class="project-description">
        <div class="project-text-holder">
          <div class="project-text-inner">
            <h3>Porselen Baskı</h3>
          </div>
        </div>
      </a>
    </div>
    <div class="grid-item">
      <img class="img-responsive" alt="" src="http://sucuoglugranit.com/res/img/product_imgs/mermer_static/19.jpg">
      <a href="<?php echo URL_BASLIK_EDITOR ?>" class="project-description">
        <div class="project-text-holder">
          <div class="project-text-inner">
            <h3>Granit - Mermer İşleme</h3>
          </div>
        </div>
      </a>
    </div>
    
    <div class="grid-item">
      <img class="img-responsive" alt="" src="http://sucuoglugranit.com/res/img/product_imgs/mermer_static/12.jpg">
      <a href="<?php echo URL_BASLIK_EDITOR ?>" class="project-description">
        <div class="project-text-holder">
          <div class="project-text-inner">
            <h3>Granit - Mermer İşleme</h3>
          </div>
        </div>
      </a>
    </div>

    <div class="grid-item">
      <img class="img-responsive" alt="" src="http://sucuoglugranit.com/res/img/product_imgs/mermer_static/6.jpg">
      <a href="<?php echo URL_BASLIK_EDITOR ?>" class="project-description">
        <div class="project-text-holder">
          <div class="project-text-inner">
            <h3>Granit - Mermer İşleme</h3>
          </div>
        </div>
      </a>
    </div>

    <div class="grid-item">
      <img class="img-responsive" alt="" src="http://sucuoglugranit.com/res/img/product_imgs/granit_static/17.jpg">
      <a href="<?php echo URL_BASLIK_EDITOR ?>" class="project-description">
        <div class="project-text-holder">
          <div class="project-text-inner">
            <h3>Granit - Mermer İşleme</h3>
          </div>
        </div>
      </a>
    </div>
    <div class="grid-item">
      <img class="img-responsive" alt="" src="http://sucuoglugranit.com/res/img/product_imgs/granit_static/13.jpg">
      <a href="<?php echo URL_BASLIK_EDITOR ?>" class="project-description">
        <div class="project-text-holder">
          <div class="project-text-inner">
            <h3>Granit - Mermer İşleme</h3>
          </div>
        </div>
      </a>
    </div>
    
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function (event) {
     masonryBuild();
  });
</script>

</main>

<script>
document.addEventListener("DOMContentLoaded", function (event) {
  navbarToggleSidebar();
  navActivePage();
});
</script>

<?php

  require 'inc/footer.php';