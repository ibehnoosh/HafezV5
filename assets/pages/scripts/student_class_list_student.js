
var FormInputMask = function () {
    
    var handleInputMasks = function () {
        $(".nomarat").inputmask("mask", {
            "mask": "99.99",
			"autoUnmask" : false,
			"oncomplete": function(){  var index = $('.nomarat').index(this) + 1;
         									$('.nomarat').eq(index).focus();}
        }); 
		$("#code_class").inputmask({
            "mask": "9",
            "repeat": 4,
            "greedy": false
        });
    }
    return {
		    init: function () {
            handleInputMasks();}
    };}();
$(document).ready(function(e) {
    FormInputMask.init();
});
function search_pop()//----------------------------------ok
{
	$('.search').change(function(){
	var type=$(this).attr('id');
	var term=$(this).attr('term');
	var id=$(this).val();
	
			$.ajax({
			type:"POST",
			url:"ajax/search_code_result.php",  
			data:({type:type,t:term,id:id}),
			success:function(data){
				if((data.result)=='true')
					$('#search_result_by_'+type).html(data.output); 
				}, 
			dataType:"json"});
			return false;
	});
}
function fill(thisValue , ilevel)//----------------------ok
{
	$('#code_class').val(thisValue);
	$('#li').val(ilevel);
	$('#ajax-modal').modal('toggle'); 
}
function class_info(term)//------------------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'code_class',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function list_in_class(term)//---------------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	class_info(term);
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'list_in_class',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function student_delay(term)//---------------------------ok
{
	setTimeout(function() {$('#query_result_div').fadeOut('slow');}, 20000);
	var today=$('#date_persian').val();
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
		$('#search_result_div').html('');
	class_info(term);
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'delay',term:term,permision:$('#permision').val(), code:$('#code_class').val(),today:today}),
	success:function(data){
		if((data.result)=='true')
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function delete_delay(i,code)//--------------------------ok
{
	if(confirm("از حذف اطلاعات اطمینان دارید؟"))
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'delete_present',id:i,code:code}),
	success:function(data){
		if((data.result)=='true')
			$('#query_result_div').html(data.output);
			student_delay($('#term').val());
		}, 
	dataType:"json"});
	}
	return false;
}
function save_delay(term)//------------------------------ok
{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:($('#save_delay_form').serialize()),
	success:function(data){
		if((data.result)=='true')
			{
			$('#query_result_div').html(data.output);
			$('#search_result_div').html(data.output);
			student_delay(term);}
		}, 
	dataType:"json"});
	return false;
}
function edit_delay(term)//------------------------------ok
{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:($('#edit_delay_form').serialize()),
	success:function(data){
		if((data.result)=='true')
			{
			$('#query_result_div').html(data.output);
			$('#search_result_div').html(data.output);
			student_delay(term);}
		}, 
	dataType:"json"});
	return false;
}
function student_grade(term)//---------------------------ok
{
	var today=$('#date_persian').val();
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	class_info(term);
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'grade',term:term,permision:$('#permision').val(), code:$('#code_class').val(),today:today}),
	success:function(data){
		if((data.result)=='true')
			$('#search_result_div').html(data.output);
			hilight_table();
			$('#grade_list_table').enableCellNavigation();
		}, 
	dataType:"json"});
	}
	return false;
}
function hilight_table() //------------------------------ok
{	
	$("tr.row_values").click(function(){
		operatino(this)
	})
}
function operatino(element) //---------------------------ok
{
	
	$("#grade_list_table tbody tr").removeClass('success');
	$(element).addClass('success');
		
	var a=$(element).attr('id')+'b';
	var s=$(element).attr('id')+'s';
	var v=$(element).attr('id')+'v';
		
	var sum=0.0;
			
	$('input:text').each(function(){
		if($(this).attr('id').search(a) > -1)
		{
			sum+=parseFloat($(this).val());
		}
				
	});
	$('#'+s).html(sum);
}
function save_grad_form()//------------------------------ok
{	 
	
	$.ajax({
	type:"POST",
	url:"student/class/save_grade.php", 
	data:($(":input").serialize()),
	success:function(data){
		if((data.result)=='true')
			$('#query_result_div').html(data.output);
			student_grade($('#term').val());
		}, 
	dataType:"json"});
	return false;
}
function save_grad_form_one(id,a,b,id_buttom)//----------ok
{
	$(id_buttom).attr("disabled", true);	
	$("#loading").ajaxStart(function(){$(this).show();});
	$("#loading").ajaxStop(function(){$(this).hide();});  
	var formdata=$(":input").serialize();
	$.ajax({
	type:"POST",
	url:"student/class/save_grade.php", 
	data:(formdata+'&a_one='+a+'&b_one='+b+'&save_one=yes'),
	success:function(data){
		if((data.result)=='true')
			$(id_buttom).attr("disabled", false);	
		}, 
	dataType:"json"});
	return false;
	
}
function student_polling(term)//-------------------------ok
{
	var today=$('#date_persian').val();
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	class_info(term);
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'polling',term:term,permision:$('#permision').val(), code:$('#code_class').val(),today:today}),
	success:function(data){
		if((data.result)==='true')
		{
			$('#search_result_div').html(data.output);
			hilight_table_polling();
		}
		}, 
	dataType:"json"});
	}
	return false;
}
function hilight_table_polling() //----------------------ok
{
		 
		$('input:text').blur(function() {
		   if(parseInt($(this).val()) > 4) {
			   $(this).val('0');
		   }
		   if (this.value != this.value.replace(/[^0-9\.]/g, '')){
			    $(this).val('0');
			}
		 });
	
}

