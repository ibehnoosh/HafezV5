// JavaScript Document
$(document).ready(function(){
	show_category($('#center').val());
	show_group($('#categorys').val());
	$('#center').change(function(){show_category($('#center').val())});
	$('#categorys').change(function(){show_group($('#categorys').val())});
});
function func()
{
	$('#center').change(function(){show_category($('#center').val())});
	$('#categorys').click(function(){show_group($('#categorys').val())});
}
function show_category(center)
{
		$.ajax({
			type:"POST",
			url:"report/ajax_student.php",  
			data:({type:'cat' , center:center}),
			success:function(data){
				if((data.result)=='true')
				$('#category').html(data.output);
				show_group($('#categorys').val());
				func();
				}, 
			dataType:"json"});
	
	return false;
}
function show_group(category)
{
	if(category !=='all')
	{
		$.ajax({
			type:"POST",
			url:"report/ajax_student.php",  
			data:({type:'group' , category:category}),
			success:function(data){
				if((data.result)=='true')
				$('#group').html(data.output);
				func();
				}, 
			dataType:"json"});
	}
	else
	{
		$('#group').html('');
	}
	return false;
}
function levels(t)
{
	if($(t).is(':checked'))
	{
		$('.levels_f_'+($(t).val())).attr('checked',true);
		$('.levels_f_'+($(t).val())).attr('disabled',false);
	}
	else
	{
		$('.levels_f_'+($(t).val())).attr('checked',false);
		$('.levels_f_'+($(t).val())).attr('disabled',true);
	}
}
function show_result()
{
	//alert($('#report_form').serialize());
	$.ajax({
			type:"POST",
			url:"report/ajax_student.php",  
			data:($('#report_form').serialize()),
			success:function(data){
				if((data.result)=='true')
				$('#result_show').html(data.output);
				}, 
			dataType:"json"});
	
	return false;
	
}