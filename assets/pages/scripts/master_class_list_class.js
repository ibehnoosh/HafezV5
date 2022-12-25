
function print_list(which,term,master)
{
	$.ajax({
	type:"POST",
	url:"master/class/ajax_list_class.php",  
	data:({type:which, term:term,master:master}),
	success:function(data){
	if((data.result)==='true')
	{$("#printarea").html(data.output);window.print();}
	}, 
	dataType:"json"});
	return false;
}
