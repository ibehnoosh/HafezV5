<?php
class privat
{
	function list_fld() //ok
	{
		$fld = array();
		$result = mysql_query('select * from `pri_request` LIMIT 0 ,1');

		for ($i = 0; $i < mysql_num_fields($result); $i++) {
			$name = mysql_field_name($result, $i);
			array_push($fld, $name);
		}
		return $fld;
	}
	function list_fld_class() //ok
	{
		$fld = array();
		$result = mysql_query('select * from `pri_edu_class` LIMIT 0 ,1');

		for ($i = 0; $i < mysql_num_fields($result); $i++) {
			$name = mysql_field_name($result, $i);
			array_push($fld, $name);
		}
		return $fld;
	}
	function off_code($i)
	{
		$sql = mysql_query("SELECT * FROM `pri_master_off`,`master_info` WHERE `id`='" . $i . "' AND `master`=`id_mas`");
		$row = mysql_fetch_object($sql);
		$this->title = $row->title;
		$this->master_off = $row->family_mas . ' ' . $row->name_mas;
		$this->id_master_off = $row->id_mas;
		$this->off_stu = $row->off_stu;
	}
	function show($i)
	{
		if (is_numeric($i)) {
			$fld = array();
			$fld = $this->list_fld();
			$result = mysql_query("SELECT * FROM `pri_request` WHERE `id` =" . $i);
			$row = mysql_fetch_array($result);

			foreach ($fld as $key => $val) {
				if ($row[$val] == '0000-00-00') $real_value = '';
				else $real_value = $row[$val];

				$this->$val = $real_value;
			}
		}
	}
	function show_class($i)
	{
		if (is_numeric($i)) {
			$fld = array();
			$fld = $this->list_fld_class();
			$result = mysql_query("SELECT * FROM `pri_edu_class` WHERE `id_e_class` =" . $i);
			$row = mysql_fetch_array($result);

			foreach ($fld as $key => $val) {
				if ($row[$val] == '0000-00-00') $real_value = '';
				else $real_value = $row[$val];

				$this->$val = $real_value;
			}
		}
	}

	function how_many_session($i)
	{
		$sql = mysql_query("SELECT * FROM `pri_edu_class_days` WHERE `class` = " . $i);
		$ccc = mysql_num_rows($sql);
		return $ccc;
	}
	function show_class_request($i)
	{
		if (is_numeric($i)) {
			$fld = array();
			$fld = $this->list_fld_class();
			$result = mysql_query("SELECT * FROM `pri_edu_class` WHERE `request` =" . $i);
			$row = mysql_fetch_array($result);

			foreach ($fld as $key => $val) {
				if ($row[$val] == '0000-00-00') $real_value = '';
				else $real_value = $row[$val];

				$this->$val = $real_value;
			}
		}
	}

