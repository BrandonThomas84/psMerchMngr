<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class image_link extends imageLink{ 
	
	public static $alias = __CLASS__;

	public static function defaultValues(){
		//`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`
		return "('google','image_link',NULL,'image_link',NULL,1,7)";
	}
	public static function description(){
		return "This is the URL of an associated image for a product.\n\nIf you have multiple different images of the item, submit the main image using this attribute, and include all other images in the \'additional image link\' attribute.\n\nImage size:\n\n    Submit the largest, full-size image you have for the product, up to 4MB file size.\n    We recommend images at least 800 pixels in height and width.\n    Do not scale up images or submit thumbnails.\n    For apparel products we require images of at least 250 x 250 pixels.";
	}
	public static function required(){
		return "Y";
	}
}
?>