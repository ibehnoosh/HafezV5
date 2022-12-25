<?php
class message
{
	var $sender_type,
		$reciver_type,
		$subject_ml,
		$body_ml,
		$sender_ml,
		$resiver_ml,
		$senddate_ml,
		$readdate_ml,
		$file1_ml,
		$file2_ml,
		$file3_ml,
		$file1_name_ml,
		$file2_name_ml,
		$file3_name_ml,
		$operation_s,
		$operation_r,
		$lable_r ,
		$reply_ml,
		$forward_ml;
	
	function add_new_seeting($s,$r,$d)
	{
		if($d=='yes')
		{
			if($this->check($s,$r))
			{
				$sql="INSERT INTO `mail_setting` (`id_ms`, `sender_type`, `reciver_type`) 
					  VALUES (NULL, '$s', '$r');";
				mysql_query($sql);
			}
			if($this->check($r,$s))
			{
				$sql="INSERT INTO `mail_setting` (`id_ms`, `sender_type`, `reciver_type`) 
					  VALUES (NULL, '$r', '$s');";
				mysql_query($sql);
			}
			$message='<div class="ok">تنظیمات ثبت گردید.</div>';
		}
		else
		{
			if($this->check($s,$r))
			{
				$sql="INSERT INTO `mail_setting` (`id_ms`, `sender_type`, `reciver_type`) 
					  VALUES (NULL, '$s', '$r');";
				mysql_query($sql);
				$message='<div class="ok">تنظیمات ثبت گردید.</div>';
				
			}
			else
			{
				$message='<div class="error">تنظیمات این فرستنده و گیرنده قبلا ثبت شده است.</div>';
			}
		}
		return $message;
	}
	function check($s,$r)
	{
		$sql="SELECT * FROM `mail_setting` WHERE `sender_type`='$s' AND `reciver_type`='$r'";
		$res=mysql_query($sql);
		$count=mysql_num_rows($res);
		
		if($count == 0)
		return true;
		else
		return false;
	}
	function show_reciver($senderid,$sender_type)
	{
		$out='<select id="reciver_type" name="reciver_type">';
		switch($sender_type)
		{
			
			case 'person':
			$sql="SELECT * FROM `person_semat` ORDER BY `person_semat`.`name_per_sem` ASC";	
				$res=mysql_query($sql);
				while($row=mysql_fetch_array($res))
				{
					$reciver_type=$row['id_per_sem'];
					$name=$row['name_per_sem'];
					$out.='<option value="'.$reciver_type.'">'.$name.'</option>';
				}
			break;
			case 'support':
			break;
			case 'student':
			$sql="SELECT * FROM(SELECT `reciver_type`, CONCAT_WS(' ',`reciver_name`,`name_role`) AS `name` 
				FROM `mail_setting`
				LEFT JOIN `master_role` 
				ON `reciver_type`=`id_role`
				WHERE `sender_type` = 'student') AS `b` ORDER BY  `name` ASC";
			$res=mysql_query($sql);
				while($row=mysql_fetch_array($res))
				{
					$reciver_type=$row['reciver_type'];
					$name=$row['name'];
					$out.='<option value="'.$reciver_type.'">'.$name.'</option>';
				}
			break;
			case 'all_mas':
			break;
			case 'all_stu':
			break;
		}
		$out.='</select>';
		return $out;
	}
	function show_reciver_option($type)
	{
		if(is_numeric($type)) $option='master';
		else $option=$type;
		
		switch($option)
		{
			case 'master':
			
			$sql="  SELECT `id_per` AS `id`, CONCAT_WS(' ', `family_per`, `name_per`) AS `mas` FROM `person_info` WHERE `semat_per` LIKE '%-".$type."-%' AND `active_per`='yes' ORDER BY `person_info`.`family_per` ASC";
			
			$res=mysql_query($sql);
			$count=mysql_num_rows($res);
			if($count==0)
			{
				$out=
				'<span class="red">در حال حاضر شخصی با این نقش وجود ندارد و امکان ارسال پیام وجود ندارد</span>';
			}
			else
			{
				
				$out='<select name="reciver_selection">';
				while($row=mysql_fetch_array($res))
				{
					$id=$row['id'];
					$mas=$row['mas'];
					$out.='<option value="'.$id.'">'.$mas.'</option>';
				}
				$out.='</select>';
			}
			
			break;
			//---------------------------------------------------------------
			case 'support':
				$out='';
			break;
			case 'student':
				$out='<input type="text" maxlength="9" value="" name="reciver_selection" id="student_id_enter">';
			break;
			case 'all_stu':
				$out='';
			break;
		}
		
		return $out;
	}
	function upload()
	{
		$upload_dir = "../attach/";
		$num_files = 2;
		$size_bytes =10240000;
		$limitedext = array(".gif",".jpg",".jpeg",".png" , ".doc" , ".xls",".ppt" , ".docx" , ".xlsx",".pptx",".zip",".rar" , ".pdf");
	//****************************************************
	for ($i = 1; $i <= 3; $i++) 
	{
      //define variables to hold the values.
      $new_file = $_FILES['file'.$i];
      $file_name1 = $new_file['name'];
      //to remove spaces from file name we have to replace it with "_".
      $file_name = str_replace(' ', '_', $file_name1);
      $file_tmp = $new_file['tmp_name'];
      $file_size = $new_file['size'];
	 
		 $number=date("ymd").date("His");
		 $namefile= split ('[.]' , $file_name , -1);
		 $items = count($namefile);
		 $prefix=strtolower($namefile[$items-1]);
		 $new_pic_name=$number.'_'.$i.'.'.$prefix; 	  
		   #-----------------------------------------------------------#
           # this code will check if the files was selected or not.    #
           #-----------------------------------------------------------#

           if (!is_uploaded_file($file_tmp)) 
		   {
              if($i ==1 )
	 			{
					$new_pic_name='no';
				}
	 		 elseif($i ==2 )
	 			{
					$new_pic_name='no';
				}
			 elseif($i ==3 )
	 			{
					$new_pic_name='no';
				}
           }
		   else
		   {
                 #-----------------------------------------------------------#
                 # this code will check file extension                       #
                 #-----------------------------------------------------------#

                 $ext = strrchr($file_name,'.');
                 if (!in_array(strtolower($ext),$limitedext)) 
				 {

					$error_message= 'فرمت فایل'.'<b>';
					$error_message.= "($file_name)</b>";
					$error_message.= '.مجاز نمی باشد، لذا همراه پیام ارسال نمی گردد ';

			        if($i ==1 )
	 			{
					$new_pic_name='no';
				}
	 		 elseif($i ==2 )
	 			{
					$new_pic_name='no';
				}
			 elseif($i ==3 )
	 			{
					$new_pic_name='no';
				} 
                 }
				 else
				 {
                  #-----------------------------------------------------------#
                  # this code will check file size is correct                 #
                  #-----------------------------------------------------------#

                   if ($file_size > $size_bytes)
				   {

					$error_message= 'حجم فایل'.'<b>';
					$error_message.= "($file_name)</b>";
					$error_message.= 'بیشتر از <b>'. $size_bytes / 1024 ."</b> KB است، لذا همراه پیام ارسال نمی گردد";

					if($i ==1 )
	 			{
					$new_pic_name='no';
				}
	 		 elseif($i ==2 )
	 			{
					$new_pic_name='no';
				}
			 elseif($i ==3 )
	 			{
					$new_pic_name='no';
				}
					
                   }
					else
				 	{
                     	if (move_uploaded_file($file_tmp,$upload_dir.$prefix.'/'.$new_pic_name)) 
					 		{
                     			echo "";
                      		}
					  	else
					  		{
                     			$error_message= 'آپلود فایل ($file_name) خطا داشت';
								if($i ==1 )
	 			{
					$new_pic_name='no';
				}
	 		 elseif($i ==2 )
	 			{
					$new_pic_name='no';
				}
			 elseif($i ==3 )
	 			{
					$new_pic_name='no';
				}
                      		}#end of (move_uploaded_file).
                    }#end of (file_size).

                 }#end of (limitedext).

           }#end of (!is_uploaded_file).

     if($i ==1 )
	 	{
		$file1= $prefix.'/'.$new_pic_name;
		$state1=$new_pic_name;
		$file1_name=$file_name1;
		}
	 elseif($i ==2 )
	 	{
		$file2= $prefix.'/'.$new_pic_name;
		$state2=$new_pic_name;
		$file2_name=$file_name1;
		}
	 elseif($i ==3 )
	 	{
		$file3= $prefix.'/'.$new_pic_name;
		$state3=$new_pic_name;
		$file3_name=$file_name1;
		}
	   }#end of (for loop).


		return array ($file1 , $file1_name , $file2 ,$file2_name ,$file3 , $file3_name ,$state1 ,$state2 , $state3 ,$error_message) ;
	}
	function send($id_sender,$id_resiver,$subject,$body,$reply,$forward,$file1 , $file1_name , $file2 ,$file2_name ,$file3 , $file3_name)
	{
		
			if(trim($this->clean($subject))=='') $subject='بدون موضوع';
			$sql="INSERT INTO `mail` (`idml`, `subject_ml`, `body_ml`, `sendertype_ml`, `sender_ml`, 
			`resivertype_ml`, `resiver_ml`, `senddate_ml`, `readdate_ml`, 
			`file1_ml`, `file1_name_ml`, `file2_ml`, `file2_name_ml`, `file3_ml`, `file3_name_ml`, 
			`reply_ml`, `forward_ml`, `operation_s`, `operation_r`, `lable_r`) 
			VALUES (NULL, '".$subject."', '".$body."', '".$type_sender."', '".$id_sender."', 
			'".$type_reciver."', '".$id_resiver."', NOW(), '', 
			'".$file1."', '".$file1_name."', '".$file2."', '".$file2_name."', '".$file3."', '".$file3_name."', 
			'".$reply."', '".$forward."', 's', 's', '1');";
			if(mysql_query($sql))
				return true;
			else 
				return mysql_error();
	}
	function send_s($id_sender,$id_resiver,$subject,$body,$reply,$forward,$file1 , $file1_name , $file2 ,$file2_name ,$file3 , $file3_name)
	{
		
			if(trim($this->clean($subject))=='') $subject='بدون موضوع';
		$sql="INSERT INTO `site_mail` (`idml`, `subject_ml`, `body_ml`,  `sender_ml`, 
			 `resiver_ml`, `senddate_ml`, `readdate_ml`, 
			`file1_ml`, `file1_name_ml`, `file2_ml`, `file2_name_ml`, `file3_ml`, `file3_name_ml`, 
			`reply_ml`, `forward_ml`, `operation_s`, `operation_r`, `lable_r`) 
			VALUES (NULL, '".$subject."', '".$body."',  '".$id_sender."', 
			 '".$id_resiver."','".date("Y-m-d H:i:s")."', '', 
			'".$file1."', '".$file1_name."', '".$file2."', '".$file2_name."', '".$file3."', '".$file3_name."', 
			'".$reply."', '".$forward."', 's', 's', '1');";
			if(mysql_query($sql))
				{
					$id_message=mysql_insert_id();
					$sql_log="INSERT INTO `site_mail` (`idml`, `subject_ml`, `body_ml`,  `sender_ml`, 
			 `resiver_ml`, `senddate_ml`, `readdate_ml`, 
			`file1_ml`, `file1_name_ml`, `file2_ml`, `file2_name_ml`, `file3_ml`, `file3_name_ml`, 
			`reply_ml`, `forward_ml`, `operation_s`, `operation_r`, `lable_r`) 
			VALUES (".$id_message.", '".$subject."', '".$body."',  '".$id_sender."', 
			 '".$id_resiver."','".date("Y-m-d H:i:s")."', '', 
			'".$file1."', '".$file1_name."', '".$file2."', '".$file2_name."', '".$file3."', '".$file3_name."', 
			'".$reply."', '".$forward."', 's', 's', '1');";
