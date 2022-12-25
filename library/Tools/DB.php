<?php

namespace App\Tools;
class DB
{

    public \PDO $pdo;
    public static $instance = null;

    public static function getInstance(): Database
    {
        if(self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function __construct() {
        $config = [
            'dsn' => $_ENV['DBHOST'],
            'username' => $_ENV['DBUSER'],
            'password' => $_ENV['DBPASS'],
        ];
        $this->connect($config);
    }

    public function connect(array $config) {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new  \PDO($dsn, $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

}