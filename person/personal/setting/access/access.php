<link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />
<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/table-datatables-buttons.js" type="text/javascript"></script>
<?php
if(!$access)
{
print '<h1>No Access</h1>';
print '<h1>Your IP Is: '.$_SERVER['REMOTE_ADDR'].'</h1>';
}
else
{	
if(isset($_REQUEST['i']) && is_numeric($_REQUEST['i']))
	{
		$id_person=$_REQUEST['i'];
		if(isset($_REQUEST['le']) && is_numeric($_REQUEST['le']))
		{
			switch ($_REQUEST['le'])
			{
				case '0':
					$sql_updte="UPDATE `person_info` SET `level` = '3' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
				case '1':
					$sql_updte="UPDATE `person_info` SET `level` = '0' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
				case '2':
					$sql_updte="UPDATE `person_info` SET `level` = '1' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
				case '3':
					$sql_updte="UPDATE `person_info` SET `level` = '2' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
			}
		}
		if(isset($_REQUEST['ch']) && is_numeric($_REQUEST['ch']))
		{
			switch ($_REQUEST['ch'])
			{
				case '0':
					$sql_updte="UPDATE `person_info` SET `chc` = '1' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
				case '1':
					$sql_updte="UPDATE `person_info` SET `chc` = '0' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
			}
		}
		if(isset($_REQUEST['ac']) && is_numeric($_REQUEST['ac']))
		{
			switch ($_REQUEST['ac'])
			{
				case '0':
					$sql_updte="UPDATE `person_info` SET `acc` = '1' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
				case '1':
					$sql_updte="UPDATE `person_info` SET `acc` = '0' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
			}
		}
		if(isset($_REQUEST['cc']) && is_numeric($_REQUEST['cc']))
		{
			switch ($_REQUEST['cc'])
			{
				case '0':
					$sql_updte="UPDATE `person_info` SET `com_class_day` = '1' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
				case '1':
					$sql_updte="UPDATE `person_info` SET `com_class_day` = '0' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
			}
		}
		if(isset($_REQUEST['ap']))
		{
			switch ($_REQUEST['ap'])
			{
				case 'yes':
					$sql_updte="UPDATE `person_info` SET `active_per` = 'no' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
				case 'no':
					$sql_updte="UPDATE `person_info` SET `active_per` = 'yes' WHERE `id_per`=".$id_person;
					mysql_query($sql_updte);
					break;
			}
		}
		
		 //------------------------------------------------------	
			//$logg->add($_SESSION[PREFIXOFSESS.'idp'] , 'تغییر سطح دسترسی' ,$id_person , $sql_updte);
		//------------------------------------------------------
	}
	
?>
<div class="page-content">
	<div class="note note-info"><h4 class="block">سطوح دسترسی پرسنل</h4></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-dark">
		<i class="icon-settings font-dark"></i>
		<span class="caption-subject bold uppercase">لیست پرسنل</span>
		</div>
		<div class="tools"> </div>
	</div>
       
<div class="portlet-body green">
<table class="table table-striped table-bordered sample_2">
<thead>
<tr>
       <th>#</th>
       <th>نام خانوادگی  نام</th>
       <th>سطح</th>
       <th>تغییر ظرفیت</th>
       <th>وضعیت حسابدار</th>
       <th>تایید وضعیت کلاس</th>
       <th>وضعیت همکاری</th>
       <th>عملیات</th>
</tr>
</thead>
<tbody>
<?php
$sql_list="SELECT * FROM `person_info` WHERE `active_per`='yes' ORDER BY `person_info`.`family_per` ASC ";
$res=mysql_query($sql_list);
while($row=mysql_fetch_array($res))
{
	  $i++;
	  print '
	  <tr>
	  	<th>'.$i.'</th>
		<td><a title="ویرایش" href="index.php?screen=personal/setting/access/oneperson&i='.$row[id_per].'">'. $row[family_per].'&nbsp;'.$row[name_per].'</a></td>
		<td><a href="index.php?screen=personal/setting/access/access&i='.$row[id_per].'&le='.$row[level].'">'. $row[level].'<span class="glyphicon glyphicon-pencil"> </span></td>
		<td><a href="index.php?screen=personal/setting/access/access&i='.$row[id_per].'&ch='.$row[chc].'">'.$row[chc].'<span class="glyphicon glyphicon-pencil"> </span></a></td>
		<td><a href="index.php?screen=personal/setting/access/access&i='.$row[id_per].'&ac='.$row[acc].'">'.$row[acc].'<span class="glyphicon glyphicon-pencil"> </span></a></td>
		<td><a href="index.php?screen=personal/setting/access/access&i='.$row[id_per].'&cc='.$row[com_class_day].'">'.$row[com_class_day].'<span class="glyphicon glyphicon-pencil"> </span></a></td>
		<td><a href="index.php?screen=personal/setting/access/access&i='.$row[id_per].'&ap='.$row[active_per].'">'.$row[active_per].'<span class="glyphicon glyphicon-pencil"> </span></a></td>
        <td>
		<a title="ویرایش" href="index.php?screen=personal/setting/access/oneperson&i='.$row[id_per].'">
			<span class="glyphicon glyphicon-edit"> </span>
		</td>
	</tr>';
}
	?>
    </tbody>
    </table>
<?php
}
?>
</div>
</div>
</div>