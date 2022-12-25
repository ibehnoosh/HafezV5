$(document).ready(function(e) {
    show_result();
});
function show_result()
{
	var selected = $('#list_active_term').find('option:selected');
    var centerID = selected.data('center');
	var term=$("#list_active_term").val();
	var date_persian=$('#date_persian').val();
	var code_class=$('#code_class_list').val();
	var id_student=$('#id_student').val();
	var date_register=$('#date_register').val();
	$.ajax({
			type:"POST",
			url:"class/register/ajax_register_list.php",  
			data:({type:'search',c:centerID, term:term, code_class:code_class, id_student:id_student, date_register:date_register,date_persian:date_persian}),
			success:function(data){
				if((data.result)=='true')
					$('#result_div').html(data.output);
				}, 
			dataType:"json"});
			return false;
}
function delete_student(s,t,ir,ic)
{
	if(confirm('آیا از حذف اطلاعات ثبت نام مطمئن هستید؟'))
	{
	$.ajax({
			type:"POST",
			url:"class/register/register_operation.php",  
			data:({type:'delete', s:s ,t:t,ir:ir,ic:ic}),
			success:function(data){
				if((data.result)=='true')
				alert('دانشجو با موفقیت حذف گردید');
				show_result();
				}, 
			dataType:"json"});
			return false;
	}
	
	else
	{
		return false;
	}
}
function edit_enseraf(s,t,ir,ic)
{
	if(confirm('بعد از تایید انصراف، مشخصات ثبت نام به حالت قطعی در می آید. آیا عملیات را تایید می نمایید؟'))
	{
	$.ajax({
			type:"POST",
			url:"class/register/register_operation.php",
			data:({type:'edit_enseraf', s:s ,t:t,ir:ir,ic:ic}),
			success:function(data){
				if((data.result)=='true')
				alert('اطلاعات دانشجو با موفقیت به وضعیت قطعی تبدیل گردید');
				show_result();
				}, 
			dataType:"json"});
			return false;
	}
	
	else
	{
		return false;
	}
}
function radios()
{
	if($('#opt1').is(':checked'))
	{
		$('#select_t').attr('disabled',false);
		$('#select_r').attr('disabled',true);
	}
	if($('#opt2').is(':checked'))
	{
		$('#select_t').attr('disabled',true);
		$('#select_r').attr('disabled',false);
	}
}