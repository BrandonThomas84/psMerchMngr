<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
class update {

	public function getFiles($getType){

		if($getType == "checkUpdate"){
			//setting root dir for checking for updates by removing the filename and folder location of this file name
			$rootdir = str_replace(DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . "update.class.php" ,"", __FILE__);
		} elseif($getType == "applyUpdate"){
			//setting root dir for applying the uploaded update by replacing the folderlocation on this file to the update folder location
			$rootdir = str_replace(DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . "update.class.php" ,DIRECTORY_SEPARATOR . "_config" . DIRECTORY_SEPARATOR . "_update", __FILE__);
		}

		//creating array to be returned
		$files = array();

		//files to ignore
		$ignore = array(".","..",".htaccess","_backup","Thumbs.db","_update");
		
		

		//start directory scan
		$dirs = scandir($rootdir);

		foreach($dirs AS $dir){

			//make sure files are not in ignored array
			if(!in_array($dir,$ignore)){

				//look for files with file extensions
				if(strpos($dir,".") > 0) {
				
					//add php file to array
					array_push($files,array("location"=>$rootdir,"filename"=>$dir));
				
				} else {
				
					//setting new directory to scan
					$l2Dir = $rootdir . DIRECTORY_SEPARATOR . $dir;

					//scan the directory for files
					$l2Dirs = scandir($l2Dir);

					foreach($l2Dirs AS $dir){

						//make sure files are not in ignored array
						if(!in_array($dir,$ignore)){

							//look for files with file extensions
							if(strpos($dir,".") > 0) {

								//add php file to array
								array_push($files,array("location"=>$l2Dir,"filename"=>$dir));
							
							} else {
								//setting new directory to scan
								$l3Dir = $l2Dir . DIRECTORY_SEPARATOR . $dir;

								//scan the directory for files
								$l3Dirs = scandir($l3Dir);

								foreach($l3Dirs AS $dir){

									//make sure files are not in ignored array
									if(!in_array($dir,$ignore)){

										//look for files with file extensions
										if(strpos($dir,".") > 0) {

											//add php file to array
											array_push($files,array("location"=>$l3Dir,"filename"=>$dir));
										} else {
											//setting new directory to scan
											$l4Dir = $l3Dir . DIRECTORY_SEPARATOR . $dir;

											//scan the directory for files
											$l4Dirs = scandir($l4Dir);

											foreach($l4Dirs AS $dir){

												//make sure files are not in ignored array
												if(!in_array($dir,$ignore)){

													//look for files with file extensions
													if(strpos($dir,".") > 0) {

														//add php file to array
														array_push($files,array("location"=>$l4Dir,"filename"=>$dir));
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}		
		}

		//returns file location and filenames
		return $files;
	}
	public function printFileInfo(){
		$fileVersions = new versionControl;
		//get file versions
		$files = $fileVersions->getFileVersionsforUpdate(self::getFiles("checkUpdate"));
		echo "<table>";
		foreach($files AS $file){
			echo "<tr><td>" . $file["name"] . "</td><td>" . $file["location"] ."</td></tr>";//<ul><li>Location: <i>" . $file["location"] . "</i></li><li>Version: <i>" . $file["version"] . "</i></li></ul>";
		}
		echo "</table>";
	}

	public function fileInfoForm(){
		$fileVersions = new versionControl;

		//creating a return array 
		$return = array();

		//creating a map form element that instructs the update server
		$map = array();

		//get file versions
		$files = $fileVersions->getFileVersionsforUpdate(self::getFiles("checkUpdate"));

		//getting each of the file information
		for($i = 0;$i< count($files); $i++){

			//creating a single string with everything in it
			$fileInfo =  $files[$i]["name"] . "~" . $files[$i]["version"];

			//pushing filename to map
			array_push($map,$fileInfo);
			
		}

		//implode map array for insertion into form
		$mapValue = implode(";",$map);

		//pushing map value to return array
		array_push($return,"<input type=\"hidden\" name=\"fieldMap\" value=\"" . $mapValue . "\">");

		//pushing random name for zip file
		array_push($return,"<input type=\"hidden\" name=\"zipFileName\" value=\"" . md5(uniqid(rand(), true)) . "\">");

		return implode("",$return);
	}
	public function applyUpdate(){
		$filesUpdated = array();

		//checking if file has been submitted
		if(isset($_FILES["updateFile"])){

			//checking for errors on upload
			if ($_FILES["updateFile"]["error"] > 0){
			
				//return error to user
			  	return messageReporting::insertMessage("error","Update File Error: " . $_FILES["updateFile"]["error"]);
			
			} else {

				//setting temp array of file name attr
				$temp = explode(".", $_FILES["updateFile"]["name"]);

				//file exntention
				$extension = end($temp);

				if($extension == "zip"){

					//setting new zip location and filename variable 
					$newZip = "_config" . DIRECTORY_SEPARATOR . "_update" . DIRECTORY_SEPARATOR . "" . $_FILES["updateFile"]["name"];

					//moving zip file to the update folder
					move_uploaded_file($_FILES["updateFile"]["tmp_name"],$newZip);
				
					//instantiating new zip class
					$zip = new ZipArchive;
			
					//checking that file can be opened
					if($zip->open($newZip) === TRUE){
						//extract to the update folder
	    				$zip->extractTo("_config" . DIRECTORY_SEPARATOR . "_update" . DIRECTORY_SEPARATOR);
	    			}

	    			//closeing zip file so it can be removed
	    			$zip->close();

	    			//deleteing zip file
	    			unlink($newZip);

	    			//get file versions
					$files = self::getFiles("applyUpdate");

					foreach($files AS $file){

						//setting the new fole variable
						$newFile = $file["location"] . DIRECTORY_SEPARATOR . $file["filename"];

						//variable for removing the folder location from the filename string
						$replace = DIRECTORY_SEPARATOR . "_config" . DIRECTORY_SEPARATOR . "_update";

						//setting old file variable
						$oldFile = str_replace($replace,"",$newFile);

						//backup file with location
						$backup = str_replace(".php",".bak.php", $newFile);
						$backup = str_replace(".css",".bak.css", $backup);
						$backup = str_replace(".txt",".bak.txt", $backup);
						$backup = str_replace("_update","_backup", $backup);

						//backup file name only
						$backupFileName = str_replace(".php",".bak.php", $file["filename"]);
						$backupFileName = str_replace(".css",".bak.css", $backupFileName);
						$backupFileName = str_replace(".txt",".bak.txt", $backupFileName);
						$backupFileName = str_replace("_update","_backup", $backupFileName);

						//checking if a folder exists for the backup
						if (!file_exists(str_replace($backupFileName,"",$backup))) {
    						mkdir(str_replace($backupFileName,"",$backup), 0777, true);
						}
						//copying original file to backup folder
						copy($oldFile,$backup);

						//overwriting old file with new file
						rename($newFile,$oldFile);

						array_push($filesUpdated,$file["filename"] . "<br>");
					}
					
					return messageReporting::insertMessage("success","Successfully updated the following files:<br>" . implode("",$filesUpdated));

	    		} else {

	    			//wrong filetype error
	    			return messageReporting::insertMessage("error","Wrong file type. You may only upload zip files.");
	    		}
			}
		}
	}
}
?>