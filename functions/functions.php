<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
////////////////////////////////////////////////////////////////////////
// Core Required files
////////////////////////////////////////////////////////////////////////
require_once("functions/db_connect.php");
require_once("_config/_settings/settings.inc.php");

////////////////////////////////////////////////////////////////////////
// Settings
////////////////////////////////////////////////////////////////////////
//instantiating the settings (also sets cookie values)
$settings = new settings;
$settings->getSettings();

////////////////////////////////////////////////////////////////////////
//Include all classes
////////////////////////////////////////////////////////////////////////
$classes = scandir("./classes");
for($i=2;$i<=(count($classes)-1);$i++){
	require("./classes/" . $classes[$i]);
}

////////////////////////////////////////////////////////////////////////
// General Functions
////////////////////////////////////////////////////////////////////////
//returns an array containing the currently installed merchants
function installedMerchants(){	
	$sql = "SELECT DISTINCT `merchant_id` FROM `" . _DB_NAME_ . "`.`mc_select_config`";
	$query = mysql_query($sql);

	$a = array();

	while($row = mysql_fetch_array($query)){
		array_push($a,$row["merchant_id"]);
	}
	
	return $a;
}
function forceRefresh(){
	//WARNING calling this script in anything other than a case situation will create an undending loop
	echo "<script>location.reload()</script>";
}
//creates a refresh script in the footer that can be called using the delayedRefreshCall function
function delayedRefreshScript($urlExt){
	echo "
	<script type=\"text/javascript\">
		function delayedRefresh(){
		    window.location = \"index.php" . $urlExt . "\"
		}
	</script>";
}
//calls delayedrefreshscript / should only be placed on links or buttons
function delayedRefreshLink($delay){
	echo " onClick=\"setTimeout('delayedRefresh()', " . $delay . ")\" ";
}
//generates merchant ID for the constant
function merchantID($m){
    if($m == "gpf") {
    	return "google";
    }
}
//generates friendly merchant name for the constant
function merchantFriendly($m){
   if($m == "gpf") {
   	return "Google";
   }
}
//merchant to merch
function merchantToMerch($merchantID){
	if($merchantID == "google") {
		$merch ="gpf";
	}
	return $merch;
}
//defining constant values
function setMerchantConstants(){
	if(isset($_GET["f"])){
		$merch = $_GET["f"];
	}
	//defining merchant constant variables
	if(isset($merch)){
	    define('_MERCH_', $merch);
	    define('_MERCHANTID_', merchantID(_MERCH_));
	    define('_MERCHANT_', merchantFriendly(_MERCH_));
	} else {
		define('_MERCH_', "home");
	    define('_MERCHANTID_', "");
	    define('_MERCHANT_', "");
	}
}
//setting constants
setMerchantConstants();

