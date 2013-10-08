<?php /* FILEVERSION: v1.0.1b */ ?>
<body>

<?php 
//check for existence of installation or update file
$install  = "_config/_install/install.inc.php";

if(file_exists($install)){

	//if install exists redirect to install process
	require($install);
} else {

	if(isset($_POST['loginemail'], $_POST['password'])) { 
	   $email = $_POST['loginemail'];
	   $password = $_POST['password']; 
	   $check = login($email, $password, $mysqli);
	}

	//check that session has started correctly (logged in)
	if(login_check($mysqli) == true) {
		
		//instantiate  nav generation class
		$nav = new navGeneration; 

		//begin primary page contents
		echo "<div class=\"container theme-showcase\" id=\"home\">";
		
		//ignoring error reporting to bypass error that is issued on loading of the homepage
		if(@$check == "success") {
			//deliver login success message
	      	messageReporting::insertMessage("success","Welcome back " . $_SESSION['username'] . "!");
	   	}

	   	//displays page content
		$page = new page;

	} else {	

		if(isset($_POST['loginemail'], $_POST['password'])) { 
		   $email = $_POST['loginemail'];
		   $password = $_POST['password']; 
		   $check = login($email, $password, $mysqli);
		   //deliver login failure message
			if($check == "locked") {
		      messageReporting::insertMessage("error","You have been locked out of your account due to too many failed attempts.");
		   } elseif($check == "pass") { 
		      messageReporting::insertMessage("error","Incorrect password.");
		   } elseif($check == "user") { 
		   	  messageReporting::insertMessage("error","Unable to locate the account associated with the email address you entered. Please check the email and try again.");
		   } else {
		   	  messageReporting::insertMessage("error","Sorry there was an error while trying to log you in.");
		   }
		}

	   //require login script
		require('pages/login.php');
	} 
}
?>