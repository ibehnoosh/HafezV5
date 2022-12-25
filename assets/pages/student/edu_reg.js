$(document).ready(function() {
	
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
                    $('#rootwizard').find('.button-submit').show();
                } else {
                    $('#rootwizard').find('.button-next').show();
                    $('#rootwizard').find('.button-submit').hide();
                }
            }

		
		$('#rootwizard').bootstrapWizard({
			 onNext: function (tab, navigation, index) {
                    if (index == 2) {
                        if($('#t').val() == '') 
						{alert('ابتدا ترم مورد نظر خود را انتخاب نمایید.'); return false;}
						else
						class_list($('#t').val(),$('#cat').val());
                    }
					if(index == 3)
					{
						if($('#c').val() == '') 
						{alert('ابتدا کلاس مورد نظر خود را انتخاب نمایید.'); return false;}
						else
						fee_list($('#t').val(),$('#l').val());
						
					}
					if(index==4)
					{
						class_info();
					}
					if(index==5)
					{
						class_info();
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
    	}});
});
function select_row(tr,id,l)
{
	$('#table_list_class tr').removeClass('success');
	$('#c').val(id);
	$('#l').val(l);
	$('#'+tr).addClass('success');
}
function select_cat(tr,id)
{
	$('#table_list_cat tr').removeClass('success');
	$('#cat').val(id);
	$('#'+tr).addClass('success');
}

function select_term(tr,id)
{
	$('#table_list_term tr').removeClass('success');
	$('#t').val(id);
	$('#'+tr).addClass('success');
}

function class_list(t,cat)
{
	$.ajax({
	type:"POST",
	url:"edu/ajax_reg.php",  
	data:({type:'class_list', t:t , cat:cat}),
	success:function(data){
	if((data.result)==='true')
	{$("#class_list").html(data.output);}
	}, 
	dataType:"json"});
	return false;
}

function fee_list(t,l)
{
	if($('#book_fee').is(':checked'))
	{ var b='yes';}
	if($('#cd_fee').is(':checked'))
	{ var c='yes';}
	$.ajax({
	type:"POST",
	url:"edu/ajax_reg.php",  
	data:({type:'fee_list', t:t,l:l,b:b,cd:c,m:$('#mg').val()}),
	success:function(data){
	if((data.result)==='true')
	{
		$("#fee_list").html(data.output);
	}
	}, 
	dataType:"json"});
	return false;
}

function class_info()
{
	if($('#book_fee').is(':checked'))
	{ var b='yes';}
	if($('#cd_fee').is(':checked'))
	{ var cd='yes';}
	$.ajax({
		
	type:"POST",
	url:"edu/ajax_reg.php",  
	data:({type:'class_info',c:$('#c').val(),b:b,cd:cd,l:$('#l').val(),t:$('#t').val(),mg:$('#mg').val()}),
	success:function(data){
	if((data.result)==='true')
	{$("#class_info_print").html(data.output);}
	}, 
	dataType:"json"});
	return false;
}



