<?php /* FILEVERSION: v1.0.2b */ ?>
<?php

$settings = new settings;

if(isset($_POST["updateCore"])){
	$settings->coreSubmissionUpdate();
	header('Location: index.php?p=cpnl');
}
?>
<!doctype html>
<html><head>

<title>Merchant Center Manager</title>
<meta charset="utf-8">
<meta name="description" content="Merchant Manager - Easily create feeds for the webs top shopping engines" />
<meta name="author" content="Brandon Thomas">
<meta name="robots" content="NOINDEX,NOFOLLOW"/>
<!-- Bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/merch-mngr-responsive.css" rel="stylesheet">
<link href="css/merch-mngr.css" rel="stylesheet">
<link href="css/merch-mngr-theme.css" rel="stylesheet">
<!--linking font package-->
<link href='css/raleway.css' rel='stylesheet' type='text/css'>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="../../assets/js/html5shiv.js"></script>
  <script src="../../assets/js/respond.min.js"></script>
<![endif]-->
<style id="holderjs-style" type="text/css">.holderjs-fluid {font-size:16px;font-weight:bold;text-align:center;font-family:sans-serif;margin:0}</style>
</head>