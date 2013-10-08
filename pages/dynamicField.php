<?php /* FILEVERSION: v1.0.1b */ ?>
<?php

$classes = scandir("merchants/" . _MERCHANTID_ . "/classes");
for($i=2;$i<=(count($classes)-1);$i++){
	require("merchants/" . _MERCHANTID_ . "/classes/" . $classes[$i]);
}

new dynamicField;

?>

</div><!--FOOTER START -->