//applies 'selected' to optionlists where value matches
function feedConfigSelected($needle,$haystack){
	if($needle != $haystack){
		return "";
	} else {
		return " selected ";
	}
}
//adds an active class to the left hand navigation for selected merchant
function navActiveClass($v){
	if($v[0] == $v[1]){
		return " class=\"active\" ";
	}
}
function merchantHeader($h1){
	$logo = "<a href=\"index.php?f=" . _MERCH_ . "\" title=\"Return to " . _MERCHANT_ . " Control Page\"><img src=\"merchants/" . _MERCHANTID_ . "/img/" . _MERCHANTID_ . "_logo.png\" alt=\"" . _MERCHANT_ . " Product Feed\" class=\"merchLogo\"></a>";
	$taxonomy = new taxonomyButton;
	$theme = "flat";
	$merchantNav = "
	<div class=\"clearfix\"></div>
	
		<div class=\"navbar navbar-default merchant-navbar\">
			<div class=\"container\">
				<div class=\"navbar-header\">
					<button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\".quicklink-collapse\">
		            <span class=\"icon-bar\"></span>
		            <span class=\"icon-bar\"></span>
		            <span class=\"icon-bar\"></span>
		          </button>
					<p class=\"navbar-brand\">" . _MERCHANT_ . " Quick Links</p>
				</div>
				<div class=\"quicklink-collapse collapse navbar-left\">
					<ul class=\"nav navbar-nav\">
			        	<li>
			        		<a href=\"index.php?f=" . _MERCH_ . "\" title=\"Return to " . _MERCHANT_ . " control panel\">
			        			<img src=\"merchants/" . _MERCHANTID_ . "/img/" . $theme . "/sm/" . _MERCHANTID_ . ".png\">
			        		</a>
			        	</li>
			        	<li>
			        		<a href=\"index.php?f=" . _MERCH_ . "&ql_man=crt\" title=\"Create a new " . _MERCHANT_ . "  feed\">
			        			<img src=\"images/" . $theme . "/sm/createfeed.png\">
			        		</a>
			        	</li>
			        	<li>
			        		<a href=\"index.php?f=" . _MERCH_ . "&ql_man=del\" title=\"Purge " . _MERCHANT_ . " feed\">
			        			<img src=\"images/" . $theme . "/sm/deletefeed.png\">
			        		</a>
			        	</li>
			        	<li>
			        		<a href=\"submissions/" . _MERCHANTID_ . "_feed.txt\" title=\"Download a copy of your " . _MERCHANT_ . " feed\">
			        			<img src=\"images/" . $theme . "/sm/downloadfeed.png\">
			        		</a>
			        	</li>
			        	<li>
			        		<a href=\"index.php?f=" . _MERCH_ . "&p=exmng\" title=\"Manage " . _MERCHANT_ . " feed exclusions\">
			        			<img src=\"images/" . $theme . "/sm/exclusions.png\">
			        		</a>
			        	</li>
			        	<li>
			        		<a href=\"index.php?f=" . _MERCH_ . "&p=ovrde\" title=\"Manage " . _MERCHANT_ . " value overrides\">
			        			<img src=\"images/" . $theme . "/sm/override.png\">
			        		</a>
			        	</li>
			        	". $taxonomy->quickLinks() . "
			        </ul>
			    </div>
		    </div>
		</div>
	
	<div class=\"clearfix\"></div>";

	return "
	<div class=\"page-header\" id=\"merchant-header\">
		<h1>" . _MERCHANT_ . " " . $h1 . "</h1>
		<div class=\"merchant-logo\">" . $logo . "</div>
	</div>
	" . $merchantNav;
}
function confirmMessage($message){
	$start = "onClick=\"return confirm(";
	$end = ")\"";
	return $start . "'" . $message . "'" . $end;
}
function tableLettertoFriendly($table){
	if($table == "A"){ return  _DB_PREFIX_ . "product";}
    if($table == "B"){ return  _DB_PREFIX_ . "manufacturer";}
    if($table == "C"){ return  _DB_PREFIX_ . "product_lang";}
    if($table == "D"){ return "URL Rewrite";}
    if($table == "E"){ return "Category Rewrite";}
    if($table == "F"){ return "Sale Information";}
    if($table == "img1"){ return "Additional Images 1";}
    if($table == "img2"){ return "Additional Images 2";}
    if($table == "img3"){ return "Additional Images 3";}
    if($table == "img4"){ return "Additional Images 4";}
    if($table == "img5"){ return "Additional Images 5";}
    if($table == "img6"){ return "Additional Images 6";}
    if($table == "img7"){ return "Additional Images 7";}
    if($table == "img8"){ return "Additional Images 8";}
    if($table == "img9"){ return "Additional Images 9";}
    if($table == "img10"){ return "Additional Images 10";}
    if($table == "feat"){ return "Mapped to Feature";}
    if($table == "cur"){ return "Currency";}
}
function selectFieldReturn($fieldID){
	$sql = "SELECT `id`, `report_field_name`, `static_value`, `custom_function`,`function_command`,`table_name`,`database_field_name`,`notes`,`enabled`,`order` FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE `merchant_id` = '" . _MERCHANTID_ . "' AND `id` = '" . $fieldID . "'";
	$query = mysql_query($sql) or die(mysql_error());
	
	while($row = mysql_fetch_array($query)){
			if(!is_null($row["static_value"])){
	    		$value = "'" . $row["static_value"] . "' AS `" . $row["report_field_name"] . "`";
	    		return $value;
			} elseif(!is_null($row["table_name"]) && !is_null($row["database_field_name"])){
				$value = "`" . $row["table_name"] . "`.`" . $row["database_field_name"] . "` AS `" . $row["report_field_name"] . "`";
				return $value;
			} elseif($row["custom_function"] == "mapToFeature"){
				if(is_null($row["function_command"])){
					messageReporting::manualMessage("error","You must first select a feature to be mapped to for feed element <a href=\"index.php?f=" . _MERCH_ . "&fieldID=" . $row["id"] . "\" title=\"Click here to Edit " . $row["report_field_name"] . "\">" . $row["report_field_name"] . "</a>");
				} else {
					$value = $row["function_command"]::select($row["function_command"]::selectNoAlias(),$row["report_field_name"]);
					return $value;
				}
			} elseif($row["custom_function"] == "mapToAttribute"){
				if(is_null($row["function_command"])){
					messageReporting::manualMessage("error","You must first select an attribute to map this field to before this will function.");
				} else {
					$value = mapToAttribute::select(mapToAttribute::selectNoAlias($row["function_command"]),$row["report_field_name"]);
					return $value;
				}
			} else {
				$value = $row["custom_function"]::select($row["custom_function"]::selectNoAlias(),$row["report_field_name"]);
				return $value;
			} 
	}
}
////////////////////////////////////////////////////////////////////////
// Check for logout
////////////////////////////////////////////////////////////////////////
if(isset($_GET["p"])){
	if($_GET["p"] == "logout"){
		new logout;
	}
}
////////////////////////////////////////////////////////////////////////
//Report Wizard Query Functions
////////////////////////////////////////////////////////////////////////
//create query portion - "where"
function reportQueryWhere(){
	return " WHERE (`A`.`active` = 1) AND (`A`.`available_for_order` = 1) AND (`A`.`id_product` NOT IN (SELECT DISTINCT `id_product` FROM `" . _DB_NAME_ . "`.`mc_exclusion` WHERE `exclusion` = '" . _MERCHANTID_ . "'))";
}
//create feed grouping statement
function reportQueryGroup(){
	return " GROUP BY " . id::selectNoAlias();
}
function getAttrGroups(){
	$sql = "SELECT DISTINCT `id_attribute_group` AS `id`, `public_name` AS `group` FROM  `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute_group_lang`";
	return $sql;
}

