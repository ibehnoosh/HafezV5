<?php
class discount
{
    public function how_many_term($student)
    {
        $query = "
		SELECT  count(*) AS `c` FROM `view_preneed` WHERE `student_stu_reg` = " . $student . " AND
		 `free` LIKE 'n' AND `type_stu_reg` LIKE 'fix'";
        $sql = mysql_query($query);
        $row = mysql_fetch_object($sql);
        $c = $row->c;
        return $c;
    }
    public function form_discount($student, $term)
    {
        $query = "SELECT * FROM `financial_dis_form` WHERE `student` = " . $student . " AND `term` = " . $term;
        $sql = mysql_query($query);
        $row = mysql_fetch_object($sql);
        $statuse = $row->statuse;
        if ($statuse == 'Ok') {
            return array(true, $row->discount);
        } else {
            return array(false, 0);
        }
    }
    public function relate($center, $student)
    {
        $sql = mysql_query("SELECT * FROM `view_relate` WHERE `stu_cen` LIKE '%" . $center . $student . "%' ");
        $row = mysql_fetch_object($sql);
        if ($row->id > 0) {
            return array(true, substr_count($row->student, ','));
        } else {
            return array(false, 0);
        }
    }
    public function dis($c, $discount_form, $center, $has_relate, $num_relate)
    {
        $dis = 0;
        $array_dis = array();
        if ($c > 0) {
            $sql = mysql_query("SELECT * FROM `financial_quota`
			WHERE `center_finquo`=" . $center . " AND `term` <= " . $c . " AND `term` > 0 ORDER BY `discount_finquo` DESC LIMIT 0,1");
            $row = mysql_fetch_object($sql);
            $id_c = $row->id_finquo;
            if ($id_c != null) {
                $dis++;
                $array_dis[$dis]["id"] = $id_c;
                $array_dis[$dis]["title"] = $row->title_finquo;
                $array_dis[$dis]["dis"] = $row->discount_finquo;
            }
        }
        if ($discount_form > 0) {
            $sql = mysql_query("SELECT * FROM `financial_quota` WHERE `id_finquo` =" . $discount_form);
            $row = mysql_fetch_object($sql);
            $dis++;
            $array_dis[$dis]["id"] = $row->id_finquo;
            $array_dis[$dis]["title"] = $row->title_finquo;
            $array_dis[$dis]["dis"] = $row->discount_finquo;
        }
        if ($has_relate) {
            $sql = mysql_query("SELECT `title_finquo`,`id_finquo`,`discount_finquo` FROM `financial_quota`
			WHERE `center_finquo`=" . $center . " AND `family`=" . $num_relate);
            $row = mysql_fetch_object($sql);
            $id_card = $row->id_finquo;
            if ($id_card != null) {
                $dis++;
                $array_dis[$dis]["id"] = $id_card;
                $array_dis[$dis]["title"] = $row->title_finquo;
                $array_dis[$dis]["dis"] = $row->discount_finquo;
            }
        }
        if ($dis > 0) {
            $max = 0;
            $id = 1;
            $sum = 0;
            for ($i = 1; $i <= $dis; $i++) {
                if ($array_dis[$i]["dis"] > $max) {
                    $max = $array_dis[$i]["dis"];
                    $id = $i;
                    $sum += $array_dis[$i]["dis"];
                } else {
                    $max = $max;
                    $sum += $array_dis[$i]["dis"];
                }
            }
            return array($array_dis[$id]["id"], $array_dis[$id]["title"], $array_dis[$id]["dis"]);
        }
    }
    public function relate_student($center, $student, $term)
    {
        $sql_relate_date = mysql_query("SELECT `date_relate`  FROM `edu_term`
		where `id_e_term`=" . $term);
        $row_relate = mysql_fetch_array($sql_relate_date);
        $date_relate = $row_relate['date_relate'];
        $Converter = new Converter;
        list($year, $month, $day) = preg_split('-/-', $date_relate);
        $g2j = $Converter->JalaliToGregorian($year, $month, $day);
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
        $date_english = $g2j[0] . "-" . $m2 . "-" . $ddd;
        $sql = mysql_query("
		SELECT count(*) as `c` FROM `view_relate_request`
		WHERE
		(`student` = " . $student . "
		  AND `statuse`='تایید شده'
		  AND `center`= " . $center . "
		  AND `when` >= '" . $date_english . "')
	   OR
	   (`main`=
	        (SELECT `main` FROM `view_relate_request`
			WHERE
			`student` = " . $student . "
			AND `statuse`='تایید شده'
			AND `center`= " . $center . "
			AND `when` >= '" . $date_english . "')
			AND `when` >= '" . $date_english . "' AND `statuse`='تایید شده' )");
        $row = mysql_fetch_object($sql);
        if ($row->c > 1) {
            if ($row->c > 2) {
                $ccc = 3;
            } else {
                $ccc = 2;
            }
            return array(true, $ccc);
        } else {
            return array(false, 0);
        }
    }
    public function dis_student($c, $center, $has_relate, $num_relate, $term)
    {
        $dis = 0;
        $array_dis = array();
        $Converter = new Converter;
        $date = date("Y , m , d");
        list($year, $month, $day) = preg_split('/,/', $date);
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
        $sql_dic = mysql_query("SELECT * FROM `edu_term` WHERE `id_e_term`=" . $term . " AND `start_off`<= '" . $date_persian . "' AND `end_off` >= '" . $date_persian . "'");
        $num_term = mysql_num_rows($sql_dic);
        if ($num_term > 0) {
            $sql_which_dis = mysql_fetch_object($sql_dic);
            $kkkk = $sql_which_dis->intt;
            $sql = mysql_query("SELECT * FROM `financial_quota` WHERE `id_finquo`=" . $kkkk);
            $row = mysql_fetch_object($sql);
            $dis++;
            $array_dis[$dis]["id"] = $row->id_finquo;
            $array_dis[$dis]["title"] = $row->title_finquo;
            $array_dis[$dis]["dis"] = $row->discount_finquo;
        }
        if ($c > 0) {
            $sql = mysql_query("SELECT * FROM `financial_quota`
			WHERE `center_finquo`=" . $center . " AND `term` <= " . $c . " AND `term` > 0 ORDER BY `discount_finquo` DESC LIMIT 0,1");
            $row = mysql_fetch_object($sql);
            $id_c = $row->id_finquo;
            if ($id_c != null) {
                $dis++;
                $array_dis[$dis]["id"] = $id_c;
                $array_dis[$dis]["title"] = $row->title_finquo;
                $array_dis[$dis]["dis"] = $row->discount_finquo;
            }
        }
        if ($has_relate) {
            $sql = mysql_query("SELECT `title_finquo`,`id_finquo`,`discount_finquo` FROM `financial_quota`
			WHERE `center_finquo`=" . $center . " AND `family`=" . $num_relate);
            $row = mysql_fetch_object($sql);
            $id_card = $row->id_finquo;
            if ($id_card != null) {
                $dis++;
                $array_dis[$dis]["id"] = $id_card;
                $array_dis[$dis]["title"] = $row->title_finquo;
                $array_dis[$dis]["dis"] = $row->discount_finquo;
            }
        }
        if ($dis > 0) {
            $max = 0;
            $id = 1;
            $sum = 0;
            for ($i = 1; $i <= $dis; $i++) {
                if ($array_dis[$i]["dis"] > $max) {
                    $max = $array_dis[$i]["dis"];
                    $id = $i;
                    $sum += $array_dis[$i]["dis"];
                } else {
                    $max = $max;
                    $sum += $array_dis[$i]["dis"];
                }
            }

            if (($dis > 1)) {
                return list($id, $title, $dis) = $this->find_discount($center, $sum, 20);
            } else {
                return array($array_dis[$id]["id"], $array_dis[$id]["title"], $array_dis[$id]["dis"]);
            }
        }
    }
    public function main($student, $level, $center, $term)
    {
        $c = $this->how_many_term($student);
        list($yes, $discount_form) = $this->form_discount($student, $term);
        list($has_relate, $num_relate) = $this->relate($center, $student);
        list($id, $title, $dis) = $this->dis($c, $discount_form, $center, $has_relate, $num_relate);
        return array($id, $title, $dis, $c, $card);
    }
    public function main_student($student, $level, $center, $term)
    {
        $c = $this->how_many_term($student);
        list($has_relate, $num_relate) = $this->relate_student($center, $student, $term);
        list($id, $title, $dis) = $this->dis_student($c, $center, $has_relate, $num_relate, $term);
        return array($id, $title, $dis, $c, false);
    }
    public function find_discount($center, $dis, $max)
    {
        $disSearch = 0;
        ($dis > $max) ? $disSearch = $max : $disSearch = $dis;

        $sql = "SELECT * FROM `financial_quota` WHERE `type_finquo` LIKE 'multi' AND `discount_finquo` = " . $disSearch . " AND `active`='y' AND `center_finquo` =  " . $center;
        $res = mysql_query($sql);
        $row = mysql_fetch_object($res);
        return array($row->id_finquo, $row->title_finquo, $row->discount_finquo);
    }
}