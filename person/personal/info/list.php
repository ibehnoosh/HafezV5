<?php
if(!$access)
{
	print '<h1>No Access</h1>';
	print '<h1>Your IP Is: '.$_SERVER['REMOTE_ADDR'].'</h1>';
}
else
{
	
	$basic=new basic;	
?>
<link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />
<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/table-datatables-buttons.js" type="text/javascript"></script>
<?php
if(isset($_REQUEST['id']))
	{
		$id_per=$_REQUEST['id'];
		switch ($_REQUEST[statuse])
		{
			case 'no':
				$sql_updte="
UPDATE `person_info` SET `active_per` = 'yes' WHERE `id_per`=".$id_per.";";
				mysql_query($sql_updte);
//------------------------------------------------------------------
//درج لاگ
//------------------------------------------------------------------


// $stringData =$sql_updte;


				break;
			case 'yes':
				$sql_updte="
UPDATE `person_info` SET `active_per` = 'no' WHERE `id_per`=".$id_per.";";
//------------------------------------------------------------------
//درج لاگ
//------------------------------------------------------------------


// $stringData =$sql_updte;


				mysql_query($sql_updte);
				break;
		}
	}
?>
<div class="page-content">
	<div class="note note-info"><strong>پرسنل</strong></div>
<div class="tabbable-line">
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-dark">
		<i class="icon-settings font-dark"></i>
		<span class="caption-subject bold uppercase">لیست پرسنل</span>
		</div>
		<div class="tools"> </div>
	</div>
<div class="portlet-body green">
<input type="hidden" name="operation" />
<input type="hidden" name="id_personal" />
<input type="hidden" name="statuse" />
<table class="table table-striped table-bordered sample_2">
<thead>
      <tr>
      <th>#</th>
      <th>تصویر</th>
      <th>نام خانوادگی / نام</th>
      <th>تلفن همراه</th>
      <th>کد ملی</th>
      <th>وضعیت</th>
      <th>عملیات</th>
      </tr>
  </thead>
  <tbody>
      <?php
	$sql_list_group="
	SELECT `id_per` , `name_per` , `family_per` , `mobile_per`  , `active_per`,`pic_per` , `meli_per`
	FROM `person_info` 
	ORDER BY `person_info`.`family_per` ASC";
	
	$res=mysql_query($sql_list_group);
	if(mysql_num_rows($res) == 0)
	{
		print '<tr><td colspan="8" align="center">هیچ پرسنلی با این مشخصات وجود ندارد</td></tr>';
	}
	else
	{
	
  //*****************************************************
		 while($row=mysql_fetch_array($res))
  {
	  if(!($row[pic_per]=='')) 
		$img= '<img src="../pictures/person/'.$row[pic_per].'"height="70">'; 
		else $img= '<span class="icon-picture "></span>';
	   //--------------------------------------------------------
			  $cipher = new Crypt_Blowfish($key_encrypte);
			  $cipher_id_e_person = Eencrypt($cipher,$row[id_per]);
			  $cipher_id_e_person=str_replace("+", "%2B", $cipher_id_e_person);
	  //--------------------------------------------------------
	  $i++;
	  print '<tr>
	  
	  <th>'.$i.'</th>
      <td align="center">'.$img.'</td>
	  <td>'. $row[family_per].'&nbsp;'.$row[name_per].'</td>
	  <td>'. $row[mobile_per].'</td>
	  <td>'. $row[meli_per].'</td>
	  <td align="center">
		<a href="index.php?screen=personal/info/list&id='.$row[id_per].'&statuse='.$row[active_per].'">'.$per->show_active($row[active_per]).'</a></td>
	  <td align="center">
		<a title="اطلاعات بیشتر"  href="index.php?screen=personal/info/more_info&id='.$cipher_id_e_person.'">
		<span class="glyphicon glyphicon-info-sign"> </span></a> 
		<a title=" ویرایش تصاویر" href="index.php?screen=personal/info/picture&id='.$cipher_id_e_person.'"">
		<span class="glyphicon glyphicon-picture"> </span>
		</a>
		<a title="ویرایش" href="index.php?screen=personal/info/edit&id='.$cipher_id_e_person.'">
		<span class="glyphicon glyphicon-edit"> </span></a>
		<a title="رمز عبور" href="index.php?screen=personal/info/password&id='.$cipher_id_e_person.'">
		<span class="fa fa-key"> </span></a>
		</td>
      </tr>';
	}
?>
    <?php
	}
	?>
    </tbody>
    </table>
</div>
</div>
</div>
</div>
<?php
}
?>