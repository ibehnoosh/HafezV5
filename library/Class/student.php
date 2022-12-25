<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
class student
{
	function list_fld() //ok
	{
		$fld = array();
		$result = mysql_query('select * from student_info LIMIT 0 ,1');

		for ($i = 0; $i < mysql_num_fields($result); $i++) {
			$name = mysql_field_name($result, $i);
			array_push($fld, $name);
		}
		return $fld;
	}
	function list_fld_ad() //ok
	{
		$fld = array();
		$result = mysql_query('select * from site_student_info LIMIT 0 ,1');

		for ($i = 0; $i < mysql_num_fields($result); $i++) {
			$name = mysql_field_name($result, $i);
			array_push($fld, $name);
		}
		return $fld;
	}
	function generate_unique_id($sal, $mah)
	{
		if ($mah < 10)
			$digit = 0;
		else
			$digit = '';
		$num = '';

		for ($i = 0; $i < 4; $i++) {
			$num .= rand(0, 9);
		}
		$student_number = $sal . $digit . $mah . $num;
		$check = mysql_query("SELECT id_stu FROM student_info WHERE id_stu = " . $student_number);
		if (mysql_num_rows($check) == 0) {
			return $student_number;
		} else {
			return $this->generate_unique_id($sal, $mah);
		}
	}

	function show($user) //ok
	{
		$fld = array();
		$fld = $this->list_fld();
		$result = mysql_query("select * from student_info where  id_stu='" . $user . "'");
		$row = mysql_fetch_array($result);

		foreach ($fld as $key => $val) {
			if ($row[$val] == '0000-00-00') $real_value = '';
			else $real_value = $row[$val];

			$this->$val = $real_value;
		}
	}

	function show_add($user) //ok
	{
		$fld = array();
		$fld = $this->list_fld_ad();
		$result = mysql_query("select * from site_student_info where  id='" . $user . "'");
		$row = mysql_fetch_array($result);

		foreach ($fld as $key => $val) {
			if ($row[$val] == '0000-00-00') $real_value = '';
			else $real_value = $row[$val];

			$this->$val = $real_value;
		}
	}

	function kasr_shahrieh($id)
	{
		$resul = mysql_query("SELECT `discount_finquo` FROM `financial_quota` WHERE `id_finquo` =" . $id);
		while ($row = mysql_fetch_array($resul)) {
			$discount_finquo = $row['discount_finquo'];
		}
		return $discount_finquo;
	}

	function pardakht($student, $class, $term)
	{
		$sql = "
			SELECT SUM(`money_stu_reg`) AS `money` FROM `student_recipt`
			WHERE `student_stu_rec` = '" . $student . "' AND `class_id` = '" . $class . "'
		 UNION 
			SELECT SUM(`money_pay`) AS `money` FROM `student_payment` 
			WHERE `student_pay` = '" . $student . "'  AND `class_pay` = '" . $class . "'
		 UNION 
			SELECT SUM(`money_pm`) AS `money` FROM `student_paypermas` 
			WHERE `student_pm` = '" . $student . "'  AND `class_pm` = '" . $class . "'";

		$result = mysql_query($sql);
		$money = 0;
		while ($row = mysql_fetch_array($result)) {
			$money += $row['money'];
		}
		return $money;
	}

	function pardakht_to_student($student, $class, $term)
	{
		$sql = "SELECT `money_sr` FROM `student_recives` 
		WHERE `student_sr` = '" . $student . "' AND `term_sr` = '" . $term . "' AND `class_id` = '" . $class . "'";

		$result = mysql_query($sql);
		$money = 0;
		while ($row = mysql_fetch_array($result)) {
			$money += $row['money_sr'];
		}
		return $money;
	}

	function baghimanade($id)
	{
		$i = 0;
		$baghimandeh_final = 0;
		$string = "
		SELECT `term_stu_reg` , `class_stu_reg` , `cd` , `book` , `tape` , `type_stu_reg` , `id_e_level` , `kasr` , 
		`quota_stu_reg` , `quotaid_stu_reg` , `id_stu_reg` , `back_money`,`fee_finfee`, `book_finfee`, `cd_finfee`
		FROM `student_register` ,`edu_class`,`financial_fee`
		WHERE `student_stu_reg` = '" . $id . "'
		AND `term_stu_reg` > FirstTermForCalculateFee
		AND `id_e_class` = `class_stu_reg`
		AND `term_stu_reg`=`term_finfee`
		AND `id_e_level`=`level_finfee`
		";

		$sql = mysql_query($string);

		while ($row = mysql_fetch_object($sql)) {
			$tahvil = '';
			$mashmole_kasr = '';
			$pardakht = '';
			$ghabel_pardakht = '';
			$kasr_money = '';
			$kasr_darsad = '';
			$shahriye = '';
			$cd = '';
			$book = '';
			$class_info = '';
			$type = '';
			$oo = '';
			$i++;
			//------------------------------------------------------------------------------شهریه کلاس ها
			$shahriye = $row->fee_finfee;
			$cfee = $shahriye;
			if ($row->book == 'y') {
				$shahriye = $shahriye + $row->book_finfee;
				$cbook = $row->book_finfee;
			}
			if ($row->cd == 'y') {
				$shahriye = $shahriye + $row->cd_finfee;
				$ccd = $row->cd_finfee;
			}
			if ($row->tape == 'y') {
				$shahriye = $shahriye + $row->tape_finfee;
				$ctap = $row->tape_finfee;
			}
			//----------------------------------------------------------------------------------سهمیه ها
			if ($row->quota_stu_reg == 'y') {
				$kasr_darsad = $this->kasr_shahrieh($row->quotaid_stu_reg);
				$kasr_money = ($cfee * $kasr_darsad) / 100;
			} else {
				$kasr_darsad = 0;
				$kasr_money = 0;
			}
			//----------------------------------------------------------------------------------قابل پرداخت
			$ghabel_pardakht = $shahriye - $kasr_money;
			//----------------------------------------------------------------------------------پرداخت شده
			$pardakht = $this->pardakht($id, $row->class_stu_reg, $row->term_stu_reg);
			//----------------------------------------------------------------------------------
			$tahvil = $row->back_money; // تحویل نقدی به دانشجوی
			//----------------------------------------------------------------------------------
			$tahivile_wf = $this->pardakht_to_student($id, $row->class_stu_reg, $row->term_stu_reg);
			$tahvil = $tahvil + $tahivile_wf;
			//----------------------------------------------------------------------------------

			if ($row->type_stu_reg == 'fix') {
				$baghimandeh = $ghabel_pardakht - $pardakht + $tahvil;
			} elseif ($row->type_stu_reg == 'transfer') {
				$ghabel_parkhat_return = $cfee - $kasr_money;

				$baghimandeh = (($ghabel_parkhat_return * $row->kasr) / 100) - $pardakht + $tahvil;
			} elseif ($row->type_stu_reg == 'return') {
				$ghabel_parkhat_return = $cfee - $kasr_money;
				$baghimandeh = (($ghabel_parkhat_return * $row->kasr) / 100) - $pardakht + $tahvil;
			}

			$baghimandeh_final = $baghimandeh_final + $baghimandeh;
		}
		return $baghimandeh_final;
	}

