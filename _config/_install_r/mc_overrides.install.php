<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class mc_overrides extends tableInstall {

	public static function create(){
		return "CREATE TABLE `" . _DB_NAME_ . "`.`mc_overrides` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `merchant_id` varchar(100) NOT NULL,
		  `id_product` int(10) NOT NULL,
		  `override_type` varchar(255) NOT NULL,
		  `override_value` varchar(255) DEFAULT NULL,
		  PRIMARY KEY (`merchant_id`,`id_product`,`override_type`),
		  UNIQUE KEY `id_UNIQUE` (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;";
	}
}

?>