<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class mc_cattax_mapping extends tableInstall {

	public static function create(){
		return "
		CREATE TABLE `" . _DB_NAME_ ."`.`mc_cattax_mapping` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `category_string` varchar(255) NOT NULL,
		  `cattax_id` int(11) DEFAULT NULL,
		  `cattax_merchant_id` varchar(50) NOT NULL,
		  PRIMARY KEY (`id`,`category_string`,`cattax_merchant_id`),
		  UNIQUE KEY `idmc_cattax_conversion_UNIQUE` (`id`)
		)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	}
}

?>