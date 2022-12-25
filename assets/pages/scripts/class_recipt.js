
function show_fishlist()
{
	var term=$("#list_active_term").val();
	var date_persian=$('#date_persian').val();
	var code_class=$('#code_class').val();
	var id_student=$('#id_student').val();
	var date_register=$('#date_register').val();
	$.ajax({
			type:"POST",
			url:"class/recipt/ajax_fish.php",  
			data:({type:'fish', t:term, c:code_class, s:id_student, rd:date_register}),
			success:function(data){
				if((data.result)=='true')
					$('#result_div').html(data.output);
				}, 
			dataType:"json"});
			return false;
}
function show_checklist()
{
	var term=$("#list_active_term").val();
	var date_persian=$('#date_persian').val();
	var code_class=$('#code_class').val();
	var id_student=$('#id_student').val();
	var date_register=$('#date_register').val();
	$.ajax({
			type:"POST",
			url:"class/recipt/ajax_check.php",  
			data:({type:'check', t:term, c:code_class, s:id_student, rd:date_register}),
			success:function(data){
				if((data.result)=='true')
					$('#result_div').html(data.output);
				}, 
			dataType:"json"});
			return false;
}