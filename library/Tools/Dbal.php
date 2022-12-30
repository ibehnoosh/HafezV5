<?php

namespace App\Tools;
use Doctrine\DBAL\DriverManager;

class Dbal
{
    public function connect()
    {
        $connectionParams = [
            'dbname' => DBNAME,
            'user' => DBUSER,
            'password' => DBPASS,
            'host' => DBHOST,
            'driver' => 'pdo_mysql',
            'port'=> '3008'
        ];
        $conn = DriverManager::getConnection($connectionParams);
        return $conn;
    }

}



