$(document).ready(function() {
	
	$('.mt-element-ribbon').click(function(e) {
		
        var vall=$(this).find('input:hidden').val();
		$('.ribbon').removeClass('ribbon-color-warning');
		$('.ribbon').addClass('ribbon-color-success');
		$('#div_'+vall).removeClass('ribbon-color-success');
		$('#div_'+vall).addClass('ribbon-color-warning');
		$('#term_select').val(vall);
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
                    $('#rootwizard').find('.button-submit').show();
                } else {
                    $('#rootwizard').find('.button-next').show();
                    $('#rootwizard').find('.button-submit').hide();
                }
            }
		
		$('#rootwizard').bootstrapWizard({
			 onNext: function (tab, navigation, index) {
                    if (index == 1) {
                        if($('#term_select').val() == '') 
						{alert('ابتدا ترم مورد نظر خود را انتخاب نمایید.'); return false;}
						else
						class_list($('#term_select').val(),$('#level_select').val());
                    }
					if(index == 2)
					{
						if($('#class_select').val() == '') 
						{alert('ابتدا کلاس مورد نظر خود را انتخاب نمایید.'); return false;}
						else
						fee_list($('#term_select').val(),$('#level_select').val());
						
					}
					if(index==3)
					{
						fee_accounting();
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
function class_list(t,l)
{
	$.ajax({
	type:"POST",
	url:"edu/ajax_reg.php",  
	data:({type:'class_list', t:t,l:l}),
	success:function(data){
	if((data.result)==='true')
	{$("#class_list").html(data.output);}
	}, 
	dataType:"json"});
	return false;
}
function fee_list(t,l,m)
{
	$.ajax({
	type:"POST",
	url:"edu/ajax_reg.php",  
	data:({type:'fee_list', t:t,l:l,m:$('#mande_ghabli').val()}),
	success:function(data){
	if((data.result)==='true')
	{$("#fee_list").html(data.output); $('#ghabel_select').val($('#ghabel_pardakht').val());}
	}, 
	dataType:"json"});
	return false;
}
function class_info(c)
{
	$.ajax({
	type:"POST",
	url:"edu/ajax_reg.php",  
	data:({type:'class_info', c:c}),
	success:function(data){
	if((data.result)==='true')
	{$("#class_info_print").html(data.output);}
	}, 
	dataType:"json"});
	return false;
}
function select_row(tr,id)
{
	$('#table_list_class tr').removeClass('success');
	$('#class_select').val(id);
	$('#'+tr).addClass('success');
	class_info(id);
	fee_accounting();
}
//----------------------------------------------------------------------------ok
function fee_accounting()
{
	$('#book_finfee_span').html('');$('#cd_finfee_span').html('');
			var mande_ghabli=parseInt($('#mande_ghabli').val());
			var ghabel_pardakht=parseInt($('#ghabel_pardakht').val());
			var fee_finfee=parseInt($('#fee_finfee').val());
			var ghabel_select=parseInt($('#ghabel_select').val());
			var sum=fee_finfee+mande_ghabli-parseInt(fee_finfee*0.1);
				if($('#book_fee').is(':checked'))
				{
					sum=parseInt(sum)+parseInt($('#book_finfee').val());$('#book_finfee_span').html($('#book_finfee').val()+ 'ریال');
					
				}
				if($('#cd_fee').is(':checked'))
				{
					sum=parseInt(sum)+parseInt($('#cd_finfee').val());$('#cd_finfee_span').html($('#cd_finfee').val()+ 'ریال');
				}
			
			$('#ghabel_select').val(sum);
			$('#ghabel_pardakht_span').html('مبلغ قابل پرداخت'+sum+' ريال');
			$('#sum_finfee_span').html(sum+ 'ریال');
			$('#sum_finfee_span2').html(sum+ 'ریال');
			$('#fee_finfee_span').html(fee_finfee+ 'ریال');
}