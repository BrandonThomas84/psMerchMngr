<?php /* FILEVERSION: v1.0.2b */ ?>
<?php
	require_once("functions/login_functions.php");
	sec_session_start(); 

	//require functions
	setcookie("help",1);
	require_once('functions/functions.php'); 
	
	require_once('functions/head.include.php');
	
	require_once('functions/body.include.php'); 

	require_once('functions/footer.include.php'); 
?>
