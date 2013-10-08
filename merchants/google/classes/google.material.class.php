<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class material extends feedFunction {
	
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
		return "('google','material','AWATING VALUE','material',NULL,0,23)";
	}
	public static function description(){
		return "The material or fabric that a product is made out of. For example, a high heel pump might have values of “Leather”, “Denim”, “Suede”, etc.\n\nWhen to include: Required for all apparel variants that differ by material for feeds that target the US, UK, DE, FR, and JP. Recommended for other countries and product categories (might become required in the future).";
	}
}
?>