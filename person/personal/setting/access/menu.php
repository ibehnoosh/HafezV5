<div class="page-content">
	<div class="note note-info"><h4 class="block">مدیریت  منو ها</h4></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="add">
    <?php
	if(isset($_POST[addm]))
	{
		$title=($_POST[title]);
		$url=($_POST[url]);
		$order=($_POST[order]);
		$group=$_POST[group];
		$sql_insert="
INSERT INTO `p_menu_option` (`id`, `name`, `group`, `order`, `url`) VALUES (NULL, '$title', '$group', '$order', '$url');";
		if(mysql_query($sql_insert))
		{
			//------------------------------------------------------------------
			//درج لاگ
			//------------------------------------------------------------------
					
					
					// $stringData =$sql_insert;
					
					
			print '<div class="ok">عملیات انجام شد.</div>';
		}
	}
	if(isset($_POST[editm]))
	{
		$title=($_POST[title]);
		$url=($_POST[url]);
		$order=($_POST[order]);
		$group=$_POST[group];
		$id=$_POST[id];
		$sql_edit="
UPDATE `p_menu_option` SET `name` = '$title',  `group`='$group', `order`='$order', `url` ='$url' WHERE `id`=".$id.";";
		if(mysql_query($sql_edit))
		{
			//------------------------------------------------------------------
			//درج لاگ
			//------------------------------------------------------------------
					
					
					// $stringData =$sql_edit;
					
					
			print '<div class="ok">عملیات انجام شد.</div>';
		}
	}
	
	if(isset($_REQUEST['edit']))
	{
		$edit=$_REQUEST['edit'];
		$sql_fetch=mysql_query("SELECT *  FROM `p_menu_option` WHERE `id` = ".$edit);
		$rowf=mysql_fetch_object($sql_fetch);
		?>
         <form name="addmform" action="index.php?screen=personal/setting/access/menu" method="post">
         <input type="hidden" value="<?=$edit?>" name="id" />
    <p><b>ویرایش  منو</b></p>
    <p>عنوان منو: <input type="text" name="title"  value="<?=$rowf->name?>"/></p>
    <p> مسیر منو: <input type="text" name="url" value="<?=$rowf->url?>"/></p>
    <p> ترتیب: <input type="text" name="order" value="<?=$rowf->order?>"/></p>
    <p>گروه: <select name="group">
    <?php
	$sql=mysql_query("SELECT * FROM `p_menu_group` ORDER BY `p_menu_group`.`name` ASC");
	while($row=mysql_fetch_object($sql))
	{
		if($rowf->group == $row->id)
		print '<option value="'.$row->id.'" selected>'.$row->name.'</option>';
		else
		print '<option value="'.$row->id.'">'.$row->name.'</option>';
	}
	?>
    </select></p>
    <p><input name="editm" type="submit" value="ویرایش" class="buttom_edit" /></p></form>
        <?php
	}
	else
	{
	?>
    <form name="addmform" action="" method="post">
    <p><b>افزودن  منو</b></p>
    <p>عنوان منو: <input type="text" name="title" /></p>
    <p> مسیر منو: <input type="text" name="url" /></p>
    <p> ترتیب: <input type="text" name="order" /></p>
    <p>گروه: <select name="group">
    <?php
	$sql=mysql_query("SELECT * FROM `p_menu_group` ORDER BY `p_menu_group`.`name` ASC");
	while($row=mysql_fetch_object($sql))
	{
		print '<option value="'.$row->id.'">'.$row->name.'</option>';
	}
	?>
    </select></p>
    <p><input name="addm" type="submit" value="افزودن" class="buttom_add" /></p></form>
    <?php
	}
	?>
    </td>
   <td class="add">
    <?php
	if(isset($_POST[adds]))
	{
		$url=($_POST[url]);
		$group=$_POST[group];
		$sql_insert="
INSERT INTO  `p_menu_sub` (`id`, `url`, `parent`) VALUES (NULL, '$url', '$group');";
		if(mysql_query($sql_insert))
		{//------------------------------------------------------------------
			//درج لاگ
			//------------------------------------------------------------------
					
					
					// $stringData =$sql_insert;
					
					
			print '<div class="ok">عملیات انجام شد.</div>';
		}
	}
	?>
    <form name="addsform" action="" method="post">
    <p><b>افزودن زیر منو</b></p>
    <p> مسیر منو: <input type="text" name="url" /></p>
    <p>گروه: <select name="group">
    <?php
	$sql=mysql_query("SELECT * FROM  `p_menu_option` ORDER BY  `p_menu_option`.`name` ASC");
	while($row=mysql_fetch_object($sql))
	{
		print '<option value="'.$row->id.'">'.$row->name.' - '.$row->url.'</option>';
	}
	?>
    </select></p>
    <p><input name="adds" type="submit" value="افزودن" class="buttom_add" /></p></form>
    </td>
  </tr>
  <tr>
  <td class="add" colspan="2">
<table class="table table-striped table-bordered sample_2">
  	<tr>
    	<th>عنوان منو</th><th>ترتیب</th><th>آدرس</th><th>گروه</th><th>ویرایش</th>
    </tr>
    <?php
	$sql=mysql_query("SELECT
	`p_menu_option`.`id`,`p_menu_option`.`name`,`p_menu_option`.`order`,`p_menu_option`.`url`,`p_menu_group`.`name` AS `nameg`
	FROM `p_menu_option`, `p_menu_group`
	WHERE `group`=`p_menu_group`.`id` ORDER BY `p_menu_group`.`name` , `p_menu_option`.`order` ASC");
	
	while($row=mysql_fetch_object($sql))
	{
		print '
		<tr>
    	<td>'.$row->name.'</td>
		<td>'.$row->order.'</td>
		<td>'.$row->url.'</td>
		<td>'.$row->nameg.'</td>
		<td><a href="index.php?screen=personal/setting/access/menu&edit='.$row->id.'"><span class="glyphicon glyphicon-edit"> </span></a></td>
    	</tr>';
	}
	?>
    
  </table>
  </td>
  </tr>
</table>
</div>