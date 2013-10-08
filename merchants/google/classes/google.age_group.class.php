<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class age_group extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`AWATING VALUE`"; 
	}
	public static function includeTables(){
		$a = array("Feat",__CLASS__);
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','age_group','AWATING VALUE','age_group',NULL,0,19)";
	}
	public static function description(){
		return "<p>Accepted values:</p><ul><li>Adult</li><li>Kids</li></ul><hr><p>When to include:</p><p>Required for all apparel items in feeds that target the US, UK, DE, FR, and JP.</p><hr><p>Recommended for other countries and product categories (might become required in the future).</p>";
	}
}
?>