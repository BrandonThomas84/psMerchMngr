<?php /* FILEVERSION: v1.0.2b */ ?>
<?php

class fieldConfig{

	//select_config table value properties
	public $id;
	public $merchant_id;
	public $report_field_name;
	public $custom_function;
	public $function_command;
	public $static_value;
	public $table_name;
	public $database_field_name;
	public $notes;
	public $enabled;
	public $order;
	public $editable;
	public $table_name_Friendly;
	public $messageDelivery;

	public function fieldConfig(){
		//checking for submitted values
		self::checkForSubmission();

		//setting class properties
		$sql = "SELECT DISTINCT `id`, `merchant_id`, `report_field_name`, `custom_function`, `function_command`, `static_value`, `table_name`, `database_field_name`, `notes`, CASE WHEN `enabled` = true THEN 'Y' WHEN `enabled` = false THEN 'N' END AS `enabled`, `order` FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE `merchant_id`='" . _MERCHANTID_ . "' AND `id`= " . $_GET["fieldID"];
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$this->id = $row["id"];
		$this->merchant_id = $row["merchant_id"];
		$this->report_field_name = $row["report_field_name"];
		$this->custom_function = $row["custom_function"];
		$this->function_command = $row["function_command"];
		$this->static_value = $row["static_value"];
		$this->table_name = $row["table_name"];
		$this->database_field_name = $row["database_field_name"];
		$this->notes = $row["notes"];
		$this->enabled = $row["enabled"];
		$this->order = $row["order"];
		$this->required = $row["report_field_name"]::required();
		$this->editable =  $row["report_field_name"]::editable($this->required);
		$this->table_name_Friendly = tableLettertoFriendly($row["table_name"]);

		
	}

	public function updateWriter($field,$value){
	
		if($value == "" || $value == "NULL"){
			$value = "NULL";
			} else {

				//defining array of string variables
				if(in_array($field,array("table_name","database_field_name","static_value","custom_function","function_command"))){
					$value = "'" . $value . "'";

				} elseif(in_array($value,array("on",1,"true",true))){

					//converting non friendly false values to db friendly ones
					$value = 1;

				} elseif((in_array($value,array("off",0,"false",false)))){

					//checking if it is a fals or null value or not set if enabled 
					$value = 0;

				} else{

					//simply return the form data
					$value = $value;
				}
			} 
				
		return "`" . $field . "` = " . $value;
	}
	public function checkForSubmission(){
		if(isset($_GET["act"])){
			if($_GET["act"] == "drp"){
				self::dropDynamicAssociation();
				messageReporting::insertMessage("warning","Removed dynamic column association");
			} elseif($_GET["act"] == "default"){
				self::restoreDefaults($_GET["fieldID"]);
				messageReporting::insertMessage("warning","Default values have been restored");
			}elseif($_GET["act"] == "update"){
				self::updateField();
				messageReporting::insertMessage("success","Success! You have updated your feed settings!");
			}elseif($_GET["act"] == "dtbs"){
				self::updateDynamicAssociation();
				messageReporting::insertMessage("success","Successfully mapped dynamic field.");
			}
		}

	}
	public function restoreDefaults($id){
		$sql = "SELECT `report_field_name` FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE `id` = " . $id;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);

		$row["report_field_name"]::restoreDefaults($row["report_field_name"]);
	}
	public function dropDynamicAssociation(){
		$sql = "UPDATE `" . _DB_NAME_ . "`.`mc_select_config` SET `table_name` = NULL, `database_field_name` = NULL WHERE `id` = " . $_GET["fieldID"];
		mysql_query($sql);
	}
	public function updateDynamicAssociation(){
		$a = array();

		array_push($a,self::updateWriter("table_name",$_POST["table_name"]));
		array_push($a,self::updateWriter("database_field_name",$_POST["database_field_name"]));
		$fields = implode(",",$a);

		$sql = "UPDATE `" . _DB_NAME_ . "`.`mc_select_config` SET " . $fields . " WHERE `id` = " . $_POST["id"];
		mysql_query($sql);
	}
	public function updateField(){

		//what fields to look for in the submitted form
		$fields = array("static_value","custom_function","function_command","enabled");

		//array used to print fields in update
		$a = array();

		//for each field check to see if it has been submitted and if so push the update statement to the update array
		foreach($fields as $field){
			if(isset($_POST[$field])){
				@array_push($a,self::updateWriter($field,$_POST[$field]));
			}

			if($field == "enabled"){
				if(isset($_POST["enabled"])){
					array_push($a," `enabled` = 1 ");
				} else {
					array_push($a," `enabled` = 0 ");
				}
				
			}
		}

		//compile each update into one
		$updateFields = implode(",",$a);

		//update query
		$sql = "UPDATE `" . _DB_NAME_ . "`.`mc_select_config` SET " . $updateFields . " WHERE `id` = " . $_POST["id"];		

		//run update
		$query = mysql_query($sql);
	}
}	

?>