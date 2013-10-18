<?php /* FILEVERSION: v1.0.2b */ ?>
<?php
class selectMerchantDisplay{

	public function showIt() {
		$return = array();
		
		array_push($return,"
			<form action=\"index.php\" method=\"get\" name=\"selectMerch\">
				<div class=\"col-lg-6\">
					<select class=\"form-control\" name=\"f\">");

		foreach(installedMerchants() AS $v){
			array_push($return,"<option value=\"" . merchantToMerch($v) . "\">" . merchantFriendly(merchantToMerch($v)) . "</option>");
		}
	
		array_push($return,"
				</select>
			</div>
			<div class=\"col-lg-6\">
				<input name=\"p\" value=\"" . $_GET["p"] . "\" type=\"hidden\">
				<input class=\"form-control btn btn-default\" type=\"submit\" value=\"Select Merchant\">
			</div>
		</form>");

		array_push($return, help::createButton("selectMerchant"));

		return implode("",$return);
	}
}

?>