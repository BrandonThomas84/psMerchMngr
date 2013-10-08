<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class unit_pricing_base_measure extends feedFunction {
	
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
		return "('google','unit_pricing_base_measure','AWATING VALUE','unit_pricing_base_measure',NULL,0,32)";
	}
	public static function description(){
		return "The ‘unit pricing base measure\' attribute specifies your preference of the denominator of the unit price (e.g. 100ml). You should only submit this attribute if you also submit ‘unit pricing measure\'.\n\nYou should only submit unit pricing attributes for specific products that require unit pricing to comply with local, state, or federal laws applicable to the country your product listings are targeting. For example, if your product listings are targeting any of the EU member states or Switzerland please consider the legal requirements on this matter defined in the national implementation acts of the EU directive 98/6/EC and any other applicable local law.\n\nWhen to include: Recommended if applicable for items in feeds targeting Germany, France, the United Kingdom, Italy, Spain, Switzerland, the Czech Republic, and the Netherlands. You should only submit this attribute if you also submit ‘unit pricing measure\', but it is not required to show unit prices.";
	}
}
?>