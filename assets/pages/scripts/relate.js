$(document).ready(function(e) {
	"use strict";
$('#id_student').blur(function(e) {
    $( "#family_stu" ).val("");
});
	
	 $( "#loading" ).hide();
	$( "#family_stu" ).autocomplete({
		source: "ajax/search_relate.php",
				minLength: 2,
				autoFocus:true,
				select: function(event, ui) {
					$('#id_student').val(ui.item.id);
					$('#family_stu').val(ui.item.abbrev);
					$('#center_stu').val(ui.item.cenn);
				}
	}); 
	  
});
$( document ).ajaxStart(function() { $( "#loading" ).show();});
function add2list()
{
	"use strict";
	var student=$('#id_student').val();
	var center=$('#center_stu').val();
	$.ajax({
	type:"POST",
	url:"student/relate/ajax_list.php",  
	data:({type:'search_id', id_stu:student, center_id:center}),
	success:function(data){
	if((data.result)=='true')
	var u=9;
			$("#add2list_div").append(data.output);clear();
	}, 
	dataType:"json"});
	return false;
}
function clear()
{
	"use strict";
	$('#id_student').val('');
	$('#center_stu').val('');
	$( "#family_stu" ).val("");
}
function delete_list(id)
{
	"use strict";
	$('#'+id).remove();
}
function savelist()
{
	"use strict";
	$.ajax({
	type:"POST",
	url:"student/relate/ajax_list.php",  
	data:$('#list2save').serialize(),
	success:function(data)
	{
		alert(data.result);$("#add2list_div").empty();/*
		if((data.result)==='true')
		{
			$("#add2list_div").empty();
			alert('عملیات با موفقیت انجام شد.');
		}
		else if((data.result)==='false')
		{alert('عملیات با خطا همراه بوده است.تعداد زبان آموزان باید بیشتر از 1 نفر باشد.');
		}
		*/
	}, 
	dataType:"json"});
	return false;
}