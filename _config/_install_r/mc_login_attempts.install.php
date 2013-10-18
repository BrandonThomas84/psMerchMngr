<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class mc_login_attempts extends tableInstall {

	public static function create(){
		return "
		CREATE TABLE " . _DB_NAME_ .".`mc_login_attempts` (
		  `user_id` int(11) NOT NULL,
		  `time` varchar(30) NOT NULL
		)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	}
}

?>