<?php
class edu_exce
{
	
	function class_info($id)
	{
		$sql_class="SELECT *  FROM `class_view` WHERE `class` =".$id;
		$res_class=mysql_query($sql_class);
		$row=mysql_fetch_object($res_class);
		$this->center=$row->center;
		$this->code=$row->code;
		$this->igroup=$row->igroup;
		$this->ilevel=$row->ilevel;
		$this->mark=$row->mark;
		$this->level=$row->level;
		$this->sort_e_level=$row->sort_e_level;
		$this->master=$row->master;
		$this->mobile_mas=$row->mobile_mas;
		$this->family=$row->family;
		$this->name=$row->name;
		$this->day_0=$row->day_0;
		$this->day_1=$row->day_1;
		$this->day_2=$row->day_2;
		$this->day_3=$row->day_3;
		$this->day_4=$row->day_4;
		$this->day_5=$row->day_5;
		$this->day_6=$row->day_6;
		$this->place=$row->place;
		$this->start=$row->start;
		$this->end=$row->end;
		$this->capacity_class=$row->capacity_class;
		$this->registers=$row->registers;
		$this->session=$row->session;
		$this->jobrani=$row->jobrani;
		$this->fee=$row->fee;
		$this->icat=$row->icat;
		$this->term=$row->term;
		$this->reg_internet=$row->reg_internet;
	}
	function sum_fee($term,$level,$book,$cd,$tape)
	{
		$res=mysql_query("SELECT *  FROM `financial_fee` 
		WHERE `term_finfee` = '".$term."' AND `level_finfee` = '".$level."'");
		while($row=mysql_fetch_array($res))
		{
			$sum=$row['fee_finfee'];
            $cbook=0;
            $ccd=0;
			$cfee=$sum;
			if($book=='y') {$sum=$sum+$row['book_finfee'];$cbook=$row['book_finfee'];}
			if($cd=='y') {$sum=$sum+$row['cd_finfee'];$ccd=$row['cd_finfee'];}
			if($tape=='y') {$sum=$sum+$row['tape_finfee'];$ctap=$row['tape_finfee'];}
		}
		
		return array($sum,$cfee,$cbook,$ccd);
	}
}
