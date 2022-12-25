<?php
class menu
{
	function check_menu($menu_id ,$semat,$center)
	{
		$sql_ch_menu=
		"SELECT * FROM `p_person_da` WHERE `semat` = '".$semat."' AND `menu` = '".$menu_id."' AND `center` = '".$center."'";	
		$res_ch_menu=mysql_query($sql_ch_menu);
		$rows=mysql_num_rows($res_ch_menu); 
		if($rows == 0)
			return false;
			//It is Not Add Befor
		else
			return true;
			// It is Add
	}
	
	function check_menu_person($menu_id ,$person)
	{
		$sql_ch_menu=
		"SELECT * FROM `p_person_access` WHERE `person` = '".$person."' AND `menu` = '".$menu_id."'";	
		$res_ch_menu=mysql_query($sql_ch_menu);
		$rows=mysql_num_rows($res_ch_menu); 
		if($rows == 0)
			return false;
			//It is Not Add Befor
		else
			return true;
			// It is Add
	}
	function check_menu_person_center($menu_id ,$person,$center)
	{
		$sql_ch_menu=
		"SELECT * FROM `p_person_access` WHERE 
		`person` = '".$person."' AND `menu` = '".$menu_id."' 
		AND `center`='".$center."'";	
		$res_ch_menu=mysql_query($sql_ch_menu);
		$rows=mysql_num_rows($res_ch_menu); 
		if($rows == 0)
			return false;
			//It is Not Add Befor
		else
			return true;
			// It is Add
	}
	function reset_menu($semat,$center)
	{
		$sql=mysql_query("SELECT `person`  FROM `p_semat` WHERE `center` = ".$center." AND `semat` = ".$semat);
		while($row=mysql_fetch_object($sql))
		{
			$this->reset_menu_person($semat,$row->person,$center);
		}
	}
	
	function reset_menu_person($semat,$person,$center)
	{
		$sql=mysql_query("SELECT *  FROM `p_person_da` WHERE `semat` =".$semat." AND `center` = '".$center."'");
		while($row=mysql_fetch_object($sql))
		{
			if($this->check_menu_person($row->menu , $person,$center))
			{
				mysql_query("UPDATE `p_person_access` SET `permision` = '".$row->type."' WHERE  `person` = '".$person."' AND `menu` = '".$row->menu."' AND `center`=".$center."");
				//print '<br>Update - '.$person;
			}
			else
			{
				mysql_query("INSERT INTO `p_person_access` (`id`, `person`, `menu`, `permision`,`center`) 
				VALUES (NULL, '".$person."', '".$row->menu."', '".$row->type."','".$center."');");
				//print '<br>Insert - '.$person;
			}
		}
		
	}
	function print_radio($j , $menu_id ,$semat,$center)
	{
		if($this->check_menu($menu_id ,$semat,$center))
		{
			$sql_ch_menu="SELECT * FROM `p_person_da` 
			WHERE `semat` = '".$semat."' AND `menu` = '".$menu_id."' AND `center` = '".$center."'";	
			$res_ch_menu=mysql_query($sql_ch_menu);
			while($row_acc_point=mysql_fetch_array($res_ch_menu))
			{
				$access_point=$row_acc_point['type'];
			}
			switch($access_point)
			{
				case '0':
				print ' 
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="0" checked="checked" /></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="1" /></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="2" /></td>';
				break;
				
				case '1':
				print ' 
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="0"/></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="1" checked="checked" /></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="2" /></td>';
				break;
				
				case '2':
				print ' 
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="0"/></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="1" /></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="2" checked="checked" /></td>';
				break;
			}
		}
		else
		{
			print ' 
				<td style="background:#FFFFB7;" align="center"><input name="access_point_'.$j.'" type="radio" value="0" /></td>
				<td style="background:#FFFFB7;" align="center"><input name="access_point_'.$j.'" type="radio" value="1" /></td>
				<td style="background:#FFFFB7;" align="center"><input name="access_point_'.$j.'" type="radio" value="2" /></td>';
			
			
		}
	}
	
	function print_radio_one($j , $menu_id ,$person ,$center)
	{
		if($this->check_menu_person_center($menu_id ,$person,$center))
		{
			$sql_ch_menu="SELECT * FROM `p_person_access` 
			WHERE `person` = '".$person."' AND `menu` = '".$menu_id."' 
			AND `center` = '".$center."'";	
			$res_ch_menu=mysql_query($sql_ch_menu);
			while($row_acc_point=mysql_fetch_array($res_ch_menu))
			{
				$access_point=$row_acc_point['permision'];
			}
			switch($access_point)
			{
				case '0':
				print ' 
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="0" checked="checked" /></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="1" /></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="2" /></td>';
				break;
				
				case '1':
				print ' 
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="0"/></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="1" checked="checked" /></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="2" /></td>';
				break;
				
				case '2':
				print ' 
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="0"/></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="1" /></td>
				<td align="center"><input name="access_point_'.$j.'" type="radio" value="2" checked="checked" /></td>';
				break;
			}
		}
		else
		{
			print ' 
				<td style="background:#FFFFB7;" align="center"><input name="access_point_'.$j.'" type="radio" value="0" /></td>
				<td style="background:#FFFFB7;" align="center"><input name="access_point_'.$j.'" type="radio" value="1" /></td>
				<td style="background:#FFFFB7;" align="center"><input name="access_point_'.$j.'" type="radio" value="2" /></td>';
			
			
		}
	}
	
}