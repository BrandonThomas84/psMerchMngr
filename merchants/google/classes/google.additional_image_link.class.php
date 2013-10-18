<?php /* FILEVERSION: v1.0.2b */ ?>
<?php
class additional_image_link extends feedFunction{ 
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){

		$max = 10;
		$a = array();

		//adding the opening values to the array
		array_push($a,"concat(");

		for($i=0;$i<$max;$i++){
			//adding the coalesce select for each image to the select
			$img_row = "COALESCE(concat('http://" . $_SERVER["SERVER_NAME"] . "',`img" . ($i+2) . "`.`img`),''),CASE WHEN COALESCE(`img" . ($i+3) . "`.`img`,'') = '' THEN '' ELSE ', ' END";

			//comma used to separate each of the coalesces in the concat
			$comma = ",";

			//adding the select row to the return array
			array_push($a,$img_row);

			//checking if this is the last row
			if($i <= ($max-2)) {
				array_push($a,$comma);
			}
		}

		//adding closing parentheses to the array
		array_push($a,")");

		$a = implode("",$a);

		return $a;
	}
	public static function includeTables(){
		$a = array();
		
		//max nuber of additional images that are supported 
		for($i=0; $i<=11; $i++){
			array_push($a,array("Imgs",($i+1)));
		}

		//return array containing all tables
		return $a;
	}
	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','additional_image_link',NULL,'additional_image_link',NULL,0,8)";
	}
	public static function description(){
		return "<p>If you have additional images for this item, include them in this attribute. For example, if you have images that show the product from a different angle than the main image, or if you have images of the packaging or the product in various settings.</p><p>You can include up to 10 additional images per item by including the attribute multiple times. For tab-delimited, separate each URL by a comma.</p><p>When to include: For all items with multiple images.</p>";
	}
	public static function configDescription(){
        return "<p>The additional_image field default configuration is to check for up to 10 additional images. Each will be inserted into this field and separated by commas for submissions to Google.</p>";
    }
}
?>