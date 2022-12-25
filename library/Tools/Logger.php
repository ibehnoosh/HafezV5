<?php
namespace App\Tools;

class logger
{
	function add($who , $operation , $what , $details , $key=0)
	{
		$details=str_replace("'","",$details);
		$sql_in="INSERT INTO `logg` (`id`, `who`, `operation`, `what`, `details`,`key`, `date`) VALUES
		(NULL, '".$who."', '".$operation."', '".$what."', '".$details."','".$key."', NOW());";
		
		mysql_query($sql_in);
	}
	
}
?>