////////////////////////////////////////////////////////////////////////
//File Creation Functions 
////////////////////////////////////////////////////////////////////////

//constructs the query from the three segements above
function queryBuilder($v){
	//creating array for full sql statement
	$a = array();
	
	//adding individual statement segments
	array_push($a,feedSelect::selectConstruct());
	array_push($a,feedFrom::fromConstruct(""));
	array_push($a,reportQueryWhere());
	array_push($a,feedGroup::groupConstruct());

	//imploding query array
    $query =  implode("",$a); 
	
	//setting a limit for printing the header
	$headerlimit = " LIMIT 0,1 ";

	//making sure the server will accept big selects
	mysql_query('SET SQL_BIG_SELECTS=1;');

	//checking if printing head or body
	if($v == 'head'){

		$sql = mysql_query($query . $headerlimit);
		if(!$sql){die('Invalid query: ' . mysql_error());}
		return $sql;
	} else {

		$sql = mysql_query($query);
		if(!$sql){die('Invalid query: ' . mysql_error());}
		return $sql;
	}
};
//prints the query being used for testing purposes
function printQueryBuilder($v){
    
    $a = array();
	
	array_push($a,feedSelect::selectConstruct());
	array_push($a,feedFrom::fromConstruct(""));
	array_push($a,reportQueryWhere());
	array_push($a,feedGroup::groupConstruct());
	
    $query =  implode("",$a); 

	return $query;
}
//function used to construct the header of the output file
function HeaderPrint($file,$sql){
	
	//error checking
	if (!$sql) {die('Invalid query: ' . mysql_error());}
	while($row = mysql_fetch_assoc($sql)){
		$headers = array_keys($row);		
		fputcsv($file, $headers, chr(9));		
	}
}; 

