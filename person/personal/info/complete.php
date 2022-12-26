<div class="page-content">
	<div class="note note-info"><strong>ثبت مشخصات پرسنل</strong></div>
<div class="tabbable-line">
<?php
if(!$access)
{
	print '<h1>No Access</h1>';
	print '<h1>Your IP Is: '.$_SERVER['REMOTE_ADDR'].'</h1>';
}
else
{	
	
	$basic=new basic;
if($_POST['add_personal'])
{
	//****************************************************
	$number_per=$_SESSION[PREFIXOFSESS.'number_per']=$pur->purify($_POST[number_per]);
	$meli_per=$_SESSION[PREFIXOFSESS.'meli_per']=$pur->purify($_POST[meli_per]);
	$name_per=$_SESSION[PREFIXOFSESS.'name_per']=$pur->purify($_POST[name_per]);
	$family_per=$_SESSION[PREFIXOFSESS.'family_per']=$pur->purify($_POST[family_per]);
	$birth_per=$_SESSION[PREFIXOFSESS.'birth_per']=$pur->purify($_POST[birth_per]);
	$city_per=$_SESSION[PREFIXOFSESS.'city_per']=$pur->purify($_POST[city_per]);
	$gender_per=$_SESSION[PREFIXOFSESS.'gender_per']=$pur->purify($_POST[gender_per]);
	$mobile_per=$_SESSION[PREFIXOFSESS.'mobile_per']=$pur->purify($_POST[mobile_per]);
	$hometel_per=$_SESSION[PREFIXOFSESS.'hometel_per']=$pur->purify($_POST[hometel_per]);
	$nesstel_per=$_SESSION[PREFIXOFSESS.'nesstel_per']=$pur->purify($_POST[nesstel_per]);
	$homeadd_per=$_SESSION[PREFIXOFSESS.'homeadd_per']=$pur->purify($_POST[homeadd_per]);
	$email_per=$_SESSION[PREFIXOFSESS.'email_per']=$pur->purify($_POST[email_per]);
	$degree_per=$_SESSION[PREFIXOFSESS.'degree_per']=$pur->purify($_POST[degree_per]);
	$major_per=$_SESSION[PREFIXOFSESS.'major_per']=$pur->purify($_POST[major_per]);
	$username_per=$number_per;
	$password_stu=md5($number_per);
	$sql_insert="INSERT INTO `person_info` 
				(
				`id_per` ,`number_per` ,`name_per` ,`family_per` ,`meli_per` ,`birth_per` ,`city_per` ,`gender_per` ,
				`mobile_per` ,`hometel_per` ,`nesstel_per` ,`homeadd_per` ,`email_per` ,
				`semat_per` ,`work_per` ,`degree_per` ,`major_per` ,`pic_per` ,`username_per` , `password_per`
				)
				VALUES 
				(
				NUll, '$number_per','$name_per', '$family_per', '$meli_per', '$birth_per', '$city_per', '$gender_per', '$mobile_per', '$hometel_per', '$nesstel_per', '$homeadd_per', '$email_per', '', '', '$degree_per', '$major_per', '$picperson_per','$username_per' ,'$password_stu'
				);";
	   
	   if(mysql_query($sql_insert))
		{	
			$sql_insert_log="
			INSERT INTO `person_info` (`id_per` ,`number_per` ,`name_per` ,`family_per` ,`meli_per` ,`birth_per` ,`city_per` ,`gender_per` ,
			`mobile_per` ,`hometel_per` ,`nesstel_per` ,`homeadd_per` ,`email_per` ,
			`semat_per` ,`work_per` ,`degree_per` ,`major_per` ,`pic_per` ,`username_per` , `password_per`)
			VALUES (".mysql_insert_id().", '$number_per','$name_per', '$family_per', '$meli_per', '$birth_per', '$city_per', '$gender_per', '$mobile_per', '$hometel_per', '$nesstel_per', '$homeadd_per', '$email_per', '', '', '$degree_per', '$major_per', '$picperson_per','$username_per' ,'$password_stu'
			);
			";
		//------------------------------------------------------	
			$logg->add($_SESSION[PREFIXOFSESS.'idp'] , 'افزودن پرسنل' ,mysql_insert_id() , $sql_insert_log);
		//------------------------------------------------------
			print '<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">پیام تایید</h3></div>
			<div class="panel-body"><h4>مشخصات پرسنل با موفقیت ذخیره گردید .</h4></div>
			</div>';
			unset($_SESSION[PREFIXOFSESS.'number_per']);
			unset($_SESSION[PREFIXOFSESS.'meli_per']);
			unset($_SESSION[PREFIXOFSESS.'name_per']);
			unset($_SESSION[PREFIXOFSESS.'family_per']);
			unset($_SESSION[PREFIXOFSESS.'birth_per']);
			unset($_SESSION[PREFIXOFSESS.'city_per']);
			unset($_SESSION[PREFIXOFSESS.'gender_per']);
			unset($_SESSION[PREFIXOFSESS.'mobile_per']);
			unset($_SESSION[PREFIXOFSESS.'hometel_per']);
			unset($_SESSION[PREFIXOFSESS.'nesstel_per']);
			unset($_SESSION[PREFIXOFSESS.'homeadd_per']);
			unset($_SESSION[PREFIXOFSESS.'email_per']);
			unset($_SESSION[PREFIXOFSESS.'degree_per']);
			unset($_SESSION[PREFIXOFSESS.'major_per']);
		}
	else
		{
			print '<div class="panel panel-danger">
		<div class="panel-heading">
		<h3 class="panel-title">خطا</h3></div>
		<div class="panel-body font-lg"><h4>ثبت با خطا مواجه بود لطفا مجددا تلاش نمایید .</h4></div>
		</div>';
		}
		
}
}
?>