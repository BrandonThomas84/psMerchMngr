<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

//creates navigation menu classes
class navGeneration{
	public function navGeneration(){
		echo "
		<div class=\"navbar navbar-inverse navbar-fixed-top\">
		  <div class=\"container\">
		    <div class=\"navbar-header main-nav\">
			  <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
	            <span class=\"icon-bar\"></span>
	            <span class=\"icon-bar\"></span>
	            <span class=\"icon-bar\"></span>
	          </button>
		      <a class=\"navbar-brand\" href=\"#\">Merchant Manager</a>
		    </div>
		    <div class=\"navbar-collapse collapse\" style=\"margin-left: 20px;\">
		      <ul class=\"nav navbar-nav\">
		        <li><a href=\"index.php\">Home</a></li>";
		echo self::navMerchants();
		echo self::navSettings();

		echo "
				<li><a href=\"index.php?p=logout\">Logout</a></li>
		      </ul>
		    </div>
		  </div>
		</div>
		<div class=\"clearfix\"></div>";
	}

	public function navMerchants(){
		$sql = "SELECT DISTINCT `merchant_id` FROM `" . _DB_NAME_ . "`.`mc_select_config` ORDER BY `merchant_id`";
		$query = mysql_query($sql);
		$a = array();
		
		$start = "
			<li class=\"dropdown\">
	          <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Feed Manager<b class=\"caret\"></b></a>
	          <ul class=\"dropdown-menu\">
	            <li class=\"dropdown-header\"><strong>Shopping Feeds</strong></li>
	            <li class=\"divider\"></li>";
		array_push($a,$start);

		while($row = mysql_fetch_array($query)){
			$m = merchantToMerch($row["merchant_id"]);
			
			$v = "<li><a href=\"./index.php?f=" . $m . "\" title=\"Manage " . strtoupper(substr($row["merchant_id"],0,1)) . substr($row["merchant_id"],1,15)  . " Product Feed\">" . strtoupper(substr($row["merchant_id"],0,1)) . substr($row["merchant_id"],1,15)  . "</a></li>";
			array_push($a,$v);
		}

		$end = "</ul></li>";
		array_push($a,$end);

		return implode("",$a);
	}
	
	public function navSettings(){
		$theme = "color";
		if($_SESSION["username"] !== "DemoUser"){
			$testingLink = "<li><a href=\"index.php?p=tst\" title=\"Testing Page\">Testing Page</a></li>";
		} else {
			$testingLink = "";
		}
		echo "
			<li class=\"dropdown\">
	          <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Settings <b class=\"caret\"></b></a>
	          <ul class=\"dropdown-menu\">
	          	<li class=\"dropdown-header\"><strong>Globals</strong></li>
	          	<li><a href=\"index.php?p=exmng\" title=\"Product Exclusions\">Product Exclusions</a></li>
	          	<li><a href=\"index.php?p=ovrde\" title=\"Product Value Overrides\">Value Overrides</a></li>
	          	<li class=\"divider\"></li>
	            <li class=\"dropdown-header\"><strong>Configuration</strong></li>
	            <li><a href=\"index.php?p=cpnl\" title=\"Control Panel\">Control Panel</a></li>
	            " . $testingLink  . "	            
			    <li><a href=\"#bugModal\" role=\"button\" data-toggle=\"modal\">Report a Bug</a></li>
			    <li class=\"divider\"></li>
			    <li><a href=\"index.php?p=logout\" title=\"Logout of Session\">Logout</a></li>
	          </ul>
	        </li>"; 
	}
}

?>