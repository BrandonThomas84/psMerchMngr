<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

class dynamicField {
	
	//field info properties
	public $name;		//The name of the column
	public $orgname;	//Original column name if an alias was specified
	public $table;		//The name of the table this field belongs to (if not calculated)
	public $orgtable;	//Original table name if an alias was specified
	public $def;		//Reserved for default value, currently always ""
	public $db;			//Database (since PHP 5.3.6)
	public $catalog;	//The catalog name, always "def" (since PHP 5.3.6)
	public $max_length;	//The maximum width of the field for the result set.
	public $length;		//The width of the field, as specified in the table definition.
	public $charsetnr;	//The character set number for the field.
	public $flags;		//An integer representing the bit-flags for the field.
	public $type;		//The data type used for this field
	public $decimals;	//The number of decimals used (for integer fields)
	
	public function __construct(){
		$sql = "SELECT * " . feedFrom::fromConstruct("base") . reportQueryWhere() . " LIMIT 0,1";
		$query = mysql_query($sql);
		
		echo "
		<div class=\"page-header\">
			<h1>Dynamic Field Linking</h1>
		</div>
		<div class=\"clearfix spacer\"></div>
		<div class=\"panel col-sm-12\">
			<div class=\"col-sm-3\">
				<label class=\"form-label\">Database Table</label>
			</div>
			<div class=\"col-sm-3 col-sm-offset-1\">
				<label class=\"form-label\">Database Column</label>
			</div>
			<div class=\"col-sm-4 col-sm-offset-1\">
				<label class=\"form-label\">Action</label>
			</div>
			<div class=\"clearfix\"></div>
		</div>
		<div class=\"clearfix\"></div>";

		while ($finfo = mysql_fetch_field($query)) {
			echo "
			<div class=\"panel col-sm-12\">
				<form action=\"index.php?f=" . _MERCH_ . "&fieldID=" . $_GET["fieldID"] . "&act=dtbs\" method=\"POST\" class=\"form\" name=\"" . $finfo->table . $finfo->name . "_Mapping\">
					
						<input type=\"text\" class=\"col-sm-3\" value =\"" . tableLettertoFriendly($finfo->table) . "\" name=\"showTable\" disabled>
						<input type=\"text\" class=\"col-sm-3 col-sm-offset-1\" value =\"" . $finfo->name . "\" name=\"showfieldName\" disabled>

						<input type=\"hidden\" value =\"TRUE\" name=\"updateDynamic\">
						<input type=\"hidden\" value =\"" . $finfo->table . "\" name=\"table_name\">
						<input type=\"hidden\" value =\"" . $finfo->name . "\" name=\"database_field_name\">

						<input type=\"hidden\" value =\"" . $_GET["fieldID"] . "\" name=\"id\">

						<input type=\"submit\" class=\"btn btn-success col-sm-4 col-sm-offset-1\" value=\"Associate Field\">
				</form>
				<div class=\"clearfix\"></div>
			</div>
			<div class=\"clearfix\"></div>";
		}

		echo "<div class=\"clearfix\"></div>";
	}
}

?>