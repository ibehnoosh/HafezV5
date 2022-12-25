// JavaScript Document
$(document).ready(function(){
	$(".mobile_n").attr('checked',false);
$('#sende_sms_button').click(function(){
		 if($('#message').val()=='')
		 {
			 alert('متن پیام نمی تواند خالی باشد.');
			 $('#message').focus();
		 }
		 else
		 {
			$('#sende_sms_button').attr('disabled',true);
			$.ajax({
			type:"POST",
			url:"message/ajax_send_sms.php",  
			data:($(":input").serialize()),
			success:function(data){
				if((data.result)=='true')
					alert(data.output);
					$('#sende_sms_button').attr('disabled',false);
					$('#message').val('');
					$('#mobiles').val('');
				}, 
			dataType:"json"});
			return false;
		 }
	 });
});