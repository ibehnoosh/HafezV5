<?php
if(!$access)
{
	print '<h1>No Access</h1>';
	print '<h1>Your IP Is: '.$_SERVER['REMOTE_ADDR'].'</h1>';
	exit();
}
$id=$pur->purify($_REQUEST['id']);
if(isset($_POST[send]))
{
	$subject=$_POST[subject];
	$body=$_POST[body];
	mysql_query("UPDATE `site_content` SET `body`='".$body."' , `title`='".$subject."' WHERE `id`=".$id);
}
$sql=mysql_query("SELECT * FROM `site_content` WHERE `id` = ".$id);
$row=mysql_fetch_object($sql);
?>
<link href="../assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="../assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-summernote/lang/summernote-fa-IR.js"></script>
<script src="../assets/pages/scripts/editors.js"></script>
<div class="page-content">
	<div class="note note-info"><h4 class="block">لیست مطالب سیستم ثبت نام</h4></div>
<div class="tabbable-line">
<div class="form-body">
<form  id="send_message_form" method="post" name="send_message" action="">
<div class="row">
    <div class="form-group col-md-12"><input placeholder="موضوع" value="<?=$row->title?>" type="text" name="subject"  class="form-control" required id="subject"></div>
</div>
<div class="row">
 <textarea name="body" id="summernote_1"><?=$row->body?></textarea>
 </div>
 <div class="row">    
    <div class="form-group col-md-12"><button type="submit" class="btn green btn-lg" name="send" value="save">ذخیره</button></div>
</div>
</form>
  </div>