//------------------------------------------------------------------
//درج لاگ
//------------------------------------------------------------------


// $stringData =$sql_log;
//------------------------------------------------------
					return true;
				}
			else 
				return mysql_error();
	}
	function clean($str)
	{
		if(get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}
		$str = mysql_real_escape_string($str);
		
		return $str;
	}
	function inbox_list($semat)
	{
		$i=0;
		$array_semat=explode("-",$semat);
		$count_semat=count($array_semat);
		$tedad=0;
		for($i;$i<=$count_semat;$i++)
		{
			if($array_semat[$i])
			{
				$tedad++;
				$semat_selection=$array_semat[$i];
			}
		}
		return array($tedad,$semat_selection);
	}
	function count_new_mail($id,$type)
	{
		$sql=mysql_query("SELECT *  FROM `mail` 
		WHERE `resivertype_ml` = '".$type."' AND `resiver_ml` = '".$id."'
		AND `readdate_ml`='0000-00-00 00:00:00' AND `operation_r`='s'");
		$count=mysql_num_rows($sql);
		
		return $count;
	}
	
	function count_send_mail($id,$type)
	{
		$sql=mysql_query("SELECT *  FROM `mail` 
		WHERE `sendertype_ml` = '".$type."' AND `sender_ml` = '".$id."' AND `operation_s`='s'");
		$count=mysql_num_rows($sql);
		
		return $count;
	}
	
	function count_all_mail($id,$type)
	{
		$sql=mysql_query("SELECT *  FROM `mail` 
		WHERE `resivertype_ml` = '".$type."' AND `resiver_ml` = '".$id."'
		AND `operation_r` = 's'");
		$count=mysql_num_rows($sql);
			
		return $count;
	}
	function show_rec_sen($id,$type)
	{
	
		switch($type)
		{
			case 'person':
				$sql="SELECT CONCAT_WS(' ',`family_per`,`name_per`) AS `name` FROM `person_info` WHERE `id_per` = ".$id;
				$res=mysql_query($sql);
				$row=mysql_fetch_object($res);
				$name=$row->name;
				$shenase='';
				
			break;
			
			
			case 'student':
				$sql="SELECT CONCAT_WS(' ',`family_stu`,`name_stu`) AS `name` FROM `student` 
				WHERE `id_stu` = ".$id;
				$res=mysql_query($sql);
				$row=mysql_fetch_object($res);
				$name=$row->name;
				$shenase=$id;
			break;
			
			case 'all_stu':
				$sql="SELECT CONCAT_WS(' ',`family_stu`,`name_stu`) AS `name` FROM `student` 
				WHERE `id_stu` = ".$id;
				$res=mysql_query($sql);
				$row=mysql_fetch_object($res);
				$name=$row->name;
				$shenase=$id;
			break;
			
			case 'support':
				$name='پشتبان فنی';
				$shenase='';
			break;
		}
		
		return array($name,$shenase);
	}
	function reply($id)
	{
		$sql=mysql_query("SELECT `idml` FROM `mail` WHERE `reply_ml` = '".$id."'");
		$count=mysql_num_rows($sql);
		
		return $count;
	}
	
	function show_mail($id)
	{
		$sql="SELECT *  FROM `mail` WHERE `idml` =".$id;
		$res=mysql_query($sql);
		while($row=mysql_fetch_array($res))
		{
			$this->subject_ml=$row[subject_ml];
			$this->body_ml=$row[body_ml];
			$this->sender_type=$row[sendertype_ml];
			$this->sender_ml=$row[sender_ml];
			$this->reciver_type=$row[resivertype_ml];
			$this->resiver_ml=$row[resiver_ml];
			$this->senddate_ml=$row[senddate_ml];
			$this->readdate_ml=$row[readdate_ml];
			$this->file1_ml=$row[file1_ml];
			$this->file2_ml=$row[file2_ml];
			$this->file3_ml=$row[file3_ml];
			$this->file1_name_ml=$row[file1_name_ml];
			$this->file2_name_ml=$row[file2_name_ml];
			$this->file3_name_ml=$row[file3_name_ml];
			$this->reply_ml=$row[reply_ml];
			$this->forward_ml=$row[forward_ml];
		}
	}
	
	function update_read_date($id)
	{
		$sql="UPDATE `mail` SET `readdate_ml` = NOW() WHERE `idml` = ".$id;
		mysql_query($sql);
	}
	

}