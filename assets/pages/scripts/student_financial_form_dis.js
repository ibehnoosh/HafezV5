// JavaScript Document
$(document).ready(function(){
	
	$('#list_active_term').change(function(){
		$.ajax({
		type:"POST",
		url:"student/financial/ajax_form_dis.php",  
		data:({type:'discount_list', term:$(this).val(),student:$('#id_student').val() , q:0}),
		success:function(data){
		if((data.result)=='true')
		$("#discount_list_div").html(data.output);
		}, 
		dataType:"json"});
		return false;	
	});
});