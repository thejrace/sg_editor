<?php

	
	

	define("MAIN_DIR", $_SERVER["DOCUMENT_ROOT"] . "/sucuoglu_granit/");
	define("INC_DIR", MAIN_DIR . "inc/");
	define("CLASS_DIR", INC_DIR . "class/");
	
	define("ASSETS_DIR", MAIN_DIR . "assets/");
	define("IMGS_DIR", ASSETS_DIR . "images/");
	define("UPLOADS_DIR", MAIN_DIR . "uploads/");
	define("UPLOADS_DIR_PORSELEN", UPLOADS_DIR . "porselen_siparisler/");
	define("UPLOADS_DIR_BASLIK", UPLOADS_DIR . "baslik_siparisler/");

	define("URL_MAIN", "http://localhost/sucuoglu_granit/");
	define("URL_ASSETS", URL_MAIN . "assets/");
	define("URL_JS", URL_ASSETS . "js/");
	define("URL_CSS", URL_ASSETS . "css/");
	define("URL_IMGS", URL_ASSETS . "images/");
	define("URL_UPLOADS", URL_MAIN . "uploads/");
	define("URL_UPLOADS_PORSELEN", URL_UPLOADS . "porselen_siparisler/");
	define("URL_UPLOADS_BASLIK", URL_UPLOADS . "baslik_siparisler/");

	define("URL_HIZMETLER", URL_MAIN . "hizmetler.php");
	define("URL_ILETISIM", URL_MAIN . "iletisim.php");
	define("URL_HAKKIMIZDA", URL_MAIN . "hakkimizda.php");
	define("URL_PROJE", URL_MAIN . "proje.php");
	define("URL_PORSELEN_BASKI", URL_MAIN . "porselen_baski.php");	

	define("DBT_PORSELEN_SIPARISLERI", "porselen_siparisleri");
	define("DBT_KULLANICILAR", "kullanicilar");
	define("DBT_COOKIE_TOKENS", "cookie_tokens");
	define("DBT_MISAFIRLER", "misafirler");


	ini_set('error_log', MAIN_DIR . "error.log");
	define("DB_NAME", "sucuoglu_granit");
	define("DB_USER", "root");
	define("DB_PASS", "Dogansaringulu9");
	define("DB_IP", "localhost:3306");

	session_start();

	require CLASS_DIR . 'Common.php';
	require CLASS_DIR . 'DataCommon.php';
	require CLASS_DIR . 'DB.php';
	require CLASS_DIR . 'Input.php';
	require CLASS_DIR . 'User.php';
	require CLASS_DIR . "Guest.php";	

	// hatirlamaya calis
	if( !User::remember() ){
		// misafir cookiesi yoksa yeni oluştur guest init et
		Guest::check();
		//echo User::get_data("user_email");
	}
