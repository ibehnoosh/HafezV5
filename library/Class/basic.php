<?php
class basic
{
	function show_center($center_e_group)
	{
		$test='';
		$codearray = explode("-", $center_e_group);
		$count_lenght=count($codearray);
		$total=0;
		
		for($i = 1; $i <= $count_lenght; $i++)
		{
			if($codearray[$i])
			{
				$test.=$this->show_center_one($codearray[$i]).'&nbsp;<span class="red">|</span>&nbsp;';
			}
			
			
		}
		return $test;
	}
	function show_center_one($id_center)
	{
		$name_b_center='';
		if($id_center == '')
			$name_b_center='مشخص نشده است';
		else
		{
				$sql_search="SELECT `name_b_center` FROM  `basic_center` WHERE `id_b_center` ='".$id_center."'";
				$res_search=mysql_query($sql_search);
				while($row=mysql_fetch_array($res_search))
				{
					$name_b_center=$row['name_b_center'];
				}
		}
		return $name_b_center;
	}
	function center_2_add_items($work_per , $jsfunction)
	{
		$codearray = explode("-", $work_per);
		$count_lenght=count($codearray);
		$total=0;
		
		for($i = 1; $i <= $count_lenght; $i++)
		{
			if($codearray[$i])
			{
				$total++;
			}
		}
		if($total == 1)
		{
			for($i = 1; $i <= $count_lenght; $i++)
			{
				if($codearray[$i])
				{
					print $this->show_center_one($codearray[$i]);
					print '<input type="hidden" name="center_list" value="'.$codearray[$i].'">';
					$_SESSION[PREFIXOFSESS.'center_term']=$codearray[$i];
				}
			}
		}
		else
		{
			print '<select name="center_list" class="required" id="center_list" style="auto;" '.$jsfunction.'>';
			print '<option value=""></option>';
			for($i = 1; $i <= $count_lenght; $i++)
			{
				$name_b_center=$this->show_center_one($codearray[$i]);
				if($name_b_center <> 'مشخص نشده است')
				{
				if(($codearray[$i]) == ($_SESSION[PREFIXOFSESS.'center_term']))
					
					print '<option value="'.$codearray[$i].'" selected="selected">'.$name_b_center.'</option>';
						
				else
					print '<option value="'.$codearray[$i].'">'.$this->show_center_one($codearray[$i]).'</option>';
				}
				
			}
			print '</select>';
		}
	}
	
	function check_center_4_show_or_not($id_center,$id_person)
	{
		$sql_c_s_t=
		"SELECT *  FROM `person_info` WHERE `work_per` LIKE '%-".$id_center."-%' 
		AND `id_per`=".$id_person;
		$number=mysql_num_rows(mysql_query($sql_c_s_t));
		if($number == 0)
		return false;
		else
		return true;
	}
	function center_4_show_master_personal_info($work_per)
	{
		$codearray = explode("-", $work_per);
		$count_lenght=count($codearray);
		$total=0;
		
		for($i = 1; $i <= $count_lenght; $i++)
		{
			if($codearray[$i])
			{
				$total++;
			}
		}
		if($total == 1)
		{
			for($i = 1; $i <= $count_lenght; $i++)
			{
				if($codearray[$i])
				{
					print $this->show_center_one($codearray[$i]);
					$_SESSION[PREFIXOFSESS.'center_mas']=$codearray[$i];
				}
			}
		}
		else
		{
			print '<select name="center_mas" class="drop_list" style="auto;" onChange="getsupport(\'work\');">';
			print ' <option value="all">محل کار (همه)</option>';
			for($i = 1; $i <= $count_lenght; $i++)
			{
				$name_b_center=$this->show_center_one($codearray[$i]);
				if($name_b_center <> 'مشخص نشده است')
				{
				if(($codearray[$i]) == ($_SESSION[PREFIXOFSESS.'center_mas']))
					
					print '<option value="'.$codearray[$i].'" selected="selected">'.$name_b_center.'</option>';
						
				else
					print '<option value="'.$codearray[$i].'">'.$this->show_center_one($codearray[$i]).'</option>';
				}
				
			}
			print '</select>';
		}
	}
	function center_2_add_multi_items($work_per)
	{
		$codearray = explode("-", $work_per);
		$count_lenght=count($codearray);
		$total=0;
		
		for($i = 1; $i <= $count_lenght; $i++)
		{
			if($codearray[$i])
			{
				$total++;
			}
		}
		if($total == 1)
		{
			for($i = 1; $i <= $count_lenght; $i++)
			{
				if($codearray[$i])
				{
					print $this->show_center_one($codearray[$i]).'<input type="hidden" name="center_stu" value="'.$codearray[$i].'">';
				}
			}
		}
		else
		{
			print '<select name="center_stu"  class="required">';
			print '<option value="">انتخاب مرکز</option>';
			for($i = 1; $i <= $count_lenght; $i++)
			{
				if($codearray[$i])
				{
					print '<option value="'.$codearray[$i].'">'.$this->show_center_one($codearray[$i]).'</option>';
				}
			}
			print '</select>';
		}
	}
}