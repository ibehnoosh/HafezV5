function show_program()
{
	$.ajax({
	type:"POST",
	url:"private/ajax_request_program.php",  
	data:({type:'search_master', date2:$('#date2').val(),id_e_master:$('#id_e_master').val(),date:$('#date').val()}),
	success:function(data){
	if((data.result)=='true')
	$("#ajax_search_classs").html(data.output);
	}, 
	dataType:"json"});
	return false;
	
}