<?php

	$LOGIN_PAGE = true;
	require '../inc/admin_header.php';
    require '../inc/defs.php';

    if( Admin::check_login() ){
    	header("Location: " . URL_ADMIN_SIPARISLER );
    }

    if( $_POST ){

    	$OK = 1;
    	$TEXT = "";

    	if( !Admin::login( Input::escape($_POST) ) ){
    		$OK = 0;
    	}
    	$TEXT = Admin::get_return_text();

    	die(json_encode(array(
    		'ok' => $OK,
    		'text' => $TEXT,
    		'oh' => $_POST
    	)));

    }

    require 'inc/header.php';

?>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" id="login_form" action="index.html">
		        <h2 class="form-login-heading">SG ADMIN Giriş</h2>
		        <div class="login-wrap">
		            <input type="text" class="form-control req email" placeholder="Eposta" name="eposta" autofocus>
		            <br>
		            <input type="password" class="form-control req" placeholder="Şifre" name="pass">
		            <!-- <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
		
		                </span>
		            </label> -->
		            <button class="btn btn-theme btn-block" type="button" id="login_btn"><i class="fa fa-lock"></i> GİRİŞ YAP</button>
		             <!-- <hr>
		            
		           <div class="login-social-link centered">
		            <p>or you can sign in via your social network</p>
		                <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
		                <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
		            </div> -->
		            <!-- <div class="registration">
		                Don't have an account yet?<br/>
		                <a class="" href="#">
		                    Create an account
		                </a>
		            </div> -->
		
		        </div>
		
		          
		
		      </form>	  	
	  	
	  	</div>
	  </div>


    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script type="text/javascript">
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
        var form = $("#login_form");
        $("#login_btn").click(function(){

        	if( FormValidation.check( form.get(0))){
        		REQ.ACTION("", form.serialize(), function(res){
        			console.log(res);
        			if( res.ok ){
        				PamiraNotify("success", "İşlem Tamam", res.text );
        				setTimeout(function(){ location.reload(); }, 300);
        			} else {
        				PamiraNotify("error", "Hata", res.text );
        			}
        		});
        	} else{
        		PamiraNotify("error", "Hata", "Formda eksiklikler var.");
        	}

        });

    </script>


  </body>
</html>
