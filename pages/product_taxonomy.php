<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
//merchant functions autoloader information 
function __autoload($classname) {
	$file = "merchants/" . _MERCHANTID_ . "/classes/" . _MERCHANTID_ . "." . $classname . '.class.php';
    include_once($file);
}

$tControl = new taxonomyControl;
if(isset($_POST["categoryDrop"])){
	echo $tControl->deleteCategoriesGhost($_POST["categoryDrop"]);
}
if(isset($_POST["category"])){ 
	$category = $_POST["category"];
	$tControl->mapTheMapID($category);
	$tControl->checkForSubmission();
	
	echo merchantHeader("Taxonomy Configuration");
	echo "<div class=\"container well\">";
	$tControl->displayTaxonomyConfiguration($category);
	echo "
		</div>
		<br>";

} else { 
	$tControl->displayCategorySelect();
}
?>
</div><!--FOOTER START -->

