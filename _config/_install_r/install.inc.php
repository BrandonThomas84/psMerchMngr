<?php /* FILEVERSION: v1.0.2b */ ?>
<?php
function __autoload($classname) {
	$file = $classname . '.install.php';
    @include_once($file);
}

class install {
	public $version;
	public $installComplete;
	public $tables = array("mc_cattax_mapping","mc_exclusion","mc_login_attempts","mc_members","mc_select_config","mc_taxonomy","mc_overrides");

	public function __construct(){
		if(isset($_POST["message"])){messageReporting::insertMessage("warning",$_POST["message"]);}
		self::startInstall();

		$this->version = "v1.0.2b";
	}

	public function startInstall(){
		if(!isset($_GET["step"])){
			$this->step = 1;
		} else {$this->step = $_GET["step"];}

		$stepComplete = false;

		if($this->step == 1){
			$stepComplete = false;
			self::tableCheckForFormSubmit();
			if(self::checkTablesExist() == 0){
				$this->step = 2;
				$stepComplete = true;
			}
			if($stepComplete == false){
				//create title area
				echo self::displayTableInstall();
				echo self::displayStepNav($stepComplete);
			}
		}

		if($this->step == 2){
			$stepComplete = false;
			self::userCheckForFormSubmit();
			if(self::userExists() == true){
				$this->step = 3;
				$stepComplete = true;
			} 
			if($stepComplete == false){
				echo $this->requestFirstUser();
				echo self::displayStepNav($stepComplete);
			}
		} 
		
		if($this->step == 3){
			$stepComplete = false;
			$this->createFirstFeed();
			echo self::deleteFolderInstructions();		
		}		
	}
	protected function displayStepNav($stepComplete){
		if($this->step > 1){
			$prev = "<a href=\"index.php?step=" . (($this->step)-1) . "\" class=\"col-md-5  btn btn-default \">Previous Step</a>";
		}  else {$prev = "<a href=\"\" class=\"invisible col-md-5 btn btn-default\"></a>";}
		
		if($stepComplete == false){$next = "";} else {$next = "<a href=\"index.php?step=" . (($this->step)+1) . "\" class=\"col-md-5 col-md-offset-1 btn btn-default\">Next Step</a>";}
				
		return "<div class=\"col-md-12\">" . $prev . $next . "<div class=\"clearfix\"></div></div><div class=\"clearfix spacer\"></div>";
	}
	private function rowsInTable($table){
		$sql = "SELECT * FROM `" . _DB_NAME_ . "`.`" . $table . "`";
		$query = mysql_query($sql);
		return @mysql_num_rows($query);
	}
	private function checkTablesExist(){
		$t = 0;
		foreach($this->tables AS $table){
			$sql = "DESCRIBE `" . _DB_NAME_ . "`.`" . $table . "`";
			$query = mysql_query($sql);
			if(!$query){$t++;}
			
			if(self::minimumValues($table) !== 0){
				$numRows = self::rowsInTable($table);
				if($numRows < self::minimumValues($table)){$t++;}
			}
		}
		return $t;
	}
	private function tableCheckForFormSubmit(){
		if(isset($_POST["installTable"])){
			$table = $_POST["installTable"];
			$table = new $table;
			$version = $_POST["installVersion"];
			
			if($version == "create"){
				$drop = mysql_query($table->drop());
				$create = mysql_query($table->create());
				if(!$create){//check for errors in table create
					messageReporting::insertMessage("error","There was an error installing " . mysql_error());
				} else { $version = "populate";	}
			}

			if($version == "populate"){
				if($table->populate() !== "no values"){
					$populate = mysql_query($table->populate());
					if(!$populate){	//check for errors during insert
						messageReporting::insertMessage("error","There was an error populating " . mysql_error());
					}
				}
			}
		}
	}
	public function displayTableInstall(){
		$tables = $this->tables;
		$a = array();
		
		echo "<div class=\"col-sm-3 panel panel-default\">Status</div>
				<div class=\"col-sm-3 col-sm-offset-1 panel panel-default\">Table Name</div>
				<div class=\"col-sm-3 col-sm-offset-1 panel panel-default\">Status Message</div>
				<div class=\"clearfix\"></div>";

		foreach($tables as $table){
			$sql = "SELECT * FROM `" . _DB_NAME_ . "`.`" . $table . "`";
			$query = mysql_query($sql);
			
			//check to make sure table exists
			$check = strpos(mysql_error(), "doesn't exist");
			if($check > 1){
				//return create row
				echo self::tableInstallForm($table,"create");
			} else {
				//check if all minimum values are present
				$numRows = mysql_num_rows($query);
				
				if($numRows < self::minimumValues($table)){
					//return populate row
					echo self::tableInstallForm($table,"populate");
				} else {
					//if table installed and all values present return installed success row
					echo self::tableInstalled($table);
				}
			}
		}			
	}
	private function minimumValues($table){
		//set minimum number of rows that should be in table to verify all contents have been inserted
		if($table == "mc_select_config"){return 36;} elseif($table == "mc_taxonomy"){return 5665;} else {return 0;}
	}
	private function tableInstallForm($table,$version){
		if($version == "populate"){
			$style = "warning";
			$img = "pop.png";
			$message = "<p class=\"alert alert-warning wrapit\">MISSING VALUES<br>Table exists but not all the values are present.<br>There are currently <strong class=\"alert-danger\">" . self::rowsInTable($table) . "</strong> rows in this table. While <strong class=\"alert-danger\">" . self::minimumValues($table). "</strong> should exist.</p>";
			$button = "warning";
			$help = $table::populate();
			$helpI = "Some server settings do not allow you to populate this much data from your website. You can use your preferred SQL interface, such as phpMyAdmin, to manually populate this table.";
		} else {
			$style = "danger";
			$img = "install.png";
			$message = "<p class=\"alert alert-danger wrapit\">MISSING TABLE<br>Table does not exist in your database " . @mysql_error() . "</p>";
			$button = "success";
			$help = $table::create();
			$helpI = "Some server settings do not allow you to create tables directly from your website. You can use your preferred SQL interface, such as phpMyAdmin, to manually create this table.";
		}

		return "
		<div class=\"col-md-12 panel panel-default tableInstall\">
			<div class=\"clearfix spacer\"></div>
			<div class=\"col-md-3 " . $style . " img\">
				<img src=\"_config/_install/img/" . $img . "\">
			</div>
			<div class=\"col-md-3 col-md-offset-1 " . $style . "\">
				<p class=\"alert alert-" . $style . "\">" . $table . "</p>
			</div>
			<div class=\"col-md-3 col-md-offset-1 " . $style . "\">"
			  	 . $message . "
				<form name=\"" . $table . "Install\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"POST\">
					<input type=\"submit\" class=\"btn btn-" . $button . " col-md-10 col-md-offset-1\" name=\"install\" value=\"" . $version . " Table\">
					<input type=\"hidden\" name=\"installTable\" value=\"" . $table . "\">
					<input type=\"hidden\" name=\"installVersion\" value=\"" . $version . "\">
				</form>
			</div>
			<div class=\"clearfix\"></div>
			<div class=\"col-lg-12\">
				<form action=\"_config/output.php\"  method=\"POST\" name=\"" . $table. " help\" target=\"_BLANK\">
					<input type=\"hidden\" value=\"" . $helpI . "\" name=\"helpInstructions\">
					<input type=\"hidden\" value=\"" . $help . "\" name=\"helpBody\">
					<input type=\"submit\" class=\"btn-info\" value=\"?\">
				</form>
			</div>
			<div class=\"clearfix\"></div><br>
		</div>";
	}
	private function tableInstalled($table){
		return "
		<div class=\"col-md-12 panel panel-default tableInstall\">
			<div class=\"clearfix spacer\"></div>
			<div class=\"col-md-3 img\">
				<img src=\"_config/_install/img/success.png\">
			</div>
			<div class=\"col-md-3 col-md-offset-1\">
				<p class=\"alert alert-info\">" . $table . " </p>
			</div>
			<div class=\"col-md-3 col-md-offset-1\">
				<p class=\"alert alert-info\">INSTALLED</p>
			</div>
			<div class=\"clearfix\"></div><br>
		</div>";
	}
	private function requestFirstUser(){
		return "
			<div class=\"clearfix spacer\">
				<div class=\"col-sm-10 col-sm-offset-1\">
					<div class=\"col-lg-12 panel-default panel\">
						<h2 class=\"panel-heading\">Create Admin User</h2>
					
						<form class=\"form\" method=\"POST\" action=\"index.php?step=2\"><br>
							<input type=\"hidden\" name=\"step\" value=\"2\">
							<div class=\"col-sm-6\">
								<label class=\"form-label\">Email</label>
							</div>
							<div class=\"col-sm-6\">
								<input class=\"form-control\" type=\"text\" name=\"email\" REQUIRED>
							</div>
							<div class=\"clearfix\"></div><br>
							<div class=\"col-sm-6\">
								<label class=\"form-label\">First Name</label>
							</div>
							<div class=\"col-sm-6\">
								<input class=\"form-control\" type=\"text\" name=\"username\" REQUIRED>
							</div>
							<div class=\"clearfix\"></div><br>
							<div class=\"col-sm-6\">
								<label class=\"form-label\">Password</label>
							</div>
							<div class=\"col-sm-6\">
								<input class=\"form-control\" type=\"password\" name=\"password\" REQUIRED>
							</div>
							<div class=\"clearfix\"></div><br>
							<div class=\"col-sm-6\">
								<label class=\"form-label\">Password Verify</label>
							</div>
							<div class=\"col-sm-6\">
								<input class=\"form-control\" type=\"password\" name=\"password2\" REQUIRED>
							</div>
							<div class=\"clearfix\"></div><br>
							<div class=\"col-sm-12 col-offset-1\">
								<input class=\"form-control btn btn-success\" type=\"submit\" name=\"createUser\" value=\"Create Admin User\">
							</div>
							<div class=\"clearfix\"></div><br>
						</form>
					</div>
				</div>
			</div>";
	}
	private function userCheckForFormSubmit(){
		if(isset($_POST["createUser"])){
			if($_POST["password"] !== $_POST["password2"]){
				messageReporting::insertMessage("error","The two passwords you entered do not match. Please try again.");
			} else {self::insertFirstUser();}
		}
	}
	private function userExists(){
	  $sql = "SELECT DISTINCT `email` FROM `" . _DB_NAME_ . "`.`mc_members`";
	  $query = mysql_query($sql);
	  if(mysql_num_rows($query) > 0){
	    return true;
	  }
	}
	private function insertFirstUser() {
		$mysqli = new mysqli(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_);
		$password = $_POST['password'];
		// Create a random salt
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		// Create salted password (Careful not to over season)
		$password = hash('sha512', $password.$random_salt);
		$username = $_POST['username'];
		$email = $_POST['email'];
		$perm_level = 'admin';
		if ($insert_stmt = $mysqli->prepare("INSERT INTO `" . _DB_NAME_ . "`.`mc_members` (username, email, password, salt, perm_level) VALUES (?, ?, ?, ?, ?)")) {    
		   $insert_stmt->bind_param('sssss', $username, $email, $password, $random_salt, $perm_level); 
		   // Execute the prepared query.
		   $insert_stmt->execute() or messageReporting::insertMessage("error",mysqli_error($mysqli));
		   messageReporting::insertMessage("success","New user ($username) successfully created");
		} else { messageReporting::insertMessage("error","Unable to add user.");}
	}
	public function getLocation(){
		$fullpath = $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"];
		$a = explode("/",$fullpath);
		$max = (count($a)-1);
		$aNew = array();

		for($i=0;$i<$max;$i++){
			$val = $a[$i];
			array_push($aNew,$val);
		}

		return "http://" . implode("/", $aNew);
	}
	private function createFirstFeed(){
		$file = fopen("submissions/google_feed.txt", "w+");
		fclose($file);
		$this->installComplete = true;
	}
	private function deleteFolderInstructions(){
		if($this->installComplete == true){
			return "
			<div class=\"clearfix spacer\">
			<div class=\"alert-success panel col-md-10 col-md-offset-1\">
				<h2 class=\"panel-body\">Congratulations!</h2>
				<h3 class=\"panel-body\">You have successfully completed the install process. In order to use your newly configured merchant manager you will need to delete the installation folder (server location listed below). This will help to maintain your security.</h4>
				<hr>
				<h4 class=\"text-info panel-body\"><strong class=\"text-danger\">Server Location: </strong> <i>" . $_SERVER["DOCUMENT_ROOT"] . "/_config/_install</i></h5>
			</div>";
		}
	}
}

//parent class for all subsequent tables
class tableInstall {
	//dummy method
	public static function populate(){
		return "no values";
	}
	public static function drop(){
		return "DROP TABLE IF EXISTS `" . _DB_NAME_ . "`.`" . __CLASS__ . "`;";
	}
}

?>
<style>
.tableInstall .img {
	text-align: center;
}
.tableInstall .img img{
	max-width: 100px;
	max-height: 100px;
}
.merchant-functions .panel {
	padding: 0;
}
.wrapit {
    overflow-wrap: break-word;
}
</style>
<div class="clearfix spacer"></div>
<div class="merchant-functions col-sm-10 col-sm-offset-1">
	<div class="panel panel-info">
		<h1 class="panel-heading">Merchant Manager Installation</h2>
		<div class="col-sm-12">
			
			<?php new install; ?>
					
		</div>
		<div class="clearfix"></div>	
	</div>
	<div class="clearfix"></div>
</div>
