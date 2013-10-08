<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

//primary feed field function class
class feedFunction{
	protected static function checkOverride($overrideType){
        $sql = "SELECT DISTINCT `override_type` FROM `" . _DB_NAME_ . "`.`mc_overrides` WHERE merchant_ID = '" . _MERCHANTID_ . "' AND `override_type` = '" . $overrideType . "';";
        $query = mysql_query($sql);
        $numrows = mysql_num_rows($query);
        if($numrows > 0){ 
            return true; 
        } else {
            return false;
        }
    }
	public static function select($select,$alias){
        //checking to see if there are any overrides set for this field
        if(self::checkOverride($alias) == true){
            //if there are overrides then a case is inserted around the select that instructs the override to populate on products where they exist
            return "CASE WHEN `override_" . $alias . "`.`override_" . $alias . "` IS NOT NULL THEN `override_" . $alias . "`.`override_" . $alias . "` ELSE " . $select . " END  AS `" . $alias . "`";
        } else {
            //if there are no overrides set for this field then just the normal select is returned
            return $select . " AS `" . $alias . "`";
        }
    }
    public static function description(){
    	return "<h4 class=\"panel-heading\">Field Description</h4><p class=\"panel-body\">There is currently no description for this field.</p>";
    }

    public static function restoreDefaults($fieldname){
    	$values = str_replace(array("(",")"), "", $fieldname::defaultValues());
    	$value = explode(",", $values);

    	$sql = "UPDATE `" . _DB_NAME_ . "`.`mc_select_config` SET `merchant_id` = " . $value[0] . ", `report_field_name` = " . $value[1] . ",`static_value` = " . $value[2] . ",`custom_function` = " . $value[3] . ",`function_command` = " . $value[4] . ",`enabled` = " . $value[5] . ",`order` =  " . $value[6] . " WHERE `id` = " . $_GET["fieldID"];
    	mysql_query($sql);
    }
    public static function required(){
        return "";
    }
    public static function editable($e){
        if($e == "Y"){return " disabled ";}
    }
    public static function configDescription(){
        return "<p>There is not currently a description for the existing configuration of this field.</p>";
    }
    public function functionCommand($functionCommand){
        return "";
    }
}

?>