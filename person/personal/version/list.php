<?php
if(!$access)
{
	print '<h1>No Access</h1>';
	print '<h1>Your IP Is: '.$_SERVER['REMOTE_ADDR'].'</h1>';
}
else
{
	
		
if(isset($_REQUEST[ide]))
{
	$ide=$pur->purify($_REQUEST[ide]);
	$edit=true;
	$sql_show="SELECT * FROM `version` WHERE `id`=".$ide;
	$res_show=mysql_query($sql_show);
	while($row=mysql_fetch_array($res_show))
	{
		$what=$row[what]; $ver=$row[ver];$new=$row['new']; $icon=$row[icon];  $master=$row[master];
	}
}
?>
<?php 
if(isset($_POST['add_group']))
{
	
	
	$sql_add="
INSERT INTO `version`(`id`, `what`, `date`, `ver`,`icon`,`new`,`master`) VALUES (NULL, '".$pur->purify($_POST['what'])."', NOW(), '".$pur->purify($_POST['ver'])."', '".$pur->purify($_POST['icon'])."' , 1, '".$pur->purify($_POST['master'])."');";
	
	if(mysql_query($sql_add))
	{	$message='
		<div class="panel panel-info">
		<div class="panel-heading">
		<h3 class="panel-title">پیام تایید</h3></div>
		<div class="panel-body"><h4>مشخصات با موفقیت ذخیره گردید .</h4></div>
		</div></div>';
		
		
		// $stringData =$sql_add;
		
		
		//------------------------------------------------------	
			$logg->add($_SESSION[PREFIXOFSESS.'idp'] , 'افزودن ورژن' ,mysql_insert_id() , $sql_add);
//------------------------------------------------------
	}
	else
		$message='
		<div class="panel panel-danger">
		<div class="panel-heading">
		<h3 class="panel-title">خطا</h3></div>
		<div class="panel-body font-lg"><h4>عملیات ثبت ناموفق بود. لطفا مجددا تلاش نمائید</h4></div>
		</div></div>';
}
if(isset($_POST['edit_group']))
{
	$what=$pur->purify($_POST[what]);
	$ver=$pur->purify($_POST[ver]);
	$icon=$pur->purify($_POST[icon]);
	$new=$pur->purify($_POST['new']);
	$master=$pur->purify($_POST['master']);
	$sql_2="UPDATE `version` SET `what`='$what' , `ver`= '$ver' , `new`= '$new' , `icon`='$icon', `master`='$master' WHERE `id`=".$_POST[idep].";";
	
		
		// $stringData =$sql_2;
		
		
	 //------------------------------------------------------	
			$logg->add($_SESSION[PREFIXOFSESS.'idp'] , 'ویرایش ورژن' ,$_POST[idep] , $sql_2);
//------------------------------------------------------
	
	 if(mysql_query($sql_2))
	 	$message= '<div class="panel panel-info">
		<div class="panel-heading">
		<h3 class="panel-title">پیام تایید</h3></div>
		<div class="panel-body"><h4>مشخصات با موفقیت ذخیره گردید .</h4></div>
		</div></div>';
	else
		$message='
		<div class="panel panel-danger">
		<div class="panel-heading">
		<h3 class="panel-title">خطا</h3></div>
		<div class="panel-body font-lg"><h4>عملیات ثبت ناموفق بود. لطفا مجددا تلاش نمائید</h4></div>
		</div></div>';
		unset($edu);
}
?>
 <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />     
<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/table-datatables-buttons.js" type="text/javascript"></script>
<div class="page-content">
	<div class="note note-info"><strong>ورژن ها</strong></div>
<div class="tabbable-line">
    <?php
	 print $message; 
	?>
<div class="form-body">
<div class="row">
 <form method="post" action="index.php?screen=personal/version/list" id="add_group">
<div class="form-group col-md-4">
	<label class="col-md-2 control-label">عنوان<span class="required"> * </span></label>
    <div class="col-md-6"><input class="form-control input-circlel" placeholder="عنوان" type="text" name="what" id="what" value="<?=$what?>" required>
    </div>
</div>
<div class="form-group col-md-4">
	<label class="col-md-2 control-label">ورژن<span class="required"> * </span></label>
    <div class="col-md-6"><input class="form-control input-circlel" placeholder="ورژن" type="text" name="ver" id="ver" value="<?=$ver?>" required>
    </div>
</div>
<div class="form-group col-md-4">
	<label class="col-md-2 control-label">جدید<span class="required"> * </span></label>
    <div class="col-md-6"><input class="form-control input-circlel" placeholder="جدید" type="text" name="new" id="new" value="<?=$new?>" required>
    </div>
</div>
<div class="form-group col-md-4">
	<label class="col-md-2 control-label">آیکون<span class="required"> * </span></label>
    <div class="col-md-6"><input class="form-control input-circlel" placeholder="آیکون" type="text" name="icon" id="icon" value="<?=$icon?>" required>
    </div>
</div>
<div class="form-group col-md-4">
	<label class="col-md-2 control-label">اساتید<span class="required"> * </span></label>
    <div class="col-md-6"><input class="form-control input-circlel" placeholder="جدید" type="text" name="master" id="master" value="<?=$master?>" required>
    </div>
</div>
<div class="form-group col-md-4">
    <div class="col-md-6">
    <?php
	if($edit)
	print '<input type="hidden" name="idep" value="'.$ide.'"><button type="submit" class="btn green btn-lg" name="edit_group" value="save" >ذخیره</button>';
	else
	print '<button type="submit" class="btn green btn-lg" name="add_group" value="save" >ذخیره</button>';
	?>
    
    </div>
</div> </form>
</div>
</div>
 <div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-dark">
		<i class="icon-settings font-dark"></i>
		<span class="caption-subject bold uppercase">ورژن ها</span>
		</div>
		<div class="tools"> </div>
	</div>
  
<div class="portlet-body green">
<table class="table table-striped table-bordered sample_2">
<thead>
      <tr>
        <th>#</th><th>شناسه</th><th>عنوان</th><th>ورژن</th><th>آیکون</th><th>جدید</th><th>مستر</th><th>عملیات</th>
      </tr>
</thead>
<tbody>
      <?php
	$sql_list_group="
	SELECT * FROM `version` ORDER BY `version`.`date` DESC";
	$res=mysql_query($sql_list_group);
  while($row=mysql_fetch_array($res))
  {
	  $i++; 
	  print '<tr>
	   <td>'.$i.'</td>
	   <td><strong>'.$row[id].'</strong></td>
	   <td>&nbsp;'. $row[what].'</td>
	    <td>&nbsp;'. $row[ver].'</td>
		<td>'.$row[icon].' &nbsp;<i class="fa fa-'.$row[icon].'"></i></td>
	    <td>&nbsp;'. $row['new'].'</td>
		 <td>&nbsp;'. $row['master'].'</td>
       <td align="center">';
		?>
		<a href="index.php?screen=personal/version/list&ide=<?=$row[id]?>" title="ویرایش"><span class="glyphicon glyphicon-edit"> </span></a>
		
		<?php
		print '
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