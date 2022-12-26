<?php
declare(strict_types=1);
namespace App\Enums;
enum educationStatus: int
{
    case diploma = 1;
    case upDiploma = 2;
    case bs = 3;
    case ms = 4;
    case phd =5;

    public static function toString(educationStatus $status): string
    {
        return match ($status) {
            self::diploma => 'دیپلم',
            self::upDiploma=> 'فوق دیپلم',
            self::bs => 'لیسانس',
            self::ms => 'فوق لیسانس',
            self::phd => 'دکترا',
            default => ''
        };
    }
}