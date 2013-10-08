<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class gtin extends upcFix{ 
	
	public static $alias = __CLASS__;

	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','gtin',NULL,'gtin',NULL,1,15)";
	}

	public static function description(){
		return "
		<h3>" . _MERCHANT_ . " Describes " . strtoupper(__CLASS__) . "</h3>
		<p>Use the \"gtin\" attribute to submit Global Trade Item Numbers (GTINs) in one of the following formats:</p><ul><li>UPC (in North America): 12-digit number such as 3234567890126</li><li>EAN (in Europe): 13-digit number such as 3001234567892</li><li>JAN (in Japan): 8 or 13-digit number such as 49123456 or 4901234567894</li><li>ISBN (for books): 10 or 13-digit number such as 0451524233. If you have both, only include 13-digit number.</li></ul>
		<p>When to include: Required according to the Unique Product Identifier Rules for all target countries except for Canada, India, and Russia. This attribute is recommended for Canada, India, Russia.</p>";
	}
	public static function required(){
		return "Y";
	}
}
?>