<?php

namespace App\Model;

use App\Tools\Dbal;
class Model
{
    protected $DB;
    public function __construct()
    {
        $this->DB= (new Dbal())->connect();
    }




}