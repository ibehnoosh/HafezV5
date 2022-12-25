$(document).ready(function(){ 
	
	$("#start_e_class").mask("9999/99/99");
	$("#end_e_class").mask("9999/99/99");
	$("#first_film_class").mask("9999/99/99 99:99");
	$("#second_film_class").mask("9999/99/99 99:99");
	$("#mid_class").mask("9999/99/99");
	$("#final_class").mask("9999/99/99");
	$("#result_class").mask("9999/99/99 99:99");
	
	$('#form1').validate();
});
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
function show_div(namediv)
{
	document.getElementById(namediv).style.display="block";
}
function reset_form(namediv)
{
	document.getElementById(namediv).style.display="none";
}
function getsupport ( selectedtype )
{
  document.class_list.operation.value = selectedtype ;
  document.class_list.submit() ;
}
function sort_table ( selectedtype )
{
  document.class_list_details.selectithem.value = selectedtype ;
  document.class_list_details.submit() ;
}
function popitup_print(url , height1 , width1) {
	if(document.getElementById('id_cat_list').value == '')
	{
		alert('لطفا گروه تحصیلی مورد نظر را انتخاب نمائید');
		document.getElementById('id_cat_list').focus();
		return false;
	}
	else
	{
	newwindow=window.open(url,'name','height='+height1+',width='+width1+',scrollbars=yes, resizable=yes');
	if (window.focus) {newwindow.focus()}
	return false;
	}
}