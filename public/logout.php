<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	$_SESSION["name"] = null;
	$_SESSION["usn"] = null;
	redirect_to("login.php");
?>