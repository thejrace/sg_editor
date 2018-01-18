<?php
   require 'inc/defs.php';
   require 'inc/header.php';

   $KONU = "";
   if( isset($_GET["konu"]) ){
      $KONU = $_GET["konu"];
   }

?>




<main class="" id="main-collapse">


<div class="row">
  <div class="col-xs-12">
    <div class="section-container-spacer">
      <h1>İletişim</h1>
      <p>Mesaj, telefon, WhatsApp veya eposta aracılığıyla bizimle iletişim kurun. Bilgilerimiz aşağıdadır..</p>
    </div>
    <div class="section-container-spacer">
       <form action="" class="reveal-content">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="email" class="form-control" id="eposta" name="eposta" placeholder="Eposta">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="konu" id="konu" placeholder="Konu" value="<?php echo $KONU ?>" />
              </div>
              <div class="form-group">
                <textarea class="form-control" name="mesaj" id="mesaj" rows="3" placeholder="Mesajınız"></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-lg">Gönder</button>
            </div>
            <div class="col-md-6">
              <ul class="list-unstyled address-container">
                <li>
                  <span class="fa-icon">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                  </span>
                  (0535) 496 2931
                </li>
                <li>
                  <span class="fa-icon">
                    <i class="fa fa-at" aria-hidden="true"></i>
                  </span>
                  sucuoglucengiz@gmail.com
                </li>
                <li>
                  <span class="fa-icon">
                    <i class="fa fa fa-map-marker" aria-hidden="true"></i>
                  </span>
                  İncirköy Mahallesi Sucuoğlu Sokak No: 51/1, Beykoz - İstanbul
                </li>
              </ul>
              <h3>Sosyal Medya Hesaplarımız</h3>
              <a class="fa-icon" href="#" title="Instagram">
                <i class="fa fa-instagram"></i>
              </a>
              <a class="fa-icon" href="#" title="Facebook">
                <i class="fa fa-facebook"></i>
              </a>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>
<div class="row">

    <div class="col-xs-12 col-md-12 col-sm-12">

        <div id="map" style="width:100%; height:400px;">
            
        </div>


    </div>


</div>

</main>

<script src="//api-maps.yandex.ru/2.1/?lang=tr_TR" type="text/javascript"></script>
<script>
document.addEventListener("DOMContentLoaded", function (event) {
  navbarToggleSidebar();
  navActivePage();


    var myMap;
    ymaps.ready(init);

    function init () {
        myMap = new ymaps.Map('map', {
            center: [41.117818, 29.110792],
            zoom: 15
        }, {
            searchControlProvider: 'yandex#search'
        }),
        myPlacemark = new ymaps.Placemark([41.117818, 29.110792], {
              balloonContentHeader: "Sucuoğlu Granit",
              balloonContentBody: "Koordinatlar : 41.117818, 29.110792",
              balloonContentFooter: "",
              hintContent: ""
          });
        myMap.geoObjects.add(myPlacemark);
        myMap.balloon.open([41.117818, 29.110792], "Sucuoğlu Granit", {
            closeButton: false
        });
    }


});
</script>


<?php

  require 'inc/footer.php';