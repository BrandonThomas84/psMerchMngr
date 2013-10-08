<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class description extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`C`.`description_short`"; 
	}
	public static function includeTables(){
		$a = array("C","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','description',NULL,'description',NULL,1,3)";
	}
	public static function descriptionFix(){
		return "<p>Include only information relevant to the item. Describe its most relevant attributes, such as size, material, intended age range, special features, or other technical specs. Also include details about the item\'s most visual attributes, such as shape, pattern, texture, and design, since we may use this text for finding your item.</p><p>We recommend that you submit around 500 to 1,000 characters, but you can submit up to 10,000 characters. Descriptions should follow standard grammar rules and end with a punctuation mark.</p>";
	}
	public static function required(){
		return "Y";
	}
}
?>