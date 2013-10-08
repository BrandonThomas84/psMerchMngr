<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class adwords_labels extends feedFunction {
	
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
		return "('google','adwords_labels','AWATING VALUE','adwords_labels',NULL,0,29)";
	}
	public static function description(){
		return "Very similar to adwords_grouping, but it will only only work on CPC. It can hold multiple values, allowing a product to be tagged with multiple labels.','AWATING VALUE','adwords_labels";
	}
}
?>