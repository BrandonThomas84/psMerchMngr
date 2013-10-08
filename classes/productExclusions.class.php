<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class exclusions{
	public $perPage;
	public $pageNumber;
	public $url;

	public function __construct(){
		self::checkForSubmission();
		//checking if the current page in in the url
		if(isset($_GET["pgnum"])){
			//if page is in url set the property value
			$this->pageNumber = $_GET["pgnum"];
		} else {
			//page is not in url then set pagenumber to default (1)
			$this->pageNumber = 1;
		}

		//checking if the perpage is in the url
		if(isset($_GET["ppage"])){
			//if per page is in url then set property value
			$this->perPage = $_GET["ppage"];
		} else {
			//if per page not in url then set to default (10)
			$this->perPage = 10;
		}

		//setting the submit action for forms
		$this->url = "index.php?f=" . _MERCH_ . "&p=exmng";
		
	}
	public function checkForSubmission(){
		if(isset($_POST["removeExclusion"])){
			$this->removeExclusion();
		} 

		if(isset($_POST["addExclusion"])){	
			$this->addExclusion();
		}
	}
	public function removeExclusion(){
		$sql = "DELETE FROM `" . _DB_NAME_ . "`.`mc_exclusion` WHERE `id`='" . $_POST["id"] . "' and`exclusion`='" . $_POST["merchantID"] . "';";
		mysql_query($sql) or die("Could not connect to MySQLi: " . mysql_error());
		messageReporting::insertMessage("success","Removed product exclusion");
	}
	public function addExclusion(){

		//check if valid product
		$productSQL = "SELECT DISTINCT `id_product` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product` WHERE `id_product` = '" . $_POST["id_product"] . "';";
		$query = mysql_query($productSQL);
		$numRows = mysql_num_rows($query);

		if( $numRows == 1 ){

			//check if exclusion exisits
			$checkSql = "SELECT `id` FROM `" . _DB_NAME_ . "`.`mc_exclusion` WHERE `id_product`='" . $_POST["id_product"] . "' AND `exclusion` = '" . $_POST["merchantID"] . "'";
			$query = mysql_query($checkSql);
			
			if(mysql_num_rows($query) == 0){
				//Insert new product exclusion
				$sql = "INSERT INTO `" . _DB_NAME_ . "`.`mc_exclusion` (`id_product`, `exclusion`) VALUES ('" . $_POST["id_product"] . "', '" . $_POST["merchantID"] . "');";
				$query = mysql_query($sql);
				if(!$query) {
					messageReporting::insertMessage("error","There was an error while trying to add the exclusion<br>" . mysql_error());
				} else {
					messageReporting::insertMessage("success","You have successfully added a product to your exclusions!");
				}

			} else {
				messageReporting::insertMessage("error","An exception for that product already exists within this feed");
			}
		} else {
			messageReporting::insertMessage("error","You have entered an invalid product ID (id_product)");
		}
	}
	protected function excludedProductsQuery(){
		return "
		SELECT DISTINCT `ex`.`id`,`A`.`id_product`,`C`.`name`," 		
		. productLink::select(productLink::selectNoAlias(),"link") 
		. feedFrom::fromConstruct("base") . 
		" LEFT JOIN `" . _DB_NAME_ . "`.`mc_exclusion` AS `ex`
		ON `A`.`id_product` = `ex`.`id_product`
			AND `ex`.`exclusion` = '" . _MERCHANTID_ . "'
		WHERE `ex`.`id` IS NOT NULL";
	}
	public function displayNewExclusion(){
		return "
			<div class=\"col-sm-6\">
				<form class=\"form\" action=\"" . $this->url . "\" method=\"post\">
				    <input type=\"hidden\" name=\"merchantID\" value=\"" . _MERCHANTID_  . "\">
				  	<input type=\"hidden\" name=\"addExclusion\" value=\"true\">
				  	<label class=\"form-label\">Enter Product Number</label>
				  	<input type=\"text\" class=\"form-control\" size=\"30\" maxlength=\"150\" name=\"id_product\">
			</div>
			<div class=\"col-sm-6 form\">
					<label class=\"form-label btn-label\">Add Exclusion</label><br>
					<input class=\"btn btn-success col-sm-12\" type=\"submit\" value=\"Add Exclusion\">
				</form>
			</div>";
	}
	public function displayExcludedProducts(){

		//creating start and stop point for the query based on page numbers
		$limitStart = ($this->pageNumber*$this->perPage)-$this->perPage;
		$limitRun = $this->perPage;

		//prepping query
		$sql = self::excludedProductsQuery() . " ORDER BY `A`.`id_product` LIMIT " . $limitStart . "," . $limitRun;
		$query = mysql_query($sql);
		$count = mysql_num_rows($query);
		
		//check to make sure there are current exclusions, if not set a message
		if($count > 0){
			
			while($row = mysql_fetch_array($query)){

				echo "
				<div class=\"row-fluid text-center product-exclusions\">
					<form action=\"index.php?f=" . _MERCH_ . "&p=exmng&ppage=" . $this->perPage . "&pgnum=" . $this->pageNumber . "\" method=\"POST\">
						<div class=\"existing-exclusions\">
							<div class=\"span3\">
								<label class=\"form-label\">Product Number</label>
								<input class=\"form-control\" type=\"text\" value=\"" . $row["id_product"] . "\" disabled>
								<input type=\"hidden\" value=\"" . $row["id_product"] . "\" name=\"id_product\">
							</div>
							<div class=\"span3\">
								<label class=\"form-label\">Name</label>
								<input class=\"form-control\" type=\"text\" value=\"" . $row["name"] . "\" disabled>
								<input type=\"hidden\" value=\"" . $row["name"] . "\" name=\"name\">
							</div>
							<div class=\"span3\">
								<label class=\"form-label btn-label\">View Product</label>
								<a class=\"form-control btn btn-default\" href=\"" . $row["link"] . "\" target=\"_blank\">Click to View Product " . $row["id_product"] . "</a>
							</div>
							<div class=\"span3\">
									<label class=\"form-label btn-label\">Remove</label>
							  		<input type=\"hidden\" name=\"id\" value=\"" . $row["id"] . "\" >
							  		<input type=\"hidden\" name=\"merchantID\" value=\"" . _MERCHANTID_ . "\" >
							  		<input type=\"submit\" class=\"btn btn-danger form-control\" value=\"Remove\" name=\"removeExclusion\">
							</div>
							<div class=\"clearfix\"></div>
						</div>
					</form>
				</div>";
			} 
		} else {
				echo "<div class=\"alert-warning\" style=\"margin-left: 20px;\"><div class=\"alert\"><p class=\"alert-body\">You have not yet setup any product exclusions.</p></div></div>";
		}
		
	}
	public function footer(){
		$exclusionCount = mysql_query(self::excludedProductsQuery());
		$exclusionCount = mysql_num_rows($exclusionCount);

		$footer = new footer;
		$footervalue = $footer->paginationFooter($exclusionCount, $this->perPage, $this->pageNumber, $this->url,"");
		return $footervalue;
	}
}

?>