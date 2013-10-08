<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
///////////////////////////////////////////////////////////////////////
//Required Setup Variables
////////////////////////////////////////////////////////////////////////

//if you rename the folder this will insure all links work properly
function findSite(){
	$a = explode("/",$_SERVER["PHP_SELF"],3);
	$store = $_SERVER["DOCUMENT_ROOT"];
	$mmRoot = $_SERVER["DOCUMENT_ROOT"] . "/" . $a[1];
	
	define('_STORE_FOLDER_',$store);
	define('_MM_ROOT_FOLDER_',$mmRoot);
}
findSite();

require(_STORE_FOLDER_ . "/config/settings.inc.php");

//recursive code linking
$link = mysql_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_); 
	if (!$link){die("Could not connect to MySQL: " . mysql_error());}

//OO code linking
$mysqli = new mysqli(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_);
	if (!$mysqli){die("Could not connect to MySQLi: " . mysql_error());}
?>