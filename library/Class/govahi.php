<?php
class govahi
{
	function type($i)
	{
		if($i==1) $name='صدور گواهینامه اتمام دوره تحصیلی';
		elseif($i==2) $name=' گواهینامه اشتغال به تحصیل و گذراندن دوره ها';
		elseif($i==3) $name='گواهینامه پرداخت شهریه';
        elseif($i==4) $name='گواهینامه وزارت علوم';
		
		return $name;
	}
	function lang($i)
	{
		if($i=='fa')
		$name='فارسی';
		elseif($i=='en')
		$name=' انگلیسی';
		elseif($i=='ru')
		$name='روسی';
		elseif($i=='ge')
		$name=' آلمانی';
		elseif($i=='fr')
		$name='فرانسه';
		
		return $name;
	}
}