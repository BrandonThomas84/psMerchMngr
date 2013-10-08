<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
////////////////////////////////////////////////////////////////////////
// Merchant Control General Functions
////////////////////////////////////////////////////////////////////////
//returns "checked" if input value IS "Y"
function feedConfigChecked($value){
	if($value === 'Y'){return " checked ";
	}
}
//returns button classes
function feedFieldClasses($active){
	$a = array("field-btn btn");
	if($active === "N") {
		array_push($a,"btn-danger");
	} else {array_push($a,"btn-success");
		}
	return implode(" ",$a);
}
//returns "required" class span if input value IS "Y"
function feedFieldRequired($value){
	if($value === 'Y'){return "<span class=\"required label label-danger\">*REQUIRED</span>";
	}
}
//returns available features list
function availFeatures($selected){
	$sql = feedFrom::tableFeatBuild("flist","");
	$query = mysql_query($sql);
	$a = array();
	while($row = mysql_fetch_array($query)){
		$v = "<option value=\"" . $row["Features"] . "\" " . feedConfigSelected(strtolower($row["Features"]),strtolower($selected)) . ">" . $row[0] . "</option>";
		array_push($a,$v);
	}
	return implode("",$a);
}
//returns available features list
function availAttributes($selected){
	$sql = getAttrGroups();
	$query = mysql_query($sql);
	$a = array();
	while($row = mysql_fetch_array($query)){
		$v = "<option value=\"" . $row["group"] . "\" " . feedConfigSelected(strtolower($row["group"]),strtolower($selected)) . ">" . $row[0] . "</option>";
		array_push($a,$v);
	}
	return implode("",$a);
} 
//returns a list of custom functions that are available per merchants
function availableCustomFunctions($selected){
	$sql = "SELECT DISTINCT `report_field_name` FROM `" . _DB_NAME_ ."`.`mc_select_config` WHERE merchant_id = '" . _MERCHANTID_ . "'";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query)){
		$class = $row["report_field_name"];
		if(class_exists($class)){
			echo "<option value=\"" . $class . "\" " . feedConfigSelected($class,$selected) . ">" . $class  . "</option>";;
		}
	}
}
////////////////////////////////////////////////////////////////////////
// Merchant Control Classes
////////////////////////////////////////////////////////////////////////

function displayAllFields(){
	$sql = "SELECT DISTINCT `id`, `merchant_id`, `report_field_name`, `custom_function`, `function_command`, `static_value`, `table_name`, `database_field_name`, `notes`, CASE WHEN `enabled` = true THEN 'Y' WHEN `enabled` = false THEN 'N' END AS `enabled`, `order` FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE `merchant_id`='" . _MERCHANTID_ . "' ORDER BY `order` ASC";
	$query = mysql_query($sql);
	$a = array();

	while($row = mysql_fetch_array($query)){
		$value = "
			<div class=\"feed-field col-lg-3\">
				<a class=\"" . feedFieldClasses($row["enabled"]) . "\" href=\"" . $_SERVER["PHP_SELF"] . "?f=" . _MERCH_ . "&fieldID=" . $row["id"] . "\" title=\"Edit Field Settings for " . $row["report_field_name"] . "\">
					" . $row["report_field_name"] . feedFieldRequired($row["report_field_name"]::required()) . "
				</a>
			</div>";
		array_push($a,$value);
	}

	return implode("",$a);
}
?>