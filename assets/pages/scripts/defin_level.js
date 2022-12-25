
function show_group(category)
{
	$.ajax({
	type:"POST",
	url:"defin/level_ajax.php",  
	data:({type:'group_list', category:category}),
	success:function(data){
		if((data.result)==='true')
		{$("#group_list").html(data.output);}
		}, 
		dataType:"json"});
	return false;
}
function save_level(group)
{
	var name_level=$('#name_e_level').val();
	if(group == '')
	{
		alert('لطفا نام دوره مورد نظر خود را انتخاب نمایید');
	}
	else if(name_level == '')
	{
		alert('لطفا نام سطح را وارد نمایید');
	}
	else
	{
	$.ajax({
	type:"POST",
	url:"defin/level_ajax.php",  
	data:({type:'save_level', group:group,name:name_level}),
	success:function(data){
	if((data.result)=='true')
	$("#saving").html(data.output);
	refresh_list(group);
	$('#name_e_level').val('');
	}, 
	dataType:"json"});
	return false;
		
	}
	
}
function edit_level()
{
	$("#save").on("click", function(e){
	var group=$('#group_e_name_edit').val();	
	var name_level=$('#name_e_level_edit').val();
	var id_level=$('#id_edit').val();
	var active=$('#active').val();
	var free=$('#free').val();
	var comment_level=$('#comment_level').val();
	if(group === '')
	{
		alert('لطفا نام دوره مورد نظر خود را انتخاب نمایید');
	}
	else if(name_level === '')
	{
		alert('لطفا نام سطح را وارد نمایید');
	}
	else
	{
	$.ajax({
	type:"POST",
	url:"defin/level_ajax.php",  
	data:({type:'edit_level', id:id_level,group:group,name:name_level,active:active,free:free,comment_level:comment_level}),
	success:function(data){
	if((data.result)==='true')
		{$("#saving_edit").html(data.output);}
	refresh_list(group);
	}, 
	dataType:"json"});
	return false;
	}
	});
}
function refresh_list(group)
{
	$.ajax({
	type:"POST",
	url:"defin/level_ajax.php",  
	data:({type:'refresh_list', group:group}),
	success:function(data){
	if((data.result)=='true')
	$("#refresh_list").html(data.output);
	}, 
	dataType:"json"});
	return false;
}
