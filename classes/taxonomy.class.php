<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
//instructs the merchant manager page to display the configure taxonomy button if there is a standard dataset present in the database
class taxonomyButton{

	protected function enabled(){
		$sql = "SELECT DISTINCT `A`.`merchant_id` FROM `" . _DB_NAME_ . "`.`mc_taxonomy` AS `A` WHERE `A`.`merchant_id` = '" . _MERCHANTID_ . "'";
		$query = mysql_query($sql);
		$rows = mysql_num_rows($query);
		return $rows;
	}
	
	public function controlPage(){
		if(self::enabled() > 0){
			return "
			<form action=\"index.php?f=" . _MERCH_ . "&p=tax\" method=\"post\">
				<input type=\"submit\" class=\"form-control btn btn-primary\" value=\"Manage " . _MERCHANT_ . " Taxonomy\">
			</form>";
		}	
	}
	
	public function quickLinks(){
		$theme = "flat";
		if(self::enabled() > 0){
			return "
			<li>
	    		<a href=\"index.php?f=" . _MERCH_ . "&p=tax\" title=\"Manage " . _MERCHANT_ . " Taxonomy\">
	    			<img src=\"images/flat/sm/taxonomy.png\">
	    		</a>
	    	</li>";
		}	
	}
}
class taxonomyControl{
	public $mapID;
	public $displayStyle;

