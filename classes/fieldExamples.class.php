<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class fieldExamples{
	public $exampleType;
	
	public function setExampleType(){
		if(isset($_POST["exampleDefault"])){
			$this->exampleType = array(
				"limit" => $_POST["exampleLimit"],
	  			"style" => $_POST["examplestyle"],
	  			"specificProducts" => $_POST["exampleProducts"]
				);
		} else {
			$this->exampleType = array(
				"limit" => 10,
	  			"style" => "random",
	  			"specificProducts" => false
				);
		}
	}

	public function getExamples(){

		$limit = $this->exampleType["limit"];
		$style = $this->exampleType["style"];
		$specificProducts = $this->exampleType["specificProducts"];
		

		//getting information to build the query
		$column = substr(selectFieldReturn($_GET["fieldID"]),0,strrpos(selectFieldReturn($_GET["fieldID"]), " AS ")) ;
		$select = "SELECT DISTINCT `A`.`id_product`, `B`.`name`, " . productLink::selectNoAlias() . " AS 'link', " . selectFieldReturn($_GET["fieldID"]);
		$where = reportQueryWhere() . " AND (" . $column . " IS NOT NULL) LIMIT 0,25";

		/*
		COMMENTING OUT EXAMPLE SETTINGS FOR NOW
		if($style == "random"){
			//creates where containing random ID values
			$a = array();
			for($i=1;$i<=($limit+100);$i++){
				array_push($a,rand(0,self::total()));
			}
			$where =  reportQueryWhere() . " AND (" . $column . " IS NOT NULL) AND `A`.`id_product` IN (" . implode(",",$a) . ")"; 
		} elseif($style == "specificProducts") {
			//creates where populated with selected product IDs
			$where =  reportQueryWhere() . " AND (" . $column . " IS NOT NULL) AND `A`.`id_product` IN (" . $specificProducts . ")"; 
		}

		*/
		$sql = $select . feedFrom::fromConstruct("") . $where;

		$query = mysql_query($sql);

		while(@$rows = mysql_fetch_assoc($query, MYSQL_BOTH)){
			echo "
			<div class=\"row-fluid\">
				<div class=\"span2\">
					<div class=\"field-example-product\">
						<p><a href=\"" . $rows[2] . "\" target=\"_blank\" title=\"Click to view " . $rows[0] . "\">" . $rows[0] . "</a></p>
					</div>
				</div>
				<div class=\"span2\">
					<div class=\"field-example-brand\">
						<p><a href=\"" . $rows[2] . "\" target=\"_blank\" title=\"Click to view " . $rows[0] . "\">" . $rows[1] . "</a></p>
					</div>
				</div>
				<div class=\"span8\">
					<div class=\"field-example-value\">
						<p><a href=\"" . $rows[2] . "\" target=\"_blank\" title=\"Click to view " . $rows[0] . "\">" . $rows[3] . "</a></p>
					</div>
				</div>
			</div>";
		}		
	}
	protected function total(){
		$query = feedSelect::selectConstruct() . feedFrom::fromConstruct("") . reportQueryWhere();
		$total = mysql_num_rows(QueryBuilder(""));
		
		return $total;
	}
	public function fieldExampleDisplay($fieldName){

		 echo "
		<div class=\"col-md-12 panel-body\">
			<div class=\"panel-group\" id=\"accordion\">
				<div class=\"panel panel-dark\">
					<div class=\"panel-heading\">
						<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapseFieldExamples\"><div class=\"panel-title\">Example Data</div></a>
			    	</div>
			    	<div id=\"collapseFieldExamples\" class=\"panel-collapse collapse panel-body field-information\">
			    		<div class=\"row-fluid\">
							<div class=\"span2\">
								<div class=\"field-example-product\">
									<p><strong>ID_Product</strong></p>
								</div>
							</div>
							<div class=\"span2\">
								<div class=\"field-example-brand\">
									<p><strong>Brand Name</strong></p>
								</div>
							</div>
							<div class=\"span8\">
								<div class=\"field-example-value\">
									<p><strong>" . ucfirst($fieldName) . "</strong></p>
								</div>
							</div>
						</div>
			    		<div class=\"clearfix\"></div>";

			    		echo $this->getExamples();
			    		
		echo     	"</div>
				</div>
			</div>
		</div>";
	}
}

?>