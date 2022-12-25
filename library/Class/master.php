<?php
class master
{
	function list_fld() //ok
	{
		$fld = array();
		$result = mysql_query('select * from site_master_info LIMIT 0 ,1');

		for ($i = 0; $i < mysql_num_fields($result); $i++) {
			$name = mysql_field_name($result, $i);
			array_push($fld, $name);
		}
		return $fld;
	}

	function show($id)
	{
		$fld = array();
		$fld = $this->list_fld();
		$result = mysql_query('select * from site_master_info where  id_mas=' . $id);
		$row = mysql_fetch_array($result);

		foreach ($fld as $key => $val) {
			if ($row[$val] == '0000-00-00') $real_value = '';
			else $real_value = $row[$val];

			$this->$val = $real_value;
		}
	}
	function show_add($id)
	{
		$fld = array();
		$fld = $this->list_fld();
		$result = mysql_query("select * from site_master_info where  username_mas='" . $id . "'");
		$row = mysql_fetch_array($result);

		foreach ($fld as $key => $val) {
			if ($row[$val] == '0000-00-00') $real_value = '';
			else $real_value = $row[$val];

			$this->$val = $real_value;
		}
	}

	function sanavat_class($id_master, $today, $year) //ok
	{
		$array_class = array();
		$array_sumcode = array();
		$term_active = $this->term_jari($today, $year);

		$sql = "
		SELECT group_concat(`id_e_class`) as `ids`, group_concat(`code_e_class`) AS `code_e_class`,`mokhtalet`,`name_e_level` ,
		((`edu_class`.`mokhtalet_code` * `edu_class`.`id_e_class`) + (`edu_class`.`mokhtalet_code` + `edu_class`.`id_e_class`)) AS `sumcode` 
		FROM `edu_class`,`edu_level` WHERE `id_e_term` IN (" . $term_active . ") AND `id_e_master` =" . $id_master . " 
		AND `edu_level`.`id_e_level`=`edu_class`.`id_e_level` 
		group BY `sumcode` ORDER BY `edu_level`.`name_e_level` ASC ";
		$res = mysql_query($sql);
		print '<div class="tabbable-custom nav-justified"><ul class="nav nav-tabs nav-justified">';
		$indexy = 0;

		while ($row = mysql_fetch_array($res)) {
			$indexy++;
			if ($indexy == 1) $class_tab = 'active';
			else $class_tab = '';

			if ($row['mokhtalet'] == 'y') $mokhtalet = 'مختلط';
			else $mokhtalet = 'غیرمختلط';

			array_push($array_class, $row['ids']);
			array_push($array_sumcode, $row['sumcode']);

			print '<li class="' . $class_tab . '">
			<a href="#tab' . $row['sumcode'] . '" data-toggle="tab" aria-expanded="true"> ' . $row['name_e_level'] . ' <br> ' . $row['code_e_class'] . '<br>' . $mokhtalet . '</a>
			</li>';
		}
		print '</ul>
		<div class="tab-content">';

		$indexx = 0;
		$indexsumcode = 0;
		foreach ($array_class as $vvv) {
			$indexx++;
			if ($indexx == 1) $class_pan = 'active';
			else $class_pan = '';
			print '
			<div class="tab-pane ' . $class_pan . '" id="tab' . $array_sumcode[$indexsumcode] . '"><table class="table table-striped table-bordered table-hover">
			<tr>
				<th>#</th>
				<th>نوع</th>
				<th>استاد</th>
				<th>تاریخ</th>
				<th>ساعت</th>
				<th>محل تشکیل</th>
				<th>استاد2</th>
				</tr>';

			$indexsumcode++;
			$ql_2 = mysql_query("SELECT  `edu_class_days` .`id`, `type`,`day_name`,`namect`, `class`, `master`, `master2`, `date`, `hour`.`time`, `locat`, `comment`, `statuse`,`delay` ,`comfirm` ,`comfirm1`,`a`.`name_mas` AS `name1` ,`a`. `family_mas` AS `family1` , `b`.`name_mas` AS `name2` ,`b`. `family_mas` AS `family2`  , `day` , `edu_term_free`.`title`,`accept`,`lock`,`color`
					FROM `edu_class_days` 
					LEFT JOIN `hour` ON `edu_class_days`.`time`=`hour`.`title`
					LEFT JOIN `master_info` AS `a` ON `master`=`a`.`id_mas` 
					LEFT JOIN `master_info` AS `b` ON `master2`=`b`.`id_mas` 
					LEFT JOIN `edu_class_type` ON `type`=`namect`
					LEFT JOIN `edu_term_free` ON `day` =`date` AND `edu_term_free`.`term`=`edu_class_days`.`term`
					WHERE `class` IN (" . $vvv . ")
					GROUP BY `date`
					ORDER BY `date` ASC ");

			$l = 0;
			//$to_count=count($to);
			while ($row2 = mysql_fetch_object($ql_2)) {
				$namect = '';

				if ($row2->day <> '')
					$namect = '<span class="red"> تعطیل (' . $row2->title . ')</span>';

				$str = $row2->type . $namect;
				$l++;

				print '<tr >
						<td style="background:' . $row2->color . '">' . $l . '</td>
						<td style="background:' . $row2->color . '">' . $str . '</td>
						<td style="background:' . $row2->color . '">' . $row2->family1 . ' ' . $row2->name1 . '</td>
						<td style="background:' . $row2->color . '">' . $row2->date . '(' . $row2->day_name . ')</td>
						<td style="background:' . $row2->color . '">' . $row2->time . '</td>
						<td style="background:' . $row2->color . '">' . $row2->locat . '</td>
						<td style="background:' . $row2->color . '">' . $row2->family2 . ' ' . $row2->name2 . '</td>
						';

				print '</tr>';
			}

			print '</table></div>';
		}

		print '</div>
		</div>';
	}

	function term_jari($date, $year2)
	{

		$year_2 = $year2 + 1;
		$year_3 = $year2 - 1;
		$terms_active = '0';
		$sql_search = "SELECT *  FROM `edu_term` , `basic_center` 
				WHERE (`year_e_term`='" . $year2 . "' OR `year_e_term`='" . $year_2 . "' OR `year_e_term`='" . $year_3 . "')
				AND `center_e_term`=`id_b_center`";


		$result = mysql_query($sql_search);
		while ($row = mysql_fetch_array($result)) {

			$id_e_term = $row['id_e_term'];
			$date_start_reg = $row['date_start_reg'];
			$date_end_reg = $row['date_end_class'];

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
	function lab_program($id_master, $today, $year) //ok
	{
		$out = '';
		$i = 0;
		$array_class = array();
		$array_sumcode = array();
		$term_active = $this->term_jari($today, $year);

		$sql_class = "SELECT * FROM `class_days_view` WHERE `master`=" . $id_master . " AND `term` IN (" . $term_active . ") AND (`type` = 'فیلم 1' OR `type`='فیلم 2')";
		$res = mysql_query($sql_class);
		$out .= '
			  <div class="modal-body">
			  <table class="table table-striped table-bordered table-hover" dir="ltr">
				  <tr class="title_3">
					<th style="text-align:center">محل تشکیل</th>
					<th style="text-align:center">تاریخ</th>
					<th style="text-align:center">جلسه </th>
					<th style="text-align:center">استاد کلاس</th>
					<th style="text-align:center">سطح</th>
					<th style="text-align:center">کد کلاس</th>
				  </tr>';
		while ($row = mysql_fetch_array($res)) {
			$i++;
			$out .= '<tr>';
			$out .= '<td style="text-align:center">' . $row['locat'] . '</td>';
			$out .= '<td style="text-align:center">' . $row['date'] . ' ' . $row['time'] . '</td>';
			$out .= '<td style="text-align:center">' . $row['type'] . '</td>';
			$out .= '<td style="text-align:center"> ' . $row['main_family_mas'] . ' ' . $row['main_name_mas'] . '</td>';
			$out .= '<td class="code"> ' . $row['name_e_level'] . '</td>';
			$out .= '<td style="text-align:center"> ' . $row['code_e_class'] . '</td>';
			$out .= '</tr>';
		}
		$out .= '</table>';

		print $out;
	}
	function interview_program($id_master, $today, $year) //ok
	{
		$out = '';
		$i = 0;
		$array_class = array();
		$array_sumcode = array();
		$term_active = $this->term_jari($today, $year);

		$sql_class = "SELECT * FROM `class_days_view` WHERE `master`=" . $id_master . " AND `term` IN (" . $term_active . ") AND `type`='مصاحبه'";
		$res = mysql_query($sql_class);
		$out .= '
			  <div class="modal-body">
			  <table class="table table-striped table-bordered table-hover" dir="ltr">
				  <tr class="title_3">
					<th style="text-align:center">محل تشکیل</th>
					<th style="text-align:center">تاریخ</th>
					<th style="text-align:center">جلسه </th>
					<th style="text-align:center">استاد کلاس</th>
					<th style="text-align:center">سطح</th>
					<th style="text-align:center">کد کلاس</th>
				  </tr>';
		while ($row = mysql_fetch_array($res)) {
			$i++;
			$out .= '<tr>';
			$out .= '<td style="text-align:center">' . $row['locat'] . '</td>';
			$out .= '<td style="text-align:center">' . $row['date'] . ' ' . $row['time'] . '</td>';
			$out .= '<td style="text-align:center">' . $row['type'] . '</td>';
			$out .= '<td style="text-align:center"> ' . $row['main_family_mas'] . ' ' . $row['main_name_mas'] . '</td>';
			$out .= '<td class="code"> ' . $row['name_e_level'] . '</td>';
			$out .= '<td style="text-align:center"> ' . $row['code_e_class'] . '</td>';
			$out .= '</tr>';
		}
		$out .= '</table>';

		print $out;
	}

	function class_program($id_master, $today, $year, $url) //ok
	{
		$out = '';
		$i = 0;
		$array_class = array();
		$array_sumcode = array();
		$term_active = $this->term_jari($today, $year);

		$sql_class = "SELECT group_concat(`id_e_class`) as `ids`, group_concat(`code_e_class`) AS 
			  `code_e_class`,`mokhtalet`,`name_e_level` , 
			  IF(`mokhtalet_code` > `id_e_class`, `mokhtalet_code` , `id_e_class`) AS `sumcode`,
			  `day_0`, `day_1`, `day_2`, `day_3`, `day_4`, `day_5`, `day_6`, `start_e_class`, `end_e_class`,`place_e_class` ,`id_e_class`
			  FROM `edu_class`,`edu_level` WHERE `id_e_term` IN (" . $term_active . ") AND `id_e_master` =" . $id_master . " 
			  AND `edu_level`.`id_e_level`=`edu_class`.`id_e_level` 
			  group BY `sumcode` ORDER BY `start_e_class` ASC ";
		$res = mysql_query($sql_class);
		$out .= '
			  <div class="modal-body"><table class="table table-striped table-bordered table-hover">
				  
				  <tr>
					<th style="text-align:center">کد کلاس</th>
					<th style="text-align:center">سطح</th>
					<th style="text-align:center">روزهای برگزاری</th>
					<th style="text-align:center">تاریخ شروع</th>
					<th style="text-align:center">محل تشکیل</th>
					<th style="text-align:center">جزئیات روزهای برگزاری</th>
				 </tr>';
		while ($row = mysql_fetch_array($res)) {
			if ($row['mokhtalet'] == 'y') $mokhtalet = '«مختلط»';
			else $mokhtalet = '';

			/*--------------------------------------------------------
			  $cipher = new Crypt_Blowfish($key_encrypte);
			  $cipher_id_e_class = Eencrypt($cipher,$row[id_e_class]);
			  $cipher_id_e_class=str_replace("+", "%2B", $cipher_id_e_class);
			  //--------------------------------------------------------/
			  $cipher = new Crypt_Blowfish($key_encrypte);
			$id_class=str_replace("%2B", "+", $cipher_id_e_class);
			$id_class = Edecrypt($cipher,$id_class);
			*/

			$i++;
			$out .= '<tr>';
			$out .= '<td style="text-align:center"> ' . $row['code_e_class'] . '</td>';
			$out .= '<td class="code"> ' . $row['name_e_level'] . ' ' . $mokhtalet . '</td>';
			$out .= '<td style="text-align:center"> ' . $this->show_day_list_print($row['day_0'], $row['day_1'], $row['day_2'], $row['day_3'], $row['day_4'], $row['day_5'], $row['day_6']) . '</td>';
			$out .= '<td style="text-align:center"> ' . $row['start_e_class'] . '</td>';
			$out .= '<td style="text-align:center"> ' . $row['place_e_class'] . '</td>';
			$out .= '<td style="text-align:center"><a class="btn btn-circle blue btn-outline" href="index.php?screen=' . $url . '&i=' . $row['id_e_class'] . '&ids=' . $row['ids'] . '">مشاهده لیست </a></td>';
			$out .= '</tr>';
		}
		$out .= '</table></div>';

		print $out;
	}

	function show_day_list_print($day_0, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6)
	{
		$day = '';
		$hour = '';
		if (($day_0 <> '') && ($day_1 <> '') && ($day_2 <> '') && ($day_3 <> '') && ($day_4 <> '') && ($day_5 <> '')) {
			$day = 'هر روز<br><span dir="ltr">' . $day_0 . '</span>';
		} elseif (($day_0 <> '') && ($day_2 <> '') && ($day_4 <> '') && ($day_1 == '') && ($day_3 == '') && ($day_5 == '')) {
			$day = 'روزهای زوج<br><span dir="ltr">' . $day_0 . '</span>';
		} elseif (($day_1 <> '') && ($day_3 <> '') && ($day_5 <> '') && ($day_0 == '') && ($day_2 == '') && ($day_4 == '')) {
			$day = 'روزهای فرد<br><span dir="ltr">' . $day_1 . '</span>';
		} else {
			$tedad = 0;
			$day .= '';
			if ($day_0 <> '') {
				$day .= 'شنبه ،';
				$hour .= $day_0 . ' ، ';
			}
			if ($day_1 <> '') {
				$day .= 'یکشنبه ،';
				$hour .= $day_1 . ' ، ';
			}
			if ($day_2 <> '') {
				$day .= 'دوشنبه ،';
				$hour .= $day_2 . ' ، ';
			}
			if ($day_3 <> '') {
				$day .= 'سه شنبه ،';
				$hour .= $day_3 . ' ، ';
			}
			if ($day_4 <> '') {
				$day .= 'چهارشنبه ،';
				$hour .= $day_4 . ' ، ';
			}
			if ($day_5 <> '') {
				$day .= 'پنج شنبه ،';
				$hour .= $day_5 . ' ، ';
			}
			if ($day_6 <> '') {
				$day .= 'جمعه ،';
				$hour .= $day_6 . ' ، ';
			}

			$day = $day . '<br><span dir="rtl">' . $hour . '</span>';
		}
		return $day;
	}

	function class_clock($id_master, $id_uid, $today, $year)
	{
		$array_class = array();
		$array_sumcode = array();
		$term_active = $this->term_jari($today, $year);

		$sql_class_1 = "SELECT `class_view`.*, ((`mokhtalet_code` * `class`) + (`mokhtalet_code` + `class`)) AS `sumcode` , sum(`elec_id`) AS `elec_id` FROM `class_view` WHERE `term` IN( " . $term_active . " ) AND `master` = " . $id_master . " group BY `sumcode`";
		$res = mysql_query($sql_class_1);
		while ($row = mysql_fetch_array($res)) {
			//--------------------------------------------------------
			$sql_c = mysql_query("SELECT count(`id`) AS `c` 
			  FROM `edu_class_days` 
			  WHERE `type` <> 'تعطیل' AND `class`='" . $row['class'] . "'") or die(mysql_error());
			$row_c = mysql_fetch_object($sql_c);
			$kasri = $row['session'] - $row_c->c;
			//--------------------------------------------------------

			$name_master = $row['name'] . ' ' . $row['family'];
			$sql_class_2 = mysql_query("
			SELECT GROUP_CONCAT('<tr><td>', `type`,'</td><td>', `date` ,' - ', `time` ,'</td><td>', `name_mas`,' ', `family_mas` ,'</td><td></tr>' ) AS `detail`
			FROM `class_days_view` WHERE `class`=" . $row['class'] . "
			AND `type` <> 'عادی'
			AND `type` <> 'جبرانی'
			AND `type` <> 'تعطیل'
			AND `type` NOT LIKE '%فرع%'
			group by `class`") or die(mysql_error());
			$rrr = mysql_fetch_array($sql_class_2);

			if ($row['elec_id'] > 0) {
				/*	*/
				require_once '../library/skyroom/Skyroom.php';
				$apiUrl = 'https://www.skyroom.online/skyroom/api/apikey-42329-403-77e4fd263b3c854523d32fdc1437abe3';
				$api = new Skyroom($apiUrl);
				$action_getLoginUrl = 'createLoginUrl';
				$params_getLoginUrl = array(
					'room_id' => $row['elec_id'],
					'user_id' => $id_master,
					'nickname' =>  $name_master,
					'access' => 3,
					'concurrent' => 1,
					'language' => "fa",
					'ttl' => 300,
				);
				//  print_r($params_getLoginUrl);  

				$result_getLoginUrl = $api->call($action_getLoginUrl, $params_getLoginUrl);
				//	print_r($result_getLoginUrl);
				$link_class2 = $result_getLoginUrl['result'];
				//print_r($link_class2);					

				$link_class = '<a class="btn btn-circle blue" target="_Blank" href="' . $link_class2 . '">کلاس مجازی</a>';

				/**/
			} else {

				$link_class = '';
			}
			$detail = str_replace(',', '', $rrr['detail']);
			$dday = $this->show_day_list_print($row['day_0'], $row['day_1'], $row['day_2'], $row['day_3'], $row['day_4'], $row['day_5'], $row['day_6']);
			$detail2 = '<tr><td>شروع کلاس: </td><td>' . $row['start'] . '</td></tr>
				   			<tr><td>پایان کلاس: </td><td>' . $row['end'] . '</td></tr>
							<tr><td>تعداد جلسات: </td><td>' . $row['session'] . '</td></tr>
							<tr><td>جبرانی: </td><td>' . $kasri . '</td></tr>';
			$i++;
			$t .= '<tr class="rows">';
			$t .= '<td style="border-left:1px solid #cccccc;"><b>' . $row['level'] . ' 
				   <a class="btn btn-circle grey-cascade  ajax-demo" data-toggle="modal" href="#"  data-url="program/showgu.php?i=' . $row['ilevel'] . '">ضمائم</a>
				   <br> کد: ' . $row['code'] . '
				   <a class="btn btn-circle yellow ajax-demo" data-toggle="modal" href="#"  data-url="program/exam.php?i=' . $row['class'] . '">درخواست آزمون مجازی</a>
				   </b> <br>' . $dday . '
				   <a class="btn btn-circle green-meadow ajax-demo" data-toggle="modal" href="#"  data-url="program/showd.php?i=' . $row['class'] . '">جزئیات</a>' . $link_class . '</td>';
			$t .= '<td colspan="6" style="border-left:1px solid #cccccc;"> <table border="0" align="right" width="100%">' . $detail . '</table></td>';
			$t .= '<td colspan="4"> <table border="0" align="right" width="100%">' . $detail2 . '</table></td>';
			$t .= '</tr>';
		}

		$r .= '
			  <div class="modal-body"><table class="table table-striped table-bordered table-hover">
				  <tr>
					<th colspan="1" style="width:30%">کد فرم: F-H-08</th>
					<th colspan="6" style="text-align:center" class="title">جدول زمانبندی فعالیت های کلاس</th>
					<th colspan="4" style="width:30%">موسسه آموزشی حافظ و جهان علم</th>
				  </tr>
				  <tr>
					<td colspan="11" class="title_3">
					  <p  style="float:right;">استاد گرامی: <b>' . $name_master . '</b></p>
						<ul  style="float:right; direction:rtl;">
							<li>رعایت دقیق برنامه ذیل توصیه و تاکید می گردد</li>
							<li>جهت کلاس های جبرانی با کارشناس برنامه ریزی هماهنگی بعمل آید</li>
							<li>بلافاصله بعد از اعلام نمرات و تایید کارشناس آزمون ها لیست تعداد جلسات به حسابداری اعلام می گردد</li>
						</ul>
						
					</td>
				  </tr>
				 ';
		$out = $r . $t . '</table></div>';

		print $out;
	}

	function class_info_code_4_title($code) //ok
	{
		$sql = mysql_query("SELECT 
			`name_e_level`, `name_mas`,`family_mas`,`edu_level`.`id_e_level`, `edu_class`.`id_e_group`
			FROM `edu_class` ,`edu_level`,`master_info`
			WHERE `id_e_class` LIKE '" . $code . "'
			AND  `edu_class`.`id_e_level`=`edu_level`.`id_e_level`
			AND `id_e_master`=`id_mas`");
		$row = mysql_fetch_object($sql);
		$this->name_e_level = $row->name_e_level;
		$this->name_mas = $row->name_mas;
		$this->family_mas = $row->family_mas;
		$this->id_e_level = $row->id_e_level;
		$this->id_e_group = $row->id_e_group;
	}

	function class_clock_exam($id_master, $today, $year)
	{
		$array_class = array();
		$array_sumcode = array();
		$i = 0;
		$t = '';
		$r = '';
		$term_active = $this->term_jari($today, $year);
		$sql_class_1 = "
		SELECT * FROM 
		`edu_class`  , `edu_term`,`edu_level`, `basic_center` 
		WHERE `edu_class` .`id_e_term`
		IN(" . $term_active . ") 
		AND `id_e_master` =" . $id_master . "
		AND `edu_class` .`id_e_term`=`edu_term`.`id_e_term`
		AND `edu_class`.`id_e_level`=`edu_level`.`id_e_level`
		AND `id_b_center`=`center_e_term`";
		$res = mysql_query($sql_class_1);
		while ($row = mysql_fetch_array($res)) {
			$i++;
			$t .= '<tr class="rows">';
			$t .= '<td><b>' . $row['name_e_level'] . '-  کد: ' . $row['code_e_class'] . '</b></td>
				   <td>' . $row['season_e_term'] . ' ' . $row['year_e_term'] . ' «<strong>' . $row['type_e_term'] . ' </strong>' . $row['name_b_center'] . '»</td>
				   <td><a href="index.php?screen=exam/starte&c=' . $row['id_e_class'] . '&t=' . $row['id_e_term'] . '&l=' . $row['id_e_level'] . '">تصحیح سوالات</a></td>
				   <td>' . $row['start_e_class'] . '</td>
				   <td>' . $row['end_e_class'] . '</td>';
			$t .= '</tr>';
		}

		$r .= '
			  <div class="modal-body"><table class="table table-striped table-bordered table-hover">
				  <tr>
					<th class="title">کلاس</th>
					<th class="title">ترم</th>
					<th class="title">مشاهده سوالات</th>
					<th class="title">تاریخ شروع</th>
					<th class="title">تاریخ پایان</th>
				  </tr>
				 
				 ';
		$out = $r . $t . '</table></div>';

		print $out;
	}
}