	function update_baghimandeh($id)
	{
		list($baghimandeh, $reason) = $this->find_baghimande($id);
		$sql = "UPDATE `student_info` SET `mandeh`='" . $baghimandeh . "',`reson_mandeh`='" . $reason . "' WHERE `id_stu`='" . $id . "';";
		if (mysql_query($sql))
			return true;
	}
	function type_stu_reg($type)
	{
		switch ($type) {
			case 'fix':
				$out = 'قطعی';
				break;
			case 'transfer':
				$out = 'انتقال به ترم بعد';
				break;
			case 'return':
				$out = 'برگشت شهریه';
				break;
		}
		return $out;
	}
	function sanavat_tahsili($id_student, $work_where, $button) //ok
	{
		$out = '';
		if ($button) {
			$out .= '<table class="table table-striped table-bordered table-hover">
			<tr>
			<th>#</th><th>کد کلاس</th><th>ترم</th><th>سطح</th><th>استاد</th><th>وضعیت ثبت نام</th><th>تاریخ ثبت نام</th><th>نمره</th>
			<th>وضعیت</th><th class=" hidden-print">چاپ</th>
			</tr>';
		} else {
			$out .= '<table class="table table-striped table-bordered table-hover">
			<tr>
			<th>#</th><th>کد کلاس</th><th>ترم</th><th>سطح</th><th>استاد</th><th>وضعیت ثبت نام</th><th>تاریخ ثبت نام</th><th>نمره</th><th>وضعیت</th>
			</tr>';
		}
		//------------------------------------------------------
		$sql = "SELECT 
		`id_stu_reg`,`student_stu_reg`,`date_stu_reg`,`type_stu_reg`,`class_stu_reg`,
		`statuse_reg_stu`,`mark_grade`, `mark_result` 
		,`year_e_term` , `season_e_term` , `type_e_term`, `code_e_class`,`name_mas`,`family_mas`,`name_e_level`
		FROM
			`student_register` ,`edu_term`,`edu_class`,`master_info`,`edu_level`
		WHERE 
		`student_stu_reg` = '" . $id_student . "'
		AND
		`center_e_term` IN (" . $work_where . ")
		AND
		`edu_term`.`id_e_term` =`term_stu_reg`
		AND
		`class_stu_reg`=`id_e_class`
		AND
		`id_mas`=`id_e_master`
		AND
		`edu_class`.`id_e_level` =`edu_level`.`id_e_level` 
		UNION 
		SELECT 
		`id_stu_reg`,`student_stu_reg`,`date_stu_reg`,`type_stu_reg`,`class_stu_reg`,
		`statuse_reg_stu`,`mark_grade`, `mark_result` 
		,'' AS `year_e_term` , ' ' AS `season_e_term` ,'pr' AS `type_e_term`, `class_stu_reg` AS `code_e_class`,`name_mas`,`family_mas`,`name_e_level`
		FROM
			`pri_student_register` ,`pri_edu_class`,`master_info`,`edu_level`
		WHERE 
		`student_stu_reg` = '" . $id_student . "'
		AND
		`class_stu_reg`=`id_e_class`
		AND
		`id_mas`=`id_e_master`
		AND
		`pri_edu_class`.`id_e_level` =`edu_level`.`id_e_level`
		
		ORDER BY `date_stu_reg` ASC 
		";
		$res = mysql_query($sql);
		$j = 0;
		while ($row = mysql_fetch_array($res)) {
			$j++;
			$sum = 0;
			$type = $row['type_e_term'];
			$mark_grade_array = explode("-", $row['mark_result']);
			$count_all = count($mark_grade_array);
			for ($i = 0; $i <= $count_all; $i++) {
				if ($mark_grade_array[$i]) {
					$value = substr($mark_grade_array[$i], 0, 5);

					$sum += $value;
				}
			}
			settype($sum, "float");
			if ($row['statuse_reg_stu'] == 'نامشخص') {
				if ($sum >= 70)
					$statuse = 'قبول';
				elseif ($sum == 0)
					$statuse = 'نامشخص';
				else
					$statuse = 'مردود';
			} else {
				$statuse = $row['statuse_reg_stu'];
			}
			if ($button) {
				$td = '<td class=" hidden-print">
					<a class="btn btn-circle blue btn-outline ajax-demo" data-toggle="modal" href="#"  data-url="student/education/almosana.php?id=' . $row['id_stu_reg'] . '&code_class=' . $row['class_stu_reg'] . '">
					<i class="fa fa-print"></i></a></td>';
			} else {
				$td = '';
			}
			$mark = '
				<a class="btn btn-circle blue btn-outline ajax-demo  hidden-print" data-toggle="modal" href="#"  data-url="student/education/sanavat_mark_details.php?i=' . $row['id_stu_reg'] . '">' . $sum . '</a><span class="visible-print">' . $sum . '</span>';
			$out .= '
			<tr>
				<th>' . $j . '</th><td>' . $row['code_e_class'] . '</td>
				<td align="right">' . $row['season_e_term'] . ' <b>' . $row['year_e_term'] . '</b> - ' . $type . '</td><td align="right">' . $row['name_e_level'] . '</td>
				<td align="right">' . $row['family_mas'] . ' ' . $row['name_mas'] . '</td><td>' . $this->type_stu_reg($row['type_stu_reg']) . '</td>
				<td>' . $row['date_stu_reg'] . '</td><td>' . $mark . '</td><td>' . $statuse . '</td>
				' . $td . '
			</tr>
			';
		}
		$out .= '</table>';

		return $out;
	}

