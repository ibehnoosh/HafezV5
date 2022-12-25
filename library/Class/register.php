<?php
class register
{
    public function term_active_in_center($id_center, $date, $year2, $selected)
    {
        $year_2 = $year2 + 1;
        $year_3 = $year2 - 1;
        $sql_search = "SELECT *  FROM `edu_term` , `basic_center`
				WHERE `center_e_term` IN (" . $id_center . ")
				AND (`year_e_term`='" . $year2 . "' OR `year_e_term`='" . $year_2 . "' OR `year_e_term`='" . $year_3 . "')
				AND `center_e_term`=`id_b_center` ORDER BY `center_e_term`";
        $result = mysql_query($sql_search);
        while ($row = mysql_fetch_array($result)) {
            $id_e_term = $row['id_e_term'];
            $year_e_term = $row['year_e_term'];
            $season_e_term = $row['season_e_term'];
            $date_start_reg = $row['start_op'];
            $date_end_reg = $row['end_op'];
            $type_e_term = $row['type_e_term'];
            $Converter = new Converter;
            list($year, $month, $day) = preg_split('-/-', $date_start_reg);
            $g2j = $Converter->JalaliToGregorian($year, $month, $day);
            $date_start_reg2 = $g2j[0] . '-' . $g2j[1] . '-' . $g2j[2];
            $Converter = new Converter;
            list($year, $month, $day) = preg_split('-/-', $date_end_reg);
            $g2j = $Converter->JalaliToGregorian($year, $month, $day);
            $date_end_reg2 = $g2j[0] . '-' . $g2j[1] . '-' . $g2j[2];
            $active_date = strtotime($date_start_reg2);
            $inactive_date = strtotime($date_end_reg2);
            $date_today = strtotime($date);
            if (($date_today <= $inactive_date) && ($date_today >= $active_date)) {
                if ($id_e_term == $selected) {
                    print '<option value="' . $id_e_term . '"  data-center="' . $row['id_b_center'] . '" selected>' . $season_e_term . ' - ' . $type_e_term . ' (' . $year_e_term . ')  - ' . $row['name_b_center'] . '
					(' . $row['date_start_class'] . ' - ' . $row['date_end_class'] . ')
					</option>';
                } else {
                    print '<option value="' . $id_e_term . '"  data-center="' . $row['id_b_center'] . '">' . $season_e_term . ' - ' . $type_e_term . ' (' . $year_e_term . ')  - ' . $row['name_b_center'] . '
					(' . $row['date_start_class'] . ' - ' . $row['date_end_class'] . ')
					</option>';
                }
            }
        }
    }
    public function term_reg_in_center($id_center, $date, $year2, $selected)
    {
        $year_2 = $year2 + 1;
        $year_3 = $year2 - 1;
        $sql_search = "SELECT *  FROM `edu_term` , `basic_center`
				WHERE `center_e_term` IN (" . $id_center . ")
				AND (`year_e_term`='" . $year2 . "' OR `year_e_term`='" . $year_2 . "' OR `year_e_term`='" . $year_3 . "')
				AND `center_e_term`=`id_b_center` ORDER BY `center_e_term`";
        $result = mysql_query($sql_search);
        while ($row = mysql_fetch_array($result)) {
            $id_e_term = $row['id_e_term'];
            $year_e_term = $row['year_e_term'];
            $season_e_term = $row['season_e_term'];
            $date_start_reg = $row['date_start_reg'];
            $date_end_reg = $row['date_end_reg'];
            $type_e_term = $row['type_e_term'];
            $Converter = new Converter;
            list($year, $month, $day) = preg_split('-/-', $date_start_reg);
            $g2j = $Converter->JalaliToGregorian($year, $month, $day);
            $date_start_reg2 = $g2j[0] . '-' . $g2j[1] . '-' . $g2j[2];
            $Converter = new Converter;
            list($year, $month, $day) = preg_split('-/-', $date_end_reg);
            $g2j = $Converter->JalaliToGregorian($year, $month, $day);
            $date_end_reg2 = $g2j[0] . '-' . $g2j[1] . '-' . $g2j[2];
            $active_date = strtotime($date_start_reg2);
            $inactive_date = strtotime($date_end_reg2);
            $date_today = strtotime($date);
            if (($date_today <= $inactive_date) && ($date_today >= $active_date)) {
                if ($id_e_term == $selected) {
                    print '<option value="' . $id_e_term . '"  data-center="' . $row['id_b_center'] . '" selected>' . $season_e_term . ' - ' . $type_e_term . ' (' . $year_e_term . ')  - ' . $row['name_b_center'] . '
					(' . $row['date_start_class'] . ' - ' . $row['date_end_class'] . ')
					</option>';
                } else {
                    print '<option value="' . $id_e_term . '"  data-center="' . $row['id_b_center'] . '">' . $season_e_term . ' - ' . $type_e_term . ' (' . $year_e_term . ')  - ' . $row['name_b_center'] . '
					(' . $row['date_start_class'] . ' - ' . $row['date_end_class'] . ')
					</option>';
                }
            }
        }
    }
    public function show_quota($id_center, $select)
    {
        $out = '';
        $sql_search = "SELECT *  FROM `financial_quota` WHERE `center_finquo` = '" . $id_center . "' AND `active`='y'";
        $res = mysql_query($sql_search);
        while ($row = mysql_fetch_array($res)) {
            if ($row['id_finquo'] == $select) {
                $out .= '<option value="' . $row['id_finquo'] . '" selected="selected">' . $row['title_finquo'] . '</option>';
            } else {
                $out .= '<option value="' . $row['id_finquo'] . '">' . $row['title_finquo'] . '</option>';
            }
        }
        return $out;
    }
    public function check_register_class($student, $class)
    {
        $sql_res = mysql_query("SELECT COUNT(`id_stu_reg`) AS `c`  FROM `student_register` WHERE `class_stu_reg` = '" . $class . "'
								 AND `student_stu_reg` = '" . $student . "' ");
        $row = mysql_fetch_object($sql_res);
        if ($row->c == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function show_account_return($id_center, $selected)
    {
        $out = '';
        $sql_search = "SELECT *  FROM `financial_account`
				WHERE `center_finacc` = '" . $id_center . "' AND `active`=1";
        $result = mysql_query($sql_search);
        while ($row = mysql_fetch_array($result)) {
            $id_finacc = $row['id_finacc'];
            $bank_finacc = $row['bank_finacc'];
            if ($selected == $id_finacc) {
                $out .= '<option selected="selected" value="' . $id_finacc . '">' . $bank_finacc . '</option>';
            } else {
                $out .= '<option value="' . $id_finacc . '">' . $bank_finacc . '</option>';
            }
        }
        return $out;
    }
    public function show_bank_return($selected)
    {
        $output = '';
        $sql_show = "SELECT * FROM `basic_bank` ORDER BY `basic_bank`.`name_bb` ASC";
        $res_show = mysql_query($sql_show);
        while ($row = mysql_fetch_array($res_show)) {
            if ($selected == $row['id_bb']) {
                $output .= '<option selected="selected" value="' . $row['id_bb'] . '">' . $row['name_bb'] . '</option>';
            } else {
                $output .= '<option value="' . $row['id_bb'] . '">' . $row['name_bb'] . '</option>';
            }
        }
        return $output;
    }
    public function register_fee($student, $code_class_main)
    {
        $all_pardakht = 0;
        $all_pardakhtha = 0;
        $nahve_pardakht = '';
        $baghimande_money = 0;
        $total_fee = 0;
        $sql_pardakhtha = mysql_query("SELECT `money_stu_reg`,`type_stu_rec` ,`number_stu_rec`,`date_stu_reg`
		FROM `student_recipt`
		WHERE `student_stu_rec` = '" . $student . "' AND `class_id` ='" . $code_class_main . "'");
        while ($rowi = mysql_fetch_array($sql_pardakhtha)) {
            $money_stu_reg = $rowi['money_stu_reg'];
            $number_fish_ha = $rowi['number_stu_rec'];
            $date_fish_ha = $rowi['date_stu_reg'];
            $type_stu_rec = $rowi['type_stu_rec'];
            $all_pardakhtha += $money_stu_reg;
            if ($type_stu_rec == 'f') {
                $nahve_pardakht .= 'شماره فیش ' . $number_fish_ha . ', تاریخ:<span dir="ltr">' . $date_fish_ha . '</span>, مبلغ: ' . $money_stu_reg . ' ریال <br>';
            } elseif ($type_stu_rec == 'c') {
                $nahve_pardakht .= 'شماره چک ' . $number_fish_ha . ', تاریخ:<span dir="ltr">' . $date_fish_ha . '</span>, مبلغ: ' . $money_stu_reg . ' ریال <br>';
            }
        }
        if ($baghimande_money > 0) {
            $baghimandeh = ($total_fee + $baghimande_money) - $all_pardakhtha;
            $print_statuse = 'بدهکار';
        } elseif ($baghimande_money < 0) {
            $baghimandeh = ($total_fee + $baghimande_money) - $all_pardakhtha;
            $print_statuse = 'بستانکار';
        } else {
            $baghimandeh = $total_fee - $all_pardakhtha + $baghimande_money;
        }
        if ($baghimandeh > 0) {
            $statuse_baghimandeh = '(بدهکار)';
        } elseif ($baghimandeh < 0) {
            $statuse_baghimandeh = '(بستانکار)';
        } elseif ($baghimandeh == 0) {
            $statuse_table = 2;
        }
        return array($nahve_pardakht, $baghimande_money, $baghimandeh, $print_statuse, $statuse_baghimandeh, $statuse_table, $all_pardakhtha);
    }
    public function show_register_info($id_reg)
    {
        $sql_1 = mysql_query("SELECT *  FROM `student_register_view` WHERE `id_stu_reg` = " . $id_reg);
        while ($row = mysql_fetch_array($sql_1)) {
            $this->student_stu_reg = $row['student_stu_reg'];
            $this->class_stu_reg = $row['class_stu_reg'];
            $this->date_stu_reg = $row['date_stu_reg'];
            $this->code_e_class = $row['code_e_class'];
            $this->name_b_center = $row['name_b_center'];
            $this->family_mas = $row['family_mas'];
            $this->name_stu = $row['name_stu'];
            $this->family_stu = $row['family_stu'];
            $this->pic_stu = $row['pic_stu'];
            $this->name_e_level = $row['name_e_level'];
            $this->term_stu_reg = $row['term_stu_reg'];
            $this->type_stu_reg = $row['type_stu_reg'];
            $this->id_e_level = $row['id_e_level'];
        }
    }
    public function show_register_info_4_edit($id_reg)
    {
        $sql_quota = mysql_query("SELECT *
		FROM `student_register` ,`student_info`,`edu_class`
		WHERE `id_stu_reg` = " . $id_reg . "
		AND `student_stu_reg`=`id_stu`
		AND `class_stu_reg`=`id_e_class`");
        while ($row = mysql_fetch_array($sql_quota)) {
            $this->date_stu_reg = $row['date_stu_reg'];
            $this->quota_stu_reg = $row['quota_stu_reg'];
            $this->quotaid_stu_reg = $row['quotaid_stu_reg'];
            $this->quotatype_stu_reg = $row['quotatype_stu_reg'];
            $this->quotawho_stu_re = $row['quotawho_stu_re'];
            $this->term_stu_reg = $row['term_stu_reg'];
            $this->student_stu_reg = $row['student_stu_reg'];
            $this->class_stu_reg = $row['class_stu_reg'];
            $this->term_stu_reg = $row['term_stu_reg'];
            $this->use_ghabli = $row['use_ghabli'];
            $this->id_preneed = $row['id_preneed'];
            $this->statuse_preneed = $row['statuse_preneed'];
            $this->code_e_class = $row['code_e_class'];
            $this->name_stu = $row['name_stu'];
            $this->family_stu = $row['family_stu'];
            $this->letter = $row['letter'];
            $this->who_stu_reg = $row['who_stu_reg'];
            $this->back_who = $row['back_who'];
            $this->back_date = $row['back_date'];
            $this->back_money = $row['back_money'];
            $this->id_e_center = $row['id_e_center'];
            $this->register = 'yes';
            if ($row['book'] == 'y') {
                $this->book = 'yes';
            }
            if ($row['cd'] == 'y') {
                $this->cd = 'yes';
            }
            if ($row['tape'] == 'y') {
                $this->tape = 'yes';
            }
        }
    }
    public function register_edit($term, $class, $preclass, $date_persian, $quota_stu_reg, $id_finquo, $quotatype_stu_reg, $quota_who, $letter_number, $book, $tape, $cd, $id_preneed, $statuse_preneed, $id_stu_reg, $person, $student)
    {
        $sql_1 = "
		UPDATE `student_register` SET `term_stu_reg`='" . $term . "',`class_stu_reg` ='" . $class . "' ,`type_stu_reg` = 'fix' ,`modifydate_stu_reg` = '" . $date_persian . "' ,`quota_stu_reg` = '" . $quota_stu_reg . "' ,`quotaid_stu_reg` = '" . $id_finquo . "' ,`quotatype_stu_reg` = '" . $quotatype_stu_reg . "' ,`quotawho_stu_re` = '" . $quota_who . "' ,`letter` = '" . $letter_number . "' ,`book`='" . $book . "',`tape`='" . $tape . "',`cd`='" . $cd . "',`id_preneed`='" . $id_preneed . "',`statuse_preneed`='" . $statuse_preneed . "',`who_stu_edit`= '" . $person . "' WHERE `id_stu_reg`=" . $id_stu_reg . ";
		";

        mysql_query("BEGIN");
        $res_1 = mysql_query($sql_1);
        if (($res_1)) {
            $this->update_register($class);
            $this->update_register($preclass);
            $logg = new logg();
            //------------------------------------------------------
            $logg->add($_SESSION[PREFIXOFSESS . 'idp'], ' ویرایش ثبت نام در کلاس', $student, $sql_1 . $sql_2 . $sql_3, $class);
            //------------------------------------------------------
            mysql_query("COMMIT");
            return true;
        } else {
            mysql_query("ROLLBACK");
            return false;
        }
    }
    public function check_class_4_register($student, $new_class, $preClass)
    {
        if ($new_class == $preClass) {
            return true;
        } else {
            $sqlooo = "SELECT `capacity_class`,`reg_internet` ,`registers` FROM `edu_class` WHERE `id_e_class` =" . $new_class;
            $res = mysql_query($sqlooo);
            $row = mysql_fetch_object($res);
            $capacity_class = $row->capacity_class + $row->reg_internet;
            $registers = $row->registers;
            if ($registers === $capacity_class) {
                return false;
            } else {
                return true;
            }
        }
    }
    public function kasr_shahrieh($quota_stu_reg, $quotaid_stu_reg)
    {
        if ($quota_stu_reg == 'y') {
            $sql = mysql_query("SELECT *  FROM `financial_quota` WHERE `id_finquo` =" . $quotaid_stu_reg);
            $row = mysql_fetch_object($sql);
            $title_finquo = $row->title_finquo;
            $discount_finquo = $row->discount_finquo;
        } else {
            $title_finquo = '';
            $discount_finquo = 0;
        }
        return array($title_finquo, $discount_finquo);
    }
    public function reg_category($center)
    {
        $tr = '';
        $td = '';
        $out = '';
        $sql = mysql_query("SELECT * FROM `edu_category` WHERE `active` = 1 ORDER BY `edu_category`.`name_e_cat` ASC");
        while ($row = mysql_fetch_object($sql)) {
            $tr .= '<tr id="trc_' . $row->id_e_cat . '">
			<td>' . $row->name_e_cat . '</td><td><a class="btn btn-outline btn-circle btn-sm green" href="#" onClick="select_cat(\'trc_' . $row->id_e_cat . '\' , ' . $row->id_e_cat . ')">انتخاب</a></td>
			</tr>';
        }
        $out .= '<table class="table table-hover table-advance" id="table_list_cat">
		<thead><tr><th>عنوان دوره</th><th>انتخاب</th></tr></thead>
		<tbody>' . $tr . '</tbody></table>';
        return $out;
    }
    public function reg_term_select($id_center, $today, $year)
    {
        $year_2 = $year + 1;
        $year_3 = $year - 1;
        $sql_search = "SELECT *  FROM `edu_term` , `basic_center`
			WHERE `center_e_term` = '" . $id_center . "'
			AND (`year_e_term`='" . $year . "' OR `year_e_term`='" . $year_2 . "' OR `year_e_term`='" . $year_3 . "')
			AND `center_e_term`=`id_b_center`";
        $result = mysql_query($sql_search);
        $m = 0;
        $tr = $out = '';
        while ($row = mysql_fetch_array($result)) {
            $id_e_term = $row['id_e_term'];
            $year_e_term = $row['year_e_term'];
            $season_e_term = $row['season_e_term'];
            $date_start_reg = $row['start_net'];
            $date_end_reg = $row['end_net'];
            $type_e_term = $row['type_e_term'];
            $Converter = new Converter;
            list($year, $month, $day) = preg_split('-/-', $date_start_reg);
            $g2j = $Converter->JalaliToGregorian($year, $month, $day);
            $date_start_reg2 = $g2j[0] . '-' . $g2j[1] . '-' . $g2j[2];
            $Converter = new Converter;
            list($year, $month, $day) = preg_split('-/-', $date_end_reg);
            $g2j = $Converter->JalaliToGregorian($year, $month, $day);
            $date_end_reg2 = $g2j[0] . '-' . $g2j[1] . '-' . $g2j[2];
            $active_date = strtotime($date_start_reg2);
            $inactive_date = strtotime($date_end_reg2);
            $date_today = strtotime($today);
            if (($date_today <= $inactive_date) && ($date_today >= $active_date)) {
                $m++;
                $tr .= '
				<tr  id="tr_' . $id_e_term . '">
					<td>' . $type_e_term . ' - ' . $season_e_term . ' ' . $year_e_term . '</td>
					<td>' . $row['date_start_class'] . '<br>' . $row['date_end_class'] . '</td>
					<td>' . $date_end_reg . '</td>
					<td><a class="btn btn-outline btn-circle btn-sm green" href="#" onClick="select_term(\'tr_' . $id_e_term . '\' , ' . $id_e_term . ')">انتخاب</a></td>
				</tr>';
            }
        }
        $out .= '<table class="table table-hover table-advance" id="table_list_term">
		<thead><tr><th>عنوان ترم</th><th> شروع کلاس ها</br> پایان کلاس ها</th><th> پایان ثبت نام</th><th>انتخاب</th></tr></thead>
		<tbody>' . $tr . '</tbody></table>';
        return $out;
    }

    public function update_register($id_class)
    {

        $sql = "
		UPDATE `edu_class` SET  `registers` = (
		SELECT count(*) as `c` FROM `student_register` WHERE `class_stu_reg` = " . $id_class . " AND `type_stu_reg` LIKE 'fix')
		WHERE `id_e_class`= " . $id_class;
        mysql_query($sql);
    }
}