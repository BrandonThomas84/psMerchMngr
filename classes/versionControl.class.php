<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class versionControl{

	public function getFileVersionsforUpdate($fileArray){
		//setting return array
		$return = array();

		foreach($fileArray as $file){
			//set file name and location
			$name = $file["filename"];
			$location = $file["location"];
			$filename = $location . DIRECTORY_SEPARATOR . $name;

			//open file for reading
			$file = fopen($filename,"r");

			//if php file
			if(strpos($name,".php") !== false){
				
				//look for the 22nd character
				fseek($file,22);
				
				//read 7 characters
				$fileVersion = fread($file,7);

				//add to return array
				array_push($return,array("location"=>$location,"name"=>$name,"version"=>$fileVersion));

			  //if css file
			} elseif(strpos($name,".css") !== false){
				
				//look for the 22nd character
				fseek($file,21);

				//read 7 characters
				$fileVersion = fread($file,7);

				//add to return array
				array_push($return,array("location"=>$location,"name"=>$name,"version"=>$fileVersion));
			}
			
		} 
		return $return;
	}
	
}

?>