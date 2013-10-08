<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class breadcrumbs{
	public $currentPage;

	public function breadcrumbs($currentPage){
		$this->currentPage = $currentPage;
	}
	public function constructCrumbs(){
		$crumbs = array();
		//adding default "Home" link
		array_push($crumbs,"<a href=\"index.php\" title=\"Home\">Home</a>");

		//checking to make sure you're not only at the homepage
		if($this->currentPage !== "Home"){
			//checking if this is the testing page so we can force the "testing" link before the merchant
			if(isset($_GET["p"])){
				if($_GET["p"] == "tst"){
					array_push($crumbs,"<a href=\"index.php?p=tst\" title=\"Home\">Testing</a>");
					//checking that the merchant constants have been set
					if(_MERCHANT_ !== ""){
						array_push($crumbs,"<a href=\"index.php?p=tst&f=" . _MERCH_  . "\" title=\"Testing " . _MERCHANT_ . " Functions\">" . _MERCHANT_ . " Testing</a>");
					} 
				}
			}
			//checking if current page is taxonomy page
			if(isset($_GET["f"])){
				if(!isset($_GET["p"]) || $_GET["p"] !== "tst") {
					array_push($crumbs,"<a href=\"index.php?f=" . $_GET["f"] . "\" title=\"" . _MERCHANT_ . " Control Panel\">" . _MERCHANT_ . " Control Panel</a>");
				}
			}
			//checking if current page is field configuration page
			if(isset($_GET["fieldID"])){
				//starting a fieldConfig class to get the field name
				$sql = "SELECT DISTINCT `report_field_name` FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE `merchant_id`='" . _MERCHANTID_ . "' AND `id`= " . $_GET["fieldID"];
				$query = mysql_query($sql);
				$rows = mysql_fetch_array($query);
				array_push($crumbs,"<a href=\"index.php?f=" . _MERCH_ . "&fieldID=" . $_GET["fieldID"] . "\" title=\"" . _MERCHANT_ . " Feed - " . ucfirst($rows["report_field_name"]) . " Field Control\">" . ucfirst($rows["report_field_name"]) . "</a>");
			}
			//checking if current page is dynamic database linking page
			if(isset($_GET["p"])){
				if($_GET["p"] == "dtbs"){
				array_push($crumbs,"<a href=\"index.php?f=" . _MERCH_ . "&p=dtbs&fieldID=" . $_GET["fieldID"] . "\" title=\"" . _MERCHANT_ . " Dynamic Field Linking\">Dynamic Field Linking</a>");
				}
				if($_GET["p"] == "exmng"){
				array_push($crumbs,"<a href=\"index.php?p=exmng\" title=\"" . _MERCHANT_ . " Product Exclusions\">" . _MERCHANT_ . " Product Exclusions</a>");
				}
				if($_GET["p"] == "tax"){
				array_push($crumbs,"<a href=\"index.php?f=" . _MERCH_ . "&p=tax\" title=\"" . _MERCHANT_ . " Taxonomy Configuration\">" . _MERCHANT_ . " Taxonomy Configuration</a>");
				}
				if($_GET["p"] == "cpnl"){
				array_push($crumbs,"<a href=\"index.php?p=cpnl\" title=\"Control Panel\">Control Panel</a>");
				}
				if($_GET["p"] == "ovrde"){

					if(isset($_GET["f"])){
						$f = "f=" . $_GET["f"] . "&";
					} else {
						$f = "";
					}

					array_push($crumbs,"<a href=\"index.php?" . $f . "p=ovrde\" title=\"Field Value Override Manager\">Field Value Override</a>");
				}
				if(isset($_GET["vm"])){

					if(isset($_GET["f"])){$f = "f=" . $_GET["f"] . "&";}

					//setting view method breadcrumb
					$vm = $_GET["vm"];
					if($vm == "a"){
						$vmTitle = "View All Overrides";
					} elseif($vm == "p"){
						$vmTitle = "View Overrides Grouped by Product";
					} elseif($vm == "f"){
						$vmTitle = "View Overrides Grouped by Report Field";
					}
					
					array_push($crumbs,"<a href=\"index.php?" . $f . "p=ovrde&vm=" . $vm . "\" title=\"" . $vmTitle . "\">" . $vmTitle . "</a>");
				}
			}
		}

		return "<ul class=\"breadcrumb\"><li>" . implode("<span class=\"divider\"></span></li><li>",$crumbs) . "</li></ul>";
	}
}

?>