	function merge_2_student($new, $old)
	{

		$sql1 = "UPDATE `student_payment` SET `student_pay`='" . $new . "' WHERE `student_pay`='" . $old . "';";
		if (mysql_query($sql1))
			print 'Payment<br>';

		$sql2 = "UPDATE `student_present` SET `student_sp`='" . $new . "' WHERE `student_sp`='" . $old . "';";
		if (mysql_query($sql2))
			print 'Present<br>';

		$sql3 = "UPDATE `student_paypermas` SET `student_pm`='" . $new . "' WHERE `student_pm`='" . $old . "';";
		if (mysql_query($sql3))
			print 'Paypermas<br>';

		$sql4 = "UPDATE `student_recipt` SET `student_stu_rec`='" . $new . "' WHERE `student_stu_rec`='" . $old . "';";
		if (mysql_query($sql4))
			print 'Recipt<br>';

		$sql5 = "UPDATE `student_recives` SET `student_sr`='" . $new . "' WHERE `student_sr`='" . $old . "';";
		if (mysql_query($sql5))
			print 'Recives<br>';

		$sql6 = "UPDATE `student_register` SET `student_stu_reg`='" . $new . "' WHERE `student_stu_reg`='" . $old . "';";
		if (mysql_query($sql6))
			print 'Register<br>';

		$sql7 = "UPDATE `site_student_recipt` SET `student_stu_rec`='" . $new . "' WHERE `student_stu_rec`='" . $old . "';";
		if (mysql_query($sql7))
			print 'Recipt<br>';

		$sql8 = "UPDATE `site_student_register` SET `student_stu_reg`='" . $new . "' WHERE `student_stu_reg`='" . $old . "';";
		if (mysql_query($sql8))
			print 'Register<br>';

		$sql11 = "UPDATE `e_examan`  SET `stu`='" . $new . "' WHERE `stu` = '" . $old . "';";
		if (mysql_query($sql11))
			print 'Exam_an<br>';

		$sql12 = "UPDATE `e_exam_stu`  SET `stu`='" . $new . "' WHERE `stu` = '" . $old . "';";
		if (mysql_query($sql12))
			print 'Exam_stu<br>';


		$sql9 = "DELETE  FROM `site_student_info` WHERE `id`='" . $old . "';";
		if (mysql_query($sql9))
			print 'DELETE Info<br>';

		$sql10 = "DELETE  FROM `student_info` WHERE `id_stu`='" . $old . "';";
		if (mysql_query($sql10))
			print 'DELETE Info<br>';
		$this->update_baghimandeh($new);
	}
	function delete_a_student($old)
	{

		$sql1 = "DELETE  FROM  `student_payment` WHERE `student_pay`='" . $old . "';";
		if (mysql_query($sql1))
			print 'Payment<br>';

		$sql2 = "DELETE  FROM `student_present` WHERE `student_sp`='" . $old . "';";
		if (mysql_query($sql2))
			print 'Present<br>';

		$sql3 = "DELETE  FROM `student_paypermas` WHERE `student_pm`='" . $old . "';";
		if (mysql_query($sql3))
			print 'Paypermas<br>';

		$sql4 = "DELETE  FROM `student_recipt`  WHERE `student_stu_rec`='" . $old . "';";
		if (mysql_query($sql4))
			print 'Recipt<br>';

		$sql5 = "DELETE  FROM `student_recives`  WHERE `student_sr`='" . $old . "';";
		if (mysql_query($sql5))
			print 'Recives<br>';

		$sql6 = "DELETE  FROM `student_register`  WHERE `student_stu_reg`='" . $old . "';";
		if (mysql_query($sql6))
			print 'Register<br>';

		$sql7 = "DELETE  FROM `site_student_recipt` WHERE `student_stu_rec`='" . $old . "';";
		if (mysql_query($sql7))
			print 'Recipt<br>';

		$sql8 = "DELETE  FROM `site_student_register`  WHERE `student_stu_reg`='" . $old . "';";
		if (mysql_query($sql8))
			print 'Register<br>';

		$sql11 = "DELETE  FROM `e_examan` WHERE `stu` = '" . $old . "';";
		if (mysql_query($sql11))
			print 'Exam_an<br>';

		$sql12 = "DELETE  FROM `e_exam_stu` WHERE `stu` = '" . $old . "';";
		if (mysql_query($sql12))
			print 'Exam_stu<br>';


		$sql9 = "DELETE  FROM  `site_student_info` WHERE `id`='" . $old . "';";
		if (mysql_query($sql9))
			print 'DELETE Info<br>';

		$sql10 = "DELETE  FROM `student_info` WHERE `id_stu`='" . $old . "';";
		if (mysql_query($sql10))
			print 'DELETE Info<br>';
		print $sql1 . $sql2 . $sql3 . $sql4 . $sql5 . $sql6 . $sql7 . $sql8 . $sql11 . $sql12 . $sql9 . $sql10;; {
		}
	}

	function find_baghimande($id)
	{
		$i = 0;
		$baghimandeh_final = 0;
		$string = "
		SELECT 
			`term_stu_reg` , `class_stu_reg` , `cd` , `book` , `tape` , `type_stu_reg` , `id_e_level` , `kasr` , 
					`quota_stu_reg` , `quotaid_stu_reg` , `id_stu_reg` , `back_money`,`fee_finfee`, `book_finfee`, `cd_finfee`,`discount_finquo`,`money_sr`,`money`

			FROM `student_register` 
			LEFT JOIN  `edu_class`
			ON  `id_e_class` = `class_stu_reg`

			LEFT JOIN `financial_fee`
			ON ( `term_stu_reg`=`term_finfee` AND `id_e_level`=`level_finfee`)

			LEFT JOIN `financial_quota`
			ON `quotaid_stu_reg`=`id_finquo`

			LEFT JOIN `student_recives`
			ON (`student_sr`= `student_stu_reg` AND `term_sr` = `term_stu_reg` AND `student_recives`.`class_id` =  `class_stu_reg`)

			LEFT JOIN (
			select sum(`k`.`money`) AS `money` ,`k`.`cla` from ( SELECT SUM(`money_stu_reg`) AS `money` ,`class_id` AS `cla` FROM `student_recipt` WHERE `student_stu_rec` = '" . $id . "' group BY `class_id` UNION SELECT SUM(`money_pay`) AS `money` , `class_pay` AS `cla` FROM `student_payment` WHERE `student_pay` = '" . $id . "' group by `class_pay` UNION SELECT SUM(`money_pm`) AS `money`, `class_pm` AS `cla` FROM `student_paypermas` WHERE `student_pm` = '" . $id . "' group by `class_pm` ) AS `k` group by `cla`
			) AS `t`
			ON `t`.`cla`=`class_stu_reg`

			WHERE `student_stu_reg` ='" . $id . "'
			AND `term_stu_reg` > ".FIRSTTERMDTOFEE."
			ORDER BY `student_register`.`date_stu_reg` ASC";

		$sql = mysql_query($string);

		while ($row = mysql_fetch_object($sql)) {
			$tahvil = '';
			$mashmole_kasr = '';
			$pardakht = '';
			$ghabel_pardakht = '';
			$kasr_money = '';
			$kasr_darsad = '';
			$shahriye = '';
			$cd = '';
			$book = '';
			$class_info = '';
			$type = '';
			$oo = '';
			$i++;
			//------------------------------------------------------------------------------شهریه کلاس ها
			$shahriye = $row->fee_finfee;
			$cfee = $shahriye;
			if ($row->book == 'y') {
				$shahriye = $shahriye + $row->book_finfee;
				$cbook = $row->book_finfee;
			}
			if ($row->cd == 'y') {
				$shahriye = $shahriye + $row->cd_finfee;
				$ccd = $row->cd_finfee;
			}
			if ($row->tape == 'y') {
				$shahriye = $shahriye + $row->tape_finfee;
				$ctap = $row->tape_finfee;
			}
			//----------------------------------------------------------------------------------سهمیه ها
			if ($row->quota_stu_reg == 'y') {
				//$kasr_darsad=$this->kasr_shahrieh($row->quotaid_stu_reg);
				$kasr_darsad = $row->discount_finquo;
				$kasr_money = ($cfee * $kasr_darsad) / 100;
			} else {
				$kasr_darsad = 0;
				$kasr_money = 0;
			}
			//----------------------------------------------------------------------------------قابل پرداخت
			$ghabel_pardakht = $shahriye - $kasr_money;
			//----------------------------------------------------------------------------------پرداخت شده
			$pardakht = $row->money;
			//----------------------------------------------------------------------------------
			$tahvil = $row->back_money; // تحویل نقدی به دانشجوی
			//----------------------------------------------------------------------------------
			$tahivile_wf = $row->money_sr;
			$tahvil = $tahvil + $tahivile_wf;
			//----------------------------------------------------------------------------------

			$last_statuse = $row->type_stu_reg;

			if ($row->type_stu_reg == 'fix') {
				$baghimandeh = $ghabel_pardakht - $pardakht + $tahvil;
			} elseif ($row->type_stu_reg == 'transfer') {
				$ghabel_parkhat_return = $cfee - $kasr_money;

				$baghimandeh = (($ghabel_parkhat_return * $row->kasr) / 100) - $pardakht + $tahvil;
			} elseif ($row->type_stu_reg == 'return') {
				$ghabel_parkhat_return = $cfee - $kasr_money;
				$baghimandeh = (($ghabel_parkhat_return * $row->kasr) / 100) - $pardakht + $tahvil;
			}

			$baghimandeh_final = $baghimandeh_final + $baghimandeh;
		}
		if ($baghimandeh_final <> 0) {
			if ($last_statuse == 'transfer' & $baghimandeh_final < 0) $reason_mandeh = 'انتقال شهریه';
			elseif ($last_statuse == 'fix' & $baghimandeh_final < 0) $reason_mandeh = 'اضافه واریزی';
			elseif ($last_statuse == 'return' & $baghimandeh_final < 0) $reason_mandeh = 'برگشت بدون پرداخت';
			elseif ($last_statuse == 'return' & $baghimandeh_final > 0) $reason_mandeh = 'برگشت با اضافه پرداخت';
			elseif ($last_statuse == 'fix' & $baghimandeh_final > 0) $reason_mandeh = 'نقص واریزی';
			else $reason_mandeh = 'نامشخص';
		}

		return array($baghimandeh_final, $reason_mandeh);
	}

