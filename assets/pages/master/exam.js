jQuery(document).ready(function() {
});

function save_grade(t)//ok
{
	$.ajax({
	type:"POST",
	url:"exam/ajax.php",  
	data:({type:'save', fit:$(t).attr("name"), fiv:$(t).val() }),
	success:function(data){
		
	//	alert(data.output);
	}, 
	dataType:"json"});
	return false;
}
