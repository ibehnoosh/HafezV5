function show_group(category)
{
	$.ajax({
	type:"POST",
	url:"defin/grade_ajax.php",  
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
	url:"defin/grade_ajax.php",  
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
	url:"defin/grade_ajax.php",  
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
	var n=$('#name_grad').val();
	var d=$('#default_value').val();
	$.ajax({
	type:"POST",
	url:"defin/grade_ajax.php",  
	data:({type:'save', level:level,n:n , d:d}),
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
	var level_mg_edit=$('#level_mg_edit').val();
	var title_mg_edit=$('#title_mg_edit').val();
	var default_value_edit=$('#default_value_edit').val();
	var id_edit=$('#id_edit').val();
	if(level_mg_edit === '')
	{
		alert('لطفا نام سطح مورد نظر خود را انتخاب نمایید');
	}
	else if(title_mg_edit === '')
	{
		alert('لطفا عنوان را وارد نمایید');
	}
	else
	{
	$.ajax({
	type:"POST",
	url:"defin/grade_ajax.php",  
	data:({type:'edit_mg', id:id_edit,level:level_mg_edit,title:title_mg_edit,def:default_value_edit}),
	success:function(data){
	if((data.result)==='true')
		{$("#saving_edit").html(data.output);}
	show_grade(level_mg_edit);
	}, 
	dataType:"json"});
	return false;
	}
	});
}