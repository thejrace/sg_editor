<?php

	require '../inc/admin_header.php';
    require '../inc/defs.php';
    Admin::logout();
    header("Location: " . URL_ADMIN_LOGIN );

  