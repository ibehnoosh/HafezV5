// JavaScript Document
$(document).ready(function(){
	$('#center').change(function(){
		show_master();
		});
});
function show_master()
{
	$.ajax({
			type:"POST",
			url:"report/ajax_master_season.php",  
			data:({type:'master',center:$('#center').val()}),
			success:function(data){
				if((data.result)=='true')
				$('#master_list').html(data.output);
				}, 
			dataType:"json"});
	
	return false;
	
}
function show_result()
{
	$.ajax({
			type:"POST",
			url:"report/ajax_master_season.php",  
			data:($('#report_form').serialize()),
			success:function(data){
				if((data.result)=='true')
				$('#result_show').html(data.output);
				}, 
			dataType:"json"});
	
	return false;	
}