<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class testing{
	
	public function __construct(){
		if(!isset($_GET["f"])){
			//return form to select merchant variable
			echo "
			<div class=\"page-header\">
				<h1>Select Merchant to Test from</h1>
			</div>
			<div class=\"clearfix spacer\"></div>
			<div class=\"container well\">

					<form action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"_GET\" name=\"selectMerch\">
						<select name=\"f\">";
						
						foreach(installedMerchants() AS $v){
							echo "<option value=\"" . merchantToMerch($v) . "\">" . merchantFriendly(merchantToMerch($v)) . "</option>";
						}
						
						echo "							
						</select>
						<input name=\"p\" value=\"" . $_GET["p"] . "\" type=\"hidden\">
						<input type=\"submit\" value=\"Select Merchant\">
					</form>

			</div>";
		} else {
			//including merchant classes
			$classes = scandir("merchants/" . _MERCHANTID_ . "/classes");
			for($i=2;$i<=(count($classes)-1);$i++){
				require_once("merchants/" . _MERCHANTID_ . "/classes/" . $classes[$i]);
			}

			//method testing selectuon form
			echo self::selectTestMethod();
		}

	}
	
	public function selectTestMethod(){
		if(isset($_POST["methodName"])){

			//exploding the submitte class and method into an array
			$method = explode(".",$_POST["methodName"]);

			//exploding the submitted properties into an array
			$properties = explode(",",$_POST["methodValues"]);
			
			//figuring out what to do with the submitted function / class.method
			if($method[0] == "function"){
				
				//if a regular function has been subitted
				echo $method[1](@$properties[0],@$properties[1],@$properties[2],@$properties[3],@$properties[4]);

			} elseif($method[0] == "test"){
				
				//if a test method from this page has been submitted
				echo self::$method[1](@$properties[0],@$properties[1],@$properties[2],@$properties[3],@$properties[4]);

			} else {

				//if it is a calculated class.method combination
				$dirs = array("merchants/" . _MERCHANTID_ . "/classes/","_config/_install_REMOVED/","_config/_update_REMOVED/","_config/_settings/","_config/_backup/");
				foreach($dirs AS $dir){

					//checking for submitted in the class folder
					if(file_exists($dir . _MERCHANTID_ . "." . $method[0] . ".class.php")){

						//if submitted is a class then require the class file (if it hasnt been required already)
						require_once($dir . _MERCHANTID_ . "." . $method[0] . ".class.php");

					}elseif(file_exists($dir . $method[0] . ".install.php")){

						//check for the submitted class in the installation file include both the install file and the called class
						require_once($dir . "install.inc.php");
						require_once($dir . $method[0] . ".install.php");

					}elseif(file_exists($dir . $method[0] . ".inc.php")){

						//check for the submitted class in the settings file and include the settings file if so
						require_once($dir . $method[0] . ".inc.php");
					}
				}
				//start the called class
				$testClass = new $method[0];

				echo "<div class=\"page-title\"><h1>Testing " . $_POST["methodName"] . "</h1></div>";
				//echo the called class with the submitted properties
				echo $testClass->$method[1](@$properties[0],@$properties[1],@$properties[2],@$properties[3],@$properties[4]);
			}

		} else {
			//class / file values to ignore
			$noShow = array("__construct","selectTestMethod","..",".");

			echo "
			<div class=\"page-header\">
				<h1>Select a Method to Test</h1>
			</div>
			<div class=\"clearfix spacer\"></div>
			<div class=\"alert-danger\">
				<div class=\"alert col-lg-12 alert-body\">
					<p><strong>WARNING!</strong><br>Many of these functions can make changes to <strong>the code</strong> and/or <strong>your database</strong>. Unless you are aware of the functionality that you are testing or have been asked to run a specific script it is not suggested to make any changes on this page. Any changes that are made are done so at your own risk.</p>
				</div>
			</div>
			<div class=\"container well\">
			<div class=\"panel panel-default\">
				<div class=\"panel-body\">
					<form name\"methodSelect\" class=\"form\" method=\"post\" action=\"" . $_SERVER["PHP_SELF"] . "?f=" . $_GET["f"] . "&p=tst\">
						<label class=\"form-label\">Select a Function</label>
						<select class=\"form-control col-sm-12\" name=\"methodName\">
							<option></option>";
							
							foreach(self::getMethodNamesForTesting() AS $method){
								echo "<option value=\"" . $method[0] . "." . $method[1] . "\">" . $method[0] . " . " . $method[1] . "</option>";
							}

						echo "
						</select>
						<label class=\"form-label\">Function Variables</label>
						<input type=\"text\" class=\"form-control col-lg-12\" name=\"methodValues\">
						<br>
						<input type=\"submit\" class=\"form-control col-lg-12 btn-danger\" name=\"submit\" value=\"Run Function\">
					</form>
				</div>
			</div>";
		}
	}

	private function rawServerInformation($outputMethod){
		$a = array (
			array("__LINE__",__LINE__),
			array("__FILE__",__FILE__),
			array("__DIR__",__DIR__),
			array("__FUNCTION__",__FUNCTION__),
			array("__CLASS__",__CLASS__),
			array("__TRAIT__",__TRAIT__),
			array("__METHOD__",__METHOD__),
			array("__NAMESPACE__",__NAMESPACE__),
			array("_DB_SERVER_",_DB_SERVER_),
			array("_DB_USER_",_DB_USER_),
			array("_DB_PASSWD_",_DB_PASSWD_),
			array("_DB_PREFIX_",_DB_PREFIX_),
			array("_DB_NAME_",_DB_NAME_),
			array("_MM_ROOT_FOLDER_",_MM_ROOT_FOLDER_),
			array("_STORE_FOLDER_",_STORE_FOLDER_),
			array("_MERCHANTID_",_MERCHANTID_),
			array("_MERCHANT_",_MERCHANT_),
			array("_MERCH_",_MERCH_)
			);
		if($outputMethod == "array"){
			return $a;	
		} elseif($outputMethod == "blob") {
			$c = array();
			foreach($a AS $b){
				array_push($c,implode(": ",$b));
			}
			return $c;
		}
		
	}

	public function displayServerInformation(){
		echo "
		<div class=\"page-header\">
			<h1>Server Information</h1>
		</div>
		<div class=\"clearfix spacer\"></div>
		<div class=\"container well\">
			<div class=\"panel panel-default\">
				<div class=\"panel-body\">";
					$sInfo = self::rawServerInformation("array");
					for($i=0;$i<=count($sInfo);$i++){
						echo "<p class=\"label-span\"><span class=\"label label-info\">" . $sInfo[$i][0] . ":  </span>" . $sInfo[$i][1] . "</p>";
					}
				echo "
				</div>
			</div>
		</div>";
	}

	public function sendManualBugReport(){
		$sInfo = implode("`",self::rawServerInformation("blob"));
		echo "
		<div class=\"page-header\">
			<h1>Transmit Manual Bug Report</h1>
		</div>
		<div class=\"clearfix spacer\"></div>
		<div class=\"container well\">
			<form name\"transmitBug\" class=\"form\" method=\"post\" target=\"_blank\" action=\"http://www.perspektivedesigns.com/receivebugreport.php\">
				<label class=\"form-label\">Add a custom message <span class=\"help\">(optional)</span></label>
				<textarea class=\"form-control\" name=\"bugMessage\">
				</textarea>
				<br>
				<input type=\"submit\" class=\"btn btn-success col-lg-12\" value=\"Transmit Report\" onClick=\"window.location.reload()\">
				<input type=\"hidden\" name=\"transmitBug\" value=\"Transmission Key\">
				<input type=\"hidden\" name=\"serverInfo\" value=\"" . $sInfo . "\">
			</form>
		</div>";
	}
	public function getMethodNamesForTesting(){
		$noShow = array("__construct","selectTestMethod","..",".","img","__autoload","settings.inc.txt");
		$classes = array();
		$methods = array();

		foreach(scandir("classes/") AS $class){
			if(!in_array($class,$noShow)){
				array_push($classes,$class);
			}
		}
		foreach(scandir("_config/_install_REMOVED/") AS $class){
			if(!in_array($class,$noShow)){
				require_once("_config/_install_REMOVED/" . $class);
				array_push($classes,$class);
			}
		}
		foreach(scandir("merchants/" . _MERCHANTID_ . "/classes/") AS $class){
			if(!in_array($class,$noShow)){
				require_once("merchants/" . _MERCHANTID_ . "/classes/" . $class);
				array_push($classes,$class);
			}
		}
		foreach(scandir("_config/_settings/") AS $class){
			if(!in_array($class,$noShow)){
				require_once("_config/_settings/" . $class);
				array_push($classes,$class);
			}
		}
		foreach($classes AS $class){
			$class = str_replace(".class.php","",$class);
			$class = str_replace(".install.php","",$class);	
			$class = str_replace(".inc.php","",$class);
			$class = str_replace(_MERCHANTID_ . ".","",$class);

			foreach(get_class_methods($class) AS $method){
				if(!in_array($method,$noShow)){
					array_push($methods,array($class,$method));
				}
			}
		}
		$functions = get_defined_functions();
		foreach($functions["user"] AS $function){
			if(!in_array($function,$noShow)){
				array_push($methods,array("function",$function));
			}
		}

		//adding functions from this page
		$testMethods = get_class_methods(__CLASS__);
		foreach($testMethods AS $method){
			array_push($methods,array("testing",$method));
		}
		
		return $methods;
	}

}
////////////////////////////////////////////////////////////////////
//BEGIN TESTING SCRIPTS
//COMMON SCRIPTS:
	//echo availability::select();
	//echo printQueryBuilder('');
	//echo $_SERVER["PHP_SELF"];
	//echo displayConstants();
	//echo feedFrom::tableFeatBuild("flist",0);
	//echo feedSelect::selectConstruct();
	//echo feedFrom::fromConstruct("");
	//echo printQueryBuilder("");
////////////////////////////////////////////////////////////////////
//merchant functions autoloader information 	


//Checking if this is a demo user 
if($_SESSION["username"] !== "DemoUser" || $_SESSION['perm_level'] == "demo"){

	$test = new testing;

} else {
	echo "<div class=\"container\"><h1 class=\"page-title\">Restricted Page</h1><p class=\"alert-danger alert\">Although this is an actual page, you are not authorized to view its contents.</p></div>";
}
?>

</div><!--FOOTER START -->