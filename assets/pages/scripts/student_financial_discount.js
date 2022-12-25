// JavaScript Document
$(document).ready(function(){
	$('#id_e_master').attr("disabled" , true);
	$('#id_e_person').attr("disabled" , true);
	
	$('#who_m').click(function(){
		$('#id_e_master').attr("disabled" , false);
		$('#id_e_person').attr("disabled" , true);
		});
	$('#who_p').click(function(){
		$('#id_e_master').attr("disabled" , true);
		$('#id_e_person').attr("disabled" , false);
		});
		
	$('#center_list').change(function(){
		$.ajax({
		type:"POST",
		url:"student/financial/discount_ajax.php",  
		data:({type:'discount_list', center:$(this).val() , q:0}),
		success:function(data){
		if((data.result)=='true')
		$("#discount_list_div").html(data.output);
		}, 
		dataType:"json"});
		return false;	
	});
		
	if($('#center_list').val() !== '')
	{
		$.ajax({
		type:"POST",
		url:"student/financial/discount_ajax.php",  
		data:({type:'discount_list', center:$('#center_list').val(), q:$('#id_quata').val()}),
		success:function(data){
		if((data.result)=='true')
		$("#discount_list_div").html(data.output);
		}, 
		dataType:"json"});
		return false;	
	}
	
	
});