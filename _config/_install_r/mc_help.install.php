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

	public static function populate(){
		return "INSERT INTO `" . _DB_NAME_ ."`.`mc_help` VALUES (1,NULL,NULL,'selectMerchant','Selecting a Merchant','Whenever you see this box it means you are trying to use a function that requires an active merchant be set. Please select from your installed merchants from the provided dropdown list.','right',-66,-35,0,0),(2,NULL,NULL,'merchantFieldConfiguration','Configuring Feed Fields','<p>Each of the buttons grouped below represent an individual field in your feed. Select from one of the fields below to edit individual settings.</p><p> It is important to note that most fields have their own pre-set configuration and will work by simply activating them.</p><p>For further information about how each field operates see the individual field descriptions.</p> ','left',-43,0,0,215),(3,NULL,NULL,'merchantRules','Merchant Feed Rules','<p>Options found here include Exclusions, Value Overrides and Taxonomy (if available). Each of these functions provide options for changing your feed in many different ways.</p><ul><li>Exclusions:</li><ul><li>Instructs the feed to exclude individual products from your feed.</li></ul><li>Value Overrides</li><ul><li>Use this to override single field values on a per product basis.</li></ul><li>Taxonomy:</li><ul><li>This tool will help you map your own categories to those of the merchant center that you are working with.</li></ul></ul><p>Investigate each of the options for more information about their functionality</p><p><span class=\"help-note\">It should be noted that all but restoring defaults can be accessed via the merchant quick links toolbar.</span></p><img src=\"images/help/merchant_quick_links.jpg\">','left',-43,0,0,68),(4,NULL,NULL,'merchantFunctions','Merchant Feed Functions','<p>Feed functions are tools that you can use to maniulate the actual feed files.</p><ul><li>Create / Update Feed Values</li><li>Empty (Purge) Feed</li><li>Download a Copy of Your Feed</li><li>Restore Default Settings</li></ul><p><span class=\"help-note\">It should be noted that all but restoring defaults can be accessed via the merchant quick links toolbar.</span></p><img src=\"images/help/merchant_quick_links.jpg\">','left',-43,0,0,110);";
	}
	
}

?>