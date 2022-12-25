<?php

namespace App\Tools;

class Database extends \PDO
{
    public $db;

    public function __construct()
    {
        $dbhost = DBHOST;
        $dbname = DBNAME;
        $dbuser = DBUSER;
        $dbpass = DBPASS;
        $dbtype = 'mysql';
        parent::__construct($dbtype . ':host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass);
    }
}