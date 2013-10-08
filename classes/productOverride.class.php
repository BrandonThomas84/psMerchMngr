<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class productOverride{
	//field properties
	public $merchant_id;
	public $merch;
	public $merchant;
	public $fieldID;
	public $fieldName;
	public $id_product;
	public $override_value;

	// form properties
	public $url;
	public $viewMethod;

	//pagination properties
	public $perPage;
	public $pageNumber;
	public $overrideCount;
	public $limitStart;
	public $limitRun;

	public function productOverride(){
		//checking for value updates
		self::checkForSubmission();

		//setting starting point for url
		$this->url = "index.php";

		//setting the merchant properties if user has one selected
		if(isset($_GET["f"])){
			$this->merch = _MERCH_;
			$this->merchant_id = _MERCHANTID_;
			$this->merchant = _MERCHANT_;

			//setting first instance of url property
			$this->url = $this->url . "?f=" . $this->merch;
		}

		//checking if user is on one of the field config pages
		if(isset($_GET["fieldID"])){
			//setting fieldID property
			$this->fieldID = $_GET["fieldID"];
			
			//setting fieldName property
			$sql = "SELECT DISTINCT `report_field_name` FROM `" . _DB_NAME_ . "`.`mc_select_config` WHERE id = " . $this->fieldID;
			$query = mysql_query($sql);
			$row = mysql_fetch_array($query);
			$this->fieldName = $row["report_field_name"];

			//setting url property
			$this->url = $this->url . "&fieldID=" . $this->fieldID;
		}

		//checking to see if the user is on the main config page
		if(isset($_GET["p"])){
			//adding to url property
			$this->url = $this->url . "&p=" . $_GET["p"];
		}

		if(isset($_GET["vm"])){
			//adding to url property
			$this->url = $this->url . "&vm=" . $_GET["vm"];
		}

		if(isset($_GET["fID"])){
			//adding to url property
			$this->url = $this->url . "&fID=" . $_GET["fID"];
		}

		if(isset($_GET["pID"])){
			//adding to url property
			$this->url = $this->url . "&pID=" . $_GET["pID"];
		}

		if(isset($_GET["ppage"])){
			
			//setting class property to reflect the per page amount
			$this->perPage = $_GET["ppage"];

		} else {

			//per page default value
			$this->perPage = 10;
		}

		if(isset($_GET["pgnum"])){
			//setting class property to reflect the current page number
			$this->pageNumber = $_GET["pgnum"];

		} else {

			//page number default value
			$this->pageNumber = 1;
		}

	}	
	private function checkForSubmission(){
		if(isset($_POST["override_type"])){
			//setting variables to that which was submitted
			if(isset($_POST["merchant_id"])){
				$merchant_id = $_POST["merchant_id"];
			}
			if(isset($_POST["id_product"])){
				$id_product = $_POST["id_product"];
			}
			if(isset($_POST["override_type"])){
				$override_type = $_POST["override_type"];
			}
			if(isset($_POST["override_value"])){
				$override_value = $_POST["override_value"];
			}
			if(isset($_POST["override_id"])){
				$override_id = $_POST["override_id"];
			}
		}

		if(isset($_POST["newOverride"])){
			self::addNewOverride($merchant_id,$id_product,$override_type,$override_value);
					
		} elseif(isset($_POST["updateOverride"])){
			self::updateProductOverride($override_id,$merchant_id,$id_product,$override_type,$override_value);

		} elseif(isset($_GET["rmvOvr"])){
			self::removeProductOverride($_GET["rmvOvr"]);

		}
	}
	protected function addNewOverride($merchant_id,$id_product,$override_type,$override_value){
		$sql = "INSERT INTO `" . _DB_NAME_ . "`.`mc_overrides` (`merchant_id`,`id_product`,`override_type`,`override_value`) VALUES 
		('" . $merchant_id . "','" . $id_product . "','" . $override_type . "','" . $override_value . "')";
		$query = mysql_query($sql);
		if($query){
			messageReporting::insertMessage("success","You have successfully added a " . $override_type . " override for " . $id_product);
		} else {
			messageReporting::insertMessage("error","An error occured while trying to add your override value" . mysql_error());
		}
	}
	protected function updateProductOverride($override_id,$merchant_id,$id_product,$override_type,$override_value){
		$sql = "UPDATE `" . _DB_NAME_ . "`.`mc_overrides` SET `merchant_id` = '" . $merchant_id . "',`id_product` = '" . $id_product . "',`override_type` = '" . $override_type . "',`override_value` = '" . $override_value . "') WHERE id = " . $override_id;
		$query = mysql_query($sql);
		if($query){
			messageReporting::insertMessage("success","You have successfully updated the " . $override_type . " override for " . $id_product);
		} else {
			messageReporting::insertMessage("error","An error occured while trying to update your override value");
		}
	}
	protected function removeProductOverride($override_id){
		$sql = "DELETE FROM `" . _DB_NAME_ . "`.`mc_overrides` WHERE id = " . $override_id;
		$query = mysql_query($sql);
		if($query){
			messageReporting::insertMessage("success","You have successfully removed the selected override");
		} else {
			messageReporting::insertMessage("error","An error occured while trying to remove your override value");
		}
	}
	public function fieldConfigDisplay(){

		//configuring form diplay type
		if(isset($this->fieldID)){
			$override_type = "<input type=\"text\" disabled name=\"override_type-hidden\" class=\"form-control\" value=\"" . $this->fieldName . "\">
			<input type=\"hidden\" name=\"override_type\" value=\"" . $this->fieldName . "\">";
		} else {
			$override_type = "<input type=\"text\" name=\"override_type\" class=\"form-control\">";
		}

		//configuring form diplay type
		if(isset($this->id_product)){
			$id_product = "<input type=\"text\" disabled name=\"id_product-hidden\" class=\"form-control\" value=\"" . $this->id_product . "\">
			<input type=\"hidden\" name=\"id_product\" value=\"" . $this->id_product . "\">";
		} else {
			$id_product = "<input type=\"text\" name=\"id_product\" class=\"form-control\">";
		}

		//configuring form diplay type
		if(isset($this->override_value)){
			$override_value = "<input type=\"text\" disabled name=\"override_value-hidden\" class=\"form-control\" value=\"" . $this->override_value . "\">
			<input type=\"hidden\" name=\"override_value\" value=\"" . $this->override_value . "\">";
		} else {
			$override_value = "<input type=\"text\" name=\"override_value\" class=\"form-control\">";
		}

		echo "
		<div class=\"col-md-12 panel-body\">
			<div class=\"panel-group\" id=\"accordion\">
				<div class=\"panel panel-dark\">
					<div class=\"panel-heading\">
						<a class=\"accordion-toggle collapsed\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseProductOverrides\"><div class=\"panel-title\">Product Overrides</div></a>
			    	</div>
			    	<div id=\"collapseProductOverrides\" class=\"panel-collapse panel-body product-overrides collapse\" style=\"height: 30px;\">
			    		<div class=\"alert-info\">
			    			<div class=\"alert alert-body\">
			    				<p><strong>NOTE:</strong> Here you are able to instruct the feed to manually override single product row values.</p>
			    			</div>
			    		</div>
						<div class=\"row-fluid product-override\">
							<form name=\"addProductOverride\" action=\"" . $this->url . "\" method=\"post\">
								<div class=\"span3\">
									<label for=\"id_product\" class=\"form-label\">Product Number</label>
									" . $id_product . "
									<br>
								</div>
					    		<div class=\"span3\">
					    			<label for=\"override_type\" class=\"form-label\">Field to Override</label>
					    			" . $override_type . "
					    			<br>
					    		</div>
					    		<div class=\"span3\">
					    			<label for=\"override_value\" class=\"form-label\">Override Value</label>
					    			" . $override_value . "
					    			<br>
					    		</div>
					    		<div class=\"span3\">
					    			<label for=\"submit\" class=\"form-label\">Add New Override<label>
					    			<input type=\"hidden\" name=\"merchant_id\" value=\"" . $this->merchant_id . "\">
					    			<input type=\"hidden\" name=\"newOverride\" value=\"a\">
					    			<input type=\"submit\" class=\"btn btn-success form-control\" value=\"Add New Override\">
					    		</div>
					    		<div class=\"clearfix\"></div>
					    	</form>
					    </div>
			    	</div>
				</div>
			</div>
		</div>";
	}
	public function overrideExistingDisplay($type,$id_product,$override_type,$override_value,$merchant_id,$override_id){
		if($id_product !== ""){
			$id_product_disabled = "disabled";
		} else {
			$id_product_disabled = "";
		}

		if($override_type !== ""){
			$override_type_disabled = "disabled";
		} else {
			$override_type_disabled = "";
		}

		if($override_value !== ""){
			$override_value_disabled = "disabled";
		} else {
			$override_value_disabled = "";
		}

		if($type == "add") {

			$disabled = "";
			$submit = "
				<input type=\"hidden\" name=\"newOverride\" value=\"a\">
				<input type=\"submit\"class=\"btn btn-success form-control\" value=\"Add New Override\">";

		} elseif($type == "upd") {

			$submit = "<a class=\"btn btn-danger form-control\" href=\"" . $this->url . "&rmvOvr=" . $override_id . "&ppage=" . $this->perPage . "&pgnum=" . $this->pageNumber . "\">Remove Override</a>";

		}

		return "
		<div class=\"row-fluid product-override existing-overrides\">
			<form name=\"updateProductOverride\" action=\"" . $this->url . "&ppage=" . $this->perPage . "&pgnum=" . $this->pageNumber . "\" method=\"post\">
				<div class=\"span3\">
					<label for=\"id_product\" class=\"form-label\">Product Number</label>
					<input type=\"text\" name=\"id_product\" value=\"" . $id_product . "\" " . $id_product_disabled . " class=\"form-control\">
					<br>
				</div>
	    		<div class=\"span3\">
	    			<label for=\"override_type\" class=\"form-label\">Field to Override</label>
	    			<input type=\"text\" name=\"override_type\" value=\"" . $override_type . "\" " . $override_type_disabled . " class=\"form-control\">
	    			<br>
	    		</div>
	    		<div class=\"span3\">
	    			<label for=\"override_value\" class=\"form-label\">Override Value</label>
	    			<input type=\"text\" name=\"override_value\" value=\"" . $override_value . "\" " . $override_value_disabled . " class=\"form-control\">
	    			<br>
	    		</div>
	    		<div class=\"span3\">
	    			<label for=\"submit\" class=\"form-label\">Action</label>
	    			<input type=\"hidden\" name=\"merchant_id\" value=\"" . $merchant_id . "\">
	    			<input type=\"hidden\" name=\"override_id\" value=\"" . $override_id . "\">
	    			<input type=\"hidden\" name=\"product_override\" value=\"fromFieldConfig\">
	    			" . $submit . "	    			
	    		</div>
	    		<div class=\"clearfix\"></div>
    		</form>
    	</div>";
	}
	public function selectViewMethod(){
		return "
				<div class=\"row-fluid\">
					<div class=\"span12\">
						<p class=\"panel-body\">Please select a method for viewing / editing your existing overrides</p>
					</div>
				</div>
				<div class=\"row-fluid\">
					<div class=\"span4\">
						<a class=\"form-control btn btn-default\" href=\"index.php?f=" . $this->merch . "&p=ovrde&vm=a\" title=\"View all overrides\">All Overrides</a>
						<br><br>
					</div>
					<div class=\"span4\">
						<a class=\"form-control btn btn-default\" href=\"index.php?f=" . $this->merch . "&p=ovrde&vm=f\" title=\"View field overrides grouped by feed field\">Overrides by Feed Field</a>
						<br><br>
					</div>
					<div class=\"span4\">
						<a class=\"form-control btn btn-default\" href=\"index.php?f=" . $this->merch . "&p=ovrde&vm=p\" title=\"View field overrides grouped by product\">Overrides by Product</a>
						<br><br>
					</div>
					<div class=\"clearfix\"></div>
				</div>";
	}
	public function selectGroupingMethod($viewMethod){

		if($viewMethod == "p"){ 
			$label = "Product Number";
			//if grouping by product
			$display = self::overrideByProduct();

		} elseif($viewMethod == "f"){ 
			$label = "Feed Field Name";
			//if grouping by field name
			$display = self::overrideByField();

		} 

		return "
		<div class=\"col-lg-6\">
			<form action=\"" . $this->url . "\" method=\"get\">
				<label for=\"" . $viewMethod . "ID\">" . $label . "</label>
				<input type=\"hidden\" name=\"f\" value=\"" . $_GET["f"] . "\">
				<input type=\"hidden\" name=\"p\" value=\"" . $_GET["p"] . "\">
				<input type=\"hidden\" name=\"vm\" value=\"" . $_GET["vm"] . "\">
				<select class=\"form-control\" name=\"" . $viewMethod . "ID\">
					" . $display . "
				</select>
		</div>
		<div class=\"col-lg-6\">
				<label for=\"submit\">Select Grouping Method</label>
				<input type=\"submit\" class=\"btn btn-success form-control\" value=\"Select Method\">
			</form>
		</div>
		";
	}
	public function overrideByProduct(){
		$sql = "SELECT DISTINCT `id_product` FROM `" . _DB_NAME_ . "`.`mc_overrides` WHERE `merchant_id` = '" . $this->merchant_id . "'";
		$query = mysql_query($sql);
		$num = mysql_num_rows($query);

		if($num > 0){
			$a = array();

			while ($row = mysql_fetch_array($query)){
				array_push($a,"<option value=\"" . $row["id_product"] . "\">" . $row["id_product"] . "</option>");
			}
			return implode("",$a);
		} else {
			return "<option>None Created</option>";
		}
	}
	public function overrideByField(){
		$sql = "SELECT DISTINCT `override_type` FROM `" . _DB_NAME_ . "`.`mc_overrides` WHERE `merchant_id` = '" . $this->merchant_id . "'";
		$query = mysql_query($sql);
		$num = mysql_num_rows($query);

		if($num > 0){
			$a = array();

			while ($row = mysql_fetch_array($query)){
				array_push($a,"<option value=\"" . $row["override_type"] . "\">" . $row["override_type"] . "</option>");
			}
			return implode("",$a);
		} else {
			return "<option>None Created</option>";
		}
	}
	public function viewOverrides(){
		if(!isset($_GET["vm"])){
			//if the vew method is not set then request it from the user
			return self::selectViewMethod();
		} else {
			//otherwise set the class property to the view method and continue
			$this->viewMethod = $_GET["vm"];
		}
		if($this->viewMethod != "a" && !isset($_GET[$this->viewMethod . "ID"])){
			//if there is not a product / field selected to group by, request a product to be selected
			return "<div class=\"col-lg-12\">" . self::selectGroupingMethod($this->viewMethod) . "</div>";
		}

		//setting class property values
		if($this->viewMethod == "p"){
			$this->id_product = $_GET["pID"];
			$where = " WHERE `id_product` = '" . $this->id_product . "'";
		} elseif($this->viewMethod == "f") {
			$this->fieldID = $_GET["fID"];
			$where = " WHERE `override_type` = '" . $this->fieldID . "'";
		} else {
			//if the user is viewing ALL then make the where statement blank
			$where = "";
		}

		$a = array();

		//compile sql for count value and set class overrideCount property
		$sql = "SELECT `id`, `merchant_id`, `id_product`, `override_type`, `override_value` FROM `" . _DB_NAME_ . "`.`mc_overrides` " . $where . "ORDER BY  `id_product`, `override_type`, `override_value`";
		$query = mysql_query($sql);
		$this->overrideCount = mysql_num_rows($query);

		//checking if the user is on the first page to prevent an SQL error
		if($this->pageNumber == 1){
			$supp = 0;
		} else {
			$supp = 1;
		}
		//creating the start limit based on the page number
		$this->limitStart = ((($this->pageNumber * $this->perPage) - $this->perPage)-$supp);

		//limit run is flat number based on the selected number of per page results
		$this->limitRun = $this->perPage;

		//compile sql for siaply of information including page limit
		$sql = $sql . "LIMIT " . $this->limitStart  . "," . $this->limitRun;
		$query = mysql_query($sql);

		//create add section head
		array_push($a,"<h2>Add New Override</h2>");

		//create first row (insert new)
		array_push($a,self::overrideExistingDisplay("add","","","",$this->merchant_id,""));

		//create remove section head
		array_push($a,"<div id=\"existing-overrides\" class=\"clearfix\"></div><h2>Remove Existing Overrides</h2>");
		
		if($this->overrideCount < 1){

			//check if there are anymore values and notify user if not
			array_push($a,"<div class=\"alert-warning\"><div class=\"alert\"><p class=\"alert-body\"><strong>WARNING:</strong> There are no more overrides for this grouping method. Please return to the <a href=\"index.php?f=" . $this->merch . "&p=ovrde\" title=\"Click here to select a new grouping method and return to editing\">Field Value Override</a> Selection Screen.</p></div></div>");
		} else {
			
			//adding override contents
			while($row = mysql_fetch_array($query)){
					array_push($a,self::overrideExistingDisplay("upd",$row["id_product"],$row["override_type"],$row["override_value"],$row["merchant_id"],$row["id"]));	
				}
			
		}

		//instantiating footer class
		array_push($a,self::footer());

		return implode("",$a);
	}

	public function footer(){
		$footer = new footer;
		$footervalue = $footer->paginationFooter($this->overrideCount, $this->perPage, $this->pageNumber, $this->url,"#existing-overrides");
		return $footervalue;
	}
}
?>