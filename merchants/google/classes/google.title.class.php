<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class title extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`C`.`name`"; 
	}
	public static function includeTables(){
		$a = array("C","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','title',NULL,'title',NULL,1,2)";
	}
	public static function description(){
		return "<p>This is the name of your item which is required. We recommend you include characteristics such as color or brand in the title which differentiates the item from other products.</p>";
	}
	public static function required(){
		return "Y";
	}
}
?>