<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class mc_members extends tableInstall {

	public static function create(){
		return "
		CREATE TABLE `" . _DB_NAME_ ."`.`mc_members` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `username` varchar(30) NOT NULL,
		  `email` varchar(50) NOT NULL,
		  `password` char(128) NOT NULL,
		  `salt` char(128) NOT NULL,
		  `perm_level` VARCHAR(45) NOT NULL,
		  PRIMARY KEY (`id`)
		)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	}
}

?>