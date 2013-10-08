<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

//select product category or taxonomy if defined
class productCategory extends feedFunction{
    public static function selectNoAlias(){
        return "`E`.`category_string`";
    }
    public static function includeTables(){
		$a = array("E","");
		return $a;
	}
}

?>