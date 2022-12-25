<?php
namespace App\Tools;
class Date {

    private $convertor;

    public function __construct()
    {
        $this->convertor=new dateConvert();
    }
    function today():string
    {
        $year=date("Y");
        $month=date("m");
        $day=date("d");
        list($yearPersian,$monthPersian,$dayPersian)= $this->converetToPersian($year,$month,$day);
        $todayDate = $yearPersian . "/" . $monthPersian . "/" . $dayPersian;
        return $todayDate;
    }
    function thisYear()
    {
        $year=date("Y");
        list($yearPersian,$monthPersian,$dayPersian)= $this->converetToPersian($year,1,1);
        return $yearPersian;
    }
    function dateLog($yearPersian,$monthPersian ,$dayPersian):string
    {
        return $todayLog = $yearPersian . "-" . $monthPersian . "-" . $dayPersian;
    }
    function folderLog($yearPersian,$monthPersian):string
    {
        return $folderLog = $yearPersian. "-" . $monthPersian;
    }

    function dayWeekName():string
    {
       return $this->showDay(date("l"));
    }
    function converetToPersian($year, $month, $day)
    {
        $g2j =$this->convertor->GregorianToJalali($year, $month, $day);
        $yearPersian= $g2j[0];
        ($g2j[1] < 10) ? $monthPersian = '0' . $g2j[1] : $monthPersian = $g2j[1];
        ($g2j[2] < 10) ? $dayPersian = '0' . $g2j[2] : $dayPersian = $g2j[2];
        return array($yearPersian,$monthPersian,$dayPersian);
    }
    function showMonth($id)
    {
        $month =match($id)
        {
            1 , '01' => "فروردین",
            2 , '02' =>"اردیبهشت",
            3 , '03' =>"خرداد",
            4 , '04' =>"تیر",
            5 , '05' =>"مرداد",
            6 , '06' =>"شهریور",
            7 , '07' =>"مهر",
            8 , '08' =>"آبان",
            9 , '09' =>"آذر",
            10 =>"دی",
            11 => "بهمن",
            12 =>"اسفند"
        };
        return $month;
    }
    function showDay($id)
    {
        $day =match($id)
        {
             'Saturday'=> "شنبه",
             'Sunday'=> "یکشنبه",
             'Monday'=> "دوشنبه",
             'Tuesday'=> "سه شنبه",
             'Wednesday'=> "چهارشنبه",
             'Thursday'=> "پنج شنبه",
             'Friday'=> "جمعه"
        };
        return $day;
    }
    function checkDateBetween($start , $end , $start2 , $end2) // چک می کند که آیا تاریخ 2 بین تاریخ 1 است یا خیر
    {
        $start_date=strtotime($start);
        $end_date=strtotime($end);
        $start_date2=strtotime($start2);
        $end_date2=strtotime($end2);

        if(($start_date2 <= $end_date) && ($start_date2 >= $start_date) && ($end_date2 <= $end_date) && ($end_date2 >= $start_date))

        {
            if ($end2 >= $start2)
                return true;
            else
                return false;
        }
        else
        {
            return false;
        }

    }
    function showNumberDay($id)
    {
        $day =match($id)
        {
             'Saturday'=> "day_0",
             'Sunday'=> "day_1",
             'Monday'=> "day_2",
             'Tuesday'=> "day_3",
             'Wednesday'=>"day_4" ,
             'Thursday'=> "day_5",
             'Friday'=>"day_6"
        };
        return $day;
    }

}//Class END

?>