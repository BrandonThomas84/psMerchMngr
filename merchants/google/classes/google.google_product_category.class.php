<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class google_product_category extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`E`.`final_category`"; 
	}
    public static function includeTables(){
		$a = array("E","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','google_product_category',NULL,'google_product_category',NULL,0,4)";
	}
	public static function description(){
		return "The \'google product category\' attribute indicates the category of the product being submitted, according to the Google product taxonomy. This attribute accepts only one value, taken from the product taxonomy tree. If your items fall into multiple categories, include only one category which is the most relevant.\r\n\r\nAny category from Google\'s product taxonomy must include the full path. For example, \'Apparel & Accessories > Clothing > Jeans\' is an acceptable value, but \'Jeans\' is not.\r\n\r\nWhen to include: For all target countries except Canada, India, and Russia, ‘google product category\' is required for all items that fall within the \'Apparel & Accessories\', \'Media\', and \'Software\' categories. If your products do not fall into one of those categories - or if your feed targets Canada, India, or Russia - this attribute is recommended but not required.";
	}
}
?>