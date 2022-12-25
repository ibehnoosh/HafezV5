// JavaScript Document
$(document).ready(function(){
	$('#delete_this_mail').click(function(){
		
		if(confirm('آیا از حذف پیام اطمینان دارید؟'))
		{
			$('#operation').val('delete');
			$('#read_mail').submit();
		}
	});
	
	$('#reply_this_mail').click(function(){
			$('#operation').val('reply');
			$('#read_mail').submit();
		});
		
	$('#forward_this_mail').click(function(){
			$('#operation').val('forward');
			$('#read_mail').submit();
		});
		
	
});
function refresh_list()
{
	$.ajax({
	type:"POST",
	url:"message/ajax.php",  
	data:({type:'reciver_list', rol_select:$('#master_rols').val()}),
	success:function(data){
	if((data.result)=='true')
	$("#reciver_div").html(data.output);
		reciver_list_option();
		$('#reciver_type').change(function()
		{reciver_list_option();});
	}, 
	dataType:"json"});
	return false;
}
function reciver_list_option()
{	
	$.ajax({
	type:"POST",
	url:"message/ajax.php",  
	data:({type:'rlo', rec_opt:$('#reciver_type').val()}),
	success:function(data){
	if((data.result)=='true')
	$("#rol").html(data.output);
	$("#stu_info").html('');
	check_id_student();
	
	}, 
	dataType:"json"});
	return false;
}
