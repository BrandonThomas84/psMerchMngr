<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

//maps an attribute group value to a field
class mapToAttribute extends feedFunction {

    public static function selectNoAlias($fieldName){
        return "`" . $fieldName . "` . `" . $fieldName . "`";
    }
    public static function includeTables(){
		$a = array("A","");
		return $a;
	}
}

?>