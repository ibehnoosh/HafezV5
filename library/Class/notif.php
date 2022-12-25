<?php
class notification
{
	function cheking($what , $id)
	{
		switch($what){
			case 'student_info_request':
				$sql="SELECT count(`id`) AS `c` FROM `student_info_them` WHERE `id_stu`=0;";
				$mes="درخواست ثبت نام ";
				$url="index.php?screen=student/info/request";
				$i="fa fa-user";
				$class="tile bg-yellow-saffron";
			break;
			
			case 'student_form_check':
				$sql="SELECT count(`id`) AS `c`  FROM `site_req_govahi` WHERE `statuse` LIKE 'در نوبت بررسی' AND `type` <> 4";
				$mes="درخواست گواهینامه";
				$url="index.php?screen=student/form/check";
				$i="fa fa-briefcase";
				$class="tile bg-blue-steel";
			break;
			
			case 'student_exam_request':
				$sql="SELECT count(`id_exam`) AS `c` FROM `student_exam` WHERE `statuse` LIKE 'بررسی نشده' ";
				$mes="درخواست آزمون مجدد";
				$url="index.php?screen=student/exam/request";
				$i="fa fa-user";
				$class="tile bg-purple-studio";
			break;
			
			case 'private_request':
				$sql="SELECT count(`id`) AS `c`  FROM `pri_request` WHERE `statuse` LIKE 'بررسی نشده' AND `com`=1";
				$mes="درخواست کلاس خصوصی";
				$url="index.php?screen=private/request";
				$i="fa fa-star";
				$class="tile bg-green-jungle";
			break;
			
			case 'message_inbox':
				$sql="SELECT count(`idml`) AS `c`   FROM `mail` WHERE `resiver_ml` = '".$id."'	AND `readdate_ml`='0000-00-00 00:00:00' AND `operation_r`='s'";
				$mes="پیام جدید";
				$url="index.php?screen=message/inbox";
				$i="fa fa-envelope";
				$class="tile bg-red-flamingo";
			break;
			
			case 'message_inbox23':
				$sql="SELECT count(`idml`) AS `c`  FROM `site_mail` WHERE `resiver_ml` = '23'	AND `readdate_ml`='0000-00-00 00:00:00' AND `operation_r`='s' AND `sender_ml` > 8000";
				$mes="پیام مدیریت ";
				$url="index.php?screen=message/inbox_stu&gol=23";
				$i="fa fa-envelope-o";
				$class="tile bg-green-meadow";
			break;
			
			case 'message_inbox1':
			 	$sql="SELECT count(`idml`) AS `c`  FROM `site_mail` WHERE `resiver_ml` = '1'	AND `readdate_ml`='0000-00-00 00:00:00' AND `operation_r`='s'  AND `sender_ml` > 8000";
			 	$mes="پیام پشتیبان ";
				$url="index.php?screen=message/inbox_stu&gol=1";
				$i="fa fa-comments";
				$class="tile bg-blue";
			break;
			
			case 'student_relate_request':
				$sql="SELECT count(`id`) AS `c` FROM `relate_request` WHERE `statuse`='بررسی نشده'";
				$mes="درخواست تخفیف";
				$url="index.php?screen=student/relate/request";
				$i="fa fa-scissors";
				$class="tile bg-yellow-gold";
			break;
			
			case 'student_mark1':
				$sql="
				SELECT COUNT(*) AS `c` FROM (
				SELECT  `class_stu_reg` FROM `student_grade`,`student_register` WHERE `lock` = 0 AND `id_reg`=`id_stu_reg` GROUP BY `class_stu_reg`) AS `g`";
				$mes="نمرات تایید نشده";
				$url="index.php?screen=mark/class/list_in_class";
				$i="fa fa-scissors";
				$class="tile bg-grey-silver";
			break;
			
			case 'student_mark2':
				$sql="
				SELECT COUNT(*) AS `c` FROM (
				SELECT `class_stu_reg`  FROM `student_grade`,`student_register`,`edu_class` WHERE `lock` =1
				AND `id_reg`=`id_stu_reg` AND `class_stu_reg`=`id_e_class` AND `mark`='n' GROUP BY `class_stu_reg`) AS `g`";
				$mes="نمرات تایید شده";
				$url="index.php?screen=student/class/list_in_class";
				$i="fa fa-scissors";
				$class="tile bg-grey-cascade";
			break;
			case 'ielts_writing':
				$sql="SELECT count(*) AS `c`  FROM `ielts_stu` WHERE `com` = 1 AND `request` LIKE 'wri' AND `statuse`=''";
				$mes="تصحیح رایتینگ ";
				$url="index.php?screen=ielts/writing";
				$i="fa fa-map";
				$class="tile bg-yellow-mint";
			break;
			
			default:
			$sql="";
				break;
		}
		
		if($sql <> "")
		{
			$res=mysql_query($sql);
			$row=mysql_fetch_object($res);
			
			$out='<div class="'.$class.'"><a href="'.$url.'">
			<div class="tile-body"><i class="'.$i.'"></i></div>
            <div class="tile-object"><div class="name"> '.$mes.' </div><div class="number"> '.$row->c.' </div>
            </div></a>
            </div>';
		}
		
		return $out;
	}
	function show($id)
	{
		$out='';
		$sql=mysql_query("SELECT *  FROM `p_menu_option` , `p_person_access` WHERE `func` != '0'
		AND `p_menu_option`.`id`=`menu`
		AND `person`=".$id." AND `permision`=2
		GROUP BY `menu` " );
		while($row=mysql_fetch_object($sql))
		{
			$out.=$this->cheking($row->func , $id);
		}
		
		return $out;
	}
	
}