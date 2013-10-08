<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class energy_efficiency_class extends feedFunction {
	
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
		return "('google','energy_efficiency_class','AWATING VALUE','energy_efficiency_class',NULL,0,33)";
	}
	public static function description(){
		return "The \'energy efficiency class\' attribute allows you to specify the energy efficiency class for certain product categories as defined in EU directive 2010/30/EU.\n\nYou should only submit the energy efficiency class attribute for specific products that require it to comply with local, state, or federal laws applicable to the country your product listings are targeting. For example, if your product listings target any of the EU member states or Switzerland, please consider the legal requirements on this matter defined in the national implementation acts of the EU directive 2010/30/EU and any other applicable local law.\n\nWhen to include: Recommended if applicable for items in feeds targeting Germany, France, the United Kingdom, Italy, Spain, Switzerland, the Czech Republic, and the Netherlands.";
	}
}
?>