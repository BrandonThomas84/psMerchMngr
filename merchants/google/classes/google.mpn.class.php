<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class mpn extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){

		//setting return value
		return "COALESCE(`attrSet`.`new_mpn`,`A`.`reference`)"; 
	}
	public static function includeTables(){
		$a = array("A","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','mpn',NULL,'mpn',NULL,0,16)";
	}
	public static function description(){
	return "A Manufacturer Part Number is used to reference and identify a product using a manufacturer specific naming other than GTIN.\n\nWhen to include: Required according to the Unique Product Identifier Rules for all target countries except for Canada, India, and Russia. This attribute is recommended for Canada, India, and Russia.";
	}
}
?>