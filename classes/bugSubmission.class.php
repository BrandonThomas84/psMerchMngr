<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class bugSubmission {

	public function bugSubmission(){
		if(isset($_POST["bugMessage"])){
			echo self::sendMessage();
		}
	}
	
	public function bugModal(){
		return "
		<div id=\"bugModal\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"bugModalLabel\" aria-hidden=\"true\">
		  <div class=\"modal-header\">
		    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
		    <h3 id=\"bugModalLabel\">Bug Submission</h3>
		  </div>
		  <div class=\"modal-body\">
			  <form action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">
				<div class=\"form-group\">
					<label for=\"page\">Current Page</label><br>
					<input class=\"form-control required\" type=\"text\" name=\"bugPage\" value=\"" . $_SERVER["REQUEST_URI"] . "\">
				</div>
				<div class=\"form-group\">
					<label for=\"bugMessage\">Message Body</label><br>
					<textarea class=\"form-control required\" name=\"bugMessage\" required=\"required\"></textarea><br>
				</div>
		  </div>
		  <div class=\"modal-footer\">
		    <input class=\"btn btn-danger\" type=\"submit\" value=\"Submit Bug Report\">
		    </form>
		  </div>
		  <div class=\"clearfix\"></div>
		</div>";
	}

	public function sendMessage(){
		$to = "bugs@perspektivedesigns.com";
		$subject = "Bug Submission";
		$page = "Bug Occured On Page: " . $_POST["bugPage"] . "\r\n\n";
		$message = "Message Start:\r\n" . $_POST["bugMessage"];
		$headers = "From: " . $_SESSION['email'] . "\r\n" . "Reply-To: " . $_SESSION['email'] . "\r\n" . "X-Mailer: PHP/" . phpversion();
		$error = print_r(error_get_last());

		$phpInfo = "\r\n\n\r\n\n PHP INFO: \r\n\n PHP_SELF: " . @self::functionSet($_SERVER["PHP_SELF"]) . "\r\n" . 
			"GATEWAY_INTERFACE: " . @self::functionSet($_SERVER["GATEWAY_INTERFACE"]) . "\r\n" . 
			"SERVER_ADDR: " . @self::functionSet($_SERVER["SERVER_ADDR"]) . "\r\n" . 
			"SERVER_NAME: " . @self::functionSet($_SERVER["SERVER_NAME"]) . "\r\n" . 
			"SERVER_SOFTWARE: " . @self::functionSet($_SERVER["SERVER_SOFTWARE"]) . "\r\n" . 
			"SERVER_PROTOCOL: " . @self::functionSet($_SERVER["SERVER_PROTOCOL"]) . "\r\n" . 
			"REQUEST_METHOD: " . @self::functionSet($_SERVER["REQUEST_METHOD"]) . "\r\n" . 
			"REQUEST_TIME: " . @self::functionSet($_SERVER["REQUEST_TIME"]) . "\r\n" . 
			"REQUEST_TIME_FLOAT: " . @self::functionSet($_SERVER["REQUEST_TIME_FLOAT"]) . "\r\n" . 
			"QUERY_STRING: " . @self::functionSet($_SERVER["QUERY_STRING"]) . "\r\n" . 
			"DOCUMENT_ROOT: " . @self::functionSet($_SERVER["DOCUMENT_ROOT"]) . "\r\n" . 
			"HTTP_ACCEPT: " . @self::functionSet($_SERVER["HTTP_ACCEPT"]) . "\r\n" . 
			"HTTP_ACCEPT_CHARSET: " . @self::functionSet($_SERVER["HTTP_ACCEPT_CHARSET"]) . "\r\n" . 
			"HTTP_ACCEPT_ENCODING: " . @self::functionSet($_SERVER["HTTP_ACCEPT_ENCODING"]) . "\r\n" . 
			"HTTP_ACCEPT_LANGUAGE: " . @self::functionSet($_SERVER["HTTP_ACCEPT_LANGUAGE"]) . "\r\n" . 
			"HTTP_CONNECTION: " . @self::functionSet($_SERVER["HTTP_CONNECTION"]) . "\r\n" . 
			"HTTP_HOST: " . @self::functionSet($_SERVER["HTTP_HOST"]) . "\r\n" . 
			"HTTP_REFERER: " . @self::functionSet($_SERVER["HTTP_REFERER"]) . "\r\n" . 
			"HTTP_USER_AGENT: " . @self::functionSet($_SERVER["HTTP_USER_AGENT"]) . "\r\n" . 
			"HTTPS: " . @self::functionSet($_SERVER["HTTPS"]) . "\r\n" . 
			"REMOTE_ADDR: " . @self::functionSet($_SERVER["REMOTE_ADDR"]) . "\r\n" . 
			"REMOTE_HOST: " . @self::functionSet($_SERVER["REMOTE_HOST"]) . "\r\n" . 
			"REMOTE_PORT: " . @self::functionSet($_SERVER["REMOTE_PORT"]) . "\r\n" . 
			"REMOTE_USER: " . @self::functionSet($_SERVER["REMOTE_USER"]) . "\r\n" . 
			"REDIRECT_REMOTE_USER: " . @self::functionSet($_SERVER["REDIRECT_REMOTE_USER"]) . "\r\n" . 
			"SCRIPT_FILENAME: " . @self::functionSet($_SERVER["SCRIPT_FILENAME"]) . "\r\n" . 
			"SERVER_ADMIN: " . @self::functionSet($_SERVER["SERVER_ADMIN"]) . "\r\n" . 
			"SERVER_PORT: " . @self::functionSet($_SERVER["SERVER_PORT"]) . "\r\n" . 
			"SERVER_SIGNATURE: " . @self::functionSet($_SERVER["SERVER_SIGNATURE"]) . "\r\n" . 
			"PATH_TRANSLATED: " . @self::functionSet($_SERVER["PATH_TRANSLATED"]) . "\r\n" . 
			"SCRIPT_NAME: " . @self::functionSet($_SERVER["SCRIPT_NAME"]) . "\r\n" . 
			"REQUEST_URI: " . @self::functionSet($_SERVER["REQUEST_URI"]) . "\r\n" . 
			"PHP_AUTH_DIGEST: " . @self::functionSet($_SERVER["PHP_AUTH_DIGEST"]) . "\r\n" . 
			"PHP_AUTH_USER: " . @self::functionSet($_SERVER["PHP_AUTH_USER"]) . "\r\n" . 
			"PHP_AUTH_PW: " . @self::functionSet($_SERVER["PHP_AUTH_PW"]) . "\r\n" . 
			"AUTH_TYPE: " . @self::functionSet($_SERVER["AUTH_TYPE"]) . "\r\n" . 
			"PATH_INFO: " . @self::functionSet($_SERVER["PATH_INFO"]) . "\r\n" . 
			"ORIG_PATH_INFO: " . @self::functionSet($_SERVER["ORIG_PATH_INFO"]) ."\r\n";
		
		$message = $subject . "\r\n" . $page . "\r\n" . $error . "\r\n" . $message . "\r\n" . $phpInfo;
		
		//server sends email containing bug report information
		$mail = mail($to, $subject, $message, $headers);
		if(!$mail){
			messageReporting::insertMessage("error","There was a problem with your submission please check your server SMTP settings.");
		} else {
			messageReporting::insertMessage("success","You have successfully submitted a bug report");
		}
	}

	private function functionSet($function){
		if(isset($function)){
			return $function;
		} else {
			return "Server function not set";
		}
	}
}

?>