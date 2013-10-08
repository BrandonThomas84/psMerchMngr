<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class size extends feedFunction {
	
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
		return "('google','size','AWATING VALUE','size',NULL,0,21)";
	}
	public static function description(){
		return "This indicates the size of a product. You may any provide values which are appropriate to your items. Examples for sizing values can be found in this article. When to include: Required for all apparel items in the \'clothing\' and \'shoes\' product categories in feeds that target the US, UK, DE, FR, and JP. Recommended for other countries and product categories (might become required in the future).";
	}
}
?>