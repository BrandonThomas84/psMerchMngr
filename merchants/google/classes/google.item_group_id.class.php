<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class item_group_id extends feedFunction {
	
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
		return "('google','item_group_id','AWATING VALUE','item_group_id',NULL,0,22)";
	}
	public static function description(){
		return "All items that are color/material/pattern/size variants of the same product must have the same item group id. If you have a “Parent SKU” that is shared by all variants of a product, you can provide that as the value for \'item group id\'.\n\nWhen to include:Required for variant apparel products in the US, UK, DE, FR, and JP. For other countries, if variant data is submitted with specific images then include the ‘item group ID\'.";
	}
}
?>