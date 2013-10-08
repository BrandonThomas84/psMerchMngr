<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class adwords_redirect extends feedFunction {
	
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
		return "('google','adwords_redirect','AWATING VALUE','adwords_redirect',NULL,0,30)";
	}
	public static function description(){
		return "Allows advertisers to specify a separate URL that can be used to track traffic coming from Google Shopping. If this attribute is provided, you must make sure that the URL provided through \'adwords redirect\' will redirect to the same website as given in the link attribute.";
	}
}
?>