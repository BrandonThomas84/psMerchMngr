<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class logout{
	public $settings;

	public function logout(){
		$_SESSION = array();
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		setcookie("email", '', time() - 42000);
		session_destroy();

		//releasing any settings that are being stored
		$this->settings = new settings;
		$this->settings->releaseSettings();
	}
}

?>