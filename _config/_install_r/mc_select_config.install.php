<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class mc_select_config extends tableInstall {

	public static function create(){
		return "
		CREATE TABLE `" . _DB_NAME_ ."`.`mc_select_config` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `merchant_id` varchar(100) NOT NULL,
		  `report_field_name` varchar(100) NOT NULL,
		  `custom_function` varchar(255) DEFAULT NULL,
		  `function_command` varchar(255) DEFAULT NULL,
		  `static_value` varchar(255) DEFAULT NULL,
		  `table_name` varchar(255) DEFAULT NULL,
		  `database_field_name` varchar(255) DEFAULT NULL,
		  `notes` blob,
		  `enabled` bit(1) DEFAULT b'0',
		  `order` int(11) DEFAULT NULL,
		  PRIMARY KEY (`merchant_id`,`report_field_name`),
		  UNIQUE KEY `id_UNIQUE` (`id`)
		)ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	}

	public static function populate(){
		$a = array();
		$val1 = "
		INSERT INTO `" . _DB_NAME_ . "`.`mc_select_config` 
			(`merchant_id`,`report_field_name`,`static_value`,`custom_function`,`function_command`,`enabled`,`order`) 
		VALUES ";
		
		array_push($a,$val1);
		foreach(callAllMerchantClassDefaults("google") AS $fieldrow){
			array_push($a, $fieldrow . ",");
		}
		
		return substr(implode("",$a),0,(strlen(implode("",$a))-1));
	}
}

?>