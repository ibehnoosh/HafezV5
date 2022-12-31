<?php
    $TITLE= require '../Lang/User.php';
    print (\View\Js\User::addInfo('scripts/personal_info_add.js'));
    print (\View\General\Title::show(['title' => $TITLE['addInfo'] , 'description'=> '']));
    $basicInfo=new App\Basic\basicInfo();
    $basicView= new App\Basic\basicView();
?>
<div class="tabbable-line">
    <div class="form-body">
        <form name="form_add_personal" id="form_add_personal" action="index.php?screen=personal/info/complete" method="post" >
            <?php
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['name'],'name'=>'name_per','setting'=>'required' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'name_per'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['family'],'name'=>'family_per','setting'=>'required' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'family_per'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['meli'],'name'=>'meli_per','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'meli_per'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['mobile'],'name'=>'mobile_per','setting'=>'required' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'mobile_per'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['homeTell'],'name'=>'hometel_per','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'hometel_per'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['HomeAdd'],'name'=>'homeadd_per','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'homeadd_per'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['Birth'],'name'=>'birth_per','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'birth_per'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['email'],'name'=>'email','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'email'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['locateBirth'],'name'=>'city_per','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'city_per'] ??= '');
             print $basicView->selectOption($basicInfo->degree(),['temp'=> true, 'label'=> $TITLE['degree'],'name'=>'degree_per','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'degree_per'] ??= '');
             print $basicView->selectOption($basicInfo->gender(),['temp'=> true, 'label'=> $TITLE['gender'],'name'=>'gender_per','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'gender_per'] ??= '');
             print $basicView->inputText(['temp'=> true, 'label'=> $TITLE['major'],'name'=>'major_per','setting'=>'' , 'className'=> ''],$_SESSION[PREFIXOFSESS.'major_per'] ??= ''); ?>
            <div class="form-group col-md-6">
                <button type="submit" class="btn green" name="add_personal" value="save"><?=$HTML['save']?></button>
            </div>
        </form>
    </div>
</div>
