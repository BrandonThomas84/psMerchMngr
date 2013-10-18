<?php /* FILEVERSION: v1.0.2b */ ?>
<?php
class feedSelect{
	public static function sql(){
		$sql = "SELECT `report_field_name`, `static_value`, `custom_function`,`function_command`,`table_name`,`database_field_name`,`id` FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE `merchant_id` = '" . _MERCHANTID_ . "' AND `enabled` = 1 ORDER BY `order` LIMIT 0,250";
		
		return $sql;	
	} 
	
	//grabs field settings and constructs the "SELECT" statement for the feed
	public static function selectConstruct(){
		
		$statement = array();
		
		$query = mysql_query(self::sql());

		while($row = mysql_fetch_array($query)){
			array_push($statement,selectFieldReturn($row["id"]));
		}
		
		return "SELECT DISTINCT " . implode(", ",$statement);	
	}

	public static function selectTables(){
		$tables = array();
		$query = mysql_query(self::sql());

		//mandatory tables
		array_push($tables,array("Cur",""));
		array_push($tables,array("A",""));
		array_push($tables,array("B",""));
		array_push($tables,array("AttrBase",""));
		array_push($tables,array("OverrideBase",""));
		
		
		while($row = mysql_fetch_array($query)){
			//excludes all rows with static values
			if(is_null($row["static_value"])){
				//check for flat database inclusion "dynamic value"
				if(!is_null($row["table_name"])){
					$value = array($row["table_name"],"");
					array_push($tables,$value);
				} else {
					//check if custom function is a "mapToFeature"
					if($row["custom_function"] == "mapToFeature"){
						//check to make sure function command is set if custom function is "mapToFeature"
						if(!is_null($row["function_command"])){
							$value = array("Feat",strtolower($row["function_command"]));
							//add the table to the array if it hasn't already been called
							if(!in_array($value,$tables)){
								array_push($tables,$value);
							}						
						} else {
							//returns an error to the user instructing them to select a feature to map to 
							die(messageReporting::insertMessage("error","You have not selected a feature to reference for a \"Map to Feature\" feed function. Please select a product feature to map this field to."));
						}
					} elseif($row["custom_function"] == "mapToAttribute"){
						//check to make sure function command is set if custom function is "mapToAttribute"
						if(!is_null($row["function_command"])){
							$value = array("AttrBase",strtolower($row["function_command"]));
							//add the table to the array if it hasn't already been called
							if(!in_array($value,$tables)){
								array_push($tables,$value);
							}						
						} else {
							//returns an error to the user instructing them to select a feature to map to 
							die(messageReporting::insertMessage("error","You have not selected an attribute Group to reference for a \"Map to Attribute\" feed function. Please select a product attribute to map this field to."));
						}
					} else {
						$value = $row["custom_function"]::includeTables();

						//checking if the returned value is a nested array of tables (multiple tables)
						if(count($value)>2){
							foreach($value AS $value){
								array_push($tables,$value);
							}
						} else {
							array_push($tables,$value);
						}
					}
				}
			}
		}
		return $tables;
	}
}
?>