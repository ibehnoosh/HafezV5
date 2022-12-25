<?php
require('mylogin_mas.php');
$loginSys = new login_mas();
if(!$loginSys->isLoggedInStudent())
{
	header("Location: login.php");
	die();
	exit;
}



?>