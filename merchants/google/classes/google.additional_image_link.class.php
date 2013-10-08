<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class additional_image_link extends feedFunction{ 
	
	public static $alias = __CLASS__;
	
	public static function selectNoAlias(){
	return "concat('http://" . $_SERVER["SERVER_NAME"] . "',`img2`.`img`)";
	}
	public static function includeTables(){
		$a = array("Imgs",2);
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
        return "<p>The additional_image field default configuration is to check for a single additional image. If you have more than one additional image that you would like to include please see our help information.</p>";
    }
    /* commenting out the select number of additional images code because the configure selected is not working
    public function functionCommand($function_command){

    	if(is_null($function_command) || $function_command = ""){
   			echo "<div class=\"col-sm-12 has-error\">
	   		<div class=\"alert-danger\">
				<div class=\"col-sm-4\">
					<label class=\"form-label\">You must select a number of additional images to Include :</label>
				</div>
			</div>";
		} else {
			echo"<div class=\"col-sm-12 has-success\">
			<div class=\"col-sm-4\">
				<label class=\"form-label\">Number of Additional Images to Include :</label>
			</div>";
		}
				
		echo "<div class=\"col-sm-7 col-md-offset-1\">
				<select class=\"form-control\" name=\"function_command\" >
	   				<option value=\"NULL\">NONE SELECTED</option>
	   				<option value=\"1\" " . feedConfigSelected(1,$function_command) . ">1</option>
	   				<option value=\"2\" " . feedConfigSelected(2,$function_command) . ">2</option>
	   				<option value=\"3\" " . feedConfigSelected(3,$function_command) . ">3</option>
	   				<option value=\"4\" " . feedConfigSelected(4,$function_command) . ">4</option>
	   				<option value=\"5\" " . feedConfigSelected(5,$function_command) . ">5</option>
	   				<option value=\"6\" " . feedConfigSelected(6,$function_command) . ">6</option>
	   				<option value=\"7\" " . feedConfigSelected(7,$function_command) . ">7</option>
	   				<option value=\"8\" " . feedConfigSelected(8,$function_command) . ">8</option>
	   			</select>
			</div>
			<div class=\"clearfix\"></div>
		</div>
		<div class=\"clearfix spacer\"></div>";
	}*/
}
?>