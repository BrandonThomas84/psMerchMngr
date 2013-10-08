<?php /* FILEVERSION: v1.0.1b */ ?>
<?php


//checks for valid UPCs and those whos leading zeros may have been truncated up to two spaces
class upcFix extends feedFunction{
	public static function selectNoAlias(){
		return "(case when (length(`A`.`upc`) = 12) then `A`.`upc` when (length(`A`.`upc`) = 11) then concat('0', `A`.`upc`) when (length(`A`.`upc`) = 10) then concat('00', `A`.`upc`) else NULL end)";
	}
    public static function includeTables(){
		$a = array("A","");
		return $a;
	}
}

?>