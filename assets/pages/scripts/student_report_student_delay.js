function send_sms()
{	 if($('#message').val()=='')
		 {
			 alert('متن پیام نمی تواند خالی باشد.');
			 $('#message').focus();
		 }
		 else
		 {
			
			$.ajax({
			type:"POST",
			url:"student/report/send_sms.php",  
			data:($(":input").serialize()),
			success:function(data){
				if((data.result)=='true')
					alert(data.output);
					$('#message').val('');
				}, 
			dataType:"json"});
			return false;
			
			//alert($(":input").serialize());
		 }
}
function checkAll()
{
	if($('#checkall').is(':checked'))
	{
		$('.mobile_y').prop("checked", true);
		$('.mobile_y').parent('span').addClass('checked');
	}
	else
	{
		$('.mobile_y').prop("checked", false);
		$('.mobile_y').parent('span').removeClass('checked');
	}
}