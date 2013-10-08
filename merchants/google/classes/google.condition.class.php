<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class condition extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`A`.`condition`"; 
	}
	public static function includeTables(){
		$a = array("A","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','condition',NULL,'condition',NULL,1,9)";
	}
	public static function description(){
		return "There are only three accepted values:\n\n    \'new\': The product is brand-new and has never been used. It\'s in its original packaging which has not been opened.\n    \'refurbished\': The product has been restored to working order. This includes, for example, remanufactured printer cartridges.\n    \'used\': If the two previous values don\'t apply. For example, if the product has been used before or the original packaging has been opened or is missing.";
	}
	public static function required(){
		return "Y";
	}
}
?>