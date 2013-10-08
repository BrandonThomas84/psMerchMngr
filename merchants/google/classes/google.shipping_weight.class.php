<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class shipping_weight extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		//calling attributes set that will have an effect on the price
		$query = mysql_query(getAttrGroups());
		$a = array();

		//creating a weight summation for each attribute
		while($row = mysql_fetch_array($query)){
			$v = "(CASE WHEN `" . $row["group"] . "`.`attr_weight` IS NULL THEN 0 ELSE `" . $row["group"] . "`.`attr_weight` END)";
			array_push($a,$v);
		}
		
		//summing all weights via sql
		$weightIncrease = implode("+",$a);
		
		//returning new row information for weight that includes attribute adjusted pricing
		return "CAST(`A`.`weight`+(" . $weightIncrease . ") AS DECIMAL(10,2))";
	}
	public static function includeTables(){
		$a = array("A","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','shipping_weight',NULL,'shipping_weight',NULL,0,27)";
	}
	public static function description(){
		return "This is the weight of the product used to calculate the shipping cost of the item. If you have specified a global shipping rule that is dependent on shipping weight, this attribute will be used to calculate the shipping cost of the item automatically.\r\n\r\nWhen to include: Required if you have set up a shipping rule in the Merchant Center that is based on weight.";
	}
}
?>