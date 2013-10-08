<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class unit_pricing_measure extends feedFunction {
	
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
		return "('google','unit_pricing_measure','AWATING VALUE','unit_pricing_measure',NULL,0,31)";
	}
	public static function description(){
		return "The ‘unit pricing measure\' attribute allows you to specify unit pricing information for an item. This attribute defines the measure and dimension of an item, e.g. 135ml or 55g. The unit price refers to the volume, weight, area, or length of the product without any packaging or the net drained weight of the product (in the case of food).\n\nUnit pricing attributes are recommended only for specific products that require unit pricing to comply with local, state, or federal laws applicable to the country your product listings are targeting. For example, if your product listings are targeting any of the EU member states or Switzerland please consider the legal requirements on this matter defined in the national implementation acts of the EU directive 98/6/EC and any other applicable local law.\n\nWhen to include: Recommended if applicable for items in feeds targeting the UK, Germany, France, Italy, Spain, Switzerland, the Czech Republic, and the Netherlands. It is also recommended to submit the ‘unit pricing base measure\' attribute in conjunction with ‘unit pricing measure\'.";
	}
}
?>