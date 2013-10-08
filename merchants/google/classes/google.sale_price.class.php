<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class sale_price extends feedFunction{ 
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "CONCAT(CAST(`F`.`sale_price` AS CHAR(15)),' ',`cur`.`iso_code`)";
	}
	public static function includeTables(){
		$a = array("F","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','sale_price',NULL,'sale_price',NULL,0,12)";
	}
	public static function description(){
		return "Use this attribute to submit the advertised sale price of the item.\r\nWhen to include: Recommended for items on sale. If your item is on sale and you don\'t include this attribute, the sale price must be updated as the value in the \'price\' attribute.";
	}
}
?>