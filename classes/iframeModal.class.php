<?php

class iframeModal {
	public function iframeModal($name){
		echo "
		<div id=\"" . $name . "Modal\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"" . $name . "ModalLabel\" aria-hidden=\"true\">
		  <div class=\"modal-header\">
		    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
		    <h3 id=\"" . $name . "ModalLabel\">Update Check</h3>
		  </div>
		  <div class=\"modal-body\">
			  <iframe class=\"" . $name . "-iframe\" name=\"" . $name . "-iframe\" src=\"iframe.php\"></iframe>
		  </div>
		  <div class=\"clearfix\"></div>
		</div>";
	}	
}
?>