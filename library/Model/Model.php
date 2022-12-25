<?php

namespace App\Model;

use App\Tools\Database;
class Model
{
    protected $DB;
    public function __construct()
    {
        $this->DB= new Database();
    }
}