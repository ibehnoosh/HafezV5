function show_group(category)
{
$.ajax({
	type:"POST",
	url:"class/defin/ajax_add_class.php",  
	data:({type:'group_list', category:category}),
	success:function(data){
	if((data.result)=='true')
	$("#group_list").html(data.output);
	}, 
	dataType:"json"});
	return false;
}
function show_level(group)
{
	$.ajax({
	type:"POST",
	url:"class/defin/ajax_add_class.php",
	data:({type:'level_list', group:group}),
	success:function(data){
	if((data.result)=='true')
	$("#level_list").html(data.output);
	}, 
	dataType:"json"});
	return false;
}