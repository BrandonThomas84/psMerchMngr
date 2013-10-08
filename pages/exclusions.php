<?php /* FILEVERSION: v1.0.1b */ ?>
<?php 

$exclusions = new exclusions;

if(isset($_GET["f"])){
	//merchant functions autoloader information 
	function __autoload($classname) {
		$file = "merchants/" . _MERCHANTID_ . "/classes/" . _MERCHANTID_ . "." . $classname . '.class.php';
	    include_once($file);
	}

	//setting page title
	$title = merchantHeader("Feed Exclusions");
	
?>

<div class="container well">
	<div class="col-md-12 panel-body">
		<div class="panel-group" id="accordion">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseNewExclusions"><h2 class="panel-title">Add New Exclusion</h2></a>
		    	</div>
		    	<div id="collapseNewExclusions" class="panel-collapse collapse">
		    		<br>
					<?php echo $exclusions->displayNewExclusion(); ?>
					<div class="clearfix"></div>
					<br>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 panel-body">
		<div class="panel-group">
			<div class="panel panel-dark">
				<div class="panel-heading">
					<h2 class="panel-title">Manage Existing Exclusions</h2>
		    	</div>
		    	<div class="panel exclusions-top">
		    		<br>
					<?php $exclusions->displayExcludedProducts(); ?>						
				</div>
			</div>
		</div>
	</div>
</div><!--FOOTER START -->

<?php 

echo $exclusions->footer(); 

} else {

	echo  "<div class=\"page-header\"><h1>Select a Merchant to Manage Exclusions</h1></div><div class=\"clearfix spacer\"></div><div class=\"container well\">";

	$sMerch = new selectMerchantDisplay();
	$display = $sMerch->showIt();
	
	echo $display . "</div><!--CLOSES WELL --></div><!--FOOTER START -->";
}
?>