<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class shipping extends feedFunction {
	
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
		return "('google','shipping','AWATING VALUE','shipping',NULL,0,26)";
	}
	public static function description(){
		return "This attribute provides the specific shipping estimate for the product. Providing this attribute for an item overrides the global shipping settings you defined in your Google Merchant Center settings.\n\nThis attribute has four sub-attributes:\n\n    country (required): The country to which an item will be delivered (as an ISO 3166 country code). The default value for this sub-attribute is your feed\'s target country.\n    region (optional): The geographical region to which a delivery rate applies.\n    service (optional): The name of the shipping method.\n    price (required): Fixed delivery price.\n\nYou can include this attribute up to 100 times per item to specify shipping cost for individual regions. If you decide to submit it explicitly for each part of the country, make sure to cover each region or to specify if the item has free shipping.\n\nNote: Please remember that you must only provide direct-to-consumer shipping rates, as per our Program Policies. Rates for other methods, like ship-to-store delivery, are not allowed.\nWhen to include: If you want to specify shipping cost for this item, or you want to override the default shipping cost specified in the Merchant Center settings. Learn more.";
	}
}
?>