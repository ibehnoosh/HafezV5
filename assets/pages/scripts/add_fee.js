function show_group(category,term,center)
{
	$.ajax({
	type:"POST",
	url:"class/fee/ajax_add_fee.php",  
	data:({type:'group_list', category:category,term:term , center:center}),
	success:function(data){
	if((data.result)=='true')
	$("#group_list").html(data.output);
	}, 
	dataType:"json"});
	return false;
}
function show_level(group,term,center)
{
	
	$.ajax({
	type:"POST",
	url:"class/fee/ajax_add_fee.php",  
	data:({type:'level_list', group:group,term:term , center:center}),
	success:function(data){
	if((data.result)=='true')
	$("#level_list").html(data.output);
	}, 
	dataType:"json"});
	return false;
}
function sort_table ( selectedtype )
{
  document.list_fee_form.selectithem.value = selectedtype ;
  document.list_fee_form.submit() ;
}
function getsupport ( selectedtype )
{
  document.class_list.operation.value = selectedtype ;
  document.class_list.submit() ;
}
function popitup(url , height1 , width1) {
	newwindow=window.open(url,'name','height='+height1+',width='+width1+',scrollbars=yes,');
	if (window.focus) {newwindow.focus()}
	return false;
}
function copy(id)
{
	var idpre;
	idpre=parseInt(id)-1;
	document.getElementById('fee_finfee'+id).value=document.getElementById('fee_finfee'+idpre).value;
	document.getElementById('book_finfee'+id).value=document.getElementById('book_finfee'+idpre).value;
	document.getElementById('cd_finfee'+id).value=document.getElementById('cd_finfee'+idpre).value;
}
function checkform()
{
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