//function used to construct the contents of the output file
function MerchPrint($file,$sql){
	
	//error checking
	if (!$sql) {die('Invalid query: ' . mysql_error());}
	while($row = mysql_fetch_assoc($sql)){
		$i = 0;
		fputcsv($file, $row, chr(9), chr(0));	
		++$i;
	}
};

////////////////////////////////////////////////////////////////////////
//Feed Configuration Classes a.k.a. Custom Functions
////////////////////////////////////////////////////////////////////////
//gets all classes from the files in the merchant folder excluding the default functions
function callAllMerchantClassDefaults($merchant){
	$a = array();
	$classes = scandir("merchants/" . $merchant . "/classes");

	for($i=2;$i<=(count($classes)-1);$i++){

		$remove = array($merchant . ".",".class.php");
		$class = str_replace($remove,"",$classes[$i]);
		if($class != "default_functions"){
			require_once("merchants/" . $merchant . "/classes/" . $merchant . "." . $class . ".class.php");
			array_push($a,$class::defaultValues());
		}
	}

	return $a;
}

function checkAttributes(){
		//creating output array
		$qA = array();
		
		//getting all group names
		$query = mysql_query(getAttrGroups());
		
		//create a new select for each group name
		while($row = mysql_fetch_array($query)){
			$queryPart = "SELECT DISTINCT `b`.`id_product`,
	                `d`.`name` AS `" . $row["group"] . "`,
	                `b`.`price` AS `attr_price`,
	                `b`.`weight` AS `attr_weight`,
	                CONCAT(`f`.`public_name`,': ',`d`.`name`) AS `title_addition`,
	                CONCAT(`f`.`id_attribute_group`,`b`.`id_product_attribute`) AS `id_product_ext`,
	                a.*,
					b.*,
					c.*,
					d.*,
					e.*,
					f.*
				FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product_attribute_combination` AS `a`
				INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product_attribute` AS `b` ON `a`.`id_product_attribute` = `b`.`id_product_attribute`
				INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute` AS `c` ON `a`.`id_attribute` = `c`.`id_attribute`
				INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute_lang` AS `d` ON `c`.`id_attribute` = `d`.`id_attribute`
				INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute_group` AS `e` ON `c`.`id_attribute_group` = `e`.`id_attribute_group`
				INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute_group_lang` AS `f` ON `e`.`id_attribute_group` = `f`.`id_attribute_group`
				WHERE (`f`.`public_name` = '" . $row["group"] . "')
				  AND (`b`.`available_date` < CURRENT_TIMESTAMP
				       OR `b`.`available_date` = 0000-00-00)";
			
			//adding to mass select array
			array_push($qA,$queryPart);
		}

		//imploding updated query
		$sql = mysql_query(implode(" UNION ALL ", $qA));

		$file = fopen("submissions/testing_attr_file.txt", "w+");

		$row = mysql_fetch_assoc($sql);

		//printing header
		$headers = array_keys($row);		
		fputcsv($file, $headers, chr(9));

		//printing body
		$i = 0;
		fputcsv($file, $row, chr(9), chr(0));	
		++$i;		

		return "<a href=\"submissions/testing_attr_file.txt\" target=\"_blank\" >Click Here to Download</a>";
	}
?>