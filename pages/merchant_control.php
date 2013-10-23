<?php /* FILEVERSION: v1.0.2b */ ?>
<?php 
require("functions/merchant_control_functions.php");
////////////////////////////////////////////////////////////////////////
//Include all merchant classes
////////////////////////////////////////////////////////////////////////
$classes = scandir("merchants/" . _MERCHANTID_ . "/classes");
for($i=2;$i<=(count($classes)-1);$i++){
	require("merchants/" . _MERCHANTID_ . "/classes/" . $classes[$i]);
}

if(isset($_POST["feedAction"]) || isset($_GET["ql_man"])){new feedAction;}

if(isset($_GET["fieldID"])){
	require("pages/field_config.php");
} else {
	echo merchantHeader("Feed Control Panel");

	$file = "submissions/" . _MERCHANTID_ . "_feed.txt"; 
	$taxonomy = new taxonomyButton;
	if(file_exists($file)){
		$fileCreation = date('l m/d/Y H:i:s', filemtime($file));
		$fileSize = round(((filesize($file)/1024)/1024),2,PHP_ROUND_HALF_UP); 	
	} else {
		echo messageReporting::insertMessage("warning","You have not created a feed for this merchant yet. Why don't you start by creating a new feed?");
	}
	
	
	echo "
	<div class=\"container well\">
		<div class=\"section-head\">
			<h2>Functions</h2>" .  help::createButton("merchantFunctions") . "
		</div>
		<div class=\"btn-toolbar\">
			<div class=\"feed-field col-lg-3\">
				<form action=\"index.php?f=" . _MERCH_ . "\" method=\"post\">
					<input type=\"hidden\" name=\"feedAction\" value=\"create\">
					<input type=\"submit\" class=\"form-control btn btn-success\" value=\"Create New " . _MERCHANT_ . " Feed\">
				</form>
			</div>
			<div class=\"feed-field col-lg-3\">
				<form action=\"index.php?f=" . _MERCH_ . "\" method=\"post\">
					<input type=\"hidden\" name=\"feedAction\" value=\"delete\">
					<input type=\"submit\" class=\"form-control btn btn-warning\" value=\"Purge " . _MERCHANT_ . " Feed\">
				</form>
			</div>
			<div class=\"feed-field col-lg-3\">
				<form action=\"index.php?f=" . _MERCH_ . "\" method=\"post\">
					<input type=\"hidden\" name=\"feedAction\" value=\"defaultSet\">
					<input type=\"submit\" class=\"form-control btn btn-danger\" " . confirmMessage("Are you sure you want to return all feed fields to their default settings? This will result in a loss of any changes you may have made to any feed field settings. This action cannot be undone. ") . " value=\"Reset Default Values\">
				</form>
			</div>
			<div class=\"feed-field col-lg-3\">
				<form action=\"submissions/" . _MERCHANTID_ . "_feed.txt\" target=\"_blank\" method=\"post\">
					<input type=\"submit\" class=\"form-control btn btn-info\" value=\"Download " . _MERCHANT_ . " Feed\">
				</form>
			</div>
			<div class=\"clearfix\"></div>
		</div>
		<br>
		<div class=\"section-head\">
			<h2>Rules</h2>" .  help::createButton("merchantRules") . "
		</div>
		<div class=\"feed-field col-lg-4\">
			<form action=\"index.php?f=" . _MERCH_ . "&p=exmng\" method=\"post\">
				<input type=\"submit\" class=\"form-control btn btn-primary\" value=\"Manage " . _MERCHANT_ . " Exclusions\">
			</form>
		</div>
		<div class=\"feed-field col-lg-4\">
			<form action=\"index.php?f=" . _MERCH_ . "&p=ovrde\" method=\"post\">
				<input type=\"submit\" class=\"form-control btn btn-primary\" value=\"Manage " . _MERCHANT_ . " Value Overrides\">
			</form>
		</div>
		<div class=\"feed-field col-lg-4\">"
			. $taxonomy->controlPage() . "
		</div>
		<div class=\"clearfix\"></div>
		<br>
		<div class=\"section-head\">
			<h2>Field Configuration</h2>" .  help::createButton("merchantFieldConfiguration") . "
		</div>
		<div class=\"clearfix\"></div> ";

		//Feed configuration

		echo displayAllFields() ."<div class=\"clearfix\"></div>";

		//Call merchant specific information
		require ("merchants/" . _MERCHANTID_ . "/" . _MERCHANTID_ . ".php");
		echo "</div>";
}
?>
</div><!--FOOTER START -->