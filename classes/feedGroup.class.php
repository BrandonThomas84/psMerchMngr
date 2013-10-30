<?php /* FILEVERSION: v1.0.2b */ ?>
<?php 
class feedGroup {
	public static function groupField(){
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
	public static function groupConstruct(){

		//checking if merchant is google
		if(_MERCHANTID_ == 'google'){

			//checking if mpn is enabled
			$sql = "SELECT `enabled` FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE `report_field_name` = 'mpn'";
			$query = mysql_query($sql);
			$row = mysql_fetch_array($query);

			//if mpn enabled then group by mpn
			if($row["enabled"] == 1){
				return " GROUP BY `mpn`";		
			}
		}
	} 
}
?>