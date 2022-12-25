<?php
require('mylogin.php');
$loginSys = new login();
if(!$loginSys->isLoggedInPerson())
{
	header("Location: login.php");
	die();
	exit;
}



?>