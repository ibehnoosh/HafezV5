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



    function selectOption(array $data, string $selected): string
    {
        $out='';
        foreach ($data as $key => $value)
        {
            ($key == $selected) ? $out.='<option value="'.$key.'" serlected>'.$value.'</option>' : $out.='<option value="'.$key.'">'.$value.'</option>' ;
        }
        return $out;
    }
}