<?php
if(!$access)
{
	print '<h1>No Access</h1>';
	print '<h1>Your IP Is: '.$_SERVER['REMOTE_ADDR'].'</h1>';
}
else
{
	$key_encrypte = "i10veY0u";
$cipher = new Crypt_Blowfish($key_encrypte);
$cipher_id_e_person = Edecrypt($cipher,$_REQUEST[id]);
$cipher_id_e_person_action=str_replace("+", "%2B", $_REQUEST[id]);
settype($cipher_id_e_person , 'integer');
if((is_numeric($cipher_id_e_person)) && ($cipher_id_e_person !== 0))
{	$pers=new person;
	if(isset($_POST[add_personal]))
	{
		$meli_per=$pur->purify($_POST[meli_per]);
		$name_per=$pur->purify($_POST[name_per]);
		$family_per=$pur->purify($_POST[family_per]);
		$birth_per=$pur->purify($_POST[birth_per]);
		$city_per=$pur->purify($_POST[city_per]);
		$gender_per=$pur->purify($_POST[gender_per]);
		$mobile_per=$pur->purify($_POST[mobile_per]);
		$hometel_per=$pur->purify($_POST[hometel_per]);
		$nesstel_per=$pur->purify($_POST[nesstel_per]);
		$homeadd_per=$pur->purify($_POST[homeadd_per]);
		$email_per=$pur->purify($_POST[email_per]);
		$degree_per=$_POST[degree_per];
		$major_per=$_POST[major_per];
		
		$sql_update="
UPDATE `person_info` SET`name_per` = '".$name_per."' ,`family_per` = '".$family_per."'  ,`meli_per` = '".$meli_per."'  ,`birth_per`  = '".$birth_per."' ,`city_per` = '".$city_per."'  ,`gender_per` = '".$gender_per."'  ,`mobile_per` = '".$mobile_per."'  ,`hometel_per` = '".$hometel_per."'  ,`nesstel_per` = '".$nesstel_per."'  ,`homeadd_per` = '".$homeadd_per."'  ,`email_per` = '".$email_per."'  ,`semat_per` = '".$semat."'  ,`work_per` = '".$work_per."'  ,`degree_per` = '".$degree_per."'  ,`major_per` = '".$major_per."' WHERE `id_per` = '".$cipher_id_e_person."';";
		if(mysql_query($sql_update))
		{
			//------------------------------------------------------------------
//درج لاگ
//------------------------------------------------------------------


// $stringData =$sql_update;


			//------------------------------------------------------	
			$logg->add($_SESSION[PREFIXOFSESS.'idp'] , 'ویرایش پرسنل' ,$cipher_id_e_person , $sql_update);
		//------------------------------------------------------
			$mess= '<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">پیام تایید</h3></div>
			<div class="panel-body"><h4>مشخصات پرسنل با موفقیت ذخیره گردید .</h4></div>
			</div></div>';
		}
		else
		{
			$mess=  '<div class="panel panel-danger">
		<div class="panel-heading">
		<h3 class="panel-title">خطا</h3></div>
		<div class="panel-body font-lg"><h4>ثبت با خطا مواجه بود لطفا مجددا تلاش نمایید .</h4></div>
		</div></div>';
		}
	}
?>
<script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery-validation/js/localization/messages_fa.js"></script>
<script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/personal_info_add.js"></script>
<div class="page-content">
	<div class="note note-info"><h4 class="block">ویرایش مشخصات پرسنل</h4></div>
<div class="tabbable-line">
<div class="pull-right"><button type="button" class="btn red-haze" onClick="window.open('index.php?screen=personal/info/list' ,'_self')">برگشت به صفحه قبل</button></div>
<?=$mess?>
<div class="form-body">
<?php
$pers->show_id($cipher_id_e_person);
?>
<form name="form_add_personal" id="form_add_personal" action="" method="post" enctype="multipart/form-data">
  
     
    <div class="form-group col-md-6"><label class="col-md-4 control-label">نام <span class="required">*</span></label>
	<div class="col-md-6"><input class="form-control" name="name_per" type="text" value="<?php print $pers->name_per ?>" required>
  </div></div>
  
    <div class="form-group col-md-6"><label class="col-md-4 control-label">نام خانوادگی<span class="required">*</span></label>
	<div class="col-md-6">
    <input class="form-control" name="family_per" type="text" value="<?php print $pers->family_per ?>" required>
  </div></div>
  <div class="form-group col-md-6"><label class="col-md-4 control-label">شماره ملی</label>
	<div class="col-md-6">
    <input class="form-control" name="meli_per" id="meli_per" type="text"  value="<?php print $pers->meli_per ?>" >
  </div></div>
  <div class="form-group col-md-6"><label class="col-md-4 control-label">موبایل <span class="required">*</span></label>
	<div class="col-md-6">
   <input class="form-control" name="mobile_per" type="text" id="mobile_per "  value="<?php print $pers->mobile_per ?>" /></div>
   </div>
   <div class="form-group col-md-6"><label class="col-md-4 control-label">  تلفن منزل</label>
	<div class="col-md-6">
    <input class="form-control" name="hometel_per" type="text" value="<?php print $pers->hometel_per ?>" />
  
    </div></div>
  <div class="form-group col-md-6"><label class="col-md-4 control-label">تلفن مواقع ضروری</label>
	<div class="col-md-6">
    <input class="form-control" name="nesstel_per" type="text" class="" value="<?php print $pers->nesstel_per ?>" />
    
    </div></div>
  <div class="form-group col-md-6"><label class="col-md-4 control-label">آدرس محل سكونت</label>
	<div class="col-md-6">
    <input class="form-control" name="homeadd_per" type="text" value="<?php print $pers->homeadd_per ?>" />
    
    </div></div>
    <div class="form-group col-md-6"><label class="col-md-4 control-label">سال تولد</label>
	<div class="col-md-6">
    <input class="form-control" name="birth_per" type="text"  value="<?php print $pers->birth_per ?>" >
    
  </div></div>
  <div class="form-group col-md-6"><label class="col-md-4 control-label"> پست الكترونیكی</label>
	<div class="col-md-6">
    <input class="form-control" name="email_per" type="text" class=" email" value="<?php print $pers->email_per ?>" />
   </div></div>
   <div class="form-group col-md-6"><label class="col-md-4 control-label"> محل تولد</label>
	<div class="col-md-6">
    <input class="form-control" name="city_per" type="text"  value="<?php print $pers->city_per ?>" >
    
  </div></div>
  <div class="form-group col-md-6"><label class="col-md-4 control-label"> مدرك تحصیلی</label>
	<div class="col-md-6">
    <select name="degree_per" class="form-control">
      <option value=""> انتخاب </option>
      <option value="1" <?php if($pers->degree_per== '1') 
		print 'selected="selected" '; ?>>دیپلم</option>
      <option value="2" <?php if($pers->degree_per== '2') 
		print 'selected="selected" '; ?>>فوق دیپلم</option>
      <option value="3" <?php if($pers->degree_per== '3') 
		print 'selected="selected" '; ?>>لیسانس</option>
      <option value="4" <?php if($pers->degree_per== '4') 
		print 'selected="selected" '; ?>>فوق لیسانس</option>
      <option value="5" <?php if($pers->degree_per== '5') 
		print 'selected="selected" '; ?>>دكترا</option>
    </select>
   
    </div></div>
    <div class="form-group col-md-6"><label class="col-md-4 control-label">جنسیت</label>
	<div class="col-md-6">
      <input class="form-control" name="gender_per" type="radio" value="1"  <?php if($pers->gender_per == '1') print 'checked="checked"'; ?>  />مرد
      &nbsp;&nbsp;&nbsp;
      <input class="form-control" name="gender_per" type="radio" value="2"  <?php if($pers->gender_per == '2') print 'checked="checked"'; ?> />زن 
    
  </div></div>
  <div class="form-group col-md-6"><label class="col-md-4 control-label"> رشته تحصیلی</label>
	<div class="col-md-6">
    <input class="form-control" name="major_per" type="text"  value="<?php print $pers->major_per?>" />
   
    </div></div>
    <div class="form-group col-md-6">
<button type="submit" class="btn green" name="add_personal" value="save">ذخیره</button>
  </div>
</form></div></div></div>
<?php
}
}
?>