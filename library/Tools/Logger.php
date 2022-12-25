<?php
namespace App\Tools;

class Logger
{
    private $DB;
    public function __construct()
    {
        $this->DB= new Database();
    }

	function add(int $who , string $operation ,string $what ,string $details , $key=0) : void
	{
		$details=str_replace("'","",$details);
		$stmt=$this->DB->prepare("INSERT INTO `logg` (`id`, `who`, `operation`, `what`, `details`,`key`, `date`) 
                                        VALUES (NULL, ?,?,?,?,?,NOW())");
        $stmt->execute ([$who,$operation,$what,$details,$key]);
	}
	
}
?>