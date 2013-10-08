<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class link extends productLink{ 
	
	public static $alias = __CLASS__;

	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','link',NULL,'link',NULL,1,6)";
	}
	public static function required(){
		return "Y";
	}
}
?>