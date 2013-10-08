<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class gender extends feedFunction { 
	
	public static $alias = __CLASS__;

	public static function selectNoAlias(){
		return "`" . __CLASS__. "`.`" . __CLASS__. "`";
    }
    public static function includeTables(){
		$a = array("Feat",__CLASS__);
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','gender',NULL,'gender',NULL,0,18)";
	}
	public static function description(){
		return "Three predefined values accepted:\n\n    Male\n    Female\n    Unisex\n\nWhen to include: Required for all apparel items in feeds that target the US, UK, DE, FR, and JP. Recommended for other countries and product categories (might become required in the future)";
	}
}
?>