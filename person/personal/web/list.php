<?php
if(!$access)
{
	print '<h1>No Access</h1>';
	print '<h1>Your IP Is: '.$_SERVER['REMOTE_ADDR'].'</h1>';
	exit();
}
?>
<div class="page-content">
	<div class="note note-info"><h4 class="block">لیست مطالب سیستم ثبت نام</h4></div>
<div class="tabbable-line">
<div class="form-body">
<table class="table table-hover">
      <tr>
        <th>شناسه</th> <th><a href="#">عنوان</a></th></tr>
      <?php
      $sql_2='SELECT * FROM `site_content` ORDER BY `site_content`.`title` ASC ';
	  $res_2=mysql_query($sql_2);
	  while($ro=mysql_fetch_object($res_2))
	  {
		  print '<tr ><td>'.$ro->id.'</td>
			<td><a href="index.php?screen=personal/web/edit&id='.$ro->id.'">'.$ro->title.'</a></td>
			</tr>';
	  }
	  ?>
  </table>
  </div>