	function add_class($group_e_name, $level_e_name, $id_e_master, $day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $place_e_class, $start_e_class, $end_e_class, $capacity_class, $extra_session_class, $id_request)
	{
		$code_e_class='';
		$sql_insert = "INSERT INTO `pri_edu_class`(`request`,`id_e_class`,  `id_e_group`, `id_e_level`, `id_e_master`, `code_e_class`, `day_0`, `day_1`, `day_2`, `day_3`, `day_4`, `day_5`, `day_6`, `place_e_class`, `start_e_class`, `end_e_class`,`session`,`capacity_class`) VALUES ( '" . $id_request . "',NULL, '" . $group_e_name . "', '" . $level_e_name . "', '" . $id_e_master . "', '" . $code_e_class . "','" . $day_0 . "', '" . $day_1 . "', '" . $day_2 . "', '" . $day_3 . "', '" . $day_4 . "', '" . $day_5 . "', '" . $day_6 . "', '" . $place_e_class . "','" . $start_e_class . "','" . $end_e_class . "','" . $extra_session_class . "','" . $capacity_class . "');";
		if (mysql_query($sql_insert)) {
			$id_class = mysql_insert_id();
			$sql_insert_log = "INSERT INTO `pri_edu_class`(`request`,`id_e_class`, `id_e_group`, `id_e_level`, `id_e_master`, `code_e_class`, `day_0`, `day_1`, `day_2`, `day_3`, `day_4`, `day_5`, `day_6`, `place_e_class`, `start_e_class`, `end_e_class`,`session`,`capacity_class`) VALUES ( '" . $id_request . "', " . $id_class . ", '" . $group_e_name . "', '" . $level_e_name . "', '" . $id_e_master . "', '" . $code_e_class . "','" . $day_0 . "', '" . $day_1 . "', '" . $day_2 . "', '" . $day_3 . "', '" . $day_4 . "', '" . $day_5 . "', '" . $day_6 . "', '" . $place_e_class . "', '" . $start_e_class . "', '" . $end_e_class . "','" . $extra_session_class . "','" . $capacity_class . "');";

			if ($start_e_class <> '') {
				$this->generate_class_day($id_class, $start_e_class, $end_e_class, $day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $id_e_master, $place_e_class);

				$sql_delete_sessions = mysql_query("SELECT count(`id`) as `c` FROM `pri_edu_class_days` WHERE `class`='" . $id_class . "'");
				$row_delete = mysql_fetch_object($sql_delete_sessions);
				$num_session = $row_delete->c;
				if ($num_session > $extra_session_class) {
					$num_del_item = $num_session - $extra_session_class;
					$sql_delete_extra = "DELETE FROM `pri_edu_class_days` WHERE `class`='" . $id_class . "'
				ORDER BY `pri_edu_class_days`.`date` DESC LIMIT " . $num_del_item . ";";

					mysql_query($sql_delete_extra);
				}
			}
			$logg = new logg();
			//------------------------------------------------------	
			$logg->add($_SESSION[PREFIXOFSESS.'idp'], 'ثبت کلاس خصوصی', $id_class, $sql_insert_log);
			//------------------------------------------------------
			return $id_class;
		}
	}
	function generate_class_day($class, $start1, $end, $day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $master, $locate)
	{

		$Converter = new Converter;
		list($year, $month, $day) = preg_split('-/-', $start1);
		$g2j = $Converter->JalaliToGregorian($year, $month, $day);
		$date_en = $g2j[0] . '/' . $g2j[1] . '/' . $g2j[2];

		$Converter = new Converter;
		list($year, $month, $day) = preg_split('-/-', $end);
		$g2j = $Converter->JalaliToGregorian($year, $month, $day);
		$end = $g2j[0] . '/' . $g2j[1] . '/' . $g2j[2];

		$input = strtotime($date_en);
		$day_num = date('w', $input);
		if ($day_0 <> '') {

			if ($day_num <> '6')
				$start = date('Y/m/d', strtotime("next Saturday", $input));
			else
				$start = date('Y/m/d', $input);

			$this->insert_day_of_class($start, $end, $class, $day_0, $master, $locate);
		}
		if ($day_1 <> '') {
			if ($day_num <> '0')
				$start = date('Y/m/d', strtotime("next Sunday", $input));
			else
				$start = date('Y/m/d', $input);
			$this->insert_day_of_class($start, $end, $class, $day_1, $master, $locate);
		}
		if ($day_2 <> '') {
			if ($day_num <> '1')
				$start = date('Y/m/d', strtotime("next Monday", $input));
			else
				$start = date('Y/m/d', $input);
			$this->insert_day_of_class($start, $end, $class, $day_2, $master, $locate);
		}
		if ($day_3 <> '') {
			if ($day_num <> '2')
				$start = date('Y/m/d', strtotime("next Tuesday", $input));
			else
				$start = date('Y/m/d', $input);
			$this->insert_day_of_class($start, $end, $class, $day_3, $master, $locate);
		}
		if ($day_4 <> '') {
			if ($day_num <> '3')
				$start = date('Y/m/d', strtotime("next Wednesday", $input));
			else
				$start = date('Y/m/d', $input);
			$this->insert_day_of_class($start, $end, $class, $day_4, $master, $locate);
		}
		if ($day_5 <> '') {
			if ($day_num <> '4')
				$start = date('Y/m/d', strtotime("next Thursday", $input));
			else
				$start = date('Y/m/d', $input);
			$this->insert_day_of_class($start, $end, $class, $day_5, $master, $locate);
		}
		if ($day_6 <> '') {
			if ($day_num <> '5')
				$start = date('Y/m/d', strtotime("next Friday", $input));
			else
				$start = date('Y/m/d', $input);
			$this->insert_day_of_class($start, $end, $class, $day_6, $master, $locate);
		}
	}

