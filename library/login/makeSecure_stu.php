<?php
require('mylogin_stu.php');
$loginSys = new login_stu();
if(!$loginSys->isLoggedInStudent())
{
	header("Location: login.php");
	die();
	exit;
}



?>