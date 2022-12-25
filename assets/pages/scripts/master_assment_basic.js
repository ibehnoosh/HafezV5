function show_group(category)
{
	$.ajax({
	type:"POST",
	url:"master/assessment/basic_ajax.php",  
	data:({type:'group_list', category:category}),
	success:function(data){
	if((data.result)=='true')
	$("#group_list").html(data.output);
	$("#refresh_list").html("");
	}, 
	dataType:"json"});
	return false;
	
}
function show_level(group)
{
	$.ajax({
	type:"POST",
	url:"master/assessment/basic_ajax.php",  
	data:({type:'level_list', group:group}),
	success:function(data){
	if((data.result)=='true')
	$("#level_list").html(data.output);
	$("#refresh_list").html("");
	}, 
	dataType:"json"});
	return false;
}
function show_grade(level)
{
	$.ajax({
	type:"POST",
	url:"master/assessment/basic_ajax.php",  
	data:({type:'grade_list', level:level}),
	success:function(data){
	if((data.result)=='true')
	$("#refresh_list").html(data.output);
	}, 
	dataType:"json"});
	return false;
}
function save_level(level)
{
	var t=$('#title').val();
	var v=$('#value').val();
	var o=$('#order').val();
	var td=$('#title_dis').val();
	
	$.ajax({
	type:"POST",
	url:"master/assessment/basic_ajax.php",  
	data:({type:'save',l:level,t:t,v:v , o:o , td:td}),
	success:function(data){
	if((data.result)=='true')
	$("#saving").html(data.output);
	show_grade(level);
	}, 
	dataType:"json"});
	return false;
	
}
function edit_grade()
{
	
	$("#save").on("click", function(e){
	var t=$('#title2').val();
	var v=$('#value2').val();
	var o=$('#order2').val();
	var a=$('#active2').val();
	var td=$('#title_dis2').val();
	var level=$('#level_mg_edit').val();
	var id_edit=$('#id_edit').val();
	
	if(level === '')
	{
		alert('لطفا نام سطح مورد نظر خود را انتخاب نمایید');
	}
	else if(t === '')
	{
		alert('لطفا عنوان را وارد نمایید');
	}
	else
	{
	$.ajax({
	type:"POST",
	url:"master/assessment/basic_ajax.php",  
	data:({type:'edit_mg', id:id_edit,l:level,t:t,v:v,o:o,td:td,a:a}),
	success:function(data){
	if((data.result)==='true')
		{$("#saving_edit").html(data.output);}
		show_grade(level);
	}, 
	dataType:"json"});
	return false;
	}
	});
}