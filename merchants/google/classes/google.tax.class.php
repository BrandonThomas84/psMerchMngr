<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class tax extends feedFunction {
	
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
		return "('google','tax','AWATING VALUE','tax',NULL,0,25)";
	}
	public static function description(){
		return "The tax attribute is an item-level override for merchant-level tax settings as defined in your Google Merchant Center account. This attribute is only accepted in the US, if your feed targets a country outside of the US, please do not use this attribute.\n\nThis attribute has four parts:\n\n    country (optional): The country an item is taxed in according to ISO 3166 standard (at the moment, it\'s always \'US\')\n    region (optional): The geographic region that a tax rate applies to. In the US, the two-letter state abbreviation, ZIP code, or ZIP code range using * wildcard.\n    rate (required): The tax rate as a percent of the item price, i.e., a number as a percentage\n    tax_ship (optional): Boolean value for whether you charge tax on shipping, y for yes or n for no - the default value is n\n\nYou can include this attribute up to 100 times to specify taxes for each state individually. If you decide to submit it explicitly for each state, make sure to cover every state (even the states where you do not charge tax). Note you can also specify that you charge no tax for a state.\n\nWhen to include: For items in feeds which target the US, use this attribute if you want to specify taxes for a particular item, or you want to override the default tax costs specified in the Merchant Center settings. If you do not provide tax information using one of these methods for each item, your items won\'t show up in Google Shopping results.Learn more.";
	}
}
?>