function show_group(category , term)
{
	$.ajax({
	type:"POST",
	url:"class/mark/ajax.php",  
	data:({type:'group_list', category:category,term:term}),
	success:function(data){
	if((data.result)=='true')
	$("#group_list").html(data.output);
	}, 
	dataType:"json"});
	return false;
}
function show_level(group ,term)
{
	$.ajax({
	type:"POST",
	url:"class/mark/ajax.php",
	data:({type:'level_list', group:group, term:term}),
	success:function(data){
	if((data.result)=='true')
	$("#level_list").html(data.output);
	$("#refresh_list").html("");
	}, 
	dataType:"json"});
	return false;
}
function show_grade(idlevel,term)
{
	$.ajax({
	type:"POST",
	url:"class/mark/ajax.php", 
	data:({type:'grade_list', level:idlevel, term:term}),
	success:function(data){
	if((data.result)=='true')
	$("#level").html(data.output);
	}, 
	dataType:"json"});
	return false;
}
function show_div(namediv)
{
	document.getElementById(namediv).style.display="block";
}
function reset_form(namediv)
{
	document.getElementById(namediv).style.display="none";
}
function sort_table ( selectedtype )
{
  document.table_details.selectithem.value = selectedtype ;
  document.table_details.submit() ;
}
function getsupport ( selectedtype )
{
  document.class_list.operation.value = selectedtype ;
  document.class_list.submit() ;
}