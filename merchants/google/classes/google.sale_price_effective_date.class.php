<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class sale_price_effective_date extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		$timezone = date("c",time());
		$offset = substr($timezone,-6);
		
		return "CONCAT(REPLACE(CAST(`F`.`from`AS CHAR(16)),' ','T'),'" . $offset . "/',REPLACE(CAST(`F`.`to`AS CHAR(16)),' ','T'),'" . $offset . "')";
	}
	public static function includeTables(){
		$a = array("F","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','sale_price_effective_date',NULL,'sale_price_effective_date',NULL,0,13)";
	}
	public static function description(){
		return "Used in conjunction with sale price. This attribute indicates the date range during which the sale price applies. Learn more about submitting sale price information.\r\nWhen to include: Recommended for items which use the \'sale price\' attribute.\r\nStart and end dates separated by a forward slash (/). The start is specified by the format (YYYY-MM-DD), followed by the letter ‘T\', the time of the day when the sale starts, followed by an expression of the timezone for the sale. \r\nEXAMPLE: 2011-03-01T13:00-0800/2011-03-11T15:30-0800";
	}
}
?>