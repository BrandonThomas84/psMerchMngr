<?php /* FILEVERSION: v1.0.2b */ ?>
<?php

//instatntiating primary classes
$fieldData = new fieldConfig;
$class = new $fieldData->report_field_name;
$classname = $fieldData->report_field_name;

//instantiating lower classes
$fieldInformation = new fieldInformation;
$fieldExamples = new fieldExamples;
$productOverride = new productOverride;


//begin page contents
echo merchantHeader(ucfirst($fieldData->report_field_name) . " Field Settings");

echo "
	<div class=\"container well\">
	<div class=\"col-sm-12\">
		<form action=\"index.php?f=" . _MERCH_ . "&fieldID=" . $fieldData->id . "&act=update\" method=\"POST\" enctype=\"application/x-www-form-urlencoded\" name=\"" . $fieldData->report_field_name . "\" class=\"form\">
			<div class=\"col-sm-12 navbar-form\">
				<div class=\"col-sm-3 form-group\">
					<div class=\"onoffswitch\">
					    <input type=\"checkbox\" name=\"enabled\" class=\"onoffswitch-checkbox form-control btn\" id=\"myonoffswitch\" " . feedConfigChecked($fieldData->enabled) . ">
					    <label class=\"onoffswitch-label\" for=\"myonoffswitch\">
					        <div class=\"onoffswitch-inner\"></div>
					        <div class=\"onoffswitch-switch\"></div>
					    </label>
					</div>
				</div>
				<div class=\"col-sm-3 form-group\">
					<a href=\"index.php?f=" . _MERCH_ . "&fieldID=" . $fieldData->id . "&act=default\" class=\"btn btn-danger form-control\" title=\"Restore default settings for this field\" " . confirmMessage("Are you certain you would like to return the " . strtoupper($fieldData->report_field_name) . " field to its default settings?") . ">Restore Defaults</a>
				</div>
				<div class=\"col-sm-3 form-group\">
					<a href=\"index.php?f=" . _MERCH_ . "&fieldID=" . $fieldData->id . "\" class=\"btn btn-warning  form-control\">Discard Changes</a>
				</div>
				<div class=\"col-sm-3 form-group\">
					<input type=\"hidden\" name=\"id\" value=\"" . $fieldData->id  . "\">
					<input type=\"hidden\" name=\"f\" value=\"" . _MERCH_  . "\">
					<input type=\"submit\" class=\"btn btn-success form-control\" value=\"Save Changes\">
				</div>
				<br>
			</div>
			<div class=\"clearfix spacer\"></div>
			<div class=\"col-sm-12 has-success\">
				<div class=\"col-sm-4\">
					<label class=\"form-label\">Field Function: </label>
				</div>
				<div class=\"col-sm-7 col-sm-offset-1\">
					<select class=\"form-control\" name=\"custom_function\">
						<option value=\"mapToFeature\" " . feedConfigSelected("mapToFeature",$fieldData->custom_function) . ">Map to a Feature</option>
						<option value=\"mapToAttribute\" " . feedConfigSelected("mapToAttribute",$fieldData->custom_function) . ">Map to an Attribute</option>";
			        	availableCustomFunctions($fieldData->custom_function);
			       		echo "
			       	</select>
			    </div>
			    <div class=\"clearfix\"></div>
			</div>
			<div class=\"clearfix spacer\"></div>";
	   		
			//display function command types
			$functionCommand = new functionCommand($fieldData->custom_function,$fieldData->report_field_name,$fieldData->function_command);
			
							    	
	    	//map to database field
	    	echo "
			<div class=\"col-sm-12\">
				<div class=\"col-sm-4\">
					<label class=\"form-label\">Static Value</label>
				</div>
				<div class=\"col-sm-7 col-sm-offset-1 ";
				if(!is_null($fieldData->static_value)){echo "has-success";}
				echo "\">
					<input type=\"text\" style=\"text-align: left;\" class=\"form-control\" name=\"static_value\" value=\"" . $fieldData->static_value . "\">
			    </div>
			    <div class=\"clearfix\"></div>
			</div>
			<div class=\"clearfix spacer\"></div>
			<div class=\"col-sm-12\">
				<div class=\"col-sm-4\">
					<label class=\"form-label\">Map to Database Field</label>
				</div>
				<div class=\"col-sm-7 col-sm-offset-1\">";
				if(is_null($fieldData->table_name)){
					echo "<a href=\"index.php?f=" . _MERCH_ . "&p=dtbs&fieldID=" . $fieldData->id . "\" title=\"Click to view Available Fields\" class=\"form-control btn btn-default\">Select Database Field</a>";
				} else {
					echo "
					<div class=\"col-sm-5\">
						<input type=\"text\" class=\"form-control\" name=\"mappedValue\" disabled value=\"" . $fieldData->table_name_Friendly . "." . $fieldData->database_field_name . "\">
					</div>
					<div class=\"col-sm-3 col-sm-offset-1\">
						<a href=\"index.php?f=" . _MERCH_ . "&p=dtbs&fieldID=" . $fieldData->id . "\" title=\"Click to view available dynamic fields\" class=\"form-control btn btn-warning\">Edit</a>
					</div>
					<div class=\"col-sm-3\">
						<a href=\"index.php?f=" . _MERCH_ . "&fieldID=" . $_GET["fieldID"] . "&act=drp\" title=\"Click to remove relationship\" class=\"form-control btn btn-danger\">Remove</a>
					</div>
					<div class=\"clearfix\"></div>";
				}
				echo "
			    </div>
			    <div class=\"clearfix\"></div>
			</div>
			<div class=\"clearfix spacer\"></div>
		</form>
	</div>";

	echo "
	<div class=\"col-md-12 panel-body\">
		<div class=\"panel-group\" id=\"accordion\">
			<div class=\"panel panel-dark\">
				<div class=\"panel-heading\">
					<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseFieldInfo\"><div class=\"panel-title\">Field Information</div></a>
		    	</div>
		    	<div id=\"collapseFieldInfo\" class=\"panel-collapse collapse panel-body field-information\">";
		    	echo "<h3>Current Functionality</h3>" . $fieldInformation->configDescription($fieldData->custom_function,$fieldData->report_field_name);

		    	echo $fieldInformation->health();

					if($classname == "description"){
						echo $class->descriptionFix();
					} else {
						echo $class->description();
					}
				
	echo "		</div>
			</div>
		</div>
	</div>";

	//start override
	$productOverride->fieldConfigDisplay();

	//start examples
	$fieldExamples->fieldExampleDisplay($fieldData->report_field_name);



echo "
</div>
";

?>
