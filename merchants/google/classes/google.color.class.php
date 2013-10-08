<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class color extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`AWATING VALUE`"; 
	}
	public static function includeTables(){
		$a = array("","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','color','AWATING VALUE','color',NULL,0,20)";
	}
	public static function description(){
		return "This defines the dominant color(s) for an item. When a single item has multiple colors, you can submit up to two additional values as accent colors:\n\n    Combine the colors with ‘/\' in order of prominence (dominant color first, then at most two accent colors). For example, a black shoe with green accents should have a color value of \'Black / Green\'. In the case of non-deformable goods in Apparel like jewelry or wooden accessories where finishes or materials are equivalent to color, the finish or material name can be submitted in the color attribute (e.g., \'Mahogany\' vs. \'Stainless Steel\' vs. \'Rose Gold\').\n    Limit the number of colors submitted to three values.\n    If you\'re using XML, you must represent the \'/\' with &#47;\n\nWhen to include: Required for all apparel items in feeds that target the US, UK, DE, FR, and JP. Recommended for other countries and product categories (might become required in the future).";
	}
}
?>