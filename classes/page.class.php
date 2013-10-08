<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class page {

	public $page;

	public function __construct(){
		if(isset($_GET["p"])){
			$config = $_GET["p"];
			if($config == "logout"){ 
				$breadcrumbs = new breadcrumbs("Logout");
				echo $breadcrumbs->constructCrumbs();
				require ('pages/logout.php');
			}
			if($config == "exmng"){ 
				$breadcrumbs = new breadcrumbs("Product Exclusions");
				echo $breadcrumbs->constructCrumbs();
				require ('pages/exclusions.php'); 
			}
			if($config == "tax"){ 
				$breadcrumbs = new breadcrumbs("Product Taxonomy");
				echo $breadcrumbs->constructCrumbs();
				require ('pages/product_taxonomy.php');
			}
			if($config == "cpnl"){ 
				$breadcrumbs = new breadcrumbs("Control Panel");
				echo $breadcrumbs->constructCrumbs();
				require ('pages/control_panel.php');
			}
			if($config == "tst"){ 
				$breadcrumbs = new breadcrumbs("Testing");
				echo $breadcrumbs->constructCrumbs();
				require ('pages/testing.php');
			}
			if($config == "dtbs"){ 
				$breadcrumbs = new breadcrumbs("Dynamic Field Configuration");
				echo $breadcrumbs->constructCrumbs();
				require ('pages/dynamicField.php');
			}
			if($config == "ovrde"){ 
				$breadcrumbs = new breadcrumbs("Field Value Overrides");
				echo $breadcrumbs->constructCrumbs();
				require ('pages/override.php');
			}
		} else {
			if(_MERCH_ == "home"){ 
				$breadcrumbs = new breadcrumbs("Home");
				echo $breadcrumbs->constructCrumbs();
				require ('pages/home.php');
				
			} else {
				$breadcrumbs = new breadcrumbs(_MERCHANT_ . " Control");
				echo $breadcrumbs->constructCrumbs();
				require('pages/merchant_control.php');
			}
		}
	}
}

?>