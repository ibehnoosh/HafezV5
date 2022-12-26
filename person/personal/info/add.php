<?php
    $TITLE= require '../Lang/User.php';
    print (\View\Js\User::addInfo('scripts/personal_info_add.js'));
    print (\View\General\Title::show(['title' => $TITLE['addInfo'] , 'description'=> '']));
?>
<div class="tabbable-line">
    <div class="form-body">
        <form name="form_add_personal" id="form_add_personal" action="index.php?screen=personal/info/complete" method="post" enctype="multipart/form-data">

            <div class="form-group col-md-6"><label class="col-md-4 control-label">نام <span class="required">*</span></label>
                <div class="col-md-6"><input class="form-control" name="name_per" type="text" value="<?=$_SESSION[PREFIXOFSESS.'name_per'] ??= ''; ?>" required>
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label">نام خانوادگی<span class="required">*</span></label>
                <div class="col-md-6"><input class="form-control" name="family_per" type="text" value="<?=$_SESSION[PREFIXOFSESS.'family_per']??= ''; ?>" required>
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label">شماره ملی</label>
                <div class="col-md-6"><input class="form-control" name="meli_per" id="meli_per" type="text"  value="<?=$_SESSION[PREFIXOFSESS.'meli_per']??= ''; ?>" >
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label">موبایل <span class="required">*</span></label>
                <div class="col-md-6"><input class="form-control" name="mobile_per" type="text" id="mobile_per "  value="<?=$_SESSION[PREFIXOFSESS.'mobile_per']??= ''; ?>" />
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label">  تلفن منزل</label>
                <div class="col-md-6"><input class="form-control" name="hometel_per" type="text" value="<?=$_SESSION[PREFIXOFSESS.'hometel_per']??= ''; ?>" />
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label">تلفن مواقع ضروری</label>
                <div class="col-md-6"><input class="form-control" name="nesstel_per" type="text" class="" value="<?=$_SESSION[PREFIXOFSESS.'nesstel_per']??= ''; ?>" />
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label">آدرس محل سكونت</label>
                <div class="col-md-6"><input class="form-control" name="homeadd_per" type="text" value="<?=$_SESSION[PREFIXOFSESS.'homeadd_per']??= ''; ?>" />
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label">سال تولد</label>
                <div class="col-md-6"><input class="form-control" name="birth_per" type="text"  value="<?=$_SESSION[PREFIXOFSESS.'birth_per']??= ''; ?>" >
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label"> پست الكترونیكی</label>
                <div class="col-md-6"><input class="form-control" name="email_per" type="text" class=" email" value="<?=$_SESSION[PREFIXOFSESS.'email_per']??= ''; ?>" />
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label"> محل تولد</label>
                <div class="col-md-6"><input class="form-control" name="city_per" type="text"  value="<?=$_SESSION[PREFIXOFSESS.'city_per']??= ''; ?>" >
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label"> مدرك تحصیلی</label>
                <div class="col-md-6">
                    <select name="degree_per" class="form-control">
                      <option value=""> انتخاب </option>
                      <option value="1" <?php ($_SESSION[PREFIXOFSESS.'degree_per']== '1') ?? 'selected="selected" '; ?>>دیپلم</option>
                      <option value="2" <?php ($_SESSION[PREFIXOFSESS.'degree_per']== '2') ?? 'selected="selected" '; ?>>فوق دیپلم</option>
                      <option value="3" <?php ($_SESSION[PREFIXOFSESS.'degree_per']== '3') ?? 'selected="selected" '; ?>>لیسانس</option>
                      <option value="4" <?php ($_SESSION[PREFIXOFSESS.'degree_per']== '4') ?? 'selected="selected" '; ?>>فوق لیسانس</option>
                      <option value="5" <?php ($_SESSION[PREFIXOFSESS.'degree_per']== '5') ?? 'selected="selected" '; ?>>دكترا</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label">جنسیت</label>
                <div class="col-md-6">
                    <input class="form-control" name="gender_per" type="radio" value="1"  <?php if(isset($_SESSION[PREFIXOFSESS.'gender_per']) &&( $_SESSION[PREFIXOFSESS.'gender_per']= '1')) print 'checked="checked"'; ?>  />مرد
                    &nbsp;&nbsp;&nbsp;
                    <input class="form-control" name="gender_per" type="radio" value="2"  <?php if(isset($_SESSION[PREFIXOFSESS.'gender_per']) &&( $_SESSION[PREFIXOFSESS.'gender_per']= '2')) print 'checked="checked"'; ?> />زن
                </div>
            </div>
            <div class="form-group col-md-6"><label class="col-md-4 control-label"> رشته تحصیلی</label>
                <div class="col-md-6">
                    <input class="form-control" name="major_per" type="text"  value="<?=$_SESSION[PREFIXOFSESS.'major_per'] ??= '';?>" />
                </div>
            </div>
            <div class="form-group col-md-6">
                <button type="submit" class="btn green" name="add_personal" value="save">ذخیره</button>
            </div>
        </form>
    </div>
</div>
