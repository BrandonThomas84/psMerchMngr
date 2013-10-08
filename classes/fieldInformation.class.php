<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

//class that displays feedhealth section
class fieldInformation{
	//displays the feed health information on the configuration page
	public function health(){
		$functional = self::functional();;
		$total = self::total();
		$pct = number_format((($functional/$total)*100),2);
		$bkgColor = self::healthColor($functional,$total);

		return self::styleAddition($bkgColor,$pct) . "
			<h3>Field Health</h3>
			<div class=\"col-sm-3\">
				<p><strong>Products with values:</strong><br><i>" . $functional . " / " . $total . "</i></p>
			</div>
			<div class=\"col-sm-8 col-sm-offset-1\">
				<div class=\"progress-striped progress active\">
					<div class=\"progress-bar-fieldhealth\" style=\"width:" . $pct . "%;\">(" . $pct . "%)</div>
				</div>
		    </div>
		    <div class=\"clearfix\"></div>";
	}

	//returns the TOTAL number of products in the database that are to be included in the feed
	protected function total(){
		$query = feedSelect::selectConstruct() . feedFrom::fromConstruct("") . reportQueryWhere();
		$total = mysql_num_rows(QueryBuilder(""));
		
		return $total;
	}
	//returns the number of FUNCTIONAL products in the database that are to be included in the feed
	public function functional(){
		
		$column = substr(selectFieldReturn($_GET["fieldID"]),0,strrpos(selectFieldReturn($_GET["fieldID"]), " AS ")) ;

		$select = "SELECT " . selectFieldReturn($_GET["fieldID"]);
		
		$where = reportQueryWhere() . " AND (" . $column . " IS NOT NULL)";

		$sql = $select . feedFrom::fromConstruct("") . $where;

		$query = mysql_query($sql);

		@$rows = mysql_num_rows($query);
		
		return $rows;
		
	}
	//determines the background color for the health meter
	protected function healthColor($functional,$total){
		$v = ($functional/$total);

		if($v<0.03333333){return "#d9534f";}
		if($v<0.06666666){return "#d9534f";}
		if($v<0.09999999){return "#d9534f";}
		if($v<0.13333332){return "#d8524f";}
		if($v<0.16666665){return "#d8584f";}
		if($v<0.19999998){return "#d85f4f";}
		if($v<0.23333331){return "#d86b4f";}
		if($v<0.26666664){return "#d8724f";}
		if($v<0.29999997){return "#d8744f";}
		if($v<0.33333333){return "#d8784f";}
		if($v<0.36666663){return "#d89f4f";}
		if($v<0.39999996){return "#d8af4f";}
		if($v<0.43333329){return "#d8bb4f";}
		if($v<0.46666662){return "#d8bd4f";}
		if($v<0.49999995){return "#d8c64f";}
		if($v<0.53333328){return "#d8d24f";}
		if($v<0.56666661){return "#d8d84f";}
		if($v<0.59999994){return "#d4d84f";}
		if($v<0.63333327){return "#cdd84f";}
		if($v<0.66666666){return "#c4d84f";}
		if($v<0.69999993){return "#b6d84f";}
		if($v<0.73333326){return "#afd84f";}
		if($v<0.76666659){return "#a8d84f";}
		if($v<0.79999992){return "#a2d84f";}
		if($v<0.83333325){return "#74a446";}
		if($v<0.86666658){return "#64a446";}
		if($v<0.89999991){return "#6ca446";}
		if($v<0.93333324){return "#61a446";}
		if($v<0.96666657){return "#56a446";}
		if($v<0.99999999){return "#47a447";}
		else {return "#47a447";}
	}
	protected function styleAddition($color,$width){
		return "
		<style>
			.progress-bar-fieldhealth {
				text-align: center;
				overflow: visible;
				background-color: " . $color . "; 
				width: " . $width . ";
				color: #fff;
				text-shadow: #999 1px 1px 1px;
				background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
  				background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  				background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  				background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  				background-size: 40px 40px;
			}
		</style>";
	}
	public function configDescription($function,$alias){
		if($function == "mapToFeature"){
			return $alias::configDescription();
		} elseif($function == "mapToAttribute"){
			return $alias::configDescription();
		} else {
			return $function::configDescription();
		}
	}
}

?>