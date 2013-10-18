<?php /* FILEVERSION: v1.0.2b */ ?>
<?php

class help {

	public static function createButton($element){
		if(isset($_COOKIE["help"])){
			$sql = "SELECT  `float`, `position_t`, `position_r`, `position_b`, `position_l` FROM `" . _DB_NAME_ . "`.`mc_help` WHERE `element` = '" . $element . "'";
			$query = mysql_query($sql);
			$row = mysql_fetch_array($query);

			$float = "float: " . $row["float"] . ";";
			$top = "top: " . $row["position_t"] . "px;";
			$right = "right: " . $row["position_r"] . "px;";
			$bottom = "bottom: " . $row["position_b"] . "px;";
			$left = "left: " . $row["position_l"] . "px;";

			$style = "style=\"" . $float . $top . $right . $bottom . $left . "\"";

			return "<a href=\"#" . $element . "HelpModal\" class=\"help-button\" role=\"button\" data-toggle=\"modal\" " . $style . ">?</a>";
		}
	}

	public function helpModals(){
		if(isset($_COOKIE["help"])){
			//return array
			$a = array();

			$sql = "SELECT  `element`, `title`, `body` FROM `" . _DB_NAME_ . "`.`mc_help`";
			$query = mysql_query($sql);


			//printing a new script for each element that has help information
			while($row = mysql_fetch_array($query)){
				$value = "
					<div id=\"" . $row["element"] . "HelpModal\" class=\"modal hide fade help-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"" . $row["element"] . "HelpModalLabel\" aria-hidden=\"true\">
					  <div class=\"modal-header help-modal-head\">
					    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
					    <p id=\"" . $row["element"] . "HelpModalLabel\" class=\"help-title\">" . $row["title"] . "</p>
					  </div>
					  <div class=\"help-modal-body modal-body\">
					  	" . $row["body"] . "
					  </div>
					  <div class=\"help-modal-footer modal-footer\">
					  </div>
					  <div class=\"clearfix\"></div>
					</div>";

				array_push($a,$value);
			}

			return implode("",$a);
		}
	}
}
?>