<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
//changing default time out and filesize limitations
ini_set("memory_limit",-1);
ini_set("max_execution_time",0); 

class feedAction {
	public function feedAction(){
		//open file with write permission
		$file = fopen("submissions/" . _MERCHANTID_ . "_feed.txt", "w+");
		
		if(isset($_GET["ql_man"])){
			$manualFeedFunction = $_GET["ql_man"];

			if($manualFeedFunction == "crt"){
				self::feedCreate($file);
				messageReporting::insertMessage("success","You have successfully created a new " . _MERCHANT_ . " feed.");
			} elseif($manualFeedFunction == "del"){
				@unlink($file);
				messageReporting::insertMessage("warning","You have successfully deleted the contents from your " . _MERCHANT_ . " feed.");
			}
		} elseif(isset($_POST["feedAction"])){
			//checks to see which function is being run
			if($_POST["feedAction"] == "delete"){
				@unlink($file);
				messageReporting::insertMessage("warning","You have successfully deleted the contents from your " . _MERCHANT_ . " feed.");
			} elseif($_POST["feedAction"] == "defaultSet"){
				self::restoreDefaults();
				messageReporting::insertMessage("success","Default values have been returned to all " . _MERCHANT_ . " feed fields.");
			} else {
				self::feedCreate($file);
				messageReporting::insertMessage("success","You have successfully created a new " . _MERCHANT_ . " feed.");
			} 
		}

		//close open file permissions and redirect back with message
		fclose($file);
	}

	protected function feedCreate($file){
		//creates header and contents
		HeaderPrint($file,queryBuilder('head'));
		MerchPrint($file,queryBuilder(''));
	}
	protected function restoreDefaults(){
		//delete all current values from the database for the selected merchant
		$rmvStmt = "DELETE FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE `merchant_id` = '" . _MERCHANTID_ . "'"; 
		mysql_query($rmvStmt);

		//create an array of the insert and all the default values from the individual classes
		$a = array();
		$insrtStmt = "INSERT INTO `" . _DB_NAME_ . "`.`mc_select_config` (`merchant_id`, `report_field_name`, `static_value`, `custom_function`, `function_command`, `enabled`, `order`) VALUES ";
		array_push($a,$insrtStmt);
		
		foreach(callAllMerchantClassDefaults(_MERCHANTID_) AS $fieldrow){
			array_push($a, $fieldrow . ",");
		}
		//run the insert of the default data
		mysql_query(substr(implode("",$a),0,(strlen(implode("",$a))-1)));

	}
}

?>