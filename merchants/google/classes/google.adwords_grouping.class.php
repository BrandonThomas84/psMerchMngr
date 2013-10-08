<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class adwords_grouping extends feedFunction{ 
	
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
		return "('google','adwords_grouping','AWATING VALUE','adwords_grouping',NULL,0,28)";
	}
	public static function description(){
		return "Used to group products in an arbitrary way. It can be used for Product Filters to limit a campaign to a group of products, or Product Targets to bid differently for a group of products. This is a required field if the advertiser wants to bid differently to different subsets of products in the CPC or CPA % version. It can only hold one value.";
	}
}
?>