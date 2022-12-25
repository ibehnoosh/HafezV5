// JavaScript Document
$(document).ready(function(){
	$('#center').change(function(){
		show_master();
		show_term_1();
		});
	$('#season').change(function(){
		show_term_1();
		});
	
});
function show_master()
{
	$.ajax({
			type:"POST",
			url:"report/ajax_master_term.php",  
			data:({type:'master',center:$('#center').val()}),
			success:function(data){
				if((data.result)=='true')
				$('#master_list').html(data.output);
				}, 
			dataType:"json"});
	
	return false;
	
}
function show_term_1()
{
	$.ajax({
			type:"POST",
			url:"report/ajax_master_term.php",  
			data:({type:'season',center:$('#center').val(),year:$('#year').val(),season:$('#season').val()}),
			success:function(data){
				if((data.result)=='true')
				$('#term_1').html(data.output);
				show_term_compare();
				}, 
			dataType:"json"});
	return false;
	
}
function show_term_compare()
{
	
	var term=$("#list_active_term").val();
	if(term>0)
	{
	$.ajax({
			type:"POST",
			url:"report/ajax_master_term.php",  
			data:({type:'compare_with',center:$('#center').val(),start:$('#start_'+term).val()}),
			success:function(data){
				if((data.result)=='true')
				$('#term_2').html(data.output);
				}, 
			dataType:"json"});
	return false;
	}
	else
	{
		$('#term_2').html("");
		return false;
	}
	
}
function show_result()
{
	$.ajax({
			type:"POST",
			url:"report/ajax_master_term.php",  
			data:($('#report_form').serialize()),
			success:function(data){
				if((data.result)=='true')
				$('#result_show').html(data.output);
				}, 
			dataType:"json"});
	
	return false;	
}