	function insert_day_of_class($start, $end, $class, $time, $master, $locate)
	{

		$tmpDate = new DateTime($start);
		$tmpEndDate = new DateTime($end);
		$outArray = array();
		do {
			$outArray[] = $tmpDate->format('Y/m/d');
		} while ($tmpDate->modify('+7 day') <= $tmpEndDate);

		foreach ($outArray as $i => $value) {


			$Converter = new Converter;
			list($year, $month, $day) = preg_split('-/-', $outArray[$i]);
			$g2j = $Converter->GregorianToJalali($year, $month, $day);
			$final_date = $g2j[0] . '/' . $g2j[1] . '/' . $g2j[2];

			if ($g2j[1] < 10)
				$m2 = '0' . $g2j[1];
			else
				$m2 = $g2j[1];

			if ($g2j[2] < 10)
				$ddd = '0' . $g2j[2];
			else
				$ddd = $g2j[2];

			$date_persian = $g2j[0] . "/" . $m2 . "/" . $ddd;

			$dt = strtotime($outArray[$i]);
			$day = date("l", $dt);
			$days = show_day($day);

			$sql = "
			
			INSERT INTO `pri_edu_class_days`
			(`id`,`class`, `master`, `master2`, `date`, `day_name`, `time`, `locat`, `who`) 
			VALUES 
			(NULL,'" . $class . "', '" . $master . "',NULL,'" . $date_persian . "','" . $days . "', '" . $time . "','" . $locate . "','" . $_SESSION[PREFIXOFSESS.'idp'] . "')";


			mysql_query($sql);


			$sql_log = "
			
			INSERT INTO `pri_edu_class_days`
			(`id`,`class`, `master`, `master2`, `date`, `day_name`, `time`, `locat`, `who`) 
			VALUES 
			(" . mysql_insert_id() . ",'" . $class . "', '" . $master . "',NULL,'" . $date_persian . "','" . $days . "', '" . $time . "','" . $locate . "','" . $_SESSION[PREFIXOFSESS.'idp'] . "');";




			// $stringData =$sql_log;




		}
	}

