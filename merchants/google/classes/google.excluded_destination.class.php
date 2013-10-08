<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class excluded_destination extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`AWATING VALUE`"; 
	}
	public static function includeTables(){
		$a = array("","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','excluded_destination','AWATING VALUE','excluded_destination',NULL,0,35)";
	}
	public static function description(){
		return "By default, your items will also appear in Google Commerce Search if you\'re submitting to Google Shopping. Learn more.\n\nWhen to include: If you are using either Google Shopping or Commerce Search and you would like to exclude the item from either of these destinations.";
	}
}
?>