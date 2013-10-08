<?php /* FILEVERSION: v1.0.1b */ ?>
<?php
//default functions for Google
class default_functions{
    public $friendlyName;
    public $dbName;
    public $siteID;

    //setting variables used during site session
    public function default_functions(){
        $this->friendlyName = "Google";
        $this->dbName = "google";
        $this->siteID = "gpf";
    } 
	public static function standardTables(){
        $a = array(
                array("Cur",""),
                array("A",""),
                array("B",""),
                array("C",""),
                array("D",""),
                array("E",""),
                array("F","")                
            );
        return $a;
    }
    public static function imgTables(){
        $a = array(
                array("Imgs",10)
            );
        return $a;
    }
    public static function featTables(){
        $a = array(
                array("Feat","adult"),
                array("Feat","gender")
            );
        return $a;
    }

    //function to return ALL built tables needed for merchant queries.
    public static function allTables(){
        $a = array();

        foreach (self::standardTables() as $v) {
            array_push($a,$v);
        }
        foreach (self::imgTables() as $v) {
            array_push($a,$v);
        }
        foreach (self::featTables() as $v) {
            array_push($a,$v);
        }

        return $a;
    }
}
?>