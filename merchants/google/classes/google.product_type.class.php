<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class product_type extends productCategory{ 
	
	public static $alias = __CLASS__;

	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','product_type',NULL,'product_type',NULL,0,5)";
	}
	public static function description(){
		return "
		<h3>" . _MERCHANT_  . " Describes " . ucfirst(__CLASS__) . "</h3>
		<p>This attribute also indicates the category of the product being submitted, but you can provide your own classification. Unlike the \'Google product category\', you can include more than one \'product type\' attribute value if products apply to more than one category. Please include the full category string. For example, if your products belong in Refrigerators list the full string: Home & Garden > Kitchen & Dining > Kitchen Appliances > Refrigerators. Any separator such as > or / may be used.</p><p>When to include: Strongly recommended for all items if you have a categorization for your items.</p>";
	}
	public static function configDescription(){
		return "
		<p>The \"product_type\" default setting will identify active categories that your PrestaShop products are linked to. The value that is returned is equivalent to the breadcrumb value.</p><p>By default the category with the most number of hierarchy levels will be selected. If there is more than one location with the same number of levels the choice is made alphabetically.</p>
		<div class=\"field-info-messages\">
			<p class=\"alert alert-info\"><strong>NOTE: </strong> You can override these values.</p>
		</div>";
	}
}
?>