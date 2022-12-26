<script language="JavaScript" type="text/javascript">
function getsupport ( selectedtype )
{
  document.personal_list.operation.value = selectedtype ;
  document.personal_list.submit() ;
}
</script>
<?php
include("../library/portal/menu.php");
$menu=new menu;
if(isset($_POST[operation]))
{
	$semar_per=$_POST[semar_per];
	$_SESSION[PREFIXOFSESS.'semar_per_acc']=$semar_per;
	
	$center=$_POST[center];
	$_SESSION[PREFIXOFSESS.'center']=$center;
}
if(!isset($_SESSION[PREFIXOFSESS.'semar_per_acc']))
{
	$_SESSION[PREFIXOFSESS.'semar_per_acc']='none';
}
if(!isset($_SESSION[PREFIXOFSESS.'center']))
{
	$_SESSION[PREFIXOFSESS.'center']='none';
}
	
	if(isset($_POST[apply]))
	{		
		$semat=$_SESSION[PREFIXOFSESS.'semar_per_acc'];
		$maxmenu=$_POST[maxmenu];
		$center=$_SESSION[PREFIXOFSESS.'center'];
		
		for($k=1 ; $k <= $maxmenu ; $k++)
		{
			$menu_id=$_POST['menu_'.$k];
			$access_point=$_POST['access_point_'.$k];
			if(isset($access_point))
			{
								
					if($menu->check_menu($menu_id ,$semat , $center))
					{
						$sql_update="
						UPDATE `p_person_da` 
						SET `type` = '".$access_point."'
						WHERE  `semat` = '".$semat."' AND `menu` = '".$menu_id."' AND `center` = '".$center."'";
						mysql_query($sql_update);
					}
					else
					{
						$sql_insert="
						INSERT INTO `p_person_da` 
							(`id` , `semat` , `menu` ,`center`, `type`)
						VALUES 
							( NULL , '".$semat."', '".$menu_id."', '".$center."', '".$access_point."');";
							
						mysql_query($sql_insert);
					}
			}
		}
		if($_POST[update]=='yes')
			$menu->reset_menu($semat,$center);
	}
?>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="title">تعریف سطوح دسترسی پیش فرض</td>
  </tr>
  <tr>
    <td>
    
    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="table_defin">
      <form method="post" action="" name="personal_list"><tr><td width="14%">انتخاب سمت:</td>
        <td width="86%">
        
		<select name="semar_per" onChange="getsupport('semat');">
        <option value="none"> انتخاب</option>
		<?php
	$sql_semat="SELECT `id` , `name` FROM `p_person_semat`";
	$res_semat=mysql_query($sql_semat);
	while($row=mysql_fetch_array($res_semat))
	{
		$id_sem=$row[id];
		$name_sem=$row[name];
		if(($_SESSION[PREFIXOFSESS.'semar_per_acc']) == $id_sem)
		print '<option value="'.$id_sem.'" selected="selected">'.$name_sem.'</option>'.chr(10);
		else
		print '<option value="'.$id_sem.'">'.$name_sem.'</option>'.chr(10);
	}
	?>
    </select><input type="hidden" name="operation" /> </td>
        
      </tr>
      <tr>
      	<td>مراکز:</td>
        <td>
        <select name="center" onChange="getsupport('center');">
        <option value="none"> انتخاب</option>
        <?php
		 $sql_semat="SELECT * FROM  `p_center`   ORDER BY  `p_center`.`name` ASC";
		$res_semat=mysql_query($sql_semat);
		while($row=mysql_fetch_array($res_semat))
		{
			$id_b_center=$row[id];
			$name_b_center=$row[name];
			if(($_SESSION[PREFIXOFSESS.'center']) == $id_b_center)
			print '<option value="'.$id_b_center.'" selected="selected">'.$name_b_center.'</option>'.chr(10);
			else
			print '<option value="'.$id_b_center.'">'.$name_b_center.'</option>'.chr(10);
		}
		?>
        </select>
        
        </td>
      </tr></form>
      <tr>
        <td colspan="2"  style="border:none">
        <form action="" method="post">
      <p> <input type="checkbox" value="yes" checked name="update"> تنظیمات بر روی پرسنلی که این نقش را دارند اعمال شود.
      </p>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="t1">
          <tr>
            <th width="15">#</th>
            <th>گروه</th>
            <th>عنوان منو</th>
            <th>لینک</th>
            <th width="25">مخفی</th>
            <th width="25">نمایش</th>
            <th width="25">تغییر</th>
          </tr>
          <?php
		  $sql_list_menu="
    SELECT
	`p_menu_option`.`id`,`p_menu_option`.`name`,`p_menu_option`.`order`,`p_menu_option`.`url`,`p_menu_group`.`name` AS `nameg`
	FROM `p_menu_option`, `p_menu_group`
	WHERE `group`=`p_menu_group`.`id` ORDER BY `p_menu_group`.`name` ASC";
		  $res_list_menu=mysql_query($sql_list_menu);
		  while($row_menu=mysql_fetch_array( $res_list_menu))
		  {
			  $j++;
			  $id_menu=$row_menu[id];
			  $title_menu=$row_menu[name];
			  $link_menu=$row_menu[url];
			  $group_menu=$row_menu[nameg];
			 
			 print '<tr>
            <th>'.$j.'</th>
            <td>'.$group_menu.'</td>
            <td><input name="menu_'.$j.'" type="hidden" value="'.$id_menu.'" />'.$title_menu.'</td>
            <td dir="ltr" align="left"><span class="gray">'.$link_menu.'</span></td>';
			
			$menu->print_radio($j , $id_menu ,$_SESSION[PREFIXOFSESS.'semar_per_acc'],$_SESSION[PREFIXOFSESS.'center']);
            
			print '</tr>';
		  }
		  print '<input name="maxmenu" type="hidden" value="'.$j.'" />';
		  ?>
          <tr>
          	<td colspan="7" align="center">
            <input name="apply" type="submit" class="buttom_apply" value="اعمال" /></td>
          </tr>
        </table>
        </form>
        </td>
        </tr>
    </table></td>
  </tr>
</table>