	function edit_class($id_e_class, $group_e_name, $level_e_name, $id_e_master, $place_e_class, $start_e_class, $end_e_class, $extra_session_class, $capacity_class, $day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6)
	{
		$sql_search = mysql_query("SELECT `day_0`, `day_1`, `day_2`, `day_3`, `day_4`, `day_5`, `day_6` 
		FROM `pri_edu_class` WHERE `id_e_class`=" . $id_e_class);
		while ($row_d = mysql_fetch_object($sql_search)) {
			$f_day_0 = $row_d->day_0;
			$f_day_1 = $row_d->day_1;
			$f_day_2 = $row_d->day_2;
			$f_day_3 = $row_d->day_3;
			$f_day_4 = $row_d->day_4;
			$f_day_5 = $row_d->day_5;
			$f_day_6 = $row_d->day_6;
		}
		$sql_update = "
UPDATE `pri_edu_class` SET `id_e_group`='" . $group_e_name . "', `id_e_level`='" . $level_e_name . "',`id_e_master`='" . $id_e_master . "',`place_e_class`='" . $place_e_class . "',`start_e_class`='" . $start_e_class . "',`end_e_class`='" . $end_e_class . "',`capacity_class`='" . $capacity_class . "',`session`='" . $extra_session_class . "',`day_0`='" . $day_0 . "',`day_1`='" . $day_1 . "',`day_2`='" . $day_2 . "',`day_3`='" . $day_3 . "',`day_4`='" . $day_4 . "',`day_5`='" . $day_5 . "',`day_6`='" . $day_6 . "' WHERE `id_e_class` =" . $id_e_class . ";
";

		$sql_pp = "UPDATE `pri_edu_class_days`  SET `master`='" . $id_e_master . "' 
		WHERE `class`=" . $id_e_class . " AND `accept` is NULL;";
		if (mysql_query($sql_update)) {
			mysql_query($sql_pp);

			if ($f_day_0 <> $day_0) {
				$d_0 = $day_0;
				mysql_query("DELETE FROM `pri_edu_class_days` WHERE `class` = " . $id_e_class . " AND `day_name`='شنبه' AND `accept` is NULL ");
			} else {
				$d_0 = '';
			}
			if ($f_day_1 <> $day_1) {
				$d_1 = $day_1;
				mysql_query("DELETE FROM `pri_edu_class_days` WHERE `class` = " . $id_e_class . " AND `day_name`='یکشنبه' AND `accept` is NULL");
			} else {
				$d_1 = '';
			}
			if ($f_day_2 <> $day_2) {
				$d_2 = $day_2;
				mysql_query("DELETE FROM `pri_edu_class_days` WHERE `class` = " . $id_e_class . " AND `day_name`='دوشنبه' AND `accept` is NULL");
			} else {
				$d_2 = '';
			}
			if ($f_day_3 <> $day_3) {
				$d_3 = $day_3;
				mysql_query("DELETE FROM `pri_edu_class_days` WHERE `class` = " . $id_e_class . " AND `day_name`='سه شنبه' AND `accept` is NULL");
			} else {
				$d_3 = '';
			}
			if ($f_day_4 <> $day_4) {
				$d_4 = $day_4;
				mysql_query("DELETE FROM `pri_edu_class_days` WHERE `class` = " . $id_e_class . " AND `day_name`='چهارشنبه' AND `accept` is NULL");
			} else {
				$d_4 = '';
			}
			if ($f_day_5 <> $day_5) {
				$d_5 = $day_5;
				mysql_query("DELETE FROM `pri_edu_class_days` WHERE `class` = " . $id_e_class . " AND `day_name`='پنج شنبه' AND `accept` is NULL");
			} else {
				$d_5 = '';
			}
			if ($f_day_6 <> $day_6) {
				$d_6 = $day_6;
				mysql_query("DELETE FROM `pri_edu_class_days` WHERE `class` = " . $id_e_class . " AND `day_name`='جمعه' AND `accept` is NULL");
			} else {
				$d_6 = '';
			}
			$this->generate_class_day($id_e_class, $start_e_class, $end_e_class, $d_0, $d_1, $d_2, $d_3, $d_4, $d_5, $d_6, $id_e_master, $place_e_class);
		}

		$logg = new logg();
		//------------------------------------------------------	
		$logg->add($_SESSION[PREFIXOFSESS.'idp'], 'ویرایش کلاس', $id_e_class, $sql_update);
		//------------------------------------------------------
	}

	function show_master_list($active)
	{
		$sql = "SELECT DISTINCT `master` AS `id_mas` ,`family_mas` , `name_mas` FROM `pri_edu_class_days` ,`master_info` WHERE `master`=`id_mas`";
		$res = mysql_query($sql);
		while ($row = mysql_fetch_array($res)) {
			if ($active == $row['id_mas'])
				print '<option value="' . $row['id_mas'] . '" selected="selected">' . $row['family_mas'] . '&nbsp;' . $row['name_mas'] . '</option>';
			else
				print '<option value="' . $row['id_mas'] . '">' . $row['family_mas'] . '&nbsp;' . $row['name_mas'] . '</option>';
		}
	}
	function show_category_option_list($id_cat)
	{
		$sql_list_group = "
		SELECT * FROM `edu_category`
		ORDER BY `name_e_cat` ASC";
		$res = mysql_query($sql_list_group);
		while ($row = mysql_fetch_array($res)) {
			$id_e_cat = $row['id_e_cat'];
			$name_e_cat = $row['name_e_cat'];
			if ($id_cat == $id_e_cat)
				print '<option value="' . $id_e_cat . '" selected="selected">' . $name_e_cat . '</option>';
			else
				print '<option value="' . $id_e_cat . '">' . $name_e_cat . '</option>';
		}
	}

	function show_level_option_list_in_group($id_level, $group)
	{
		$level_strin='';
		if (isset($group)) {
			$sql_level = "SELECT *  FROM `edu_level` WHERE `group_e_level` ='" . $group . "'  AND `active`='y' ORDER BY `edu_level`.`name_e_level` ASC";
			$res_level = mysql_query($sql_level);
			while ($row = mysql_fetch_array($res_level)) {
				$id_e_level = $row['id_e_level'];
				$name_e_level = $row['name_e_level'];
				if ($id_level == $id_e_level)
					$level_strin .= '<option value="' . $id_e_level . '" selected="selected">' . $name_e_level . '</option>';
				else
					$level_strin .= '<option value="' . $id_e_level . '">' . $name_e_level . '</option>';
			}
		} else {
			$sql_level = "SELECT * FROM `edu_level`,`edu_group`
	WHERE `group_e_level`=`id_e_group` AND `edu_level`.`active`='y'
	ORDER BY `edu_level`.`name_e_level` ASC";
			$res_level = mysql_query($sql_level);
			while ($row = mysql_fetch_array($res_level)) {
				$id_e_level = $row['id_e_level'];
				$name_e_level = $row['name_e_level'];
				if ($id_level == $id_e_level)
					$level_strin .= '<option value="' . $id_e_level . '" selected="selected">' . $name_e_level . '</option>';
				else
					$level_strin .= '<option value="' . $id_e_level . '">' . $name_e_level . '</option>';
			}
		}
		print $level_strin;
	}

	function show_group_in_category_option_list($id_group, $id_cate)
	{
		$sql_list_group = "
		SELECT * FROM `edu_group` , `edu_category`
		WHERE 
		`id_e_cat`=`cat_stu_group`";

		if ($id_cate == '')
			$sql_list_group .= "ORDER BY `edu_group`.`name_e_group` ASC";
		else
			$sql_list_group .= "AND `cat_stu_group` = '" . $id_cate . "' 
			ORDER BY `edu_group`.`name_e_group` ASC";

		$res = mysql_query($sql_list_group);
		while ($row = mysql_fetch_array($res)) {
			$id_e_group = $row['id_e_group'];
			$name_e_group = $row['name_e_group'];
			if ($id_group == $id_e_group)
				print '<option value="' . $id_e_group . '" selected="selected">' . $name_e_group . '</option>';
			else
				print '<option value="' . $id_e_group . '">' . $name_e_group . '</option>';
		}
	}

	function show_group_in_privatec_option_list($id_group)
	{
		$sql_list_group = "
		SELECT * FROM `edu_group` 
		WHERE 
		`cat_stu_group` = (SELECT `cat_stu_group` FROM `edu_group` WHERE `id_e_group` =" . $id_group . ")";

		$res = mysql_query($sql_list_group);
		while ($row = mysql_fetch_array($res)) {
			$id_e_group = $row['id_e_group'];
			$name_e_group = $row['name_e_group'];
			if ($id_group == $id_e_group)
				print '<option value="' . $id_e_group . '" selected="selected">' . $name_e_group . '</option>';
			else
				print '<option value="' . $id_e_group . '">' . $name_e_group . '</option>';
		}
	}
}
