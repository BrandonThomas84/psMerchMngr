<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class mc_help extends tableInstall {

	public static function create(){
		return "
		CREATE TABLE `" . _DB_NAME_ ."`.`mc_help` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `page` varchar(150) DEFAULT NULL,
		  `type` varchar(45) DEFAULT NULL,
		  `element` varchar(45) NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `body` blob NOT NULL,
		  `float` varchar(45) DEFAULT NULL,
		  `position_t` int(11) DEFAULT NULL,
		  `position_r` int(11) DEFAULT NULL,
		  `position_b` int(11) DEFAULT NULL,
		  `position_l` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;";
	}

	/*
	public static function populate(){
		return "
			INSERT INTO `" . _DB_NAME_ ."`.`mc_help` 
			(`page`,`type`,`element`,`title`,`body`,`float`,`position_t`,`position_r`,`position_b`,`position_l`) 
			VALUES 
			(NULL,NULL,'','','',NULL,NULL,NULL),";
	}
	*/
}

?>