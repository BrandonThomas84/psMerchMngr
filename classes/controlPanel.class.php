<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class controlPanel extends settings {
	public static $mysqli;
	public static $user_id;
	public static $username;
	public static $db_password;
	public static $salt;
	public static $perm_level;
	public $settings;
	public $update;

	public function __construct(){
		self::$mysqli = new mysqli(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_);
		if (!self::$mysqli){die("Could not connect to MySQLi: " . mysql_error());}
		self::controlPanelPageLoad();

		//instantiating new update class
		$this->update = new update;
		
		//checking for update submissions
		$this->update->applyUpdate();
	}
	
	public function controlPanelPageLoad(){
		self::getCurrentUserInfo($_SESSION['email']);
		self::checkSubmit();
		self::getCurrentUserInfo($_SESSION['email']);
	}
	public function getCurrentUserInfo($email){
		$stmt = self::$mysqli->prepare("SELECT id, username, password, salt, perm_level FROM `" . _DB_NAME_ . "`.`mc_members` WHERE email = ?;");
		$stmt->bind_param('s', $email);
		$stmt->execute(); 
		$stmt->store_result();
		$stmt->bind_result($user_id, $username, $db_password, $salt, $perm_level);
		$stmt->fetch();
		self::$user_id = $user_id;
		self::$username = $username;
		self::$db_password = $db_password;
		self::$salt = $salt;
		self::$perm_level = $perm_level;

	}
	public function checkSubmit(){
		if(isset($_POST["curUser"])){ self::curUserSubmit(); }
		if(isset($_POST["newUser"])){ self::newUserSubmit(); }
	}
	public static function curUserSubmit(){

		//START DEMO USER CHECK
		if(self::$perm_level == "demo"){
			messageReporting::insertMessage("success","Yay! It worked, well not really. You're in a demo, cool guy. You didnt really expect to be able to update this, did you?");
		} else {
		//START DEMO USER CHECK

		if($_POST["existingUserPass"] !== $_POST["existingUserPassConfrim"]){ 
			messageReporting::insertMessage("error","Passwords do not match");
		} else {
			if($_POST['existingUserPermLevel'] !== "admin"){
				messageReporting::insertMessage("error","Sorry " . $_POST['existingUserName'] . " you do not have access to edit this.");
			} else {
				
				$username = $_POST['existingUserName'];
				$email = $_POST['existingUserEmail'];
				$password = $_POST['existingUserPass']; 
				$password = hash('sha512', $password.self::$salt);

				if ($update_stmt = self::$mysqli->prepare("UPDATE `" . _DB_NAME_ . "`.`mc_members` SET username = ?, email = ?, password = ? WHERE email = ?")) {    
				   $update_stmt->bind_param('ssss', $username, $email, $password, $_SESSION['email']); 
				   $update_stmt->execute() or die(mysqli_error(self::$mysqli));
				   messageReporting::insertMessage("success","$username successfully updated");
				} else { 
					messageReporting::insertMessage("error","Could not update user $username.");
				}
			}
		}	

		//END DEMO USER CHECK
		} 
		//END DEMO USER CHECK
	}
	public static function newUserSubmit(){

		if(self::$perm_level == "demo"){
			new checkDemo;
		} else {

			if($_POST["newUserPass"] !== $_POST["newUserPassConfrim"]){ 
				messageReporting::insertMessage("error","Passwords do not match");
			} else {
				$password = $_POST['newUserPass']; 
				// Create a random salt
				$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
				// Create salted password (Careful not to over season)
				$password = hash('sha512', $password.$random_salt);
				$username = $_POST['newUserName'];
				$permLevel = $_POST['newUserPermLevel'];
				$email = $_POST['newUserEmail'];

				if ($insert_stmt = self::$mysqli->prepare("INSERT INTO `" . _DB_NAME_ . "`.`mc_members` (username, email, password, salt, perm_level) VALUES (?, ?, ?, ?, ?)")) {    
				   	$insert_stmt->bind_param('sssss', $username, $email, $password, $random_salt, $permLevel); 
				   	// Execute the prepared query.
				   	$insert_stmt->execute() or die(mysqli_error(self::$mysqli));
				   	messageReporting::insertMessage("success","New user ($username) successfully created");
				} else { 
					messageReporting::insertMessage("error","Could not add user.");
				}
			}

		} 
	}
}

?>