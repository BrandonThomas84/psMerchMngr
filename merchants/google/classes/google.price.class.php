<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class price extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		//calling attributes set that will have an effect on the price
		$query = mysql_query(getAttrGroups());
		$a = array();

		//creating a summation for each price attribute
		while($row = mysql_fetch_array($query)){
			$v = "(CASE WHEN `" . $row["group"] . "`.`attr_price` IS NULL THEN 0 ELSE `" . $row["group"] . "`.`attr_price` END)";
			array_push($a,$v);
		}
		
		//summing all prices via sql
		$priceIncrease = implode("+",$a);
		
		//returning new row information for price that includes attribute adjusted pricing
		return "CONCAT(CAST(CAST(`A`.`price`+(" . $priceIncrease . ") AS DECIMAL(10,2)) AS CHAR(15)),' ',`cur`.`iso_code`)";
	}
	public static function includeTables(){
		$a = array("A","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','price',NULL,'price',NULL,1,11)";
	}
	public static function description(){
		return "The price of the item has to be the most prominent price on the landing page. If multiple items are on the same page with multiple prices, it has to be straightforward for the user to find the correct item and corresponding price.\n\nWhen to include: Required for all items.";
	}
	public static function required(){
		return "Y";
	}
}
?>