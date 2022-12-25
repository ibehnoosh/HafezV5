<?php
class eduajax
{
	function show_term($id_term)
	{
		$sql_fetch_info = "SELECT * FROM `edu_term` WHERE `id_e_term` =" . $id_term;
		$res_fetch_info = mysql_query($sql_fetch_info);
		while ($row = mysql_fetch_array($res_fetch_info)) {
			$this->id_e_term = $row['id_e_term'];
			$this->season_e_term = $row['season_e_term'];
			$this->date_fix_level = $row['date_fix_level'];
			$this->date_start_reg = $row['date_start_reg'];
			$this->date_end_reg = $row['date_end_reg'];
			$this->date_start_class = $row['date_start_class'];
			$this->date_end_class = $row['date_end_class'];
			$this->free_day = $row['free_day'];
			$this->type_e_term = $row['type_e_term'];
			$this->center_e_term = $row['center_e_term'];
			$this->intt = $row['intt'];
		}
	}

	function class_info($id)
	{
		$sql_class = "SELECT *  FROM `class_view` WHERE `class` =" . $id;
		$res_class = mysql_query($sql_class);
		$row = mysql_fetch_object($res_class);
		$this->center = $row->center;
		$this->code = $row->code;
		$this->igroup = $row->igroup;
		$this->ilevel = $row->ilevel;
		$this->mark = $row->mark;
		$this->level = $row->level;
		$this->sort_e_level = $row->sort_e_level;
		$this->master = $row->master;
		$this->mobile_mas = $row->mobile_mas;
		$this->family = $row->family;
		$this->name = $row->name;
		$this->day_0 = $row->day_0;
		$this->day_1 = $row->day_1;
		$this->day_2 = $row->day_2;
		$this->day_3 = $row->day_3;
		$this->day_4 = $row->day_4;
		$this->day_5 = $row->day_5;
		$this->day_6 = $row->day_6;
		$this->place = $row->place;
		$this->start = $row->start;
		$this->end = $row->end;
		$this->capacity_class = $row->capacity_class;
		$this->registers = $row->registers;
		$this->session = $row->session;
		$this->jobrani = $row->jobrani;
		$this->fee = $row->fee;
		$this->icat = $row->icat;
		$this->term = $row->term;
		$this->reg_internet = $row->reg_internet;
	}
	function what_id_by_code($code, $term)
	{
		$sql = "SELECT `id_e_class` FROM `edu_class` WHERE `id_e_term` = '$term' AND `code_e_class` = '$code'";
		$res = mysql_query($sql);
		$row = mysql_fetch_object($res);
		return $row->id_e_class + 0;
	}

	function show_fee($id_term, $id_level)
	{

		$sql_fee_state = "SELECT  `fee_finfee` , `book_finfee` , `tape_finfee` , `cd_finfee` 
						 FROM `financial_fee`
						 WHERE `term_finfee` = '" . $id_term . "' 
						 AND `level_finfee` = '" . $id_level . "'";
		$result = mysql_query($sql_fee_state);
		$row_fee = mysql_fetch_array($result);
		$this->fee_finfee = $row_fee['fee_finfee'] + 0;
		$this->book_finfee = $row_fee['book_finfee'] + 0;
		$this->tape_finfee = $row_fee['tape_finfee'] + 0;
		$this->cd_finfee = $row_fee['cd_finfee'] + 0;
	}
}