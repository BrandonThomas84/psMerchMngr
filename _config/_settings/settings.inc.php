<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class settings {

	public $tfSettings;
	public $currentDateSettings;
	public $dateTimeSettings;

	public function buildObjectVariables(){
		$this->tfSettings = array("Debug");
		$this->currentDateSettings = array("SettingsLastModified");
		$this->dateTimeSettings = array("ApplicationCreationDate","LastApplicationUpdate","PreviousLogin");
	}

	public function coreSubmissionUpdate(){

		//concstructing object variables
		$this->buildObjectVariables();

		//check or submissions mathcing any set sN cookies
		foreach($this->getCookieNames() AS $cookie){

			//update the cookie with the new posted value
			$value = $this->formatValue($cookie,"get");

			//update settings cookies
			$this->updateCookies($cookie,$value);
		}

		//if default trigger is set then apply changes to csv file
		$this->saveSettings();

	}
	public function getCookieNames(){

		//getting the cookie names from the sN cookie value
		$settings = explode(chr(59),$_COOKIE["sN"]);

		return $settings;
	}
	public function formatValue($name,$val){
		//checking to see if value was specificed
		if($val == "get"){
			if(isset($_POST[$name])){

				$value = $_POST[$name];

				//if setting value needs date processing
				if(in_array($name,$this->dateTimeSettings)){

					//setting value to cookie value
					$time = strtotime($value);
					
					//acceptable format for writing
					$value = date("d-M-y H:i:s T",$time);

				} elseif(in_array($name,$this->currentDateSettings)){

					//setting value to current time
					$value = date("d-M-y H:i:s T",time());

				}
			} else {
				$value = "off";
			}
		} else {	
			$value = $val;
		}
		
		//return the formatted value
		return $value;
	}
	public function updateCookies($name,$value){
		//setting cookie value
		setcookie($name,$value,0);
	}
	public function getCookieValues(){

		$settings = $this->getCookieNames();

		$settingsArray = array();

		for($i = 0; $i < count($settings); $i++){
			//setting name
			$name = $settings[$i];

			//pushing name to array
			array_push($settingsArray,$name);

			//presetting cookie value
			$value = $_COOKIE[$settings[$i]];

			//run value through date formatting
			$value = $this->formatValue($name,$value);

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

	  			//checking if even array element
				if (($i == 0) || ($i % 2 == 0)) {

					//setting the cookie name
					$name = $settings[$i];
					
					//advancing to next array item (value)
					$i++;

					//format value
					$value = $this->formatValue($name,$settings[$i]);

					//setting cookie value
					$this->updateCookies($name,$value);

					//pushing setting name to array
					array_push($settingNames,$name);

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
		$settings = $this->getCookieNames();

		//releasing all cookies
		foreach($settings AS $setting){
			setcookie($setting,0,time()-1000);
		}

		//releasing cookie name cookie
		setcookie("sN",0,time()-1000);
	}
	public function saveSettings(){

		$settingsArray = $this->getCookieValues();

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
	public function showSettings(){
		$settings = explode(chr(59),$_COOKIE["sN"]);

		foreach ($settings as $setting) {
			echo "<p><strong>" . $setting . ":</strong> " . $_COOKIE[$setting] . "</p>";
		}
	}
	public function controlPanelDisplay(){
		//fields that should be disabled
		$disabledFields = array("SettingsLastModified","ApplicationCreationDate","LastApplicationUpdate","LastUserLogin","ApplicationVersion");

		$a = array();

		$settings = $this->getCookieNames();

		foreach($settings AS $setting){

			$cookieValue = $_COOKIE[$setting];

			//setting diasbled form element variable 
			if(in_array($setting,$disabledFields)){
				$disable = " disabled ";
			} else {
				$disable = "";
			}

			//checking status of setting

			if($cookieValue == 'on'){
				$checkedon = " checked ";
				$checkedoff = "";
			} else {
				$checkedon = "";
				$checkedoff = " checked ";
			}

			//checking input type

			if(in_array($setting,$this->tfSettings)){
				$input = "
				<input type=\"radio\" ". $checkedon . " name=\"" . $setting . "\" value=\"on\">ON <br/>
				<input type=\"radio\" ". $checkedoff . " name=\"" . $setting . "\" value=\"off\">OFF";
			} else {
				$input = "<input type=\"hidden\" name=\"" . $setting . "\" value=\"" . $_COOKIE[$setting] . "\"><input type=\"text\" class=\"form-control\"" . $disable . " name=\"" . $setting . "visible\" value=\"" . $_COOKIE[$setting] . "\">";
			}
			

			//fixing the spacing on the cookie names
			$spaced = trim(preg_replace('/([A-Z])/', ' $1', $setting));

			$v = "
			<div class=\"col-md-12 panel-body\">
				<div class=\"col-md-6\">
					<label class=\"form-label\" for=\"" . $setting . "\">" . $spaced . "</label>
				<div class=\"help-block\">
					<span>Warning: This will log out your session</span>
				</div>
				</div>
				<div class=\"col-md-6\">"
					. $input . "
				</div>
			</div>";

			array_push($a,$v);
		}

		//finishing off form and adding submit to array
		$submitButton = "
		<div class=\"col-md-12 panel-body\">
			<div class=\"col-md-6 col-md-offset-3\">
				<input type=\"hidden\" name=\"updateCore\" value=\"true\">
				<input type=\"submit\" value=\"Update Settings\" class=\"form-control btn btn-success\">
			</div>
			<div class=\"clearfix\"></div><br>
			<div class=\"col-md-6 col-md-offset-3 alert-warning alert\">
				<span class=\"alert-body\">Warning: This will log out your session</span>
			</div>
		</div>
		<div class=\"clearfix\"></div>
		<br>";

		array_push($a,$submitButton);
		
		return implode("",$a);
	}
}

?>