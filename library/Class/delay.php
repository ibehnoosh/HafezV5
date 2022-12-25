<?php
class delay
{
	function delay_type($i)//ok
	{
		switch($i)
		{
			case 1:
			$outpute='تاخیر';
			break;
			case 2:
			$outpute='غیبت';
			break;
		}
		return $outpute;
	}
	function class_type($i)//ok
	{
		switch($i)
		{
			case 1:
			$outpute='عادی';
			break;
			case 3:
			$outpute='جبرانی';
			break;
			case 2:
			$outpute='آزمایشگاه';
			break;
		}
		return $outpute;
	}

}
?>