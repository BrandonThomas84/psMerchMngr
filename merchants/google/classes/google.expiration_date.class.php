<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class expiration_date extends feedFunction {
	
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
		return "('google','expiration_date','AWATING VALUE','expiration_date',NULL,0,36)";
	}
	public static function description(){
		return "This is the date that an item listing will expire. If you do not provide this attribute, items will expire and no longer appear in Google Shopping results after 30 days. You cannot use this attribute to extend the expiration period to longer than 30 days.\nWhen to include: If you would like an item to expire earlier than 30 days from the upload date of the feed.\nEXAMPLE: 2004-08-19";
	}
}
?>