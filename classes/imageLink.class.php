<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

//creates a link to the primary image (full size)
class imageLink extends feedFunction{
	public static function selectNoAlias(){
		return "concat('http://" . $_SERVER["SERVER_NAME"] . "',`img1`.`img`)";
	}
    public static function includeTables(){
		$a = array("Imgs",1);
		return $a;
	}
}

?>