<?php
   require 'inc/defs.php';
  require 'inc/header.php';

?>

<main class="" id="main-collapse">


<div class="row">

 
  <div class="col-xs-12 col-md-8 col-sm-12">
    <div class="section-container-spacer">
        <h1>Granit - Mermer İşleme</h1>
        <p>Editörümüzle nasıl birşey istediğinize karar verin veya direk bizimle iletişime geçin.</p>
    </div>


    <iframe src="mezar_tasi_editor.php" id="editor_frame"></iframe>

  </div>

  <div class="col-xs-12 col-md-4 col-sm-12">


    <!--<div class="col-xs-12 col-sm-12 col-md-6">
            <div class="tas siyah_granit">


            </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="editor-item-list clearfix">
            <div class="editor-item list-toggle" data-toggle="tooltip" title="Bismillahirrahmanirrahim Altın" >
                <img src="assets/images/bsm_altin.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
            <div class="editor-item list-toggle"  data-toggle="tooltip" title="Bismillahirrahmanirrahim Siyah">
                <img src="assets/images/bsm_siyah.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
            <div class="editor-item list-toggle"  data-toggle="tooltip" title="Bismillahirrahmanirrahim Beyaz">
                <img src="assets/images/bsm_beyaz.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
            <div class="editor-item list-toggle"  data-toggle="tooltip" title="Porselen Oval">
                <img src="assets/images/porselen_oval.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
            <div class="editor-item list-toggle"  data-toggle="tooltip" title="Porselen Daire">
                <img src="assets/images/porselen_daire.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
            <div class="editor-item list-toggle"  data-toggle="tooltip" title="Porselen Dikdörtgen">
                <img src="assets/images/porselen_dikdortgen.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
            <div class="editor-item list-toggle"  data-toggle="tooltip" title="Porselen Kare">
                <img src="assets/images/porselen_kare.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
              <div class="editor-item list-toggle"  data-toggle="tooltip" title="Porselen Kalp">
                <img src="assets/images/porselen_kalp.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
             <div class="editor-item list-toggle"  data-toggle="tooltip" title="Porselen Oval Kubbe">
                <img src="assets/images/porselen_kubbe.png" />
                <i class="fa fa-remove editor-action" action="sil" title="Sil"></i>
                <i class="fa fa-refresh editor-action" action="cevir" title="Çevir"></i>
            </div>
        </div>
    </div> -->

    

    
  

  </div>
  
</div>
  <button type="button" id="test">TEST SS</button>
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

    var TAS = $(".tas");

    $(".list-toggle").click(function(){

        var elem = $(this);
        var elem2 = elem.clone();
        elem2.removeClass("editor-item").addClass("added-item")
        elem2.draggable();
        elem2.attr("title", "");
        // elem.resizable();
        TAS.append( elem2 );

    });


    $(document).on("click", "[action='sil']", function(){
        $(this).parent().css("visibility", "hidden").addClass("removed");
    });

    $(document).on("click", "[action='cevir']", function(){
        var elem = $(this).parent();
        if( elem.hasClass("rotated") ){
           elem.removeClass("rotated");
        } else {
          elem.addClass("rotated");
        }
    });

    $("#test").click(function(){

        html2canvas($(".tas").get(0), { async:false, width:500, height:500}).then(function(canvas) {
            $("#testmodal").modal("show");
            $("#testmodalcontent").html( canvas );
        });

    });

});
</script>
<?php

  require 'inc/footer.php';
