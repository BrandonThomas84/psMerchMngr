<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class online_only extends feedFunction {
	
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
		return "('google','online_only','AWATING VALUE','online_only',NULL,0,34)";
	}
	public static function description(){
		return "This is used to indicate if you have a product that is only available online and not in your physical store.\n\nThere are only two accepted values:\n\n    \'y\': if any item is not available in your store to purchase.\n    \'n\': if a customer can buy the posted item at your physical location - this is the default assumption.\n\nWhen to include: Required if you\'ve submitted your store locations, and you have items that you sell online but not in your physical stores.";}

}
?>