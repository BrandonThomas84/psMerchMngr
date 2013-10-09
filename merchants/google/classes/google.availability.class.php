<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class availability extends feedFunction {
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		$instock = 'in stock';
		$outstock = 'out of stock';
		
		return "(case when (`A`.`quantity` > 0) then '" . $instock . "' when ((`A`.`quantity` = 0) or isnull(`A`.`quantity`)) then '" . $outstock . "' else '" . $outstock . "' end)"; 
		
	}
	public static function includeTables(){
		$a = array("A","");
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','availability',NULL,'availability',NULL,1,10)";
	}
	public static function description(){
		return "<p>The availability attribute only has four accepted values:<ul><li>in stock</li><ul><li>Include this value if you are certain that it will ship (or be in-transit to the customer) in 3 business days or less. For example, if you have the item available in your warehouse.</li></ul><li>available for order</li><ul><li>Include this value if it will take 4 or more business days to ship it to the customer. For example, if you don't have it in your warehouse at the moment, but are sure that it will arrive in the next few days.</li></ul><li>preorder</li><ul><li>You are taking orders for this product, but it's not yet been released.</li></ul><li>out of stock</li><ul><li>You're currently not accepting orders for this product.</li><li><span class=\"help-block\"><span>Important Tip:</span> When your products are out of stock on your website, don't remove them from your data feed. Provide this value instead.</span></li></ul></ul></p><p>When to include: Required for all items.</p>";
	}
	public static function required(){
		return "Y";
	}
}
?>