<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class functionCommand{
	public $type;
	public $singular;
	public $optionlist;
	public $custom_function;
	public $report_field_name;
	public $function_command;

	public function functionCommand($custom_function,$report_field_name,$function_command){
		$this->function_command = $function_command;
		$this->custom_function = $custom_function;
		$this->report_field_name = $report_field_name;

		if($custom_function == "mapToFeature") {
			//displaying the function command dialog for mapToFeature configured fields
			$this->type = "Feature";
			$this->singular = "a Feature";
			$this->optionList = availFeatures($this->function_command);
			echo self::displayFunctionCommand();
		}

		if($custom_function == "mapToAttribute") {
			//displaying the function command dialog for maptoAttribute configured fields
			$this->type = "Attribute";
			$this->singular = "an Attribute";
			$this->optionList = availAttributes($this->function_command);
			echo self::displayFunctionCommand();
		}

		if($custom_function == $report_field_name) {
			//displaying the function command information for the class
			$class = new $report_field_name;
			echo $class->functionCommand($this->function_command);
		}

	}
	
	public function displayFunctionCommand(){
		$a = array();
		if(is_null($this->function_command) || $this->function_command == ""){
   			$val = "<div class=\"col-sm-12 has-error\">
	   		<div class=\"alert-danger\">
				<div class=\"col-sm-4\">
					<label class=\"form-label\">You must select " . $this->singular . " :</label>
				</div>
			</div>";
		} else {
			$val = "<div class=\"col-sm-12 has-success\">
			<div class=\"col-sm-4\">
				<label class=\"form-label\">Selected " . $this->type . " :</label>
			</div>";
		}
		array_push($a,$val);
		
		$val = "<div class=\"col-sm-7 col-md-offset-1\">
					<select class=\"form-control\" name=\"function_command\" >
		   				<option value=\"NULL\" " . feedConfigSelected("NULL",$this->function_command) . ">NONE SELECTED</option>" . $this->optionList .  "
		   			</select>
				</div>
				<div class=\"clearfix\"></div>
			</div>
			<div class=\"clearfix spacer\"></div>";
		array_push($a,$val);
		return implode("",$a);
	}
}

?>