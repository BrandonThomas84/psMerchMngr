<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class adult extends feedFunction { 
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
		return "`" . __CLASS__. "`.`" . __CLASS__. "`";
    }
    public static function includeTables(){
		$a = array("Feat",__CLASS__);
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','adult',NULL,'adult',NULL,0,27)";
	}
	public static function description(){
		return "The adult status assigned to your product listings through the ‘adult\' attribute affects where product listings can show. For example, \"\"adult\"\" or \"\"non-family safe\"\" product listings aren\'t allowed to be shown in certain countries or to a certain audience.\r\n\r\nIf your website generally targets an adult audience and contains adult-oriented content with or without nudity, sexually explicit content or language, you are responsible for labeling your site as intended for an adult audience by ticking the checkbox “This site contains ‘non-family safe\' or adult products as defined by our policy” in the “General settings” section of the Merchant Center account. Where you fail to do so, Merchant Center accounts containing product listings considered as “non-family safe” will be suspended.\r\n\r\nIf your website doesn\'t generally target an adult audience but you are promoting some product listings containing adult oriented content with or without nudity, sexually explicit content or language, such product listings should be submitted with an ‘adult\' attribute value set to TRUE. This will indicate that the correlating product listing contains “adult” or “non-family-safe” content as defined by our policy. Where you fail to do so, your account will be considered as “adult” or “non-family-safe” and disapproved and your items will not appear on Google Shopping.\r\n\r\nWhen to include: If you are submitting items that are considered “adult” or non-family safe and would like to label them at the item level for all target countries.";
	}
}
?>