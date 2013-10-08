<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class footer{

	//footer construct (case possible)
	public function footerBuild($footerBody){
		$a = array();

		//adding footer html body opener
		array_push($a,"<br><br><br><div class=\"navbar navbar-fixed-bottom footer\">");

		//adding footer html body
		array_push($a,$footerBody);

		//adding footer html body closer
		array_push($a,"</div>");

		//returning footer html
		return implode("",$a);
	}
	//pagination footer
	public function paginationFooter($count,$perPage,$pageNumber,$url,$dropto){
		//instantiating page control class
		$pagination = new pagination;

		//building footer with pagination
		return self::footerBuild($pagination->buildPagination($count,$perPage,$pageNumber,$url,$dropto));
	}

	public function footerTypes(){
		if(isset($_GET["p"])){
			//checking what page you're on (if any)
			$curPage = $_GET["p"];

			//if user is on an override page
			if($curPage == "ovrde" && isset($_GET["vm"])){
				//checking view method
				$viewMethod = $_GET["vm"];

				//checking if they are viewing all overrides
				if(in_array($viewMethod,array("a"))){
					//return the pagination footer	
					return self::paginationFooter($count,$perPage,$pageNumber,$url);
				} elseif(isset($_GET[$viewMethod."ID"])){
					//if they are viewing a grouped method wait until the ID is set to return the pagination footer 
					return self::paginationFooter($count,$perPage,$pageNumber,$url);
				}
			}
		} 		
	}
}

?>