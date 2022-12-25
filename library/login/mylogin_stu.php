<?php
class login_stu
{
	var $pepper="65MEf61MZ7Trb889dX50sH";
	
	function isLoggedInStudent()
	{
		if($_SESSION[PREFIXOFSESS.'ids'])
		{
			return true;
		}
		else return false;
	}
	function logout()
	{
		mysql_query("UPDATE `site_student_info` SET `last_login` =NOW() WHERE `id_stu`=".$_SESSION[PREFIXOFSESS.'ids']);
		unset($_SESSION[PREFIXOFSESS.'ids']);
		unset($_SESSION[PREFIXOFSESS.'userNameStudent']);
		session_destroy();
	}
	function count_login($user)
	{
		
	}
	function dologin($user,$password_per)
	{
		
		$sql_site=mysql_query("SELECT * FROM `site_student_info` WHERE `id`='".$user."'");
		if(mysql_num_rows($sql_site)>0)
		{
			$login_mm=true;
		}
		else
		{
			$sql_main=mysql_query("SELECT * FROM `student_info` WHERE `id_stu`='".$user."'");
			$row_main=mysql_fetch_object($sql_main);
			$sql_insert="
			INSERT INTO `site_student_info`
			(`id`, `name`, `family`, `meli`, `shenasnameh`, `father`, `mother`, 
			`birth`, `fmobile`, `mmobile`, `hometel`, `address`, `email`, `mobile`, 
			`PassW0rd`, `pic`, `melicard`, `name_en`, `family_en`, `passno`, `father_en`, `birth_en`, 
			`center`, `count_login`,`hint`,`passport`) 
			VALUES 
			('".$row_main->id_stu."','".$row_main->name_stu."','".$row_main->family_stu."','".$row_main->meli_stu."','".$row_main->shenasnameh_stu."',
			'".$row_main->father_stu."','".$row_main->mother_stu."','".$row_main->birth_stu."','".$row_main->fmobile_stu."','".$row_main->mmobile_stu."',
			'".$row_main->hometel_stu."','".$row_main->address_stu."','".$row_main->email_stu."','".$row_main->mobile_stu."','".$row_main->PassW0rd."',
			'','','','','','','','".$row_main->center_stu."','0','0','');
			";
			mysql_query($sql_insert);
		}
		

		$sql="SELECT `Passw0rd`,`hint`, `last_login` , HOUR(TIMEDIFF(NOW(), `last_unlogin`)) AS `hour`  FROM `site_student_info` WHERE `id`='".$user."'";
		$res=mysql_query($sql);
		
		$row=mysql_fetch_object($res);
		$_SESSION[PREFIXOFSESS.'hint']=$row->hint;
		$_SESSION[PREFIXOFSESS.'hour']=$row->hour;
		$new_pass=$row->Passw0rd;
		if(($_SESSION[PREFIXOFSESS.'hint']>5) && ($_SESSION[PREFIXOFSESS.'hour']<12))
		{
			mysql_query("INSERT INTO `site_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'".$_SERVER['REMOTE_ADDR']."' , 'no');");
			return false;
		}
		else
		{
			$result=$this->check_secure_hash($row->Passw0rd,$password_per);
			
			if($result)
			{
				mysql_query("INSERT INTO `site_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
				(NULL , '$user' , NOW() , NOW() ,'".$_SERVER['REMOTE_ADDR']."' , 'yes')");
				mysql_query("UPDATE `site_student_info` SET `last_login` = NOW(),`last_unlogin`=NOW(), `hint`=0 WHERE `id`='".$user."';");
				$_SESSION[PREFIXOFSESS.'ids'] = true;
				$_SESSION[PREFIXOFSESS.'userNameStudent'] =$user;
				$_SESSION[PREFIXOFSESS.'hint']=0;
				$_SESSION[PREFIXOFSESS.'hour']=0;
				return true;
			}
			else
			{
				if($_SESSION[PREFIXOFSESS.'hour'] < 6)
				{
					mysql_query("INSERT INTO `site_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'".$_SERVER['REMOTE_ADDR']."' , 'no')");
					mysql_query("UPDATE `site_student_info` SET `last_unlogin` = NOW(),`hint`=`hint`+1 WHERE `id`='".$user."'");
					return false;
				}
				else
				{
					mysql_query("INSERT INTO `site_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'".$_SERVER['REMOTE_ADDR']."' , 'no')");
					mysql_query("UPDATE `site_student_info` SET `last_unlogin` = NOW() WHERE `id`='".$user."'");
					return false;
	
				}
			}
		}		
	}	
	//==================================
	
	function random_bytes($length) 
	{
		$ranges = array('0-9', 'a-z', 'A-Z');
        foreach ($ranges as $r) 
		{
			$r = explode('-', $r);
			$s .= implode(range(array_shift($r), $r[1]));
		}
        while (strlen($s) < $length) $s .= $s;
        return substr(str_shuffle($s), 0, $length);
    }
	//==================================
	
	function create_secure_hash($password_per, $rounds=7000) 
	{
		$salt=$this->random_bytes(16);
		$hash=hash('sha256', $salt.$this->pepper.$password_per, true);
		$tmp=$rounds;
		do {
			$hash=hash('sha256', $hash.$password_per, true);
		} while(--$tmp);
		return base64_encode($rounds.'*'.$salt.$hash);
	}
	
	//==================================
	function check_secure_hash($hash, $password_per) {
		$hash=base64_decode($hash);
		$rounds=substr($hash, 0, strpos($hash, '*'));
		$salt=substr($hash, strpos($hash, '*')+1, strlen($hash)-strlen($rounds)-32-1);
		$hash=substr($hash, strlen($hash)-32);
		$tmp=$hash;
		$hash=hash('sha256', $salt.$this->pepper.$password_per, true);
		do {
			 $hash=hash('sha256', $hash.$password_per, true);
		} while(--$rounds);
		return $tmp===$hash;
	}	
	//==================================
	
	function chang_user_pass($id , $user , $pass )
	{
		 $password_per=$pass;
		 $username=$user;
		
		
		$check_usernaame="SELECT `id_stu` FROM `student_info` 
						  WHERE `id_stu` ='".$username."' AND `id_stu` <> ".$id;
		$res_check_usernaame=mysql_query($check_usernaame);
		if(mysql_num_rows($res_check_usernaame) == 0)
		{
			if($password_per == '')
			{
				$sql_pass="UPDATE `student_info` 
					   SET  `id_stu` ='".$username."'
					   WHERE `id_stu`=".$id;
				if(mysql_query($sql_pass))
				{
					return '<div class="ok" width="60%"> نام کاربری با موفقیت تغییر پیدا کرد.</div>';
				}
			}
			else
			{
				$new_pass=$this->create_secure_hash($password_per,7000);
				$sql_pass="UPDATE `student_info` 
					   SET `Passw0rd` = '".$new_pass."' , `id_stu` ='".$username."',`password_per`=''
					   WHERE `id_stu`=".$id;
				if(mysql_query($sql_pass))
				return '<div class="ok" width="60%"> نام کاربری و کلمه عبور با موفقیت تغییر پیدا کرد.</div>';
			}
			
		}
		else
		{
			return '<div class="error" width="60%">این نام کاربری قبلا مورد استفاده قرار گرفته است.</div>';
		}

	}
	
	function chang_pass($id , $password_per,$current_password_per)
	{
		$sql="SELECT `Passw0rd` , `id_stu` FROM `student_info` WHERE `id_stu`=".$id;
		$res=mysql_query($sql);
		$row=mysql_fetch_object($res);
		$current=$row->Passw0rd;
		$md5pass=$this->create_secure_hash($current_password_per,7000);
		$new_pass=$this->create_secure_hash($password_per,7000);
		$user=$row->User;
		if(($current == $md5pass) && ($password_per <> $user))
		{
			$sql_pass="UPDATE `student_info` 
						   SET `Passw0rd` = '".$new_pass."' ,`password_per`=''
						   WHERE `id_stu`=".$id;
			if(mysql_query($sql_pass))
			return true;
			else
			return false;
		}
		else
		{
			return false;
		}

	}
}

?>