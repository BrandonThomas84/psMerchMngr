<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class settings {

	public function settings(){
		self::getSettings();
	}
	public function checkSubmission(){

		//setting default trigger for checking if submission has been set
		$set = false;

		//check or submissions mathcing any set sN cookies
		foreach(self::getCookieNames() AS $cookie){

			if(isset($_POST[$cookie])){

				//update the cookie with the new posted value
				self::updateCookies($cookie,$_POST[$cookie]);

				//set the default trigger to true so the update runs on the csv file
				$set = true;
			}
		}

		//checking if default trigger is set
		if($set == true){

			//if default trigger is set then apply changes to csv file
			self::saveSettings();
		}

	}
	public function getCookieNames(){

		$settings = explode(chr(59),$_COOKIE["sN"]);

		return $settings;
	}
	public function getCookieValues(){

		$settings = self::getCookieNames();

		$settingsArray = array();

		for($i = 0; $i < count($settings); $i++){
			//setting name
			$name = $settings[$i];

			//pushing name to array
			array_push($settingsArray,$name);

			//presetting cookie value
			$value = $_COOKIE[$settings[$i]];

			//run value through date formatting
			$value = self::formatDateSettings($name,$value);

			//pushing value to array
			array_push($settingsArray,$value);			
		}

		return $settingsArray;
	}
	public function addNewCookieMap($name){
		
		$presVal = explode(chr(59),$_COOKIE["sN"]);
		
		$value = $_POST[$name];

		if(!in_array($name,$presVal)){
			array_push($presVal,$name);
			$newSN = implode(chr(59),$presVal);
			setcookie("sN",$newSN);
		}
	}
	public function getSettings(){
		//settings file
		$file = "_config/_settings/settings.inc.txt";

		//open settings file for reading
		$file = fopen($file,"r");

		if(!$file){
			//return an error if the file fails to open
			messageReporting::insertMessage("error","There was an error locating your settings file.");

		} else {
			//getting csv data
			$settings = fgetcsv($file,1000,chr(44));

			//count of number of pieces of data
			$items = count($settings);
	  		
	  		//settings and values array
	  		$settingsArray = array();

	  		//names of the settings cookies
	  		$settingNames = array();

	  		$i=0;

	  		while($i < $items) {

				if (($i == 0) || ($i % 2 == 0)) {

					$colName = $settings[$i];
					
					$i++;
					
					$value = $settings[$i];

					//if cookie is version then do not run time processing 
					if($colName !== "ApplicationVersion"){
						$value = self::formatDateSettings($colName,$value);
					}

					//setting cookie value
					setcookie($colName,$value);

					//pushing setting name to array
					array_push($settingNames,$colName);

					$i++;
				} 
			}

			//setting a cookie with all the settings names
			$settingNames = implode(chr(59),$settingNames);
			setcookie("sN",$settingNames);
		}
	}
	public function releaseSettings(){

		//gathering names of all the cookies
		$settings = self::getCookieNames();

		//releasing all cookies
		foreach($settings AS $setting){
			setcookie($setting,0,time()-1000);
		}

		//releasing cookie name cookie
		setcookie("sN",0,time()-1000);
	}
	public function saveSettings(){

		$settingsArray = self::getCookieValues();

		//settings file
		$file = "_config/_settings/settings.inc.txt";

		//open settings file for writing
		$file = fopen($file,"w+");

		if(!$file){
			//return an error if the file fails to open
			messageReporting::insertMessage("error","There was an error locating your settings file.");

		} else {

			//writing the updated values to the file
			fputcsv($file,$settingsArray);
			//closing file
			fclose($file);
		}
	}
	public function updateCookies($name,$value){

			//checking if cookie is last modified
			if($name == "SettingsLastModified"){

				//if so setting value to current timestamp
				$value = date("d-M-y H:i:s T",time());
			} 

			//setting cookie value
			setcookie($name,$value,0);
	}
	public function showSettings(){
		$settings = explode(chr(59),$_COOKIE["sN"]);

		foreach ($settings as $setting) {
			echo "<p><strong>" . $setting . ":</strong> " . $_COOKIE[$setting] . "</p>";
		}
	}
	public function formatDateSettings($name,$value){
		
		//presetting return value
		$value = $value;

		//cookies that will require formatting
		$dateFormatting = array("SettingsLastModified","ApplicationCreationDate","LastApplicationUpdate","PreviousLogin");

		//if cookie is version then do not run time processing 
		if(in_array($name,$dateFormatting)){
			//setting value to cookie value
			$time = strtotime($value);
			
			//acceptable format for writing
			$value = date("d-M-y H:i:s T",$time);
		}
		
		return $value;
	}
	public function controlPanelDisplay(){
		//fields that should be disabled
		$disabledFields = array("SettingsLastModified","ApplicationCreationDate","LastApplicationUpdate","LastUserLogin","ApplicationVersion");

		$a = array();

		$settings = self::getCookieNames();

		foreach($settings AS $setting){

			//setting diasbled form element variable 
			if(in_array($setting,$disabledFields)){
				$disable = " disabled ";
			} else {
				$disable = "";
			}

			//fixing the spacing on the cookie names
			$spaced = trim(preg_replace('/([A-Z])/', ' $1', $setting));

			$v = "
			<div class=\"col-md-12 panel-body\">
				<div class=\"col-md-6\">
					<label class=\"form-label\" for=\"" . $setting . "\">" . $spaced . "</label>
					<div class=\"help-block\"><span>Suggestion</span></div>
				</div>
				<div class=\"col-md-6\">
					<input type=\"text\" class=\"form-control\" " . $disable . " name=\"" . $setting . "\" value=\"" . $_COOKIE[$setting] . "\">
				</div>
			</div>";

			array_push($a,$v);
		}
		
		return implode("",$a);
	}
}

?>