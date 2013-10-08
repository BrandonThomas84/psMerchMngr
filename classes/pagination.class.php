<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class pagination{
	public function buildPagination($count,$perPage,$pageNumber,$url,$dropto){
		//return array
		$a = array();

		$pagesCount = ceil(($count / $perPage));
			
		//pushing html wrapper to array
		array_push($a,"<div class=\"col-lg-12 text-center\"><div class=\"col-lg-6\"><div class=\"pagination pagination-centered pagination-large\"><ul>");

		//setting PREVIOUS PAGE link
		if($pageNumber > 1){

			//adding next page value back into the URL
			$prevURL = $url . "&ppage=" . $perPage . "&pgnum=" . ($pageNumber-1) . $dropto;

			//declaring the button HTML value
			$prev = "<li><a href=\"" . $prevURL . "\">Prev</a></li>";

		} else {

			// displaying a disabled previous button if the user is on the first page
			$prev = "<li class=\"disabled\"><a href=\"#\">Prev</a></li>";
		}

		//adding previous link to html array
		array_push($a,$prev);

		//setting an error-proof start page
		if(($pageNumber-2)<=0){
			$pageStart = 1;
		} else {
			$pageStart = ($pageNumber-2);
		}

		//setting an error-proof end page
		if($pagesCount >= ($pageStart+4)){
			$pageEnd = ($pageNumber+2);
		} else {
			$pageEnd = $pagesCount;
		}

		//creating innerds of pagination
		for($i=$pageStart;$i<=$pageEnd;$i++){
			//checking if rendering the current page and if so adding active class
			if($pageNumber == $i){
				$active = " class=\"active\" ";
			} else {
				$active = "";
			}

			$link = $url . "&ppage=" . $perPage . "&pgnum=" . $i . $dropto;

			//adding page link to html array
			$value = "<li" . $active . "><a href=\"" . $link . "\">" . $i . "</a></li>";
			array_push($a,$value);
		}

		//setting NEXT PAGE link
		if($pageNumber < $pagesCount){

			//adding next page value back into the URL
			$nextURL = $url . "&ppage=" . $perPage . "&pgnum=" . ($pageNumber+1) . $dropto;

			//declaring the button HTML value
			$next = "<li><a href=\"" . $nextURL . "\">Next</a></li>";

		} else {

			// displaying a disabled previous button if the user is on the first page
			$next = "<li class=\"disabled\"><a href=\"#\">Next</a></li>";
		}

		//adding next link to html array
		array_push($a,$next);

		//adding html close to array
		array_push($a,"</ul></div><!--CLOSES PAGES--></div><!--CLOSE LEFT SIDE--><div class=\"col-6-lg\">");

		$perPageHTML = "
				<form class=\"form\" action=\"index.php\" method=\"get\">
				<span class=\"per-page-selection\">Per Page</span>" . self::perPageSelector() . "
					<select class=\"pagination per-page-selection\" name=\"ppage\" onchange=\"this.form.submit()\">
						<option vlaue=\"10\"" . feedConfigSelected($perPage,10) . ">10</option>
						<option vlaue=\"20\"" . feedConfigSelected($perPage,20) . ">20</option>
						<option vlaue=\"30\"" . feedConfigSelected($perPage,30) . ">30</option>
						<option vlaue=\"40\"" . feedConfigSelected($perPage,40) . ">40</option>
						<option vlaue=\"50\"" . feedConfigSelected($perPage,50) . ">50</option>
					</select>
				</form>
			</div><!--CLOSE RIGHT SIDE-->
		</div><!--CLOSE lg COLUMN-->
		<div class=\"clearfix\"></div>";

		array_push($a,$perPageHTML);
		
		//return the html array
		return implode("",$a);
	}
	public function perPageSelector(){
		$a = array();

		//GET values to look for
		$vars = array("f","p","vm","fID","pID","pgnum");

		foreach($vars AS $var){
			if(isset($_GET[$var])){
				$val = "<input type=\"hidden\" name=\"" . $var . "\" value=\"" . $_GET[$var] . "\">";
				array_push($a,$val);
			}
		}

		return implode("",$a);
	}
}

?>