<?php
class edu
{
    public function list_fld() //ok

    {
        $fld = array();
        $result = mysql_query('select * from class_view LIMIT 0 ,1');
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            $name = mysql_field_name($result, $i);
            array_push($fld, $name);
        }
        return $fld;
    }
    public function list_fld_id() //ok

    {
        $fld = array();
        $result = mysql_query('select * from edu_class LIMIT 0 ,1');
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            $name = mysql_field_name($result, $i);
            array_push($fld, $name);
        }
        return $fld;
    }
    public function add_category($name_e_group, $comment_e_group, $center) //ok

    {
        $sql_add_group = "
		INSERT INTO `edu_category`
			(`id_e_cat` ,`name_e_cat`,`comment_e_cat` , `center_e_cat`)
		VALUES
			(NULL , '" . $name_e_group . "' ,'" . $comment_e_group . "' , '" . $center . "');";
        if (mysql_query($sql_add_group)) {
            $logg = new logg();
            $id_insert = mysql_insert_id();
            $sql_add_group = "INSERT INTO `edu_category`(`id_e_cat` ,`name_e_cat`,`comment_e_cat` , `center_e_cat`) VALUES (" . $id_insert . " , '" . $name_e_group . "' ,'" . $comment_e_group . "' , '" . $center . "');";
            //------------------------------------------------------
            $logg->add($_SESSION[PREFIXOFSESS . 'idp'], ' افزودن دسته بندی', $id_insert, $sql_add_group);
            //------------------------------------------------------
            return true;
        }
    }
    public function show_category($id) //ok

    {
        $sql_1 = "SELECT *  FROM `edu_category` WHERE `id_e_cat` =" . $id;
        $res_1 = mysql_query($sql_1);
        while ($row = mysql_fetch_array($res_1)) {
            $this->name_e_group = $row['name_e_cat'];
            $this->comment_e_group = $row['comment_e_cat'];
            $this->center_e_group = $row['center_e_cat'];
        }
    }
    public function show_category_option_list($id_category) // ok

    {
        $sql_list_group = "SELECT * FROM `edu_category` ORDER BY `name_e_cat` ASC";
        $res = mysql_query($sql_list_group);
        while ($row = mysql_fetch_array($res)) {
            $id_e_cat = $row['id_e_cat'];
            $name_e_cat = $row['name_e_cat'];
            if ($id_category == $id_e_cat) {
                print '<option value="' . $id_e_cat . '" selected="selected">' . $name_e_cat . '</option>';
            } else {
                print '<option value="' . $id_e_cat . '">' . $name_e_cat . '</option>';
            }
        }
    }
    public function add_group($name_e_group, $cat_e_group, $comment_e_group) //ok

    {
        $sql_add_group = "
		INSERT INTO `edu_group`
			(`id_e_group` ,`name_e_group`,`cat_stu_group` ,`comment_e_group`)
		VALUES
			(NULL , '" . $name_e_group . "','" . $cat_e_group . "' ,'" . $comment_e_group . "');";
        if (mysql_query($sql_add_group)) {
            $id_insert = mysql_insert_id();
            $sql_add_group = "INSERT INTO `edu_group` (`id_e_group` ,`name_e_group`,`cat_stu_group` ,`comment_e_group`) VALUES (" . $id_insert . " , '" . $name_e_group . "','" . $cat_e_group . "' ,'" . $comment_e_group . "');";
            $logg = new logg();
            $logg->add($_SESSION[PREFIXOFSESS . 'idp'], ' افزودن دوره آموزشی', $id_insert, $sql_add_group);
            return true;
        }
    }
    public function show_group($id) //ok

    {
        $sql_1 = "SELECT *  FROM `edu_group` WHERE `id_e_group` =" . $id;
        $res_1 = mysql_query($sql_1);
        while ($row = mysql_fetch_array($res_1)) {
            $this->name_e_group = $row['name_e_group'];
            $this->comment_e_group = $row['comment_e_group'];
            $this->cat_stu_group = $row['cat_stu_group'];
        }
    }
    public function add_level($name_e_level, $group_e_name) //ok

    {
        $sql_add_level = "
		INSERT INTO `edu_level` (`id_e_level` ,`name_e_level` ,`group_e_level`)
		VALUES (NULL , '" . $name_e_level . "', '" . $group_e_name . "');";
        if (mysql_query($sql_add_level)) {
            $id_insert = mysql_insert_id();
            $sql_add_level = "INSERT INTO `edu_level` (`id_e_level` ,`name_e_level` ,`group_e_level`) VALUES (" . $id_insert . " , '" . $name_e_level . "', '" . $group_e_name . "');";
            $logg = new logg();
            //------------------------------------------------------
            $logg->add($_SESSION[PREFIXOFSESS . 'idp'], ' افزودن دوره آموزشی', $id_insert, $sql_add_level);
            //------------------------------------------------------
            return true;
        }
    }
    public function show_level($id) //ok

    {
        $sql_1 = "SELECT *  FROM `edu_level` WHERE `id_e_level` =" . $id;
        $res_1 = mysql_query($sql_1);
        while ($row = mysql_fetch_array($res_1)) {
            $this->name_e_level = $row['name_e_level'];
            $this->group_e_level = $row['group_e_level'];
            $this->active = $row['active'];
            $this->free = $row['free'];
        }
    }
    public function show_group_option_list($id_group) //ok

    {
        $sql_list_group = "SELECT * FROM `edu_group` ORDER BY `edu_group`.`name_e_group` ASC";
        $res = mysql_query($sql_list_group);
        while ($row = mysql_fetch_array($res)) {
            $id_e_group = $row['id_e_group'];
            $name_e_group = $row['name_e_group'];
            if ($id_group == $id_e_group) {
                print '<option value="' . $id_e_group . '" selected="selected">' . $name_e_group . '</option>';
            } else {
                print '<option value="' . $id_e_group . '">' . $name_e_group . '</option>';
            }
        }
    }
    public function ahow_class_4_term($type, $season) // ok

    {
        switch ($season) {
            case 'بهار':
                if ($type == 'عادی') {
                    $class = 'font-purple-seance font-lg bold ';
                    $type_name = 'عادی';
                } else if ($type == 'فشرده') {
                    $class = 'font-purple-sharp font-lg bold ';
                    $type_name = 'فشرده';
                } else if ($type == 'جمعه ها') {
                    $class = 'font-purple-soft font-lg bold ';
                    $type_name = 'جمعه ها';
                } else if ($type == 'مجازی') {
                    $class = 'font-purple-studio font-lg bold ';
                    $type_name = 'مجازی';
                }
                break;
            case 'تابستان':
                if ($type == 'عادی') {
                    $class = 'font-green-jungle font-lg bold';
                    $type_name = 'عادی';
                } else if ($type == 'فشرده') {
                    $class = 'font-green-meadow font-lg bold';
                    $type_name = 'فشرده';
                } else if ($type == 'جمعه ها') {
                    $class = 'font-green-soft font-lg bold';
                    $type_name = 'جمعه ها';
                } else if ($type == 'مجازی') {
                    $class = 'font-green-turquoise font-lg bold ';
                    $type_name = 'مجازی';
                }
                break;
            case 'پاییز':
                if ($type == 'عادی') {
                    $class = 'font-yellow-lemon font-lg bold';
                    $type_name = 'عادی';
                } else if ($type == 'فشرده') {
                    $class = 'font-yellow-haze font-lg bold';
                    $type_name = 'فشرده';
                } else if ($type == 'جمعه ها') {
                    $class = 'font-yellow-soft font-lg bold';
                    $type_name = 'جمعه ها';
                } else if ($type == 'مجازی') {
                    $class = 'font-yellow-saffron font-lg bold ';
                    $type_name = 'مجازی';
                }
                break;
            case 'زمستان':
                if ($type == 'عادی') {
                    $class = 'font-blue-steel font-lg bold';
                    $type_name = 'عادی';
                } else if ($type == 'فشرده') {
                    $class = 'font-blue-soft font-lg bold';
                    $type_name = 'فشرده';
                } else if ($type == 'جمعه ها') {
                    $class = 'font-blue-dark font-lg bold';
                    $type_name = 'جمعه ها';
                } else if ($type == 'مجازی') {
                    $class = 'font-blue-madison font-lg bold ';
                    $type_name = 'مجازی';
                }
                break;
        }
        return array($class, $type_name);
    }
    public function class_info_code($code, $term) //ok

    {
        $fld = array();
        $fld = $this->list_fld();
        $result = mysql_query("SELECT *  FROM `class_view` WHERE `code` ='" . $code . "' AND `term`='" . $term . "'");
        $row = mysql_fetch_array($result);
        foreach ($fld as $key => $val) {
            if ($row[$val] == '0000-00-00') {
                $real_value = '';
            } else {
                $real_value = $row[$val];
            }
            $this->$val = $real_value;
        }
    }
    public function class_info_code_4_title($code, $term) //ok

    {
        $sql = mysql_query("SELECT
			`name_e_level`, `name_mas`,`family_mas`,`edu_level`.`id_e_level`, `edu_class`.`id_e_group`
			FROM `edu_class` ,`edu_level`,`master_info`
			WHERE `id_e_term` LIKE '" . $term . "' AND `code_e_class` LIKE '" . $code . "'
			AND  `edu_class`.`id_e_level`=`edu_level`.`id_e_level`
			AND `id_e_master`=`id_mas`");
        $row = mysql_fetch_object($sql);
        $this->name_e_level = $row->name_e_level;
        $this->name_mas = $row->name_mas;
        $this->family_mas = $row->family_mas;
        $this->id_e_level = $row->id_e_level;
        $this->id_e_group = $row->id_e_group;
    }
    public function class_info_educlass($code, $term) //ok

    {
        $fld = array();
        $fld = $this->list_fld_id();
        $result = mysql_query("SELECT *  FROM `edu_class` WHERE `code_e_class` ='" . $code . "' AND `id_e_term`='" . $term . "'");
        $row = mysql_fetch_array($result);
        foreach ($fld as $key => $val) {
            if ($row[$val] == '0000-00-00') {
                $real_value = '';
            } else {
                $real_value = $row[$val];
            }
            $this->$val = $real_value;
        }
    }
    public function show_level_option_list_in_group($id_level, $group)
    {
        $level_strin = '';
        if ($group > 0) {
            $sql_level = "SELECT *  FROM `edu_level` WHERE `group_e_level` ='" . $group . "' AND `active`='y' ORDER BY `edu_level`.`name_e_level` ASC";
            $res_level = mysql_query($sql_level);
            while ($row = mysql_fetch_array($res_level)) {
                $id_e_level = $row['id_e_level'];
                $name_e_level = $row['name_e_level'];
                if ($id_level == $id_e_level) {
                    $level_strin .= '<option value="' . $id_e_level . '" selected="selected">' . $name_e_level . '</option>';
                } else {
                    $level_strin .= '<option value="' . $id_e_level . '">' . $name_e_level . '</option>';
                }
            }
        } else {
            $sql_level = "SELECT *  FROM `edu_level` WHERE `active` LIKE 'y' ORDER BY `edu_level`.`name_e_level` ASC";
            $res_level = mysql_query($sql_level);
            while ($row = mysql_fetch_array($res_level)) {
                $id_e_level = $row['id_e_level'];
                $name_e_level = $row['name_e_level'];
                if ($id_level == $id_e_level) {
                    $level_strin .= '<option value="' . $id_e_level . '" selected="selected">' . $name_e_level . '</option>';
                } else {
                    $level_strin .= '<option value="' . $id_e_level . '">' . $name_e_level . '</option>';
                }
            }
        }
        print $level_strin;
    }
    public function show_group_select_option_list($id_group, $id_cat)
    {
        $sql_list_group = "SELECT * FROM `edu_group`
		WHERE `cat_stu_group`='" . $id_cat . "'
		 ORDER BY `edu_group`.`name_e_group` ASC";
        $res = mysql_query($sql_list_group);
        while ($row = mysql_fetch_array($res)) {
            $id_e_group = $row['id_e_group'];
            $name_e_group = $row['name_e_group'];
            if ($id_group == $id_e_group) {
                print '<option value="' . $id_e_group . '" selected="selected">' . $name_e_group . '</option>';
            } else {
                print '<option value="' . $id_e_group . '">' . $name_e_group . '</option>';
            }
        }
    }
    public function show_master_list_selected($id_selected)
    {
        $sql = "SELECT `id_mas`, `name_mas`, `family_mas` FROM `master_info`
		WHERE `active_mas` LIKE 'yes' ORDER BY `master_info`.`family_mas` ASC";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res)) {
            if ($row['id_mas'] == $id_selected) {
                print '<option value="' . $row['id_mas'] . '" selected="selected">' . $row['family_mas'] . '&nbsp;' . $row['name_mas'] . '</option>';
            } else {
                print '<option value="' . $row['id_mas'] . '">' . $row['family_mas'] . '&nbsp;' . $row['name_mas'] . '</option>';
            }
        }
    }
    public function show_group_option_list_in_center($id_group, $center)
    {
        $sql_list_group = "
		SELECT * FROM `edu_group` , `edu_category`
		WHERE
		`id_e_cat`=`cat_stu_group`
		AND
		`center_e_cat` LIKE '%-" . $center . "-%'
		ORDER BY `edu_group`.`name_e_group` ASC";
        $res = mysql_query($sql_list_group);
        while ($row = mysql_fetch_array($res)) {
            $id_e_group = $row['id_e_group'];
            $name_e_group = $row['name_e_group'];
            if ($id_group == $id_e_group) {
                print '<option value="' . $id_e_group . '" selected="selected">' . $name_e_group . '</option>';
            } else {
                print '<option value="' . $id_e_group . '">' . $name_e_group . '</option>';
            }
        }
    }
    public function add_term($year, $season_e_term, $date_fix_level, $date_start_reg, $date_end_reg, $date_start_class, $date_end_class, $free_day, $type_e_term, $center_list, $start_op, $end_op, $start_net, $end_net, $start_off, $end_off, $date_relate)
    {
        $insert_new_term = "INSERT INTO `edu_term`
		(`id_e_term`, `year_e_term`, `season_e_term`, `date_fix_level`, `date_start_reg`, `date_end_reg`, `date_start_class`,
		`date_end_class`, `free_day`, `type_e_term`, `center_e_term`,`start_net`, `end_net`, `start_op`, `end_op`,`start_off`, `end_off`,`date_relate`)
		VALUES
		(NULL, '" . $year . "', '" . $season_e_term . "',
		'" . $date_fix_level . "', '" . $date_start_reg . "', '" . $date_end_reg . "', '" . $date_start_class . "',
		'" . $date_end_class . "', '" . $free_day . "', '" . $type_e_term . "', '" . $center_list . "', '" . $start_net . "', '" . $end_net . "', '" . $start_op . "','" . $end_op . "', '" . $start_off . "','" . $end_off . "','" . $date_relate . "');";
        if (mysql_query($insert_new_term)) {
            $id_insert = mysql_insert_id();
            $insert_new_term = "INSERT INTO `edu_term` (`id_e_term`, `year_e_term`, `season_e_term`, `date_fix_level`, `date_start_reg`, `date_end_reg`, `date_start_class`, `date_end_class`, `free_day`, `type_e_term`, `center_e_term`,`start_net`, `end_net`, `start_op`, `end_op`,`start_off`, `end_off`,`date_relate`) VALUES (" . $id_insert . ", '" . $year . "', '" . $season_e_term . "',		'" . $date_fix_level . "', '" . $date_start_reg . "', '" . $date_end_reg . "', '" . $date_start_class . "', '" . $date_end_class . "', '" . $free_day . "', '" . $type_e_term . "', '" . $center_list . "', '" . $start_net . "', '" . $end_net . "', '" . $start_op . "','" . $end_op . "', '" . $start_off . "','" . $end_off . "','" . $date_relate . "');";
            $logg = new logg();
            //------------------------------------------------------
            $logg->add($_SESSION[PREFIXOFSESS . 'idp'], 'ثبت ترم', $id_insert, $insert_new_term);
            //------------------------------------------------------
            return true;
        }
    }
    public function show_term($id_term)
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
            $this->start_op = $row['start_op'];
            $this->end_op = $row['end_op'];
            $this->start_net = $row['start_net'];
            $this->end_net = $row['end_net'];
            $this->start_off = $row['start_off'];
            $this->end_off = $row['end_off'];
            $this->date_relate = $row['date_relate'];
            $this->intt = $row['intt'];
        }
    }
    public function delete_class($id)
    {
        $count_register = mysql_query("SELECT count(`id_stu_reg`) AS `reg` FROM `student_register` WHERE `class_stu_reg`='" . $id . "'");
        $row_register = mysql_fetch_object($count_register);
        $tedad = $row_register->reg;
        if ($tedad == 0) {
            mysql_query("DELETE FROM `edu_class_days` WHERE `class`='" . $id . "';");
            $sql_De = "DELETE FROM `edu_class` WHERE `id_e_class`=" . $id . ";";
            if (mysql_query($sql_De)) {
                $logg = new logg();
                //------------------------------------------------------
                $logg->add($_SESSION[PREFIXOFSESS . 'idp'], 'حذف کلاس', $id, $sql_De);
                //------------------------------------------------------
                $message = '<div class="panel panel-info">
							<div class="panel-heading">
							<h3 class="panel-title">پیام تایید</h3></div>
							<div class="panel-body"><h4>کلاس با موفقیت حذف گردید </h4></div>
							</div>';
            }
            //------------------------------------------------------
        } else {
            $message = '
				<div class="panel panel-danger">
				<div class="panel-heading">
				<h3 class="panel-title">خطا</h3></div>
				<div class="panel-body font-lg"><h4>تعداد  <b>' . $tedad . '</b> دانشجو در کلاس ثبت نام کرده اند و امکان حذف وجود ندارد.</h4></div>
				</div>';
        }
        return $message;
    }
    public function generate_code($id_e_term, $id_e_center)
    {
        $sql = "SELECT MAX(`code_e_class`) as `latest`  FROM `edu_class`
		WHERE `id_e_term` = '" . $id_e_term . "' AND `id_e_center` = '" . $id_e_center . "'";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res)) {
            $latest = $row['latest'];
        }
        if ($latest == '') {
            $sql_term = mysql_query("SELECT `center_e_term`,`year_e_term`,`season_e_term`,`type_e_term` FROM `edu_term`
				WHERE `id_e_term` =" . $id_e_term);
            while ($row = mysql_fetch_array($sql_term)) {
                $type_e_term = $row['type_e_term'];
                $season_e_term = $row['season_e_term'];
                $year_e_term = $row['year_e_term'];
                $center_e_term = $row['center_e_term'];
            }
            $count = mysql_query("SELECT COUNT(*) AS `h` FROM `edu_term` WHERE
				`year_e_term`='" . $year_e_term . "' AND `center_e_term`='" . $center_e_term . "' AND
				`season_e_term`='" . $season_e_term . "' AND `type_e_term`='" . $type_e_term . "'");
            $how = mysql_result($count, 0, 'h');
            if ($type_e_term == 'عادی') {
                return 1000;
            } elseif ($type_e_term == 'فشرده') {
                return 100;
            } elseif ($type_e_term == 'جمعه ها') {
                return 500;
            } elseif ($type_e_term == 'مجازی') {
                return 5000;
            }
        } else {
            return $latest + 1;
        }
    }
    public function add_class($id_e_term, $id_e_center, $group_e_name, $level_e_name, $id_e_master, $code_e_class, $day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $place_e_class, $start_e_class, $end_e_class, $extra_session_class, $jobrani_class, $capacity_class, $mokhtalet)
    {
        $sql_log = '';
        $sql_insert = "
		INSERT INTO `edu_class` (
								 `id_e_class`, `id_e_term`, `id_e_center`, `id_e_group`, `id_e_level`,
								 `id_e_master`, `code_e_class`,
								 `day_0`,`day_1`,`day_2`,`day_3`,`day_4`,`day_5`,`day_6`,
								 `place_e_class`, `start_e_class`,`end_e_class`,
								 `extra_session_class`,`jobrani_class`, `capacity_class`,`mokhtalet`
								 )
		VALUES (
				NULL, '" . $id_e_term . "', '" . $id_e_center . "', '" . $group_e_name . "', '" . $level_e_name . "',
				'" . $id_e_master . "', '" . $code_e_class . "',
				'" . $day_0 . "', '" . $day_1 . "', '" . $day_2 . "', '" . $day_3 . "', '" . $day_4 . "', '" . $day_5 . "', '" . $day_6 . "',
				'" . $place_e_class . "', '" . $start_e_class . "', '" . $end_e_class . "',
				'" . $extra_session_class . "','" . $jobrani_class . "' ,'" . $capacity_class . "','" . $mokhtalet . "');";
        if (mysql_query($sql_insert)) {
            $id_class = mysql_insert_id();
            $sql_insert_log = "INSERT INTO `edu_class` (`id_e_class`, `id_e_term`, `id_e_center`, `id_e_group`, `id_e_level`, `id_e_master`, `code_e_class`,`day_0`,`day_1`,`day_2`,`day_3`,`day_4`,`day_5`,`day_6`, `place_e_class`, `start_e_class`,`end_e_class`,`extra_session_class`,`jobrani_class`, `capacity_class`,`mokhtalet` )VALUES (" . $id_class . ", '" . $id_e_term . "', '" . $id_e_center . "', '" . $group_e_name . "', '" . $level_e_name . "', '" . $id_e_master . "', '" . $code_e_class . "', '" . $day_0 . "', '" . $day_1 . "', '" . $day_2 . "', '" . $day_3 . "', '" . $day_4 . "', '" . $day_5 . "', '" . $day_6 . "', '" . $place_e_class . "', '" . $start_e_class . "', '" . $end_e_class . "','" . $extra_session_class . "','" . $jobrani_class . "' ,'" . $capacity_class . "','" . $mokhtalet . "');";
            if ($start_e_class != '') {
                $this->generate_class_day($id_class, $start_e_class, $end_e_class, $day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $id_e_master, $place_e_class, $id_e_term);
                $sql_delete_sessions = mysql_query("SELECT count(`id`) as `c` FROM `edu_class_days` WHERE `class`='" . $id_class . "'");
                $row_delete = mysql_fetch_object($sql_delete_sessions);
                $num_session = $row_delete->c;
                if ($num_session > $extra_session_class) {
                    $num_del_item = $num_session - $extra_session_class;
                    mysql_query("DELETE FROM `edu_class_days` WHERE `class`='" . $id_class . "'
				ORDER BY `edu_class_days`.`date` DESC LIMIT " . $num_del_item);
                }
            }
            $check = mysql_query("SELECT COUNT(`id_md`) AS `number`  FROM `mark_details` WHERE `level_md` = '" . $level_e_name . "' AND `term_md` = '" . $id_e_term . "'");
            if (mysql_result($check, 0, 'number') == 0) {
                $sql_insert_2 = "SELECT `id_mg`,`default_value`
				FROM `mark_grade` WHERE `level_mg` LIKE '" . $level_e_name . "' AND `default_value`>0";
                $res_insert = mysql_query($sql_insert_2);
                while ($rrr = mysql_fetch_array($res_insert)) {
                    $id_mg = $rrr['id_mg'];
                    $default_value = $rrr['default_value'];
                    mysql_query("INSERT INTO `mark_details` (`id_md` ,`gradeid_md` ,`level_md` ,`term_md` ,`value_md`)
					VALUES (NULL , '$id_mg', '" . $level_e_name . "', '$id_e_term', '$default_value');");
                    $id_insert_mark = mysql_insert_id();
                    $sql_mark = "INSERT INTO `mark_details` (`id_md` ,`gradeid_md` ,`level_md` ,`term_md` ,`value_md`) VALUES (" . $id_insert_mark . " , '$id_mg', '" . $level_e_name . "', '$id_e_term', '$default_value');";
                    mysql_query("INSERT INTO `mark_pass` (`id_mp`, `term_mp`, `level_mp`, `mark_pass`, `mark_mashrot`)
					VALUES (NULL , '$id_e_term', '" . $level_e_name . "', '70', '65);");
                    $sql_log .= $sql_mark;
                }
            }
            $check = mysql_query("SELECT COUNT(`id`) AS `number`  FROM `master_assment_term` WHERE `level` = '" . $level_e_name . "' AND `term` = '" . $id_e_term . "'");
            if (mysql_result($check, 0, 'number') == 0) {
                $sql_insert_2 = "SELECT `id`,`value` FROM `master_assment_basic` WHERE `level` LIKE '" . $level_e_name . "' AND `active`>0";
                $res_insert = mysql_query($sql_insert_2);
                while ($rrr = mysql_fetch_array($res_insert)) {
                    $id_ma = $rrr['id'];
                    $default_value = $rrr['value'];
                    mysql_query("INSERT INTO `master_assment_term` (`id`, `term`, `level`, `idma`, `val`)
					VALUES (NULL , '$id_e_term', '" . $level_e_name . "', '$id_ma', '$default_value');");
                    $id_insert_maa = mysql_insert_id();
                    $sql_mark = "INSERT INTO `master_assment_term` (`id`, `term`, `level`, `idma`, `val`) VALUES (" . $id_insert_maa . ",'$id_e_term', '" . $level_e_name . "', '$id_ma', '$default_value');";
                    $sql_log .= $sql_mark;
                }
            }
            $sql_cont = mysql_query("SELECT count(`id`) AS `c` FROM `edu_class_days` WHERE `class`='" . $id_class . "' AND `type`<> 'تعطیل'");
            $row_count = mysql_fetch_object($sql_cont);
            $count_count = $row_count->c;
            $sql_edit = mysql_query("UPDATE `edu_class` SET `jobrani_class`=`extra_session_class`-" . $count_count . " WHERE `id_e_class`=" . $id_class . ";");
            $logg = new logg();
            //------------------------------------------------------
            $logg->add($_SESSION[PREFIXOFSESS . 'idp'], 'ثبت کلاس', $id_class, $sql_insert_log);
            //------------------------------------------------------
        }
    }
    public function generate_class_day($class, $start1, $end, $day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $master, $locate, $term)
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
        if ($day_0 != '') {
            if ($day_num != '6') {
                $start = date('Y/m/d', strtotime("next Saturday", $input));
            } else {
                $start = date('Y/m/d', $input);
            }
            $this->insert_day_of_class($start, $end, $class, $day_0, $master, $locate, $term);
        }
        if ($day_1 != '') {
            if ($day_num != '0') {
                $start = date('Y/m/d', strtotime("next Sunday", $input));
            } else {
                $start = date('Y/m/d', $input);
            }
            $this->insert_day_of_class($start, $end, $class, $day_1, $master, $locate, $term);
        }
        if ($day_2 != '') {
            if ($day_num != '1') {
                $start = date('Y/m/d', strtotime("next Monday", $input));
            } else {
                $start = date('Y/m/d', $input);
            }
            $this->insert_day_of_class($start, $end, $class, $day_2, $master, $locate, $term);
        }
        if ($day_3 != '') {
            if ($day_num != '2') {
                $start = date('Y/m/d', strtotime("next Tuesday", $input));
            } else {
                $start = date('Y/m/d', $input);
            }
            $this->insert_day_of_class($start, $end, $class, $day_3, $master, $locate, $term);
        }
        if ($day_4 != '') {
            if ($day_num != '3') {
                $start = date('Y/m/d', strtotime("next Wednesday", $input));
            } else {
                $start = date('Y/m/d', $input);
            }
            $this->insert_day_of_class($start, $end, $class, $day_4, $master, $locate, $term);
        }
        if ($day_5 != '') {
            if ($day_num != '4') {
                $start = date('Y/m/d', strtotime("next Thursday", $input));
            } else {
                $start = date('Y/m/d', $input);
            }
            $this->insert_day_of_class($start, $end, $class, $day_5, $master, $locate, $term);
        }
        if ($day_6 != '') {
            if ($day_num != '5') {
                $start = date('Y/m/d', strtotime("next Friday", $input));
            } else {
                $start = date('Y/m/d', $input);
            }
            $this->insert_day_of_class($start, $end, $class, $day_6, $master, $locate, $term);
        }
    }
    public function insert_day_of_class($start, $end, $class, $time, $master, $locate, $term)
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
            if ($g2j[1] < 10) {
                $m2 = '0' . $g2j[1];
            } else {
                $m2 = $g2j[1];
            }
            if ($g2j[2] < 10) {
                $ddd = '0' . $g2j[2];
            } else {
                $ddd = $g2j[2];
            }
            $date_persian = $g2j[0] . "/" . $m2 . "/" . $ddd;
            $dt = strtotime($outArray[$i]);
            $day = date("l", $dt);
            $days = show_day($day);
            $sql_free = mysql_query("SELECT * FROM `edu_term_free` WHERE `day`='" . $date_persian . "' AND `term`='" . $term . "'");
            if (mysql_num_rows($sql_free) > 0) {
                $sql = "INSERT INTO `edu_class_days`
			(`id`,`type`,`class`, `master`, `date`, `day_name`, `time`, `locat`, `comment`, `statuse`, `who` , `term`)
			VALUES
			(NULL,'تعطیل','" . $class . "', '" . $master . "','" . $date_persian . "','" . $days . "', '" . $time . "','" . $locate . "', '','0','" . $_SESSION[PREFIXOFSESS . 'idp'] . "','" . $term . "');";
            } else {
                $sql = "INSERT INTO `edu_class_days`
			(`id`,`class`, `master`, `date`, `day_name`, `time`, `locat`, `comment`, `statuse`,`who` , `term`)
			VALUES
			(NULL,'" . $class . "', '" . $master . "','" . $date_persian . "','" . $days . "', '" . $time . "','" . $locate . "', '','0','" . $_SESSION[PREFIXOFSESS . 'idp'] . "','" . $term . "');";
            }
            mysql_query($sql);
        }
    }
    public function show_term_info($id_term)
    {
        $sql_query = mysql_query("SELECT `year_e_term`, `season_e_term`, `type_e_term` ,`name_b_center`
		FROM `edu_term` ,`basic_center`
		WHERE `id_e_term`=" . $id_term . "
		AND `id_b_center`=`center_e_term`");
        $row = mysql_fetch_object($sql_query);
        $type = $row->type_e_term;
        return $row->season_e_term . '<b>' . $row->year_e_term . '</b> (' . $type . ') - ' . $row->name_b_center;
    }
    public function show_category_option_list_in_center($id_cat, $center)
    {
        $sql_list_group = "
		SELECT * FROM `edu_category`
		WHERE
		`center_e_cat` LIKE '%-" . $center . "-%'
		ORDER BY `name_e_cat` ASC";
        $res = mysql_query($sql_list_group);
        while ($row = mysql_fetch_array($res)) {
            $id_e_cat = $row['id_e_cat'];
            $name_e_cat = $row['name_e_cat'];
            if ($id_cat == $id_e_cat) {
                print '<option value="' . $id_e_cat . '" selected="selected">' . $name_e_cat . '</option>';
            } else {
                print '<option value="' . $id_e_cat . '">' . $name_e_cat . '</option>';
            }
        }
    }
    public function show_master_list_in_center($id_center)
    {
        $sql = "SELECT `id_mas`, `name_mas`, `family_mas` FROM `master_info`
		WHERE `active_mas` LIKE 'yes' AND `center_mas` LIKE '%-" . $id_center . "-%'ORDER BY `master_info`.`family_mas` ASC";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res)) {
            print '<option value="' . $row['id_mas'] . '">' . $row['family_mas'] . '&nbsp;' . $row['name_mas'] . '</option>';
        }
    }
    public function show_level_option_list_in_group_in_center($id_level, $group, $center)
    {
        $level_strin = '';
        if (isset($group)) {
            $sql_level = "SELECT *  FROM `edu_level` WHERE `group_e_level` ='" . $group . "'  AND `active`='y' ORDER BY `edu_level`.`name_e_level` ASC";
            $res_level = mysql_query($sql_level);
            while ($row = mysql_fetch_array($res_level)) {
                $id_e_level = $row['id_e_level'];
                $name_e_level = $row['name_e_level'];
                if ($id_level == $id_e_level) {
                    $level_strin .= '<option value="' . $id_e_level . '" selected="selected">' . $name_e_level . '</option>';
                } else {
                    $level_strin .= '<option value="' . $id_e_level . '">' . $name_e_level . '</option>';
                }
            }
        } else {
            $sql_level = "SELECT * FROM `edu_level`,`edu_group`,`edu_category`
			WHERE `center_e_cat` LIKE '%" . $center . "%' AND`group_e_level`=`id_e_group` AND `edu_level`.`active`='y'
			AND
			`cat_stu_group`=`id_e_cat` ORDER BY `edu_level`.`name_e_level` ASC";
            $res_level = mysql_query($sql_level);
            while ($row = mysql_fetch_array($res_level)) {
                $id_e_level = $row['id_e_level'];
                $name_e_level = $row['name_e_level'];
                if ($id_level == $id_e_level) {
                    $level_strin .= '<option value="' . $id_e_level . '" selected="selected">' . $name_e_level . '</option>';
                } else {
                    $level_strin .= '<option value="' . $id_e_level . '">' . $name_e_level . '</option>';
                }
            }
        }
        print $level_strin;
    }
    public function show_master_list_term_center($active, $term, $center)
    {
        $sql = "
		select * FROM (
		SELECT DISTINCT `master` AS `id_mas` ,`family_mas` , `name_mas` FROM `edu_class_days` ,`master_info` WHERE `term`=" . $term . " AND `master`=`id_mas`
			UNION
			SELECT DISTINCT `master2` AS `id_mas` , `family_mas` , `name_mas` FROM `edu_class_days` ,`master_info` WHERE `term`=" . $term . " AND `master2`=`id_mas` ) AS `c`
			ORDER BY `c`.`family_mas` ";
        $res = mysql_query($sql);
        while ($row = mysql_fetch_array($res)) {
            if ($active == $row['id_mas']) {
                print '<option value="' . $row['id_mas'] . '" selected="selected">' . $row['family_mas'] . '&nbsp;' . $row['name_mas'] . '</option>';
            } else {
                print '<option value="' . $row['id_mas'] . '">' . $row['family_mas'] . '&nbsp;' . $row['name_mas'] . '</option>';
            }
        }
    }
    public function show_group_in_category_option_list_in_center($id_group, $id_cate, $center)
    {
        $sql_list_group = "
		SELECT * FROM `edu_group` , `edu_category`
		WHERE
		`id_e_cat`=`cat_stu_group`
		AND
		`center_e_cat` LIKE '%-" . $center . "-%'";
        if ($id_cate == '') {
            $sql_list_group .= "ORDER BY `edu_group`.`name_e_group` ASC";
        } else {
            $sql_list_group .= "AND `cat_stu_group` = '" . $id_cate . "'
			ORDER BY `edu_group`.`name_e_group` ASC";
        }
        $res = mysql_query($sql_list_group);
        while ($row = mysql_fetch_array($res)) {
            $id_e_group = $row['id_e_group'];
            $name_e_group = $row['name_e_group'];
            if ($id_group == $id_e_group) {
                print '<option value="' . $id_e_group . '" selected="selected">' . $name_e_group . '</option>';
            } else {
                print '<option value="' . $id_e_group . '">' . $name_e_group . '</option>';
            }
        }
    }
    public function show_day_list($day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6)
    {
        $tedad = 0;
        $day = '';
        if ($day_0 != '') {
            $day .= 'شنبه (' . $day_0 . ') ';
            $tedad++;
        }
        if ($day_1 != '') {
            $day .= 'یکشنبه (' . $day_1 . ') ';
            $tedad++;
        }
        if ($day_2 != '') {
            $day .= 'دوشنبه (' . $day_2 . ') ';
            if ($tedad >= 2) {
                $day .= '<br>';
                $tedad = 0;
            }
        }
        if ($day_3 != '') {
            $day .= 'سه شنبه (' . $day_3 . ') ';
            if ($tedad >= 2) {
                $day .= '<br>';
                $tedad = 0;
            }
        }
        if ($day_4 != '') {
            $day .= 'چهارشنبه (' . $day_4 . ') ';
            if ($tedad >= 2) {
                $day .= '<br>';
                $tedad = 0;
            }
        }
        if ($day_5 != '') {
            $day .= 'پنج شنبه (' . $day_5 . ') ';
            if ($tedad >= 2) {
                $day .= '<br>';
                $tedad = 0;
            }
        }
        if ($day_6 != '') {
            $day .= 'جمعه (' . $day_6 . ') ';
            if ($tedad >= 2) {
                $day .= '<br>';
                $tedad = 0;
            }
        }
        return $day;
    }
    public function show_day_list_print($day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6)
    {
        $hour = '';
        if (($day_0 != '') && ($day_1 != '') && ($day_2 != '') && ($day_3 != '') && ($day_4 != '') && ($day_5 != '')) {
            $day = 'هر روز<br><span dir="ltr">' . $day_0 . '</span>';
        } elseif (($day_0 != '') && ($day_2 != '') && ($day_4 != '') && ($day_1 == '') && ($day_3 == '') && ($day_5 == '')) {
            $day = 'روزهای زوج<br><span dir="ltr">' . $day_0 . '</span>';
        } elseif (($day_1 != '') && ($day_3 != '') && ($day_5 != '') && ($day_0 == '') && ($day_2 == '') && ($day_4 == '')) {
            $day = 'روزهای فرد<br><span dir="ltr">' . $day_1 . '</span>';
        } else {
            $tedad = 0;
            $day = '';
            if ($day_0 != '') {
                $day .= 'شنبه ،';
                $hour .= $day_0 . ' ، ';
            }
            if ($day_1 != '') {
                $day .= 'یکشنبه ،';
                $hour .= $day_1 . ' ، ';
            }
            if ($day_2 != '') {
                $day .= 'دوشنبه ،';
                $hour .= $day_2 . ' ، ';
            }
            if ($day_3 != '') {
                $day .= 'سه شنبه ،';
                $hour .= $day_3 . ' ، ';
            }
            if ($day_4 != '') {
                $day .= 'چهارشنبه ،';
                $hour .= $day_4 . ' ، ';
            }
            if ($day_5 != '') {
                $day .= 'پنج شنبه ،';
                $hour .= $day_5 . ' ، ';
            }
            if ($day_6 != '') {
                $day .= 'جمعه ،';
                $hour .= $day_6 . ' ، ';
            }
            $day = $day . '<br><span dir="rtl">' . $hour . '</span>';
        }
        return $day;
    }
    public function show_class($id)
    {
        $sql_1 = "SELECT *  FROM `edu_class`,`edu_group`
		WHERE `id_e_class`=" . $id . "
		AND `edu_class`.`id_e_group`=`edu_group`.`id_e_group`";
        $res_1 = mysql_query($sql_1);
        while ($row = mysql_fetch_array($res_1)) {
            $this->id_e_category = $row['cat_stu_group'];
            $this->id_e_group = $row['id_e_group'];
            $this->id_e_level = $row['id_e_level'];
            $this->code_e_class = $row['code_e_class'];
            $this->id_e_master = $row['id_e_master'];
            $this->place_e_class = $row['place_e_class'];
            $this->start_e_class = $row['start_e_class'];
            $this->end_e_class = $row['end_e_class'];
            $this->extra_session_class = $row['extra_session_class'];
            $this->jobrani_class = $row['jobrani_class'];
            $this->capacity_class = $row['capacity_class'];
            $this->day_0 = $row['day_0'];
            $this->day_1 = $row['day_1'];
            $this->day_2 = $row['day_2'];
            $this->day_3 = $row['day_3'];
            $this->day_4 = $row['day_4'];
            $this->day_5 = $row['day_5'];
            $this->day_6 = $row['day_6'];
            $this->mokhtalet = $row['mokhtalet'];
            $this->registers = $row['registers'];
            $this->reg_internet = $row['reg_internet'];
            $this->elec_id = $row['elec_id'];
            $this->support = $row['support'];
        }
    }
    public function edit_class($id, $group_e_name, $level_e_name, $id_e_master, $place_e_class, $start_e_class, $end_e_class, $extra_session_class, $jobrani_class, $day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $mokhtalet)
    {
        $sql_search = mysql_query("SELECT `day_0`, `day_1`, `day_2`, `day_3`, `day_4`, `day_5`, `day_6` ,`id_e_term`
		FROM `edu_class` WHERE `id_e_class`=" . $id);
        while ($row_d = mysql_fetch_object($sql_search)) {
            $f_day_0 = $row_d->day_0;
            $f_day_1 = $row_d->day_1;
            $f_day_2 = $row_d->day_2;
            $f_day_3 = $row_d->day_3;
            $f_day_4 = $row_d->day_4;
            $f_day_5 = $row_d->day_5;
            $f_day_6 = $row_d->day_6;
            $id_e_term = $row_d->id_e_term;
        }
        $sql_update = "UPDATE `edu_class` SET `id_e_group`='" . $group_e_name . "', `id_e_level`='" . $level_e_name . "',`id_e_master`='" . $id_e_master . "',`place_e_class`='" . $place_e_class . "',`start_e_class`='" . $start_e_class . "',`end_e_class`='" . $end_e_class . "',`extra_session_class`='" . $extra_session_class . "',`jobrani_class`='" . $jobrani_class . "',`day_0`='" . $day_0 . "',`day_1`='" . $day_1 . "',`day_2`='" . $day_2 . "',`day_3`='" . $day_3 . "',`day_4`='" . $day_4 . "',`day_5`='" . $day_5 . "',`day_6`='" . $day_6 . "',`mokhtalet`='" . $mokhtalet . "' WHERE `id_e_class` =" . $id . ";";
        $sql_pp = "UPDATE `edu_class_days`  SET `master`='" . $id_e_master . "'
		WHERE `class`=" . $id . " AND `accept` is NULL AND `lock` is NULL;";
        if (mysql_query($sql_update)) {
            mysql_query($sql_pp);
            print '<div class="ok">تغییرات با موفقیت اعمال گردید</div>';
            if ($f_day_0 != $day_0) {
                $d_0 = $day_0;
                $sql00 = "DELETE FROM `edu_class_days` WHERE `class` = " . $id . " AND `day_name`='شنبه' AND `accept` is NULL  AND `lock` is NULL;";
                mysql_query($sql00);
            } else {
                $d_0 = '';
            }
            if ($f_day_1 != $day_1) {
                $d_1 = $day_1;
                $sql01 = "DELETE FROM `edu_class_days` WHERE `class` = " . $id . " AND `day_name`='یکشنبه' AND `accept` is NULL AND `lock` is NULL;";
                mysql_query($sql01);
            } else {
                $d_1 = '';
            }
            if ($f_day_2 != $day_2) {
                $d_2 = $day_2;
                $sql02 = "DELETE FROM `edu_class_days` WHERE `class` = " . $id . " AND `day_name`='دوشنبه' AND `accept` is NULL AND `lock` is NULL;";
                mysql_query($sql02);
            } else {
                $d_2 = '';
            }
            if ($f_day_3 != $day_3) {
                $d_3 = $day_3;
                $sql03 = "DELETE FROM `edu_class_days` WHERE `class` = " . $id . " AND `day_name`='سه شنبه' AND `accept` is NULL AND `lock` is NULL;";
                mysql_query($sql03);
            } else {
                $d_3 = '';
            }
            if ($f_day_4 != $day_4) {
                $d_4 = $day_4;
                $sql04 = "DELETE FROM `edu_class_days` WHERE `class` = " . $id . " AND `day_name`='چهارشنبه' AND `accept` is NULL AND `lock` is NULL;";
                mysql_query($sql04);
            } else {
                $d_4 = '';
            }
            if ($f_day_5 != $day_5) {
                $d_5 = $day_5;
                $sql05 = "DELETE FROM `edu_class_days` WHERE `class` = " . $id . " AND `day_name`='پنج شنبه' AND `accept` is NULL AND `lock` is NULL;";
                mysql_query($sql05);
            } else {
                $d_5 = '';
            }
            if ($f_day_6 != $day_6) {
                $d_6 = $day_6;
                $sql06 = "DELETE FROM `edu_class_days` WHERE `class` = " . $id . " AND `day_name`='جمعه' AND `accept` is NULL AND `lock` is NULL;";
                mysql_query($sql06);
            } else {
                $d_6 = '';
            }
            $this->generate_class_day($id, $start_e_class, $end_e_class, $d_0, $d_1, $d_2, $d_3, $d_4, $d_5, $d_6, $id_e_master, $place_e_class, $id_e_term);
            $sql_cont = mysql_query("SELECT count(`id`) AS `c` FROM `edu_class_days` WHERE `class`='" . $id . "' AND `type`<> 'تعطیل'");
            $row_count = mysql_fetch_object($sql_cont);
            $count_count = $row_count->c;
            $sql_edit = mysql_query("UPDATE `edu_class` SET `jobrani_class`=`extra_session_class`-" . $count_count . " WHERE `id_e_class`=" . $id);
        }
        $logg = new logg();
        $logg->add($_SESSION[PREFIXOFSESS . 'idp'], 'ویرایش کلاس', $id, $sql_update);
        //------------------------------------------------------
    }
    public function change_capacity($id, $capacity_class, $reg_internet)
    {
        $sql = "UPDATE `edu_class` SET `capacity_class`='$capacity_class' , `reg_internet`='$reg_internet' WHERE `id_e_class`=" . $id . ";";
        if (mysql_query($sql)) {
            $logg = new logg();
            //------------------------------------------------------
            $logg->add($_SESSION[PREFIXOFSESS . 'idp'], 'تغییر ظرفیت', $id, $sql);
            //------------------------------------------------------
            return true;
        }
    }
    public function class_info($id)
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
    public function what_id_by_code($code, $term)
    {
        $sql = "SELECT `id_e_class` FROM `edu_class` WHERE `id_e_term` = '$term' AND `code_e_class` = '$code'";
        $res = mysql_query($sql);
        $row = mysql_fetch_object($res);
        return $row->id_e_class;
    }
    public function show_fee($id_term, $id_level)
    {
        $sql_fee_state = "SELECT  `fee_finfee` , `book_finfee` , `tape_finfee` , `cd_finfee`
						 FROM `financial_fee`
						 WHERE `term_finfee` = '" . $id_term . "'
						 AND `level_finfee` = '" . $id_level . "'";
        $result = mysql_query($sql_fee_state);
        $row_fee = mysql_fetch_array($result);
        $this->fee_finfee = $row_fee['fee_finfee'];
        $this->book_finfee = $row_fee['book_finfee'];
        $this->tape_finfee = $row_fee['tape_finfee'];
        $this->cd_finfee = $row_fee['cd_finfee'];
    }
    public function show_bank_name($id)
    {
        $res = mysql_query("SELECT `name_bb` FROM `basic_bank` WHERE `id_bb` =" . $id);
        while ($row = mysql_fetch_object($res)) {
            $name_bb = $row->name_bb;
        }
        return $name_bb;
    }
    public function show_account_name($id)
    {
        $res = mysql_query("SELECT `bank_finacc` FROM `financial_account` WHERE `id_finacc` =" . $id);
        while ($row = mysql_fetch_object($res)) {
            $bank_finacc = $row->bank_finacc;
        }
        return $bank_finacc;
    }
    public function class_type($i) //ok

    {
        switch ($i) {
            case 1:
                $outpute = 'عادی';
                break;
            case 3:
                $outpute = 'جبرانی';
                break;
            case 2:
                $outpute = 'آزمایشگاه';
                break;
        }
        return $outpute;
    }
    public function delay_type($i) //ok

    {
        switch ($i) {
            case 1:
                $outpute = 'تاخیر';
                break;
            case 2:
                $outpute = 'غیبت';
                break;
        }
        return $outpute;
    }
    public function sum_fee($term, $level, $book, $cd, $tape)
    {
        $res = mysql_query("SELECT *  FROM `financial_fee`
		WHERE `term_finfee` = '" . $term . "' AND `level_finfee` = '" . $level . "'");
        while ($row = mysql_fetch_array($res)) {
            $sum = $row['fee_finfee'];
            $cfee = $sum;
            if ($book == 'y') {
                $sum = $sum + $row['book_finfee'];
                $cbook = $row['book_finfee'];
            }
            if ($cd == 'y') {
                $sum = $sum + $row['cd_finfee'];
                $ccd = $row['cd_finfee'];
            }
            if ($tape == 'y') {
                $sum = $sum + $row['tape_finfee'];
                $ctap = $row['tape_finfee'];
            }
        }
        return array($sum, $cfee, $cbook, $ccd);
    }
    public function check_class_statuse($class, $student)
    {
        $sql = mysql_query("
		select SUM(`c`) AS `stu`  FROM (
		SELECT count(*) AS `c`  FROM `student_register` WHERE `student_stu_reg`='" . $student . "' AND `type_stu_reg`='fix' AND `class_stu_reg` ='" . $class . "'
		UNION
		SELECT count(*) AS `c` FROM `site_student_register` WHERE `student_stu_reg`='" . $student . "' AND `class_stu_reg` ='" . $class . "')
		AS `t`");
        $row = mysql_fetch_object($sql);
        $sql2 = mysql_query("
		select SUM(`c`) AS `all`  FROM (
		SELECT count(*) AS `c`  FROM `student_register` WHERE `who_stu_reg`=2 AND `type_stu_reg`='fix' AND `class_stu_reg` ='" . $class . "'
		UNION
		SELECT count(*) AS `c` FROM `site_student_register` WHERE `type_stu_reg`='fix' AND `class_stu_reg` ='" . $class . "')
		AS `t`");
        $row2 = mysql_fetch_object($sql2);
        return array($row->stu, $row2->all);
    }
    public function list_of_free_level($sort_level)
    {
        $str = '';
        $sql = mysql_query("SELECT * FROM `edu_level` WHERE `sort_e_level` IN (" . $sort_level . ") AND `active` LIKE 'y'");
        while ($row = mysql_fetch_object($sql)) {
            $str .= " OR `extra_sort` LIKE '%," . $row->id_e_level . ",%'";
        }
        $sql_2 = mysql_query("SELECT group_concat(`id_e_level`) AS `idl` FROM `edu_level` WHERE `active` LIKE 'y' AND `free` LIKE 'y' AND ( `extra_sort` ='' " . $str . ")");
        $row_2 = mysql_fetch_object($sql_2);
        return $row_2->idl;
    }
    public function list_of_level_ok($cat, $student)
    {
        $ttt = "
		SELECT * FROM `view_preneed`
		WHERE `student_stu_reg` = " . $student . " AND `cat_stu_group` = " . $cat . " AND `statuse_reg_stu` <> 'مردود' AND `free`='n' and `type_stu_reg`='fix' ORDER BY `view_preneed`.`date_stu_reg` DESC LIMIT 0,1 ";
        $sql = mysql_query($ttt);
        $count = mysql_num_rows($sql);
        if ($count == 0) {
            $out = $this->check_last_fail($student, $cat);
        } else {
            $row = mysql_fetch_object($sql);
            $sort_e_level = $row->sort_e_level;
            $new_sort = $sort_e_level + 1;
            $date_stu_reg = $row->end_e_class;
            $diff_date = $this->diff_date($date_stu_reg);
            if ($diff_date < 181 && $diff_date > 0) {
                $out = $sort_e_level . ',' . $new_sort . ',' . $this->check_taeen_sath_stu($student, $cat);
            } elseif ($diff_date < 366) {
                $out = $sort_e_level . ',' . $this->check_last_fail($student, $cat) . ',' . $this->check_taeen_sath_stu($student, $cat);
            } else {
                $out = $this->check_taeen_sath_stu($student, $cat);
            }
        }
        return $out;
    }
    public function check_last_fail($student, $cat)
    {
        $out1 = $this->check_taeen_sath_stu($student, $cat);
        $sql = mysql_query("
		SELECT * FROM `view_preneed`
		WHERE `student_stu_reg` = " . $student . " AND `cat_stu_group` = " . $cat . "  AND `free`='n' and `type_stu_reg`='fix' ORDER BY `view_preneed`.`date_stu_reg` DESC LIMIT 0,1 ");
        $count = mysql_num_rows($sql);
        if ($count == 0) {
            $out = '0';
        } else {
            $row = mysql_fetch_object($sql);
            $sort_e_level = $row->sort_e_level;
            $date_stu_reg = $row->end_e_class;
            $diff_date = $this->diff_date($date_stu_reg);
            if ($diff_date < 111) {
                $out = $sort_e_level;
            } else {
                $out = '0';
            }
        }
        return $out . ',' . $out1;
    }
    public function check_taeen_sath_stu($stu, $cat)
    {
        $sql_taeen = mysql_query("
		SELECT `stu`, `level_accept`, `date_reg_taeen`, `cat_stu_group`,`sort_e_level`
		FROM `site_taeen_level`,`edu_level` , `edu_group`
		WHERE `stu`=" . $stu . " AND `level_accept`=`id_e_level` AND `group_e_level`=`id_e_group`  AND `cat_stu_group`=" . $cat . " ORDER BY `date_reg_taeen` DESC LIMIT 0,1");
        $res = mysql_fetch_object($sql_taeen);
        $date = $res->date_reg_taeen;
        $diff_date = $this->diff_date_en($date);
        if ($diff_date < 111 && $diff_date >= 0) {
            $out = $res->sort_e_level;
        } else {
            $out = $this->fisrt_level($cat);
        }
        if ($out == '') {
            $out = 0;
        } else {
            $out = $out;
        }
        return $out;
    }
    public function fisrt_level($cat)
    {
        $sql = mysql_query("SELECT * FROM `edu_level`, `edu_group` WHERE `group_e_level`=`id_e_group` AND `cat_stu_group`=" . $cat . " AND `active`='y' AND `free`='n' ORDER BY `edu_level`.`sort_e_level` ASC limit 0,1 ");
        $row = mysql_fetch_object($sql);
        $out = $row->sort_e_level;
        return $out;
    }
    public function diff_date($date)
    {
        $Converter = new Converter;
        $date_m = date("Y , m , d");
        list($year, $month, $day) = preg_split('/,/', $date_m);
        $g2j = $Converter->GregorianToJalali($year, $month, $day);
        if ($g2j[1] < 10) {
            $m2 = '0' . $g2j[1];
        } else {
            $m2 = $g2j[1];
        }
        if ($g2j[2] < 10) {
            $ddd = '0' . $g2j[2];
        } else {
            $ddd = $g2j[2];
        }
        $date_persian = $g2j[0] . "/" . $m2 . "/" . $ddd;
        $datetime1 = new DateTime($date);
        $datetime2 = new DateTime($date_persian);
        if ($datetime1 >= $datetime2) {
            return 1;
        } else {
            $difference = $datetime1->diff($datetime2);
            return $difference->days;
        }
    }
    public function diff_date_en($date)
    {
        $date_m = date("Y-m-d");
        $datetime1 = new DateTime($date);
        $datetime2 = new DateTime($date_m);
        $difference = $datetime1->diff($datetime2);
        return $difference->days;
    }
}