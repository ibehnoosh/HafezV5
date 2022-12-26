<?php
session_start();
$pers=new person;
//--------------------------------------------------------
$key_encrypte = "i10veY0u";
$cipher = new Crypt_Blowfish($key_encrypte);
$cipher_id_e_person = Edecrypt($cipher,$_REQUEST[id]);
$cipher_id_e_person=str_replace("%2B", "+", $cipher_id_e_person);
settype($cipher_id_e_person , 'integer');
//include ("../library/login/mylogin.php");
$logini=new login;
if((is_numeric($cipher_id_e_person)) && ($cipher_id_e_person !== 0))
{
//--------------------------------------------------------
$id_person=$cipher_id_e_person;
if(isset($_POST[send]))
{
	$Password=$pur->purify($_POST[Password]);
	$username=$pur->purify($_POST[username]);
		
		
		$check_usernaame="SELECT `username_per` FROM `person_info` 
						  WHERE `username_per` ='".$username."' AND `id_per` <> ".$id_person;
		$res_check_usernaame=mysql_query($check_usernaame);
		if(mysql_num_rows($res_check_usernaame) == 0)
		{
			if($Password == '')
			{
				$sql_pass="UPDATE `person_info` 
					   SET  `username_per` ='".$username."'
					   WHERE `id_per`=".$id_person;
				if(mysql_query($sql_pass))
				{
					$mess= '<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">پیام تایید</h3></div>
			<div class="panel-body"><h4>نام کاربری با موفقیت تغییر پیدا کرد .</h4></div>
			</div></div>';
			  //------------------------------------------------------	
			$logg->add($_SESSION[PREFIXOFSESS.'idp'] , 'تغییر نام کاربری' ,$id_person , $sql_pass);
		//------------------------------------------------------
				}
			}
			else
			{
				$sql_pass="UPDATE `person_info` 
					   SET `passw0rd` = '".$logini->create_secure_hash($Password,7000)."' , `password_per`='',`username_per` ='".$username."'
					   WHERE `id_per`=".$id_person;
					   
					   //------------------------------------------------------	
			$logg->add($_SESSION[PREFIXOFSESS.'idp'] , 'تغییر نام کاربری و رمز عبور' ,$id_person , $sql_pass);
		//------------------------------------------------------
		
		
				if(mysql_query($sql_pass))
				$mess= '<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">پیام تایید</h3></div>
			<div class="panel-body"><h4>نام کاربری و کلمه عبور با موفقیت تغییر پیدا کرد .</h4></div>
			</div></div>';
				
			}
			
		}
		else
		{
			$mess=  '<div class="panel panel-danger">
		<div class="panel-heading">
		<h3 class="panel-title">خطا</h3></div>
		<div class="panel-body font-lg"><h4>این نام کاربری قبلا مورد استفاده قرار گرفته است .</h4></div>
		</div></div>';
		}
	
	
}
$pers->show_id($id_person);
?>
<div class="page-content">
	<div class="note note-info"><h4 class="block">تنظیمات ورود</h4></div>
<div class="tabbable-line">
<div class="form-body"><?=$mess?>
<div class="pull-right"><button type="button" class="btn red-haze" onClick="window.open('index.php?screen=personal/info/list' ,'_self')">برگشت به صفحه قبل</button></div>
<form action="" name="theForm" method="post">
<div class="form-group col-md-12"><label class="col-md-3 control-label">نام کاربری<span class="required">*</span></label>
	<div class="col-md-4"><input class="form-control" name="username" type="text" value="<?php print $pers->username_per ?>" required>
  </div></div>
  
  <div class="form-group col-md-12"><label class="col-md-3 control-label">کلمه عبور جدید </label>
	<div class="col-md-4"><input class="form-control" name="Password" type="text">
  </div></div>
  
  <div class="form-group col-md-12"><label class="col-md-3 control-label">تکرار کلمه عبور جدید </label>
	<div class="col-md-4"><input class="form-control" name="Password2" type="text" >
  </div></div>
  <div class="form-group col-md-12">
<button type="submit" class="btn green" name="send" value="save">ذخیره</button>
  </div>
  
</form>
</div></div></div>
<?php
}
?>
</body>
</html>