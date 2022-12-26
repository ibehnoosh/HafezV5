<div class="page-content">
	<div class="note note-info"><h4 class="block">جزئیات کار پرسنل</h4></div>
<div class="tabbable-line">
<form id="edit_form" name="edit_form" method="post" action="">
 <div class="form-group col-md-6"><label class="col-md-4 control-label"  >
who</label><select id="who" name="who" class="form-control" >
    <option value=""></option>
    <?php
	$sql_re="SELECT `id_per`, `name_per`, `family_per` FROM `person_info` WHERE `active_per` LIKE 'yes' ORDER BY `person_info`.`family_per` ASC ";
	$res_re=mysql_query($sql_re);
	while($row_re=mysql_fetch_object($res_re))
	{
		print '<option value="'.$row_re->id_per.'">'.$row_re->family_per.' '.$row_re->name_per.'</option>';
	}
	?>
    </select></div>
     <div class="form-group col-md-6"><label class="col-md-4 control-label">
operation</label><select id="operation" name="operation" class="form-control" >
    <option value=""></option>
    <?php
	$sql_re="SELECT DISTINCT `operation` FROM `logg` ORDER BY `logg`.`operation` ASC";
	$res_re=mysql_query($sql_re);
	while($row_re=mysql_fetch_object($res_re))
	{
		print '<option value="'.$row_re->operation.'">'.$row_re->operation.'</option>';
	}
	?>
    </select></div>
<div class="form-group col-md-6"><label class="col-md-4 control-label">
what</label><input type="text" name="what" value="<?=$_SESSION[PREFIXOFSESS.'log_what']?>" class="form-control" ></div>
<div class="form-group col-md-6"><label class="col-md-4 control-label">
details</label><input type="text" name="details" value="<?=$_SESSION[PREFIXOFSESS.'log_details']?>" class="form-control" ></div>
 <div class="form-group col-md-6"><label class="col-md-4 control-label">
key</label><input type="text" name="key" value="<?=$_SESSION[PREFIXOFSESS.'log_key']?>" class="form-control" ></div>
 <div class="form-group col-md-6"><label class="col-md-4 control-label">
date</label><input type="text" name="date" value="<?=$_SESSION[PREFIXOFSESS.'log_date']?>" class="form-control" ></div>
 <div class="form-group col-md-6">
<input  type="submit" name="search" value="جستجو" class="btn green"></div>
</form>
<?php
if(isset($_POST[search]))
{
	$sql="SELECT `id`, `who`, `operation`, `what`, `details`, `key`, `date`,`family_per`,`name_per` 
	FROM `logg` ,`person_info`
	WHERE `who`=`id_per` ";
	if($_POST[who] <> '' ) $sql.=" AND `who`=".$_POST[who];
	if($_POST[operation] <> '' ) $sql.=" AND `operation`='".$_POST[operation]."'";
	if($_POST[what] <> '' ) $sql.=" AND `what` LIKE '%".$_POST[what]."%'";
	if($_POST[details] <> '' ) $sql.=" AND `details` LIKE '%".$_POST[details]."%'";
	if($_POST[key] <> '' ) $sql.=" AND `key` LIKE '%".$_POST[key]."%'";
	if($_POST[date] <> '' ) $sql.=" AND `date` LIKE '%".$_POST[date]."%'";
}
else
{
	$sql="SELECT `id`, `who`, `operation`, `what`, `details`, `key`, `date`,`family_per`,`name_per` 
	FROM `logg` ,`person_info`
	WHERE `who`=`id_per` ORDER BY `logg`.`date` DESC limit 0,100";
}
$res=mysql_query($sql);
?>
<table class="table table-striped table-bordered table-hover">
	<tr>
    	<th>#</th>
    	<th>who</th>
        <th>operation</th>
        <th>what</th>
        <th>details</th>
        <th>key</th>
        <th>date</th>
    </tr>
    <?php
	while($row=mysql_fetch_object($res))
	{
		$t++;
		print '<tr>
		<td>'.$t.'</td>
    	<td>'.$row->family_per.' '.$row->name_per.'</td>
        <td>'.$row->operation.'</td>
        <td>'.$row->what.'</td>
        <td style="direction:ltr">'.$row->details.'</td>
        <td>'.$row->key.'</td>
        <td>'.$row->date.'</td>
    </tr>';
	}
	?>
</table>
</div>
</div>