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
	data:({type:'save', fit:$(t).attr("name"), fiv:$(t).val(), checkk:$(t).is(":checked") }),
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
	data:({type:'over'}),
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
	data:({type:'update', fit:$(t).attr("name"), fiv:$(t).val(), checkk:$(t).is(":checked") }),
	success:function(data){
	}, 
	dataType:"json"});
	return false;
}

function save_all()
{
	/*
	$.ajax({
			type:"POST",
			url:"exam/ajaxi.php",  
			data:($('#exam_form_all').serialize()),
			
			success:function(data){
				if((data.result)=='true')
					{
						alert('اطلاعات آزمون با موفقیت ثبت گردید');
						window.open("index.php?screen=exam/start","_self");
					}
				else
					{
						alert('متاسفانه در ثبت اطلاعات آزمون شما مشکلی بوجود آمده است.');
					}
					
				}, 
			dataType:"json"});
	return false;
	*/
	alert('اطلاعات آزمون با موفقیت ثبت گردید');
	window.open("index.php?screen=exam/start","_self");
}