	function sanavat_mali($id, $work_where, $button)
	{
		$out = '';
		if ($button)
			$out .= '<table class="table table-striped table-bordered table-hover">
		<tr>
			<td colspan="16">سطر سفید: ترم قطعی 
			
			||<span class="bg-blue-sharp"> سطر آبی: ترم برگشت داده شده</span>
			<span class="bg-yellow-saffron">
			 || سطر زرد: انتقال به ترم بعد<span</td>
		</tr>
		<tr>
			<th>#</th><th>تاریخ</th><th>ترم تحصیلی</th><th>کلاس</th><th>کتاب</th><th>cd</th><th>جمع<br>شهریه</th>
			<th>تخفیف</th><th>کسر</th><th>قابل<br>پرداخت</th><th>پرداخت<br>شده</th><th>مشمول<br>کسر</th><th>تحویل<br>به دانشجو</th>
			<th>باقیمانده</th><th>باقیمانده<br>نهایی</th><th>جزئیات</th>
			</tr>';
		else
			$out .= '<table class="table table-striped table-bordered table-hover">
		<tr>
			<td colspan="15">سطر سفید: ترم قطعی 
			
			||<span class="bg-blue-sharp"> سطر آبی: ترم برگشت داده شده</span>
			<span class="bg-yellow-saffron">
			 || سطر زرد: انتقال به ترم بعد<span</td>
		</tr>
		<tr>
			<th>#</th><th>تاریخ</th><th>ترم تحصیلی</th><th>کلاس</th><th>کتاب</th><th>cd</th><th>جمع<br>شهریه</th>
			<th>تخفیف</th><th>کسر</th><th>قابل<br>پرداخت</th><th>پرداخت<br>شده</th><th>مشمول<br>کسر</th><th>تحویل<br>به دانشجو</th>
			<th>باقیمانده</th><th>باقیمانده<br>نهایی</th>
		</tr>';

		$string = "
			SELECT 
				`term_stu_reg` , `class_stu_reg` , `cd` , `book` , `tape` , `type_stu_reg` , 
				`edu_class`.`id_e_level` , `kasr` , `quota_stu_reg` , `quotaid_stu_reg` , `id_stu_reg` , 
				`back_money`,`fee_finfee`, `book_finfee`, `cd_finfee`,`discount_finquo`,`money_sr`,`money`,
				`name_e_level` ,`code_e_class` , `year_e_term`, `season_e_term` , `type_e_term` , `date_stu_reg`   
			FROM `student_register` 
			LEFT JOIN `edu_class` ON `id_e_class` = `class_stu_reg` 
			LEFT JOIN `edu_level` ON `edu_class`.`id_e_level`=`edu_level`.`id_e_level`
			LEFT JOIN `edu_term` ON `edu_term`.`id_e_term`=`edu_class`.`id_e_term`
			LEFT JOIN `financial_fee` ON ( `term_stu_reg`=`term_finfee` 
											AND 
											`edu_class`.`id_e_level`=`level_finfee`) 
			LEFT JOIN `financial_quota` ON `quotaid_stu_reg`=`id_finquo` 
			LEFT JOIN `student_recives` ON (`student_sr`= `student_stu_reg` 
											AND 
											`term_sr` = `term_stu_reg` 
											AND 
											`student_recives`.`class_id` = `class_stu_reg`) 
			LEFT JOIN ( select sum(`k`.`money`) AS `money` ,`k`.`cla` from ( SELECT SUM(`money_stu_reg`) AS `money` ,`class_id` AS `cla` FROM `student_recipt` WHERE `student_stu_rec` = '" . $id . "' group BY `class_id` UNION SELECT SUM(`money_pay`) AS `money` , `class_pay` AS `cla` FROM `student_payment` WHERE `student_pay` = '" . $id . "' group by `class_pay` UNION SELECT SUM(`money_pm`) AS `money`, `class_pm` AS `cla` FROM `student_paypermas` WHERE `student_pm` = '" . $id . "' group by `class_pm` ) AS `k` group by `cla`) AS `t` ON `t`.`cla`=`class_stu_reg` 

			WHERE `student_stu_reg` ='" . $id . "'
			UNION
			SELECT 
				'' AS `term_stu_reg` , `class_stu_reg` , `cd` , `book` , `tape` , `type_stu_reg` , 
				`pri_edu_class`.`id_e_level` , `kasr` , '' AS `quota_stu_reg` , '' AS `quotaid_stu_reg` , `id_stu_reg` , 
				`back_money`,`fee_class` AS`fee_finfee`, '' AS`book_finfee`,'' AS `cd_finfee`,'' AS `discount_finquo`,'' AS `money_sr`,`money`,
				`name_e_level` ,`code_e_class` , '' AS `year_e_term`,'' AS `season_e_term` , 'pr' AS `type_e_term` , `date_stu_reg`   
			FROM `pri_student_register` 
			LEFT JOIN `pri_edu_class` ON `id_e_class` = `class_stu_reg` 
			LEFT JOIN `edu_level` ON `pri_edu_class`.`id_e_level`=`edu_level`.`id_e_level`
			LEFT JOIN ( select sum(`k`.`money`) AS `money` ,`k`.`cla` from ( SELECT SUM(`money_stu_reg`) AS `money` ,`class_id` AS `cla` FROM `pri_student_recipt` group BY `class_id`) AS `k` group by `cla`) AS `t` ON `t`.`cla`=`class_stu_reg` 

			WHERE `student_stu_reg` ='" . $id . "'

			ORDER BY `date_stu_reg` ASC";

		$sql = mysql_query($string);
		$i = 0;
		$baghimandeh_final = 0;

		while ($row = mysql_fetch_object($sql)) {
			$baghimandehf_html = '';
			$baghimandeh_html = '';
			$tahvil = '';
			$mashmole_kasr = '';
			$pardakht = '';
			$ghabel_pardakht = '';
			$kasr_money = '';
			$kasr_darsad = '';
			$shahriye = '';
			$cd = '';
			$book = '';
			$class_info = '';
			$type = '';
			$oo = '';
			$i++;
			//------------------------------------------------------------------------------شهریه کلاس ها
			$shahriye = $row->fee_finfee;
			$cfee = $shahriye;
			if ($row->book == 'y') {
				$shahriye = $shahriye + $row->book_finfee;
				$cbook = $row->book_finfee;
			}
			if ($row->cd == 'y') {
				$shahriye = $shahriye + $row->cd_finfee;
				$ccd = $row->cd_finfee;
			}
			if ($row->tape == 'y') {
				$shahriye = $shahriye + $row->tape_finfee;
				$ctap = $row->tape_finfee;
			}
			//----------------------------------------------------------------------------------سهمیه ها
			if ($row->quota_stu_reg == 'y') {
				$kasr_darsad = $row->discount_finquo;
				$kasr_money = ($cfee * $kasr_darsad) / 100;
			} else {
				$kasr_darsad = 0;
				$kasr_money = 0;
			}
			//----------------------------------------------------------------------------------قابل پرداخت
			$ghabel_pardakht = $shahriye - $kasr_money;
			//----------------------------------------------------------------------------------پرداخت شده
			$pardakht = $row->money;
			//----------------------------------------------------------------------------------
			$tahvil = $row->back_money; // تحویل نقدی به دانشجوی
			//----------------------------------------------------------------------------------
			$tahivile_wf = $row->money_sr;
			$tahvil = $tahvil + $tahivile_wf;
			//----------------------------------------------------------------------------------

			if ($row->type_stu_reg == 'fix') {
				$baghimandeh = $ghabel_pardakht - $pardakht + $tahvil;
			} elseif ($row->type_stu_reg == 'transfer') {
				$ghabel_parkhat_return = $cfee - $kasr_money;
				$baghimandeh = (($ghabel_parkhat_return * $row->kasr) / 100) - $pardakht + $tahvil;
				if ($row->kasr == 0) {
					$mashmole_kasr = 'خیر';
				} else {
					$mashmole_kasr = $row->kasr . '%';
				}
			} elseif ($row->type_stu_reg == 'return') {
				$ghabel_parkhat_return = $cfee - $kasr_money;
				$baghimandeh = (($ghabel_parkhat_return * $row->kasr) / 100) - $pardakht + $tahvil;
				if ($row->kasr == 0) {
					$mashmole_kasr = 'خیر';
				} else {
					$mashmole_kasr = $row->kasr . '%';
				}
			}

			if ($row->year_e_term < 1390) {
				$baghimandeh_final = 0;
			} else {
				$baghimandeh_final = $baghimandeh_final + $baghimandeh;
			}
			//-----------------------------------------------------

			$type = $row->type_e_term;


			if ($row->book == 'y') $book = '<span style="color:#090;"><b> &#10004;</b></span>';
			elseif ($row->book == 'n') $book = '<span style="color:#F00"><b>×</b></span>';

			if ($row->cd == 'y') $cd = '<span style="color:#090;"><b> &#10004;</b></span>';
			elseif ($row->cd == 'n') $cd = '<span style="color:#F00"><b>×</b></span>';

			if ($baghimandeh < 0) $baghimandeh_html = '<span class="font-green-jungle">' . number_format($baghimandeh) . '</span>';
			elseif ($baghimandeh > 0) $baghimandeh_html = '<span class="font-red-thunderbird">' . number_format($baghimandeh) . '</span>';
			else $baghimandeh_html = 0;

			if ($baghimandeh_final < 0) $baghimandehf_html = '<span class="font-green-jungle">' . number_format($baghimandeh_final) . '</span>';
			elseif ($baghimandeh_final > 0) $baghimandehf_html = '<span class="font-red-thunderbird">' . number_format($baghimandeh_final) . '</span>';
			else $baghimandehf_html = 0;

			$class_info = $row->name_e_level . ' -<b>' . $row->code_e_class . '</b>';
			//-----------------------------------------------------
			if ($button) {
				if ($row->type_e_term == 'pr') {
					$td = '<td>
							<a class="btn btn-circle blue btn-outline ajax-demo" data-toggle="modal" href="#"  data-url="student/financial/sanavat_private_details.php?i=' . $row->id_stu_reg . '"><i class="glyphicon glyphicon-info-sign"></i></a></td>';
				} else {
					$td = '<td>
							<a class="btn btn-circle blue btn-outline ajax-demo" data-toggle="modal" href="#"  data-url="student/financial/sanavat_details.php?i=' . $row->id_stu_reg . '"><i class="glyphicon glyphicon-info-sign"></i></a></td>';
				}
			} else {
				$td = '';
			}
			if ($row->type_stu_reg == 'return') $row_class = "bg-blue-sharp";
			else if ($row->type_stu_reg == 'transfer') $row_class = "bg-yellow-saffron";
			else if ($row->type_stu_reg == 'fix') $row_class = "";

			$out .= '
				<tr class="' . $row_class . '">
					<th>' . $i . '</th>
					<td>' . $row->date_stu_reg . '</td>
					<td>' . $row->season_e_term . ' <b>' . $row->year_e_term . '</b> - ' . $type . '</td>
					<td dir="rtl">' . $class_info . '</td>
					<td>' . $book . '</td>
					<td>' . $cd . '</td>
					<td>' . number_format($shahriye) . '</td>
					<td>' . $kasr_darsad . '%</td>
					<td>' . number_format($kasr_money) . '</td>
					<td>' . number_format($ghabel_pardakht) . '</td>
					<td>' . number_format($pardakht) . '</td>
					<td>' . $mashmole_kasr . '</td>
					<td>' . number_format($tahvil) . '</td>
					<td>' . $baghimandeh_html . '</td>
					<td>' . $baghimandehf_html . '</td>
					' . $td . '
				</tr>
				';
		}
		$out .= '</table>';
		return $out;
	}

