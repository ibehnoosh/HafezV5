<script language="JavaScript" type="text/javascript">
function subf()
{
  $( "#select_center" ).submit();
}
</script>
<div class="page-content">
	<div class="note note-info"><h4 class="block">سطوح دسترسی پرسنل</h4></div>
<?php
if(isset($_REQUEST['i']) && is_numeric($_REQUEST['i']))
{
	$id_person=$_REQUEST['i'];

$menu=new menu;
if(isset($_POST[operation]))
{	
	$center=$_POST[center];
	$_SESSION[PREFIXOFSESS.'center']=$center;
}
if(isset($_POST[apply]))
	{		
		$maxmenu=$_POST[maxmenu];
		$center=$_SESSION[PREFIXOFSESS.'center'];
		
		for($k=1 ; $k <= $maxmenu ; $k++)
		{
			$menu_id=$_POST['menu_'.$k];
			$access_point=$_POST['access_point_'.$k];
			if(isset($access_point))
			{
								
					if($menu->check_menu_person_center($menu_id ,$id_person,$_SESSION[PREFIXOFSESS.'center']))
					{
						$sql_update="
						UPDATE `p_person_access` 
						SET `permision` = '".$access_point."'
						WHERE  `person` = '".$id_person."' AND `menu` = '".$menu_id."' AND `center` = '".$center."'";
						mysql_query($sql_update);
					}
					else
					{
						$sql_insert="
						INSERT INTO `p_person_access` 
							(`id` , `person` , `menu` ,`center`, `permision`)
						VALUES 
							( NULL , '".$id_person."', '".$menu_id."', '".$center."', '".$access_point."');";
							
						mysql_query($sql_insert);
					}
			}
		}
		//------------------------------------------------------	
			//$logg->add($_SESSION[PREFIXOFSESS.'idp'] , 'تغییر سطح دسترسی' ,$id_person , 'منوها');
		//------------------------------------------------------
	}
?>
<form id="select_center" action="" method="post">
<input type="hidden" value="show" name="operation">
انتخاب مرکز: <select name="center" onChange="subf()" class="form-control input-lg">
			<?php $per->center_list($_SESSION[PREFIXOFSESS.'center']);?>
            </select>
</form>
<form action="" method="post">
<table class="table table-striped table-hover">
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
			
			$menu->print_radio_one($j,$id_menu ,$id_person,$_SESSION[PREFIXOFSESS.'center']);
            
			print '</tr>';
		  }
		  print '<input name="maxmenu" type="hidden" value="'.$j.'" />';
		  ?>
          <tr>
          	<td colspan="7" align="center">
            <button class="btn green" type="submit" name="apply">اعمال</button>
            <button class="btn default" type="button" onClick="window.open('index.php?screen=personal/setting/access/access' ,'_self')">برگشت</button>
            </td>
          </tr>
        </table>
        </form>
<?php
}
?>
</div>