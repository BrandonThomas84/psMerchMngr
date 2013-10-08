<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class pattern extends feedFunction {
	
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
		return "('google','pattern','AWATING VALUE','pattern',NULL,0,24)";
	}
	public static function description(){
		return "The pattern or graphic print featured on a product. For example, a t-shirt might have a logo of a sports team and have pattern values of “Bears”, “Tigers”, etc. A dress might come in two prints, and have pattern values of “Polka Dot”, “Striped”, “Paisley”, etc.\n\nAs a rule of thumb, if a user can choose to select different patterns on the landing page of your product, include all variant items in the same item group. Otherwise, use separate item groups.\n\nWhen to include: Required for all apparel variants that differ by pattern for feeds that target the US, UK, DE, FR, and JP. Recommended for other countries and product categories(might become required in the future).";}

}
?>