	function sanavat_class($id_student, $center, $today, $year) //ok
	{
		$term_active = $this->term_jari($center, $today, $year);
		$sql = "SELECT 
		`id_stu_reg`,`student_stu_reg`,`date_stu_reg`,`type_stu_reg`,`class_stu_reg`,
		`statuse_reg_stu`,`mark_grade`, `mark_result` 
		,`year_e_term` , `season_e_term` , `type_e_term`, `code_e_class`,`name_mas`,`family_mas`,`name_e_level`
		FROM
			`student_register` ,`edu_term`,`edu_class`,`master_info`,`edu_level`
		WHERE  `student_stu_reg` = '" . $id_student . "'
		AND `term_stu_reg` IN (" . $term_active . ")
		AND `type_stu_reg`='fix'
		AND `edu_term`.`id_e_term` =`term_stu_reg`
		AND `class_stu_reg`=`id_e_class`
		AND `id_mas`=`id_e_master`
		AND `edu_class`.`id_e_level` =`edu_level`.`id_e_level` 
		ORDER BY `student_register`.`date_stu_reg` DESC";
		$res = mysql_query($sql);
		print '<div class="tabbable-custom nav-justified"><ul class="nav nav-tabs nav-justified">';
		while ($row = mysql_fetch_array($res)) {
			print '<li class="">
			<a href="#tab' . $row['class_stu_reg'] . '" data-toggle="tab" aria-expanded="true"> ' . $row['name_e_level'] . $row['code_e_class'] . $row['family_mas'] . '</a>
			</li>';
		}
		print '</ul></div>';
	}
	function term_jari($id_center, $date, $year2)
	{

		$year_2 = $year2 + 1;
		$year_3 = $year2 - 1;
		$terms_active = '0';
		$sql_search = "SELECT *  FROM `edu_term` , `basic_center` 
				WHERE `center_e_term` IN (" . $id_center . ")
				AND (`year_e_term`='" . $year2 . "' OR `year_e_term`='" . $year_2 . "' OR `year_e_term`='" . $year_3 . "')
				AND `center_e_term`=`id_b_center`";


		$result = mysql_query($sql_search);
		while ($row = mysql_fetch_array($result)) {

			$id_e_term = $row['id_e_term'];
			$date_start_reg = $row['date_start_reg'];
			$date_end_reg = $row['date_end_reg'];

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
				$terms_active .= ',' . $id_e_term;
			}
		}
		return $terms_active;
	}
	function sanavat_reg($id, $work_where)

	{
		$bg=0;$out='';
		$out .= '<table class="table table-striped table-bordered table-hover">
		<tr>

			<td colspan="15">سطر سفید: ترم قطعی 
			||<span class="bg-blue-sharp"> سطر آبی: ترم برگشت داده شده</span>
			<span class="bg-yellow-saffron">
			 || سطر زرد: انتقال به ترم بعد<span</td>
		</tr>
		<tr>
			<th>#</th><th>تاریخ ثبت نام</th><th>ترم تحصیلی</th><th>کلاس</th><th>استاد</th><th>نمره</th><th>تاریخ شروع کلاس</th><th>روزهای برگزاری</th>
			<th>کتاب</th><th>cd</th><th>جمع<br>شهریه</th>
			<th>تخفیف</th><th>قابل<br>پرداخت</th>
		</tr>';
		$string = "
		SELECT `term_stu_reg` , `class_stu_reg` , `cd` , `book` , `tape` , `type_stu_reg` , 
		`edu_class`.`id_e_level` , `kasr` , `quota_stu_reg` , `quotaid_stu_reg` , `id_stu_reg` , 
		`back_money`,`fee_finfee`, `book_finfee`, `cd_finfee`,`discount_finquo`,`money_sr`,`money`,
		`name_e_level` ,`code_e_class` , `year_e_term`, `season_e_term` , `type_e_term` , `date_stu_reg`,
		`day_0` , `day_1`,`day_2`,`day_3`,`day_4`,`day_5`,`day_6`,`start_e_class`,`name_mas`,`family_mas`,`mark_result` ,`edu_class`.`mark`		FROM `student_register_read` 
		LEFT JOIN `edu_class` ON `id_e_class` = `class_stu_reg` 
		LEFT JOIN `edu_level` ON `edu_class`.`id_e_level`=`edu_level`.`id_e_level`
		LEFT JOIN `master_info` ON `edu_class`.`id_e_master`=`master_info`.`id_mas`
		LEFT JOIN `edu_term` ON `edu_term`.`id_e_term`=`edu_class`.`id_e_term`
		LEFT JOIN `financial_fee` ON ( `term_stu_reg`=`term_finfee` 
		AND `edu_class`.`id_e_level`=`level_finfee`) 
		LEFT JOIN `financial_quota` ON `quotaid_stu_reg`=`id_finquo` 
		LEFT JOIN `student_recives` ON (`student_sr`= `student_stu_reg` 
		AND `term_sr` = `term_stu_reg` 
		AND `student_recives`.`class_id` = `class_stu_reg`) 
		LEFT JOIN ( select sum(`k`.`money`) AS `money` ,`k`.`cla` from ( SELECT SUM(`money_stu_reg`) AS `money` ,`class_id` AS `cla` FROM `student_recipt` WHERE `student_stu_rec` = '" . $id . "' group BY `class_id`  UNION SELECT SUM(`money_pm`) AS `money`, `class_pm` AS `cla` FROM `student_paypermas` WHERE `student_pm` = '" . $id . "' group by `class_pm` ) AS `k` group by `cla`) AS `t` ON `t`.`cla`=`class_stu_reg` 
		WHERE `student_stu_reg` ='" . $id . "'
		UNION
		SELECT 
			`term_stu_reg` , `class_stu_reg` , `cd` , `book` , `tape` , `type_stu_reg` , 
			`edu_class`.`id_e_level` , `kasr` , `quota_stu_reg` , `quotaid_stu_reg` , `id_stu_reg` , 
			`back_money`,`fee_finfee`, `book_finfee`, `cd_finfee`,`discount_finquo`,`money_sr`,`money`,
			`name_e_level` ,`code_e_class` , `year_e_term`, `season_e_term` , `type_e_term` , `date_stu_reg`,
			`day_0` , `day_1`,`day_2`,`day_3`,`day_4`,`day_5`,`day_6`,`start_e_class`,`name_mas`,`family_mas`,`mark_result`,`edu_class`.`mark`
		FROM `student_register` 
		LEFT JOIN `edu_class` ON `id_e_class` = `class_stu_reg` 
		LEFT JOIN `edu_level` ON `edu_class`.`id_e_level`=`edu_level`.`id_e_level`
		LEFT JOIN `master_info` ON `edu_class`.`id_e_master`=`master_info`.`id_mas`
		LEFT JOIN `edu_term` ON `edu_term`.`id_e_term`=`edu_class`.`id_e_term`
		LEFT JOIN `financial_fee` ON ( `term_stu_reg`=`term_finfee` 
		AND `edu_class`.`id_e_level`=`level_finfee`) 
		LEFT JOIN `financial_quota` ON `quotaid_stu_reg`=`id_finquo` 
		LEFT JOIN `student_recives` ON (`student_sr`= `student_stu_reg` 
		AND `term_sr` = `term_stu_reg` AND `student_recives`.`class_id` = `class_stu_reg`) 
		LEFT JOIN ( select sum(`k`.`money`) AS `money` ,`k`.`cla` from ( SELECT SUM(`money_stu_reg`) AS `money` ,`class_id` AS `cla` FROM `student_recipt` WHERE `student_stu_rec` = '" . $id . "' group BY `class_id`  UNION SELECT SUM(`money_pm`) AS `money`, `class_pm` AS `cla` FROM `student_paypermas` WHERE `student_pm` = '" . $id . "' group by `class_pm` ) AS `k` group by `cla`) AS `t` ON `t`.`cla`=`class_stu_reg` 
		WHERE `student_stu_reg` ='" . $id . "'
		UNION
		SELECT `term_stu_reg` , `class_stu_reg` , `cd` , `book` , `tape` , `type_stu_reg` , 
		`edu_class`.`id_e_level` , `kasr` , `quota_stu_reg` , `quotaid_stu_reg` , `id_stu_reg` , 
		`back_money`,`fee_finfee`, `book_finfee`, `cd_finfee`,`discount_finquo`,'1' AS `money_sr`,`money_stu_reg` AS `money`,
			`name_e_level` ,`code_e_class` , `year_e_term`, `season_e_term` , `type_e_term` ,`site_student_register`.`date_stu_reg`,
			`day_0` , `day_1`,`day_2`,`day_3`,`day_4`,`day_5`,`day_6`,`start_e_class`,`name_mas`,`family_mas`,`mark_result`,`edu_class`.`mark`
		FROM `site_student_register` 
		LEFT JOIN `edu_class` ON `id_e_class` = `class_stu_reg` 
		LEFT JOIN `edu_level` ON `edu_class`.`id_e_level`=`edu_level`.`id_e_level`
		LEFT JOIN `master_info` ON `edu_class`.`id_e_master`=`master_info`.`id_mas`
		LEFT JOIN `edu_term` ON `edu_term`.`id_e_term`=`edu_class`.`id_e_term`
		LEFT JOIN `financial_fee` ON ( `term_stu_reg`=`term_finfee` 
		AND `edu_class`.`id_e_level`=`level_finfee`) 
		LEFT JOIN `financial_quota` ON `quotaid_stu_reg`=`id_finquo` 
		LEFT JOIN `site_student_recipt` ON (`student_stu_rec`= `student_stu_reg` AND 
		`term_stu_rec` = `term_stu_reg` AND `site_student_recipt`.`class_id` = `class_stu_reg`) 
		WHERE `student_stu_reg` ='" . $id . "'";

		//print $string;

		$sql = mysql_query($string);
		$i = 0;
		while ($row = mysql_fetch_object($sql)) {
			$sum = 0;
			$tahvil = '';
			$mashmole_kasr = '';
			$pardakht = '';
			$ghabel_pardakht = '';
			$kasr_money = '';
			$kasr_darsad = '';
			$shahriye = '';
			$cd = '';
			$book = '';
			$class_info = '';
			$type = '';
			$oo = '';
			$i++;
			$show_mark = $this->showPolling($row->term_stu_reg, $id);
			if ($show_mark) {
				if ($row->mark == 'y') {
					$mark_grade_array = explode("-", $row->mark_result);
					$count_all = count($mark_grade_array);
					for ($i = 0; $i <= $count_all; $i++) {
						if ($mark_grade_array[$i]) {
							$value = substr($mark_grade_array[$i], 0, 5);
							$sum += $value;
						}
					}

					settype($sum, "float");
					$mark = '<a class="btn btn-circle blue btn-outline ajax-demo" data-toggle="modal" href="#"  data-url="student/education/sanavat_mark_details.php?i=' . $row->id_stu_reg . '">' . $sum . '</a>';
				} else {
					$mark = '<a class="btn btn-circle red-mint btn-outline " href="#">اعلام نشده</a>';
				}
			} else {
				$mark = '<a class="btn btn-circle red-mint" href="index.php?screen=polling/polling">شرکت در نظرسنجی</a>';
			}


			$edu = new edu;
			$days = $edu->show_day_list($row->day_0, $row->day_1, $row->day_2, $row->day_3, $row->day_4, $row->day_5, $row->day_6);
			//------------------------------------------------------------------------------شهریه کلاس ها
			$shahriye = $row->fee_finfee;
			$cfee = $shahriye;
			if ($row->book == 'y') {
				$shahriye = $shahriye + $row->book_finfee;
				$cbook = $row->book_finfee;
			}
			if ($row->cd == 'y') {
				$shahriye = $shahriye + $row->cd_finfee;
				$ccd = $row->cd_finfee;
			}
			if ($row->tape == 'y') {
				$shahriye = $shahriye + $row->tape_finfee;
				$ctap = $row->tape_finfee;
			}
			//----------------------------------------------------------------------------------سهمیه ها
			if ($row->quota_stu_reg == 'y') {
				$kasr_darsad = $row->discount_finquo;
				$kasr_money = ($cfee * $kasr_darsad) / 100;
			} else {
				$kasr_darsad = 0;
				$kasr_money = 0;
			}
			//----------------------------------------------------------------------------------قابل پرداخت
			$ghabel_pardakht = $shahriye - $kasr_money;
			//----------------------------------------------------------------------------------پرداخت شده
			$pardakht = $row->money;
			//----------------------------------------------------------------------------------
			$tahvil = $row->back_money; // تحویل نقدی به دانشجوی
			//----------------------------------------------------------------------------------
			$tahivile_wf = $row->money_sr;
			$tahvil = $tahvil + $tahivile_wf;
			//----------------------------------------------------------------------------------
			if ($row->type_stu_reg == 'fix') {
				$baghimandeh = $ghabel_pardakht - $pardakht + $tahvil;
			} elseif ($row->type_stu_reg == 'transfer') {
				$ghabel_parkhat_return = $cfee - $kasr_money;
				$baghimandeh = (($ghabel_parkhat_return * $row->kasr) / 100) - $pardakht + $tahvil;
				if ($row->kasr == 0) {
					$mashmole_kasr = 'خیر';
				} else {
					$mashmole_kasr = $row->kasr . '%';
				}
			} elseif ($row->type_stu_reg == 'return') {
				$ghabel_parkhat_return = $cfee - $kasr_money;
				$baghimandeh = (($ghabel_parkhat_return * $row->kasr) / 100) - $pardakht + $tahvil;
				if ($row->kasr == 0) {
					$mashmole_kasr = 'خیر';
				} else {
					$mashmole_kasr = $row->kasr . '%';
				}
			}
			//-----------------------------------------------------
			$type = $row->type_e_term;
			if ($row->book == 'y') $book = '<span style="color:#090;"><b> &#10004;</b></span>';
			elseif ($row->book == 'n') $book = '<span style="color:#F00"><b>×</b></span>';
			if ($row->cd == 'y') $cd = '<span style="color:#090;"><b> &#10004;</b></span>';
			elseif ($row->cd == 'n') $cd = '<span style="color:#F00"><b>×</b></span>';
			//-----------------------------------------------------
			$class_info = $row->name_e_level . ' -<b>' . $row->code_e_class . '</b>';
			//-----------------------------------------------------
			if ($row->type_stu_reg == 'return') $row_class = "bg-blue-sharp";
			else if ($row->type_stu_reg == 'transfer') $row_class = "bg-yellow-saffron";
			else if ($row->type_stu_reg == 'fix') $row_class = "";
			$bg++;
			$out .= '
				<tr class="' . $row_class . '">
					<th>' . $bg . '</th>
					<td>' . $row->date_stu_reg . '</td>
					<td>' . $row->season_e_term . ' <b>' . $row->year_e_term . '</b> - ' . $type . '</td>
					<td dir="rtl">' . $class_info . '</td>
					<td>' . $row->family_mas . ' ' . $row->name_mas . '</td>
					<td>' . $mark . '</td>
					<td>' . $row->start_e_class . '</td>
					<td>' . $days . '</td>
					<td>' . $book . '</td>
					<td>' . $cd . '</td>
					<td>' . number_format($shahriye) . '</td>
					<td>' . $kasr_darsad . '%</td>
					<td>' . number_format($ghabel_pardakht) . '</td>
				</tr>';
		}
		$out .= '</table>';
		return $out;
	}
	function isPolling($stu, $polling)
	{

		$sql = "SELECT *  FROM `polling_a` WHERE `stu` = " . $stu . " AND `polling` =" . $polling;
		$res = mysql_query($sql);
		$nums = mysql_fetch_object($res);
		return $nums->id;
	}
	function isActivePolling($term,$group)
	{

		$sql = "SELECT `id` FROM `polling_info` WHERE `term` LIKE '%" . $term . "%' AND `groups` LIKE '%".$group."%' AND `student_active`=1";
		$res = mysql_query($sql);
		$nums = mysql_fetch_object($res);
		return $nums->id;
	}

    function groupOfpolling($level)
    {
        $sql = "SELECT `group_e_level` as `id` FROM `edu_level` WHERE `id_e_level`=".$level;
        $res = mysql_query($sql);
        $nums = mysql_fetch_object($res);
        return $nums->id;
    }
	function showPolling($term, $stu,$level)
	{
        $group=$this->groupOfpolling($level);
		$polling = $this->isActivePolling($term,$group);
		if ($polling > 0) {
			$answer = $this->isPolling($stu, $polling);
			if ($answer > 0) return true;
			else return false;
		} else {
			return true;
		}
	}
	function sanavat_exam($id, $work_where)

	{
		$row_class='';$bg='';$i=0;$out='';
		$out .= '<table class="table table-striped table-bordered table-hover">
		<tr><th>تاریخ ثبت نام</th><th>ترم تحصیلی</th><th>کلاس</th><th>استاد</th><th>نمره</th><th>وضعیت درخواست</th><th>عملیات</th>
		</tr>';
		$string = "
			SELECT 
				`term_stu_reg` , `class_stu_reg` , `statuse`,
				`edu_class`.`id_e_level`  , `id_stu_reg` , `namect`,`fee_exam`,
			`name_e_level` ,`code_e_class` , `year_e_term`, `season_e_term` , `type_e_term` , `date_stu_reg`,`reason_exam`,`date_offer_stu`,
				`name_mas`,`family_mas`,`mark_result`,`id_exam`,`type_exam`, `date_ok`, `student_exam`.`comment`, `statuse`, `bank`, `bank_info`, `date_bank`
			FROM `student_register` 
			LEFT JOIN `edu_class` ON `id_e_class` = `class_stu_reg` 
			LEFT JOIN `edu_level` ON `edu_class`.`id_e_level`=`edu_level`.`id_e_level`
			LEFT JOIN `master_info` ON `edu_class`.`id_e_master`=`master_info`.`id_mas`
			LEFT JOIN `edu_term` ON `edu_term`.`id_e_term`=`edu_class`.`id_e_term`
			LEFT JOIN `student_exam` ON `register`=`id_stu_reg`
			LEFT JOIN `edu_class_type` ON `idct`=`type_exam`
			WHERE `student_stu_reg` ='" . $id . "' AND `type_stu_reg`='fix'
			ORDER BY `id_stu_reg` DESC LIMIT 0,3
			";
		$sql = mysql_query($string);
		while ($row = mysql_fetch_object($sql)) {
			$sum = 0;
			$class_info = '';
			$type = '';
			$oo = '';
			$i++;
			$mark_grade_array = explode("-", $row->mark_result);
			$count_all = count($mark_grade_array);
			for ($i = 0; $i <= $count_all; $i++) {
				if ($mark_grade_array[$i]) {
					$value = substr($mark_grade_array[$i], 0, 5);
					$sum += $value;
				}
			}
			settype($sum, "float");
			$type = $row->type_e_term;
			if ($row->statuse == '') {
				$statuse = 'درخواستی ارسال نشده است';
				$mark2 = '
				<a class="btn btn-circle blue ajax-demo" data-toggle="modal" href="#"  data-url="form/exam_form.php?i=' . $row->id_stu_reg . '">درخواست آزمون </a>';
			} elseif ($row->statuse == 'آماده پرداخت') {
				$statuse = '<b><span class="font-green-jungle">' . $row->statuse . '</span></b>
						<br>نوع درخواست : <b>' . $row->namect . '</b> 
						<br>تاریخ : <b>' . $row->date_ok . '</b> 
						<br>توضیحات: <b>' . $row->comment . '</b>
						<br>هزینه: <b>' . $row->fee_exam . ' ریال</b>';
				$mark2 = '
				<input type="hidden" value="' . $row->type_exam . '" name="wich_type">
				<button type="submit" class="btn btn-circle green" value="' . $row->id_exam . '" name="pay">پرداخت هزینه</button>';
			} elseif ($row->statuse == 'اتمام') {
				$statuse = '<b><span class="font-green-jungle">' . $row->statuse . '</span></b>
						<br>نوع درخواست : <b>' . $row->namect . '</b> 
						<br>تاریخ : <b>' . $row->date_ok . '</b> 
						<br>توضیحات: <b>' . $row->comment . '</b>
						<br>هزینه: <b>' . $row->fee_exam . ' ریال</b> پرداخت شده';
				$mark2 = '';
			} else {
				$statuse = '<b><span class="font-yellow-gold">' . $row->statuse . '</span></b>
						<br>نوع درخواست : <b>' . $row->namect . '</b> 
						<br>علت درخواست : <b>' . $row->reason_exam . '</b> 
						<br>توضیحات آموزش: <b>' . $row->comment . '</b>';
				$mark2 = '
				<a class="btn btn-circle green ajax-demo" data-toggle="modal" href="#"  data-url="form/exam_form.php?i=' . $row->id_exam . '">پیگیری درخواست </a>';
			}
			//-----------------------------------------------------
			$class_info = $row->name_e_level . ' -<b>' . $row->code_e_class . '</b>';
			//-----------------------------------------------------
			$mark = '
				<a class="btn btn-circle blue btn-outline ajax-demo" data-toggle="modal" href="#"  data-url="student/education/sanavat_mark_details.php?i=' . $row->id_stu_reg . '">' . $sum . '</a>';
			$bg++;
			$out .= '
				<tr class="' . $row_class . '">
					<td>' . $row->date_stu_reg . '</td>
					<td>' . $row->season_e_term . ' <b>' . $row->year_e_term . '</b> - ' . $type . '</td>
					<td dir="rtl">' . $class_info . '</td>
					<td>' . $row->family_mas . ' ' . $row->name_mas . '</td>
					<td>' . $mark . '</td>
					<td>' . $statuse . '</td>
					<td>' . $mark2 . '</td>
				</tr>
				';
		}
		$out .= '</table>';

		return $out;
	}
}