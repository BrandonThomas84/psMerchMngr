<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class mc_exclusion extends tableInstall {

	public static function create(){
		return "
		CREATE TABLE `" . _DB_NAME_ ."`.`mc_exclusion` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `id_product` int(10) NOT NULL,
		  `exclusion` varchar(100) NOT NULL,
		  PRIMARY KEY (`id`,`id_product`,`exclusion`),
		  UNIQUE KEY `id_UNIQUE` (`id`)
		)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	}
}

?>