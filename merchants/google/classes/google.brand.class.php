<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class brand extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`B`.`name`"; 
	}
	public static function includeTables(){
		$a = array("B","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','brand',NULL,'brand',NULL,1,14)";
	}
	public static function description(){
		return "When to include: Required according to the Unique Product Identifier Rules for all target countries except for Canada, India, and Russia. This attribute is recommended for Canada, India, and Russia.";
	}
	public static function required(){
		return "Y";
	}
}
?>