jQuery(document).ready(function() {
  
	$('.portlet').hide();
	$('#tab_1').show();
});

function nextshow(whichc)
{
	$('.portlet').hide();
	$(whichc).show();
}

function save(t)//ok
{
	$.ajax({
	type:"POST",
	url:"exam/ajax.php",  
	data:({type:'save_t', fit:$(t).attr("name"), fiv:$(t).val(), checkk:$(t).is(":checked") }),
	success:function(data){
	}, 
	dataType:"json"});
	return false;
}
function over()
{
	alert('مهلت پاسخگویی به پایان رسیده است.');
	save_all();
	
	$.ajax({
	type:"POST",
	url:"exam/ajax.php",  
	data:({type:'over_t'}),
	success:function(data){
		
	}, 
	dataType:"json"});
	return false;
}

function deadlin(xx)
{
	alert('تا 3 دقیقه دیگر فرصت پاسخگویی به سوالات به پایان می رسد.');
}

function save2(t)//ok
{
	$.ajax({
	type:"POST",
	url:"exam/ajax.php",  
	data:({type:'update_t', fit:$(t).attr("name"), fiv:$(t).val(), checkk:$(t).is(":checked") }),
	success:function(data){
	}, 
	dataType:"json"});
	return false;
}

