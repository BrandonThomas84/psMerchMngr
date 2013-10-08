<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class messageReporting {
	public static function insertMessage($type,$message){		
		echo "<div class=\"alert has-" . $type . " page-messages col-md-12\"><a class=\"close\" data-dismiss=\"alert\" href=\"#\" aria-hidden=\"true\">X</a><p class=\"form-control\">" . $message . "</p></div>";	
	}
}

?>