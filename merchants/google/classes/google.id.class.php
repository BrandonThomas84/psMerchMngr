<?php /* FILEVERSION: v1.0.2b */ ?>
<?php
class id extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		
		//returning new row information for price that includes attribute adjusted pricing
		return "CAST(CONCAT(`A`.`id_product`,(CASE WHEN (`attrSet`.`id_product_ext` IS NULL OR `attrSet`.`id_product_ext` = '') THEN '' ELSE CONCAT('-',`attrSet`.`id_product_ext`) END)) AS CHAR(50))";
	}
	public static function includeTables(){
		$a = array("A","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','id',NULL,'id',NULL,1,1)";
	}
	public static function description(){
		return "<p>The identifier for each item has to be unique within your account, and cannot be re-used between feeds. If you have multiple feeds, ids of items within different feeds must still be unique. You can use any sequence of letters and digits for the item id.</p>";
	}
	public static function required(){
		return "Y";
	}
}
?>