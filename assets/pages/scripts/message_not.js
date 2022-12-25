// JavaScript Document

function show_class()
{
	var term=$('#term').val();
		$.ajax({
			type:"POST",
			url:"message/ajax_noti.php",  
			data:({type:'class' , term:term}),
			success:function(data){
				if((data.result)=='true')
				$('#classes').html(data.output);
				}, 
			dataType:"json"});
	
	return false;
}

function show_result()
{
	if(($('#message').val()=='')||($('#year').val()=='')||($('#season').val()=='')||($('#type_term').val()=='')||($('#statuse').val()=='')||($('#center').val()==''))
		 {
			 alert('قبل از ارسال پیام باید تمام موارد به دقت انتخاب شود.');
		 }
		 else
		 {
	// alert($('#report_form').serialize());
	$.ajax({
			type:"POST",
			url:"message/ajax_noti.php",  
			data:($('#report_form').serialize()),
			success:function(data){
				if((data.result)=='true')
				alert(data.output);
				}, 
			dataType:"json"});
	
	return false;
	
		 }
}