<?php

	define("MAIN_DIR", $_SERVER["DOCUMENT_ROOT"] . "/sg_editor/");
	//define("MAIN_DIR", $_SERVER["DOCUMENT_ROOT"] . "/beta/");
	define("INC_DIR", MAIN_DIR . "inc/");
	define("CLASS_DIR", INC_DIR . "class/");
	define("CLASS_DIR_PHPMAIL", CLASS_DIR . "phpmailer/");
	
	define("ASSETS_DIR", MAIN_DIR . "assets/");
	define("IMGS_DIR", ASSETS_DIR . "images/");

	define("UPLOADS_DIR", MAIN_DIR . "uploads/");
	define("UPLOADS_DIR_PORSELEN", UPLOADS_DIR . "porselen_siparisler/");
	define("UPLOADS_DIR_BASLIK", UPLOADS_DIR . "baslik_siparisler/");
	define("UPLOADS_TEMP", UPLOADS_DIR . "temp_files/");
	define("AH_EDITOR_DIR", UPLOADS_DIR . "ah_editor/");
	define("AH_EDITOR_IMGS_DIR", AH_EDITOR_DIR . "imgs/");
	define("AH_EDITOR_FONTS_DIR", AH_EDITOR_DIR . "fonts/");


	define("URL_MAIN", "http://localhost/sg_editor/");
	//define("URL_MAIN", "http://sucuoglugranit.com/beta/");
	define("URL_ASSETS", URL_MAIN . "assets/");
	define("URL_JS", URL_ASSETS . "js/");
	define("URL_CSS", URL_ASSETS . "css/");
	define("URL_IMGS", URL_ASSETS . "images/");
	define("URL_UPLOADS", URL_MAIN . "uploads/");
	define("URL_UPLOADS_PORSELEN", URL_UPLOADS . "porselen_siparisler/");
	define("URL_UPLOADS_BASLIK", URL_UPLOADS . "baslik_siparisler/");
	define("URL_AH_EDITOR_PREVS", URL_UPLOADS . "ah_editor/imgs/" );
	define("URL_AH_EDITOR_FONT_PREVS", URL_IMGS . "ah_editor/");


	define("URL_ADMIN", URL_MAIN . "admin/");
	define("URL_ADMIN_LOGIN", URL_ADMIN . "giris.php");
	define("URL_ADMIN_LOGOUT", URL_ADMIN . "logout.php");
	define("URL_ADMIN_MESAJLAR", URL_ADMIN . "mesajlar.php");
	define("URL_ADMIN_SIPARISLER", URL_ADMIN . "siparisler.php");
	define("URL_ADMIN_BASLIK_SIPARIS_DETAY", URL_ADMIN . "baslik_siparis_incele.php?item_id=");
	define("URL_ADMIN_PORSELEN_SIPARIS_DETAY", URL_ADMIN . "porselen_siparis_incele.php?item_id=");

	define("URL_HIZMETLER", URL_MAIN . "hizmetler.php");
	define("URL_ILETISIM", URL_MAIN . "iletisim.php");
	define("URL_HAKKIMIZDA", URL_MAIN . "hakkimizda.php");
	define("URL_PROJE", URL_MAIN . "proje.php");
	define("URL_PORSELEN_BASKI", URL_MAIN . "porselen_baski.php");	
	define("URL_PORSELEN_BASKI_SIPARIS", URL_MAIN . "porselen_baski_siparis.php");	
	define("URL_PORSELEN_BASKI_EDITOR", URL_MAIN . "porselen_baski_editor.php");	
	define("URL_BASLIK_EDITOR", URL_MAIN . "granit_mermer_isleme.php");	

	define("DBT_PORSELEN_SIPARISLERI", "porselen_siparisleri");
	define("DBT_BASLIK_SIPARISLERI", "baslik_siparisleri");
	define("DBT_KULLANICILAR", "kullanicilar");
	define("DBT_COOKIE_TOKENS", "cookie_tokens");
	define("DBT_MISAFIRLER", "misafirler");
	define("DBT_ILETISIM_FORMLARI", "iletisim_formlari");
	define("DBT_TEMP_UPLOADS", "temp_uploads");


	ini_set('error_log', MAIN_DIR . "error.log");
	define("DB_NAME", "sucuoglu_granit");
	define("DB_USER", "root");
	define("DB_PASS", "Dogansaringulu9");
	define("DB_IP", "localhost:3306");

	/*define("DB_NAME", "sgv2");
	define("DB_USER", "sgv2obarey");
	define("DB_PASS", "WAzzabii308*");
	define("DB_IP", "94.73.145.26");*/

	session_start();

	require CLASS_DIR . 'Common.php';
	require CLASS_DIR . 'DataCommon.php';
	require CLASS_DIR . 'DB.php';
	require CLASS_DIR . 'Input.php';

	if( !isset($ADMIN) ){

		require CLASS_DIR . 'User.php';
		require CLASS_DIR . "Guest.php";	

		// hatirlamaya calis
		if( !User::remember() ){
			// misafir cookiesi yoksa yeni oluştur guest init et
			Guest::check();
			//echo User::get_data("user_email");
		}
	} else {

		require CLASS_DIR . "Admin.php";	

		if( !Admin::check_login() && !isset($LOGIN_PAGE) ){
			header("Location: " . URL_ADMIN_LOGIN );
		}

	}