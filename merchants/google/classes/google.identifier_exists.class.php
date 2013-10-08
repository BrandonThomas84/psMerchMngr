<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class identifier_exists extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "(case when ((`A`.`reference` is not null) or (`A`.`reference` <> '')) then 'TRUE' when ((`A`.`upc` is not null) or (`A`.`upc` <> '')) then 'TRUE' else 'FALSE' end)";
	}
	public static function includeTables(){
		$a = array("A","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','identifier_exists',NULL,'identifier_exists',NULL,0,17)";
	}
	public static function description(){
		return "In categories where unique product identifiers are required, merchants must submit the ‘identifier exists\' attribute with a value of FALSE when the item does not have unique product identifiers appropriate to its category, such as GTIN, MPN, and brand.\n\nWhen to include: Required according to the Unique Product Identifier Rules for all target countries except for Canada, India, and Russia. This attribute is recommended for Canada, India, and Russia.";
	}
}
?>