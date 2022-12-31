<?php
declare(strict_types=1);
namespace App\Basic;
class basicInfo
{
    public function degree():array
    {
        $data=[1=>'دیپلم', 2=>'فوق دیپلم', 3=> 'لیسانس', 4=> 'فوق لیسانس', 5=> 'دکترا'];
        return $data;
    }
    public function gender():array
    {
        $data=[1=>'مرد', 2=>'زن'];
        return $data;
    }

}
