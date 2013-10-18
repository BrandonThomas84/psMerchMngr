<?php /* FILEVERSION: v1.0.2b */ ?>


<!-- Bootstrap core JavaScript
================================================== -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/holder.js"></script>
<?php

//instantiate  bug submission class
	$bugs = new bugSubmission;

//display bug submission modal code
	echo $bugs->bugModal();

$help = new help;

echo $help->helpModals();
?>

</body>
</html>