	//returns the row id for updating mc_cattax_mapping table
	public function mapTheMapID($category){
		$sql = "SELECT `id` FROM `" . _DB_NAME_ . "`.`mc_cattax_mapping` WHERE `cattax_merchant_id` = '" . _MERCHANTID_ . "' AND `category_string` =  '" . $category . "'";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$this->mapID = $row["id"];
	}
	public function checkForSubmission(){
		$this->displayStyle = array("accordion","accordion-toggle","collapse");

		if(isset($_POST["search"])){ 
			$this->displayStyle = array("","","");
		} 

		if(isset($_POST["apptax"])){
			self::setTaxonomyValue(self::getCattaxID($_POST["taxShortcut"]));
			$this->displayStyle = array("","","");
		}

		if(isset($_POST["levelSubmit"])){
			self::assignNewTaxonomy($_POST["levelval"]);
			$this->displayStyle = array("","","");
		}

		for ($i = 1; $i <= 7; $i++)
		if(isset($_POST["levelRemove" . $i])){
			self::updateTaxonomy($_POST["levelvaltext" . $i],$i);
			$this->displayStyle = array("","","");
		}
	}
	//creates the where for the query used to create the option list for the current taxonomy level
	protected function levelWhere($level,$id){
		//constucting the 'where' statement for the initial query to identify the current taxonomy
		if($id == 0){$where = "";} else {$where = " WHERE `id` = " . $id;}

		$sql = "SELECT DISTINCT `level1` AS `1`,`level2` AS `2`,`level3` AS `3`,`level4` AS `4`,`level5` AS `5`,`level6` AS `6`,`level7` AS `7` FROM `" . _DB_NAME_ . "`.`mc_taxonomy`" . $where;
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$a = array();

		for($i=2;$i<=7;$i++){
			if($level < $i){$l = "";} else {$l = " AND replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(`level" . ($i-1) . "`, '-', ''), '#', ''), '$', ''), '%', ''), '" . chr(38) . "', ''), '(', ''), ')', ''), '*', ''), ',', ''), '.', ''), '/', ''), ':', ''), ';', ''), '?', ''), '@', ''), '[', ''), ']', ''), '_', ''), '`', ''), '{', ''), '|', ''), '}', ''), '~', ''), '‘', ''), '‹', ''), '›', ''), '+', ''), '<', ''), '=', ''), '>', ''), '\'', ''), '\"', ''), ' ', ''), '---', ''), '--', '') = replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace('" . $row[($i-1)] . "', '-', ''), '#', ''), '$', ''), '%', ''), '" . chr(38) . "', ''), '(', ''), ')', ''), '*', ''), ',', ''), '.', ''), '/', ''), ':', ''), ';', ''), '?', ''), '@', ''), '[', ''), ']', ''), '_', ''), '`', ''), '{', ''), '|', ''), '}', ''), '~', ''), '‘', ''), '‹', ''), '›', ''), '+', ''), '<', ''), '=', ''), '>', ''), '\'', ''), '\"', ''), ' ', ''), '---', ''), '--', '')";}
				array_push($a,$l);
		}

		return implode($a,"");
	}
	public function displayCategorySelect(){
		echo merchantHeader("Taxonomy Configuration");
		echo "<div class=\"container well\">";
		echo self::categoriesMissingTaxonomy();
		echo self::taxonomyMissingCategories();
		self::distinctProductCategoryOptionList();
		echo "</div>";
	}
	public function displayTaxonomyConfiguration($category){
		
		echo "
		<div class=\"col-md-12 panel-body\">
			<div class=\"panel-group\" id=\"" . $this->displayStyle[0] . "\">
				<div class=\"panel panel-dark\">
					<div class=\"panel-heading\">
						<a class=\"" . $this->displayStyle[1] . "\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseCategoryTaxonomyConfig\"><h2 class=\"panel-title\">" . $category . " Taxonomy</h2></a>
			    	</div>
			    	<div id=\"collapseCategoryTaxonomyConfig\" class=\"panel-collapse " . $this->displayStyle[2] . "\">
						<br>
						<div class=\"alert alert-info col-lg-10 col-lg-offset-1 dismissable\">
							<p class=\"alert-body\">You can either map individual taxonomy levels one at a time or you can uese the quick apply search function below. Try Searching for \"dog\" and see what you get?</p>
						</div>
						<div class=\"clearfix\"></div>
						<br>
						<form class=\"form\" action=\"index.php?f=" . _MERCH_ . "&p=tax\" method=\"POST\" name=\"categorySelect\"> 
							<input class=\"form-control\" type=\"hidden\" name=\"category\" value=\"" . $category . "\">";

							for($i=1;$i<8;$i++){
								echo "<div class=\"col-sm-12\">" . self::displayTaxOptionList($i,self::categoryToTaxCheck($category)) . "</div>";
							}

		echo "
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class=\"col-md-12 panel-body\">
			<div class=\"panel-group\" id=\"" . $this->displayStyle[0] . "\">
				<div class=\"panel panel-dark\">
					<div class=\"panel-heading\">
						<a class=\"" . $this->displayStyle[1] . "\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseCategoryTaxonomySearch\"><p class=\"panel-title\">Quick Apply</p></a>
					</div>
					<div id=\"collapseCategoryTaxonomySearch\" class=\"panel-collapse " . $this->displayStyle[2] . "\">
						<br>
						<div class=\"col-sm-6\">
							<form class=\"form\" action=\"index.php?f=" . _MERCH_ . "&p=tax\" method=\"POST\" name=\"taxonomySearch\"> 
								<input class=\"form-control\" type=\"text\" name=\"search\">
								<input type=\"hidden\" name=\"category\" value=\"" . $category . "\">
						</div>
						<div class=\"col-sm-6\">
								<input class=\"btn btn-primary col-sm-12\" type=\"submit\" value=\"Search\"/>
							</form>
						</div>
						<div class=\"clearfix\"></div>
						<br>
						<div class=\"col-md-12\">";
							if(isset($_POST["search"])){self::taxonomySearch($_POST["search"],$category);}
		echo "			</div>
						<br>
					</div>
				</div>
			</div>
		</div>";
	}
	//creates an option list containing all the categories that are currently configured in the prestashop database (up to 7 levels)
	protected function distinctProductCategoryOptionList(){
		
		$sql = "SELECT DISTINCT  `E`.`category_string` AS `product_type` " .  feedFrom::fromConstruct("all") . reportQueryWhere() . " ORDER BY `product_type`";
		$query = mysql_query($sql);
		
		echo "
			<div class=\"col-md-12 panel-body\">
				<div class=\"panel-group\" id=\"accordion\">
					<div class=\"panel panel-dark\">
						<div class=\"panel-heading\">
							<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseTaxonomyMapping\"><h2 class=\"panel-title\">All Categories</h2></a>
				    	</div>
				    	<div id=\"collapseTaxonomyMapping\" class=\"panel-collapse collapse\">
							<br>
							<div class=\"alert alert-info col-lg-10 col-lg-offset-1\">
								<p class=\"alert-body\">Use this area to map " . _MERCHANT_ . " taxonomy value to your own PrestaShop categories.</p>
							</div>
							<br>
							<div class=\"col-lg-12\">
								<div class=\"col-md-6\">
									<form class=\"form\" action=\"index.php?f=" . _MERCH_ . "&p=tax\" method=\"POST\" name=\"categorySelect\">
										<select class=\"form-control\" name=\"category\">";
											while($row = mysql_fetch_array($query)){
													echo "<option value=\"" . $row["product_type"] . "\">" . $row["product_type"] . "</option>";
												}
		echo "							</select>
								</div>
								<div class=\"col-md-6\">
										<input type=\"submit\" class=\"btn btn-success col-lg-12\" value=\"Select\"/>
									</form>
								</div>
								<div class=\"clearfix\"></div>
								<br>
							</div>
						</div>
					</div>
				</div>
			</div>";
	}
	//creates drop down menu for next taxonomy level
	protected function displayTaxOptionList($level,$id){
				
		$levelSQL = "SELECT DISTINCT `level" . $level . "` as `values` FROM  `" . _DB_NAME_ . "`.`mc_taxonomy` WHERE `merchant_id` = '" . _MERCHANTID_ . "' " . self::levelWhere($level,$id);
		$levelQuery = mysql_query($levelSQL) or mysql_error();
		
		if($level == 2 && $id == 0) {
		} else {
			if(mysql_num_rows($levelQuery) >= 1){
				//constucting the 'where' statement for the initial query to identify the current taxonomy
				if($id == 0){$where = "";} else {$where = " WHERE `id` = " . $id;}

				$sql = "SELECT DISTINCT `level1` AS `1`,`level2` AS `2`,`level3` AS `3`,`level4` AS `4`,`level5` AS `5`,`level6` AS `6`,`level7` AS `7` FROM `" . _DB_NAME_ . "`.`mc_taxonomy`" . $where;
				$query = mysql_query($sql);
				$row = mysql_fetch_array($query, MYSQL_BOTH);

				if(is_null($row[$level]) || ($id == 0 && $level == 1)){
					
					echo "
						<div class=\"col-sm-12\">
							<label for=\"level" . $level . "\">Level " . $level . "</label>
						</div>
						<div class=\"col-sm-6\">
							<select class=\"form-control\" name=\"levelval\">";
						
					while($levelRow = mysql_fetch_array($levelQuery)){
						echo "<option " . feedConfigSelected($row[$level],$levelRow["values"]) ." value=\"" . $levelRow["values"] . "\">" . $levelRow["values"] . "</option>";
					}
						
					echo "
							</select>
						</div>
						<div class=\"col-sm-6\">
							<input name=\"levelSubmit\" type=\"submit\" class=\"btn btn-success col-sm-12\" value=\"Add Level " . $level . " Value\"/>
						</div>
						<div class=\"clearfix\"></div><br>";	
				} else {
					echo "<div class=\"col-sm-12\">
							<label for=\"level" . $level . "\">Level " . $level . "</label>
						</div>
						<div class=\"col-sm-6\">
							<input class=\"form-control\" name=\"level " . $level . "\" type=\"text\" value=\"" . $row[$level] . "\" disabled=disabled>
							<input name=\"levelvaltext" . $level . "\" type=\"hidden\" value=\"" . $row[$level] . "\">
						</div>
						<div class=\"col-sm-6\">
							<input class=\"btn btn-danger col-sm-12\" name=\"levelRemove" . $level . "\"type=\"submit\" value=\"Delete";
					if($level == 1){echo " All";}
					echo "\"/>
						</div>
						<div class=\"clearfix\"></div><br>";
				}
			}
		}
	}
	//creates base sql for missing and ghost categories
	protected function categorySql($v){

		$categories = "SELECT DISTINCT  `E`.`category_string` AS `category_name` ".  feedFrom::fromConstruct("all") . reportQueryWhere();
		
		if($v == "ghost"){
			$select = "SELECT DISTINCT `map`.`category_string` ";
			$join = " LEFT ";
			$where = " WHERE (`feed`.`category_name` IS NULL OR `feed`.`category_name` = '') AND (`map`.`id` IS NOT NULL OR `map`.`cattax_id` IS NOT NULL)";
		} elseif($v == "missing") {
			$select = "SELECT DISTINCT `feed`.`category_name` ";
			$join = " RIGHT ";
			$where = " WHERE (`feed`.`category_name` IS NOT NULL AND `feed`.`category_name` <> '') AND (`map`.`id` IS NULL OR `map`.`cattax_id` IS NULL)";
		}

		$sql = $select . " AS `category` FROM `" . _DB_NAME_ . "`.`mc_cattax_mapping` AS `map` " . $join . " JOIN (" . $categories . ") AS `feed` ON `cattax_merchant_id` = '" . _MERCHANTID_ . "' AND `feed`.`category_name` = `map`.`category_string` " . $where . " ORDER BY `category`";

		return $sql;
	}
	//returns categories without taxonomy
	protected function categoriesMissingTaxonomy(){
			
		$sql = self::categorySql("missing");
		$query = mysql_query($sql);
		
		if($query){
			$numrow = mysql_num_rows($query);
			$a = array();
		
			if($numrow == 0){
				$v = "
				<div class=\"col-md-12 panel-body\">
					<div class=\"panel-group\" id=\"accordion\">
						<div class=\"panel panel-dark\">
							<div class=\"panel-heading\">
								<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseCategorySuccess\"><h2 class=\"panel-title\">Categories Mapped</h2></a>
					    	</div>
					    	<div id=\"collapseCategorySuccess\" class=\"panel-collapse collapse\">
								<br>
								<div class=\"alert alert-success col-lg-10 col-lg-offset-1\">
									<p class=\"alert\">Congratulations! You have mapped all your PrestShop categories to " . _MERCHANT_ . " taxonomy values.</p>
								</div>
								<br>
							</div>
						</div>
					</div>
				</div>";
				array_push($a,$v);
			} else {
				$v = "
				<div class=\"col-md-12 panel-body\">
					<div class=\"panel-group\" id=\"accordion\">
						<div class=\"panel panel-dark\">
							<div class=\"panel-heading\">
								<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseCategoryMissing\"><h2 class=\"panel-title\">Categories Missing " . _MERCHANT_ . " Taxonomy</h2></a>
					    	</div>
					    	<div id=\"collapseCategoryMissing\" class=\"panel-collapse collapse\">
					    		<br>
								<div class=\"alert alert-warning col-lg-10 col-lg-offset-1\">
									<p class=\"alert-body\">The following PrestaShop categories are showing that they have products linked to them but do not have " . _MERCHANT_ . " taxonomy correlated to them. Select a category and all products contained within that category will have the set Google Taxonomy value applied to your feed.</p>
								</div>
								<br>";
				array_push($a,$v);
					
				while($row = mysql_fetch_array($query)){
					$v = "
								<div class=\"col-sm-3 feed-field\">
									<form class=\"form\" action=\"index.php?f=" . _MERCH_ . "&p=tax\" method=\"POST\">
										<input class=\"form-control\" type=\"hidden\" value=\"" . $row["category"] . "\" name=\"category\">
										<input type=\"submit\" class=\"btn btn-default col-sm-12\" value=\"" . $row["category"]  . "\">
									</form>
								</div>";
					array_push($a,$v);
				}

				$v = "
								<div class=\"clearfix\"></div><br>
							</div>
						</div>
					</div>
				</div>";
				array_push($a,$v);
				return implode("",$a);
			}
		} else {
			//if there are no defined categories
			echo "<div class=\"col-md-12 panel-body\">
					<div class=\"panel-group\" id=\"accordion\">
						<div class=\"panel panel-dark\">
							<div class=\"panel-heading\">
								<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseCategoryWarning\"><h2 class=\"panel-title\">No PrestaShop Categories</h2></a>
					    	</div>
					    	<div id=\"collapseCategoryWarning\" class=\"panel-collapse collapse\">
								<br>
								<div class=\"col-lg-10 col-lg-offset-1\">
									<p class=\"alert alert-warning\">WARNING: You have not configured any PrestaShop categories.</p>
								</div>
								<br>
							</div>
						</div>
					</div>
				</div>";
		}
	}
	//displays taxaonomy that has been matched to categories that don't have products
	protected function taxonomyMissingCategories(){

		$sql = self::categorySql("ghost");
		$query = mysql_query($sql);
		if($query){
			$numrow = mysql_num_rows($query);
			$a = array();
		
			if($numrow >= 1){
				$v = "
				<div class=\"col-md-12 panel-body\">
					<div class=\"panel-group\" id=\"accordion\">
						<div class=\"panel panel-dark\">
							<div class=\"panel-heading\">
								<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseCategoryGhost\"><h2 class=\"panel-title\">Ghost Categories</h2></a>
					    	</div>
					    	<div id=\"collapseCategoryGhost\" class=\"panel-collapse collapse\">
								<br>
								<div class=\"alert alert-info col-lg-10 col-lg-offset-1\">
									<p class=\"alert-body\">The following categories have taxonomy mapping but are not currently being referenced in the feed due to a lack of product associations.</p>
								</div>
								<br>";
				array_push($a,$v);
					
				while($row = mysql_fetch_array($query)){
					$v = "
								<div class=\"col-sm-3 feed-field\">
									<form class=\"form\" action=\"index.php?f=" . _MERCH_ . "&p=tax\" method=\"POST\">
										<input class=\"form-control\" type=\"hidden\" value=\"" . $row["category"] . "\" name=\"categoryDrop\">
										<input type=\"submit\" class=\"btn btn-default col-sm-12\" value=\"" . $row["category"]  . "\">
									</form>
								</div>";
					array_push($a,$v);
				}

				$v = "
								<div class=\"clearfix\"></div><br>
							</div>
						</div>
					</div>
				</div>";
				array_push($a,$v);
				return implode("",$a);
			}
		}
	}
	//return a single string value of all the taxonomy levels that are currently assigned to the category
	protected function currentTaxonomyString($maxLevel){
		//start counter
		$i = 1;
		$a = array();
		
		while($i <= $maxLevel){
			//use SQL to remove all special characters that may appear for comparison
			$column = "replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(`level" . $i . "`, '-', ''), '#', ''), '$', ''), '%', ''), '" . chr(38) . "', ''), '(', ''), ')', ''), '*', ''), ',', ''), '.', ''), '/', ''), ':', ''), ';', ''), '?', ''), '@', ''), '[', ''), ']', ''), '_', ''), '`', ''), '{', ''), '|', ''), '}', ''), '~', ''), '‘', ''), '‹', ''), '›', ''), '+', ''), '<', ''), '=', ''), '>', ''), '\'', ''), '\"', ''), ' ', ''), '---', ''), '--', '')";
			//check to see if there is already an assigned taxonomy value so that it can be used in the where
			if(self::categoryToTaxCheck($_POST["category"]) == 0){
				$where = "1=2";} 
				else {
					$where = " WHERE `id` = '" . self::categoryToTaxCheck($_POST["category"]) . "'";}
			//database select
			$sql = "SELECT " . $column . " AS `value` FROM `" . _DB_NAME_ . "`.`mc_taxonomy` " . $where . "";
			$query = mysql_query($sql);
			@$row = mysql_fetch_array($query);
			array_push($a, $row["value"]);
			$i++;
		}

		return implode("",$a);
	}
	//returns self::currentTaxonomyString with the newest selection appended to the end
	public 	function assignNewTaxonomy($newValue){
		$sql = "SELECT replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace('" . $newValue . "', '-', ''), '#', ''), '$', ''), '%', ''), '" . chr(38) . "', ''), '(', ''), ')', ''), '*', ''), ',', ''), '.', ''), '/', ''), ':', ''), ';', ''), '?', ''), '@', ''), '[', ''), ']', ''), '_', ''), '`', ''), '{', ''), '|', ''), '}', ''), '~', ''), '‘', ''), '‹', ''), '›', ''), '+', ''), '<', ''), '=', ''), '>', ''), '\'', ''), '\"', ''), ' ', ''), '---', ''), '--', '') AS `newValue`";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		
		$string = self::currentTaxonomyString(7) . $row["newValue"];
		
		$stringSQL = "SELECT `id` FROM `" . _DB_NAME_ . "`.`mc_taxonomy` WHERE replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(CONCAT(COALESCE(`level1`, ''),COALESCE(`level2`, ''),COALESCE(`level3`, ''),COALESCE(`level4`, ''),COALESCE(`level5`, ''),COALESCE(`level6`, ''),COALESCE(`level7`, '')), '-', ''), '#', ''), '$', ''), '%', ''), '&', ''), '(', ''), ')', ''), '*', ''), ',', ''), '.', ''), '/', ''), ':', ''), ';', ''), '?', ''), '@', ''), '[', ''), ']', ''), '_', ''), '`', ''), '{', ''), '|', ''), '}', ''), '~', ''), '‘', ''), '‹', ''), '›', ''), '+', ''), '<', ''), '=', ''), '>', ''), '\'', ''), '\"', ''), ' ', ''), '---', ''), '--', '') = '" . $string . "'";
		$stringQUERY = mysql_query($stringSQL);
			
		//apply new value
		while($stringROW = mysql_fetch_array($stringQUERY)){
			//check for matching value to avoid taxonomy errors	
			if(mysql_num_rows($stringQUERY) == 1){
				self::setTaxonomyValue($stringROW["id"]);
			} 
		}
		messageReporting::insertMessage("success","Success! You have added a new taxonomy value!");
	}
	//removes level (and all subsequent levels) of a taxonomy
	protected function updateTaxonomy($removeValue,$maxLevel){
		if($maxLevel == 1){
			$sql = "UPDATE `" . _DB_NAME_ . "`.`mc_cattax_mapping` SET `cattax_id` = NULL WHERE `id` = '" . $this->mapID ."'";
			$query = mysql_query($sql);
			messageReporting::insertMessage("success","Success! You have updated the taxonomy value!");
		} else {
			$sql = "SELECT replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace('" . $removeValue . "', '-', ''), '#', ''), '$', ''), '%', ''), '" . chr(38) . "', ''), '(', ''), ')', ''), '*', ''), ',', ''), '.', ''), '/', ''), ':', ''), ';', ''), '?', ''), '@', ''), '[', ''), ']', ''), '_', ''), '`', ''), '{', ''), '|', ''), '}', ''), '~', ''), '‘', ''), '‹', ''), '›', ''), '+', ''), '<', ''), '=', ''), '>', ''), '\'', ''), '\"', ''), ' ', ''), '---', ''), '--', '') AS `removeValue`";
			$query = mysql_query($sql);
			$row = mysql_fetch_array($query);

			$str = substr(self::currentTaxonomyString($maxLevel),0,strpos(self::currentTaxonomyString($maxLevel),$row["removeValue"]));
			$strCheck = substr(self::currentTaxonomyString($maxLevel),0,strlen(self::currentTaxonomyString($maxLevel))-strlen($row["removeValue"])); 
			if($str == $strCheck){$string = $str;} else {$string = $strCheck;};
			
			$stringSQL = "SELECT `id` FROM `" . _DB_NAME_ . "`.`mc_taxonomy` WHERE replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(CONCAT(COALESCE(`level1`, ''),COALESCE(`level2`, ''),COALESCE(`level3`, ''),COALESCE(`level4`, ''),COALESCE(`level5`, ''),COALESCE(`level6`, ''),COALESCE(`level7`, '')), '-', ''), '#', ''), '$', ''), '%', ''), '&', ''), '(', ''), ')', ''), '*', ''), ',', ''), '.', ''), '/', ''), ':', ''), ';', ''), '?', ''), '@', ''), '[', ''), ']', ''), '_', ''), '`', ''), '{', ''), '|', ''), '}', ''), '~', ''), '‘', ''), '‹', ''), '›', ''), '+', ''), '<', ''), '=', ''), '>', ''), '\'', ''), '\"', ''), ' ', ''), '---', ''), '--', '') = '" . $string . "'";
			$stringQUERY = mysql_query($stringSQL);
			
			while($stringROW = mysql_fetch_array($stringQUERY)){
				//check for matching value to avoid taxonomy errors	
				if(mysql_num_rows($stringQUERY) == 1){
					self::setTaxonomyValue($stringROW["id"]);
				} 
			}
			messageReporting::insertMessage("success","Success! You have updated the taxonomy value!");
		}
	}
	//updates the taxonomy mapping table
	protected function setTaxonomyValue($cattaxID){
		$sql = "UPDATE `" . _DB_NAME_ . "`.`mc_cattax_mapping` SET `cattax_id` = " . $cattaxID . " WHERE `id` = " . $this->mapID;
		mysql_query($sql);
	}
	//deletes categories from taxonomy selected in categoriesGhostSql($rows)
	public function deleteCategoriesGhost($catString){

		$sql = "DELETE FROM `" . _DB_NAME_ . "`.`mc_cattax_mapping` WHERE `cattax_merchant_id` = '" . _MERCHANTID_ . "' AND `category_string` = '" . $catString . "'";
		$query = mysql_query($sql) or die(mysql_error());
		
		if(!$query){
			messageReporting::insertMessage("error","There was an error while trying to remove the value. MYSQL ERROR: " . mysql_error());
		} else {
			messageReporting::insertMessage("success","Successfully deleted ghost categories.");
		}
	}
	//check to see if there is already a mapped value for this category if not it will insert the value into the database table if there is it returns the taxonomy id that is being used
	protected function categoryToTaxCheck($category){
		$sql = "SELECT * FROM `" . _DB_NAME_ . "`.`mc_cattax_mapping` WHERE `cattax_merchant_id` = '" . _MERCHANTID_ . "' AND `category_string` =  '" . $category . "'";
		$query = mysql_query($sql);
		$numRows = mysql_num_rows($query);
		$row = mysql_fetch_array($query);
		
		if($numRows == 0){
			$insert = "INSERT INTO `" . _DB_NAME_ . "`.`mc_cattax_mapping` (`category_string`,`cattax_merchant_id`) VALUES ('$category','" . _MERCHANTID_ . "')";
			$query2 = mysql_query($insert);

			return 0;
		} else {
			if(is_null($row["cattax_id"])){ 
				return 0;
			} else {
				return $row["cattax_id"];
			}
		}
	}
	//returns cattax_ID for querying
	protected function getCattaxID($string){
		$sql = "SELECT `id` FROM `" . _DB_NAME_ . "`.`mc_taxonomy` 
		WHERE CONCAT((CASE WHEN COALESCE(`level1`, '') = '' THEN '' ELSE CONCAT(`level1`) END),
			(CASE WHEN COALESCE(`level2`, '') = '' THEN '' ELSE CONCAT(' > ',`level2`) END),
			(CASE WHEN COALESCE(`level3`, '') = '' THEN '' ELSE CONCAT(' > ',`level3`) END),
			(CASE WHEN COALESCE(`level4`, '') = '' THEN '' ELSE CONCAT(' > ',`level4`) END),
			(CASE WHEN COALESCE(`level5`, '') = '' THEN '' ELSE CONCAT(' > ',`level5`) END),
			(CASE WHEN COALESCE(`level6`, '') = '' THEN '' ELSE CONCAT(' > ',`level6`) END),
			(CASE WHEN COALESCE(`level7`, '') = '' THEN '' ELSE CONCAT(' > ',`level7`) END)) = '" . $string . "'";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		return $row["id"];
	}
	//locate potential taxonomy matches
	protected function taxonomySearch($value,$category){
		$sql = "SELECT DISTINCT
	    	CONCAT((CASE
	                WHEN `tax`.`level1` IS NULL THEN '' ELSE `tax`.`level1` END),
	            (CASE WHEN `tax`.`level2` IS NULL THEN '' ELSE CONCAT(' > ', `tax`.`level2`) END),
	            (CASE WHEN `tax`.`level3` IS NULL THEN '' ELSE CONCAT(' > ', `tax`.`level3`) END),
	            (CASE WHEN `tax`.`level4` IS NULL THEN '' ELSE CONCAT(' > ', `tax`.`level4`) END),
	            (CASE WHEN `tax`.`level5` IS NULL THEN '' ELSE CONCAT(' > ', `tax`.`level5`) END),
	            (CASE WHEN `tax`.`level6` IS NULL THEN '' ELSE CONCAT(' > ', `tax`.`level6`) END),
	            (CASE WHEN `tax`.`level7` IS NULL THEN '' ELSE CONCAT(' > ', `tax`.`level7`) END)) AS `Taxonomy`
			FROM `" . _DB_NAME_ . "`.`mc_taxonomy` AS `tax`
			WHERE `merchant_id` = '" . _MERCHANTID_ . "' AND COALESCE(`tax`.`level7`,`tax`.`level6`,`tax`.`level5`,`tax`.`level4`,`tax`.`level3`,`tax`.`level2`,`tax`.`level1`) LIKE '%" . $value . "%' LIMIT 0,50";
		$query = mysql_query($sql);

		echo "<div class=\"col-lg-10 col-lg-offset-1\">
				<div class=\"panel-group\" id=\"accordion\">
					<div class=\"panel panel-warning\">
						<div class=\"panel-heading\">
							<h3>Search Results</h3>
						</div>
						<p class=\"panel-body\">Your search for \"<strong><i>" . strtoupper($value) . "</i></strong>\" yielded " . mysql_num_rows($query) . " results</p>";

		while($row = mysql_fetch_array($query)){
			$value = "<strong><i>" . str_replace(" > ","</i></strong> > <strong><i>", $row["Taxonomy"]) . "</i></strong>";

		echo "	<div class=\"panel panel-success search-tax col-sm-10 col-sm-offset-1\">
					<div class=\"col-sm-8\">
						<p>" . $value . "</p>
					</div>
					<div class=\"col-sm-4\">
						<form action=\"index.php?f=" . _MERCH_ . "&p=tax\" method=\"POST\" name=\"taxonomySearch\">
							<input type=\"hidden\" name=\"taxShortcut\" value=\"" . $row["Taxonomy"] . "\">
							<input type=\"hidden\" name=\"category\" value=\"" . $category . "\">
							<input class=\"btn btn-success col-sm-12\" type=\"submit\" name=\"apptax\" value=\"Apply Taxonomy\">
						</form>
					</div>
				</div>
				<div class=\"clearfix\"></div><br>";
		}

		echo "</div>";
	}
}
?>