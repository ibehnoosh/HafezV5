<?php
$pers=new person;
//--------------------------------------------------------
$key_encrypte = "i10veY0u";
$cipher = new Crypt_Blowfish($key_encrypte);
$cipher_id_e_person = Edecrypt($cipher,$_REQUEST[id]);
$cipher_id_e_person_action=str_replace("+", "%2B", $_REQUEST[id]);
settype($cipher_id_e_person , 'integer');
if((is_numeric($cipher_id_e_person)) && ($cipher_id_e_person !== 0))
{
//-------------------------------------------------------- 
$upload_dir = "../pictures/person/";
$num_files = 1;
$size_bytes =512000;
$limitedext = array(".gif",".jpg",".jpeg",".png");
$id_per=$cipher_id_e_person;
//------------------------------------------
if(isset($_REQUEST['deletepic']))
{
	$filename = '../pictures/person/'.$_REQUEST['deletepic'];
	chmod($filename, 01777);
	unlink($filename);
	$sql_update="UPDATE `person_info` SET `pic_per`=''  WHERE `id_per` = '".$id_per."'";
	mysql_query($sql_update);
}
//------------------------------------------
if(isset($_POST['add_pic']))
{
	for ($i = 1; $i <= $num_files; $i++) 
	{
      //define variables to hold the values.
      $new_file = $_FILES['file'.$i];
      $file_name = $new_file['name'];
      //to remove spaces from file name we have to replace it with "_".
      $file_name = str_replace(' ', '_', $file_name);
      $file_tmp = $new_file['tmp_name'];
      $file_size = $new_file['size'];
			list ($namefile , $prefix) = split ('[.]' , $file_name);
			$new_pic_name=$id_per.'_pic.'.$prefix;
			$pic_stu=$new_pic_name;
		
           #-----------------------------------------------------------#
           # this code will check if the files was selected or not.    #
           #-----------------------------------------------------------#
           if (!is_uploaded_file($file_tmp)) 
		   {
			  $pic_stu='';
           }
		   else
		   {
                 #-----------------------------------------------------------#
                 # this code will check file extension                       #
                 #-----------------------------------------------------------#
                 $ext = strrchr($file_name,'.');
                 if (!in_array(strtolower($ext),$limitedext)) 
				 {
                    print '<div class="error">';
					print 'فرمت فایل'.'<b>';
					print "($file_name)</b>";
					print 'مجاز نمی باشد';
					print '</div>';
					$pic_stu='';
                 }
				 else
				 {
                  #-----------------------------------------------------------#
                  # this code will check file size is correct                 #
                  #-----------------------------------------------------------#
                   if ($file_size > $size_bytes)
				   {
                    print '<div class="error">';
					print 'حجم فایل'.'<b>';
					print "($file_name)</b>";
					print 'بیشتر از <b>'. $size_bytes / 1024 ."</b> KB است";
					print '</div>';
					
						  $pic_stu='';
					
                   }
					else
				 	{
                     	if (move_uploaded_file($file_tmp,$upload_dir.$new_pic_name)) 
					 		{
                     			echo "";
                      		}
					  	else
					  		{
                     			echo "آپلود فایل ($file_name) خطا داشت<br>";
                      		}#end of (move_uploaded_file).
                    }#end of (file_size).
                 }#end of (limitedext).
           }#end of (!is_uploaded_file).
       }#end of (for loop).
$sql_update="UPDATE `person_info` SET `pic_per`='".$pic_stu."'  WHERE `id_per` = '".$id_per."'";
mysql_query($sql_update);
}
//------------------------------------------
$pers->show_id($id_per);
?>
<form method="post" action="" enctype="multipart/form-data" name="add_stu_form" id="add_stu_form">
<div class="page-content">
	<div class="note note-info"><strong>تصویر پرسنل</strong></div>
<div class="tabbable-line">
<div class="pull-right"><button type="button" class="btn red-haze" onClick="window.open('index.php?screen=personal/info/list' ,'_self')">برگشت به صفحه قبل</button></div>
 <?php 
	if($pers->pic_per == '')
	{
		?>
    <div class="form-group col-md-6">
        <label class="col-md-2 control-label">تصویر پرسنلی</label>
        <div class="col-md-6"><input name="file1" type="file" class="textfiles" tabindex="22"/>
            <button type="submit" class="btn green btn-lg" name="add_pic" value="save">ذخیره</button>
        <p class="help-block"> تصاویر باید با حجم كمتر از <strong>50</strong> كیلو بایت و با یكی از فرمت های <strong>jpeg</strong> ، <strong>jpg</strong> ، <strong>png</strong> ، <strong>gif</strong> باشد.</p>
        </div>
    
	</div> 
        <?php
	}
	else
	{
		?>
    <div class="form-group col-md-6">
	<label class="col-md-2 control-label">تصویر پرسنلی</label>
    <div class="col-md-6"><img src="../pictures/person/<?=$pers->pic_per;?>" width="200"/>
    <p class="help-block"><a href="<?=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&deletepic='.$per->pic_per ?>">
            حذف </a></p>
    </div>
    
	</div> 
        <?php
	}
	
	?>
</div>
</div>
</form>
<?php
}
?>
</body>
</html>