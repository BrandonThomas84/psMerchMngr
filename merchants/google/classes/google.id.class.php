<?php /* FILEVERSION: v1.0.2b */ ?>
<?php
class id extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		
		//calling attributes set that will have an effect on the price
		$query = mysql_query(getAttrGroups());
		$a = array();

		//creating a summation for each price attribute
		while($row = mysql_fetch_array($query)){
			$v = "(CASE WHEN (`" . $row["group"] . "`.`id_product_ext` IS NULL OR `" . $row["group"] . "`.`id_product_ext` = '-') THEN '' ELSE CONCAT('-',`" . $row["group"] . "`.`id_product_ext`) END)";
			array_push($a,$v);
		}
		
		//summing all prices via sql
		$idext = implode(",",$a);
		
		//returning new row information for price that includes attribute adjusted pricing
		return "CAST(CONCAT(`A`.`id_product`, " . $idext . ") AS CHAR(50))";
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