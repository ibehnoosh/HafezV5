<?php
class login_mas
{
	var $pepper="65MEf61MZ7Trb889dX50sH";
	
	function isLoggedInStudent()
	{
		if($_SESSION[PREFIXOFSESS.'idm'])
		{
			return true;
		}
		else return false;
	}
	function logout()
	{
		mysql_query("UPDATE `site_master_info` SET `last_login` =NOW() WHERE `id_mas`=".$_SESSION[PREFIXOFSESS.'idm']);
		unset($_SESSION[PREFIXOFSESS.'idm']);
		unset($_SESSION[PREFIXOFSESS.'userNameMaster']);
		session_destroy();
	}
	function count_login($user)
	{
		
	}
	function dologin($user,$password_per)
	{
		
		$sql_site=mysql_query("SELECT * FROM `site_master_info` WHERE `username_mas`='".$user."'");
		if(mysql_num_rows($sql_site)>0)
		{
			$login_mm=true;
		}
		else
		{
			$sql_main=mysql_query("SELECT * FROM `master_info` WHERE `username_mas`='".$user."'");
			$row_main=mysql_fetch_object($sql_main);
			$sql_insert="
			INSERT INTO `site_master_info`(
			`id_mas`, `name_mas`, `family_mas`, `meli_mas`, `birth_mas`, `city_mas`, 
			`gender_mas`, `mobile_mas`, `hometel_mas`, `nesstel_mas`, `homeadd_mas`, 
			`email_mas`, `center_mas`, `degree_mas`, `major_mas`, `pic_mas`, `password_mas`, `active_mas` , `username_mas`)   
			VALUES 
			(".$row_main->id_mas.", '".$row_main->name_mas."', '".$row_main->family_mas."', '".$row_main->meli_mas."', 
			'".$row_main->birth_mas."', '".$row_main->city_mas."', '".$row_main->gender_mas."', '".$row_main->mobile_mas."', '".$row_main->hometel_mas."', 
			'".$row_main->nesstel_mas."', '".$row_main->homeadd_mas."','".$row_main->email_mas."', '".$row_main->center_mas."', 
			'".$row_main->degree_mas."','". $row_main->major_mas."', '".$row_main->pic_mas."', 
			'".$row_main->password_mas."', '".$row_main->active_mas."' , '".$row_main->username_mas."');
			";
			if(mysql_query($sql_insert))
			{
				if($row_main->id_mas <> '')
				{
//------------------------------------------------------------------
//درج لاگ
//------------------------------------------------------------------


// $stringData =$sql_insert;
//------------------------------------------------------
				}
			}
		}
		

		$sql="SELECT `password_mas`,`hint`, `last_login` , HOUR(TIMEDIFF(NOW(), `last_unlogin`)) AS `hour`  FROM `site_master_info` WHERE `username_mas`='".$user."' AND `active_mas` LIKE 'yes'";
		$res=mysql_query($sql);
		
		$row=mysql_fetch_object($res);
		$_SESSION[PREFIXOFSESS.'hint']=$row->hint;
		$_SESSION[PREFIXOFSESS.'hour']=$row->hour;
		$new_pass=$row->password_mas;
		if(($_SESSION[PREFIXOFSESS.'hint']>5) && ($_SESSION[PREFIXOFSESS.'hour']<12))
		{
			mysql_query("INSERT INTO `site_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'".$_SERVER['REMOTE_ADDR']."' , 'no1');");
			return false;
		}
		else
		{
			$result=$this->check_secure_hash($row->password_mas,$password_per);
			
			if($result)
			{
				mysql_query("INSERT INTO `site_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
				(NULL , '$user' , NOW() , NOW() ,'".$_SERVER['REMOTE_ADDR']."' , 'yes')");
				mysql_query("UPDATE `site_master_info` SET `last_login` = NOW(),`last_unlogin`=NOW(), `hint`=0 WHERE `username_mas`='".$user."';");
				$_SESSION[PREFIXOFSESS.'idm'] = true;
				$_SESSION[PREFIXOFSESS.'userNameMaster'] =$user;
				$_SESSION[PREFIXOFSESS.'hint']=0;
				$_SESSION[PREFIXOFSESS.'hour']=0;
				return true;
			}
			else
			{
				if($_SESSION[PREFIXOFSESS.'hour'] < 6)
				{
					mysql_query("INSERT INTO `site_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'".$_SERVER['REMOTE_ADDR']."' , 'no2')");
					mysql_query("UPDATE `site_master_info` SET `last_unlogin` = NOW(),`hint`=`hint`+1 WHERE `username_mas`='".$user."'");
					return false;
				}
				else
				{
					mysql_query("INSERT INTO `site_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'".$_SERVER['REMOTE_ADDR']."' , 'no3')");
					mysql_query("UPDATE `site_master_info` SET `last_unlogin` = NOW() WHERE `username_mas`='".$user."'");
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
}

?>