function save_polling()//--------------------------------ok
{	 
	var formdata=$(":input").serialize();
	$.ajax({
	type:"POST",
	url:"student/class/save_polling.php", 
	data:(formdata),
	success:function(data){
		if((data.result)=='true')
			$('#query_result_div').html(data.out);
		}, 
	dataType:"json"});
	return false;
	/**/
	//alert(i);
}
function sms_list(term,which) //-------------------------ok
{
	var today=$('#date_persian').val();
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	class_info(term);
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:which,term:term,permision:$('#permision').val(), code:$('#code_class').val(),today:today}),
	success:function(data){
		if((data.result)=='true')
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function sms_list_final()//------------------------------ok
{
	var formdata=$(":input").serialize();
	$.ajax({
	type:"POST",
	url:"student/class/send_sms_i.php", 
	data:(formdata),
	success:function(data){
		if((data.result)=='true')
			$('#query_result_div').html(data.output);
		}, 
	dataType:"json"});
	return false;	
}
function sms_list_karname(term,which) //-----------------ok
{
	var today=$('#date_persian').val();
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	class_info(term);
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:which,term:term,permision:$('#permision').val(), code:$('#code_class').val(),today:today}),
	success:function(data){
		if((data.result)=='true')
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function send_sms_karname() //---------------------------ok
{
	$('#send_sms_all').attr("disabled", true);	
	$.ajax({
	type:"POST",
	url:"student/class/send_sms_k.php", 
	data:($(":input").serialize()),
	success:function(data){
		if((data.result)=='true')
			$('#send_sms_all').attr("disabled", false);	
			alert('با موفقیت ارسال گردید');
		}, 
	dataType:"json"});
	return false;
}
function print_list_in_class(term)//---------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_list_in_class',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function print_karname(term) //--------------------------ok
{
	var today=$('#date_persian').val();
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	class_info(term);
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_karname',term:term, code:$('#code_class').val(),today:today}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function print_karname_final(id,code,level,term)//-------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_karname_final',term:term, code:code,level:level , id:id}),
	success:function(data){
		if((data.result)=='true')
			$('#div_karname').html(data.output);
			$('#class_info').addClass('hidden-print');
			$('#query_result_div').addClass('hidden-print');
			$('#search_result_div').addClass('hidden-print');
			window.print();
			$('#class_info').removeClass('hidden-print');
			$('#query_result_div').removeClass('hidden-print');
			$('#search_result_div').removeClass('hidden-print');
			$('#div_karname').html("");
		}, 
	dataType:"json"});
	}
	return false;
}
function print_list_student(term)//----------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_list_student',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function print_hozor(term)//---------------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_hozor',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function print_film(term)//---------------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_film',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function print_mark(term)//---------------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_mark',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function print_pic(term)//---------------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_pic',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function print_interview(term)//---------------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_interview',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}
function print_classactivity(term)//---------------------------ok
{
	if($('#code_class').val() == '')
	alert('لطفا کد کلاس را درج نمایید');
	else
	{
	$.ajax({
	type:"POST",
	url:"student/class/list_student_ajax.php", 
	data:({type:'print_classactivity',term:term, code:$('#code_class').val()}),
	success:function(data){
		if((data.result)=='true')
			$('#class_info').html('');
			$('#search_result_div').html(data.output);
		}, 
	dataType:"json"});
	}
	return false;
}