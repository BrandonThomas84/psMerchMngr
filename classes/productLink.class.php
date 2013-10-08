<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

//creates a link to the product page
class productLink extends feedFunction{
    public static function selectNoAlias(){
        return "concat('http://" . $_SERVER["SERVER_NAME"] . "/', `D`.`link_rewrite`, '/', `A`.`id_product`, '-', replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace(`C`.`name`, '-', ''), '#', ''), '$', ''), '%', ''), '&', ''), '(', ''), ')', ''), '*', ''), ',', ''), '.', ''), '/', ''), ':', ''), ';', ''), '?', ''), '@', ''), '[', ''), ']', ''), '_', ''), '`', ''), '{', ''), '|', ''), '}', ''), '~', ''), '‘', ''), '‹', ''), '›', ''), '‾', ''), '+', ''), '<', ''), '=', ''), '>', ''), '↑', ''), '†', ''), '‡', ''), '‰', ''), '™', ''), '" . chr(92) .  "'', ''), '\"', ''), ' ', '-'), '---', '-'), '--', '-'), '.html')";
    }
    public static function includeTables(){
		$a = array("D","");
		return $a;
	}
}

?>