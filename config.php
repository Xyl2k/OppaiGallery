<?php
	// SQL db info
	define('MYSQL_HOST',  'localhost');
	define('MYSQL_USER',  'root');
	define('MYSQL_PASS',  '');
	define('MYSQL_DB',    'OppaiGallery');
	
	$mysql = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
	
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
    printf("Mysql fail: : %s\n", mysqli_connect_error());
    exit();
	}
	
	// footer notes
	$AppName = "OppaiGallery";
	$AppVersion = "0.5";
	
	// Script parameters
	$DisplayLatestMedias = "20";
	$DisplayRandomMedias = "20";
	$AdminDisplay = "40";
	$Redirect = "1"; // redirect time, in seconds.
?>
<!--       You don't have to prove that your waifu is the best in the world, she's happy just to know that she's the best in yours.       -->
