<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
//starting override class
$override = new productOverride;

if(isset($_GET["f"])){
	$title = merchantHeader("Override Configuration"); 
	$display = $override->viewOverrides();
} else {
	$title = "<div class=\"page-header\"><h1>Select a Merchant to Manage Overrides</h1></div>";
	$sMerch = new selectMerchantDisplay();
	$display = $sMerch->showIt();
}

echo $title . "<div class=\"clearfix spacer\"></div><div class=\"container well overrides\">" . $display . "</div><!--CLOSES WELL --></div><!--FOOTER START -->";

?>
