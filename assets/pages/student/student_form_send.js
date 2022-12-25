$(document).ready(function() {
	
	$('.mt-element-ribbon').click(function(e) {
		
        var vall=$(this).find('input:hidden').val();
		alert(vall);
		$('.ribbon').removeClass('ribbon-color-warning');
		$('.ribbon').addClass('ribbon-color-success');
		$('#div_'+vall).removeClass('ribbon-color-success');
		$('#div_'+vall).addClass('ribbon-color-warning');
		$('#lang_select').val(vall);
		//$('#rootwizard').bootstrapWizard('next');
		
    });
	
      	var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                jQuery('li', $('#rootwizard')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#rootwizard').find('.button-previous').hide();
                } else {
                    $('#rootwizard').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#rootwizard').find('.button-next').hide();
					 $('#rootwizard').find('.button-previous').hide();
                    $('#rootwizard').find('.button-submit').show();
                } else {
                    $('#rootwizard').find('.button-next').show();
                    $('#rootwizard').find('.button-submit').hide();
                }
            }

		
		$('#rootwizard').bootstrapWizard({
			 onNext: function (tab, navigation, index) {
                    if (index == 1) {
                        if($('#lang_select').val() == '') 
						{alert('ابتدا زبان مورد نظر خود را برای صدور گواهینامه انتخاب نمایید.'); return false;}
						else
						show_info($('#lang_select').val());
                    }
					if(index == 2)
					{
						if($('#info_com').val()=='no')
						{
							alert('لطفا اطلاعات پروفایل خود را تکمیل نمایید.');
							return false;
						}
						else
						{
							form_upload($('#lang_select').val());
						}
					}
					if(index==3)
					{
						if($('#document_com').val()=='no')
						{
							alert('لطفا مدارک خود را آپلود نماببد.'); 
							return false;
						}
						else
						{
							form_main($('#lang_select').val());
						}
						
					}
					if(index==4)
					{
						if($('#govahi').val()=='no')
						{
							alert('لطفا نوع گواهینامه خود را انتخاب نمایید.'); 
							return false;
						}
						else
						{
							var test=check_form($('#govahi').val());
							if (test == false) {
								return false;
							}
							 
						}
					}
					handleTitle(tab, navigation, index);
                },
			
			onTabClick:function(tab, navigation, index) {
				return false;
			},
			onTabShow: function(tab, navigation, index) {
    		var $total = navigation.find('li').length;
    		var $current = index+1;
    		var $percent = ($current/$total) * 100;
    		$('#rootwizard').find('.progress-bar').css({width:$percent+'%'});
			
				
    		}
			
			});
			$('#rootwizard').find('.button-previous').hide();
            $('#rootwizard .button-submit').click(function () {
               complete();
            }).hide();
});

function show_info(lang)
{
	$.ajax({
	type:"POST",
	url:"form/ajax_send.php",  
	data:({type:'show_info',l:lang}),
	success:function(data){
	if((data.result)==='true')
	{$("#show_info").html(data.output);
	 $('#info_com').val(data.info_com)}
	}, 
	dataType:"json"});
	return false;
}

function form_upload(lang)
{
	$.ajax({
	type:"POST",
	url:"form/ajax_send.php",  
	data:({type:'upload',l:lang}),
	success:function(data){
	if((data.result)==='true')
	{$("#div3").html(data.output);$('#document_com').val(data.document_com)}
	}, 
	dataType:"json"});
	return false;
}
function form_main(lang)
{
	$.ajax({
	type:"POST",
	url:"form/ajax_send.php",  
	data:({type:'main',l:lang}),
	success:function(data){
	if((data.result)==='true')
	{$("#div4").html(data.output);
		$('#setting_1').attr('disabled',true);
	$('#setting_2_1').attr('disabled',true);$('#setting_2_2').attr('disabled',true);$('#setting_2_3').attr('disabled',true);$('#setting_2_4').attr('disabled',true);
	$('#setting_3_1').attr('disabled',true);$('#setting_3_2').attr('disabled',true);$('#setting_3_3').attr('disabled',true);$('#setting_3_4').attr('disabled',true);
	
	}
	}, 
	dataType:"json"});
	return false;
}

function seelect(X)
{
	$('#setting_1').attr('disabled',true);
	$('#setting_2_1').attr('disabled',true);$('#setting_2_2').attr('disabled',true);$('#setting_2_3').attr('disabled',true);$('#setting_2_4').attr('disabled',true);
	$('#setting_3_1').attr('disabled',true);$('#setting_3_2').attr('disabled',true);$('#setting_3_3').attr('disabled',true);$('#setting_3_4').attr('disabled',true);
	$('#govahi').val(X);
	if(X==1)
	{
		$('#setting_1').attr('disabled',false);
	}
	else if(X==2)
	{
		$('#setting_2_1').attr('disabled',false);$('#setting_2_2').attr('disabled',false);
		$('#setting_2_3').attr('disabled',false);$('#setting_2_4').attr('disabled',false);
	}
	else if(X==3)
	{	
		$('#setting_3_1').attr('disabled',false);$('#setting_3_2').attr('disabled',false);
		$('#setting_3_3').attr('disabled',false);$('#setting_3_4').attr('disabled',false);
	}	
}

function check_form(X)
{
	if(X==1)
	{
		if($('#setting_1').val()=='')
		{
			alert('لطفا مشخص نمایید که برای چه دوره ای گواهینامه صادر گردد.');
			return false;
		}
		else
		{
			return null;
		}
	}
	else if(X==2)
	{
		if(($('#setting_2_1').val()=='')||($('#setting_2_2').val()=='')||($('#setting_2_3').val()=='')||($('#setting_2_4').val()==''))
		{
			alert('برای صدور گواهینامه لازم است کلیه اطلاعات وارد گردد.');
			return false;
		}
		else
		{
			return null;
		}
	}
	else if(X==3)
	{
		if(($('#setting_3_1').val()=='')||($('#setting_3_2').val()=='')||($('#setting_3_3').val()=='')||($('#setting_3_4').val()==''))
		{
			alert('برای صدور گواهینامه لازم است کلیه اطلاعات وارد گردد.');
			return false;
		}
		else
		{
			return null;
		}
	}
}

function complete()
{
	$.ajax({
	type:"POST",
	url:"form/ajax_send.php",  
	data:$('#request_form').serialize(),
	success:function(data){
	if((data.result)==='true')
	{$("#div5").html(data.output);}
	}, 
	dataType:"json"});
	return false;
}