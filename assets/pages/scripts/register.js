var FormValidation = function () {
	"use strict";
    var handleValidation2 = function() {
            var form2 = $('#register_student_form');
            form2.validate({
                errorElement: 'span',
                errorClass: 'help-inline help-inline-error', 
                focusInvalid: false, 
                ignore: "",
                rules: {
					ch1 :{required: true}
                },				
                highlight: function (element) { // hightlight error inputs
                   $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function (form) {
                    save_print(); 
                }
            });
    }
    return {
        init: function () {
            handleValidation2();
        }
    };
}();
var FormInputMask = function () {
    
    var handleInputMasks = function () {
        $("#student_stu_reg").inputmask("mask", {
            "mask": "99999999"
        }); 
		 $("#class_stu_reg").inputmask({
            "mask": "9",
            "repeat": 4,
            "greedy": false
        });
		$(".datedate").inputmask('shamsi', {
            autoUnmask: false,
			"placeholder": "----/--/--"
        });
		$(".moneymony").inputmask("decimal", {
    digits: 0,
    digitsOptional: false,
    autoGroup: true,
    groupSeparator: ",",
    groupSize: 3,
    allowPlus: false,
    allowMinus: false,
	autoUnmask: true
});
    }
    return {
		    init: function () {
            handleInputMasks();}
    };}();
$(document).ready(function(e) {
	"use strict";
	clear_form();
	FormInputMask.init();
	FormValidation.init();
	$('#student_stu_reg').blur(function(){
		check_student_register();
		 sanav();
		});	
	$("#class_stu_reg").blur(function(){code_class();});
	$(':checkbox').click(function(){fee_accounting();});
	$( "#name_stu_reg" ).autocomplete({
		source: "ajax/search_student.php",
				minLength: 2,
				autoFocus:true,
				select: function(event, ui) {
					$('#student_stu_reg').val(ui.item.id);
					check_student_register();
					sanav();
					$('#name_stu_reg').val(ui.item.abbrev);
					
				}
	}); 
	  
});
function which_dis()
{
			"use strict";
			var selected = $('#list_active_term').find('option:selected');
       		var centerID = selected.data('center');
			var id_student=$("#student_stu_reg").val();
			var id_class=$("#class_stu_reg").val();
			var term=$('#list_active_term').val();
		
			$.ajax({
			type:"POST",
			url:"class/register/info_ajax.php",  
			data:({type:'which_dis', s:id_student ,ce:centerID, c:id_class, t:term}),
			success:function(data){
				if((data.result)=='true')
					
						$('#id_finquo').val(data.dis_id);
						$('#dis_title').html(data.dis_title);
						$('#kasr_darsad').val(data.kasr_darsad);
						quota(); 					
						
				}, 
			dataType:"json"});
			return false;
}
function sanav()
{
	 var selected = $('#list_active_term').find('option:selected');
       var centerID = selected.data('center');
	$('#mal').attr("data-url" , "ajax/search_sanavat_fin.php?id="+$('#student_stu_reg').val()+"&c="+centerID);
	$('#tah').attr("data-url" , "ajax/search_sanavat_edu.php?id="+$('#student_stu_reg').val()+"&c="+centerID);
}
function clear_form()
{
	$('#search_class_a').attr("data-url" , "ajax/search_code.php?t="+$('#list_active_term').val());
	id_finquo_list();
		$('#class_stu_reg').val("");
		$('#classname_stu_reg').val("");
		$('#student_stu_reg').val("");
		$('#name_stu_reg').val("");
		$('#result_check_stu').html("");
		$('#result_check').html("");
		$('#result_check_class').html('');
		$('#check_code_for_student').html("");
		$('#fee_finfee').val(0);
		$('#tape_finfee').val(0);
		$('#book_finfee').val(0);
		$('#cd_finfee').val(0);
		$('#kasr_fee').val(0);
		$('#total_fee').val(0);
		$('#ch1').prop("checked", false);
		$('#ch2').prop("checked", false);
		$('#ch3').prop("checked", false);
		$('#ch4').prop("checked", false);
		$('#ch1').parent('span').removeClass('checked');
		$('#ch2').parent('span').removeClass('checked');
		$('#ch3').parent('span').removeClass('checked');
		$('#ch4').parent('span').removeClass('checked');
		$('#ch1').attr("disabled", true);
		$('#ch2').attr("disabled", true);
		$('#ch3').attr("disabled", true);
		$('#ch4').attr("disabled", true);
		$('#add_fish_info_0').html("");
		$('#add_check_info_0').html("");
		$('#quota_div').html("");
		sanav();
}
function lock_form()
{
		$('#search_class_a').attr("data-url" , "ajax/search_code.php?t="+$('#list_active_term').val());
		id_finquo_list();
		$('#class_stu_reg').val("");
		$('#classname_stu_reg').val("");
		$('#student_stu_reg').val("");
		$('#name_stu_reg').val("");
		$('#result_check').html("");
		$('#result_check_class').html('');
		$('#check_code_for_student').html("");
		$('#fee_finfee').val(0);
		$('#tape_finfee').val(0);
		$('#book_finfee').val(0);
		$('#cd_finfee').val(0);
		$('#kasr_fee').val(0);
		$('#total_fee').val(0);
		$('#ch1').prop("checked", false);
		$('#ch2').prop("checked", false);
		$('#ch3').prop("checked", false);
		$('#ch4').prop("checked", false);
		$('#ch1').parent('span').removeClass('checked');
		$('#ch2').parent('span').removeClass('checked');
		$('#ch3').parent('span').removeClass('checked');
		$('#ch4').parent('span').removeClass('checked');
		$('#ch1').attr("disabled", true);
		$('#ch2').attr("disabled", true);
		$('#ch3').attr("disabled", true);
		$('#ch4').attr("disabled", true);
		$('#add_fish_info_0').html("");
		$('#add_check_info_0').html("");
		$('#quota_div').html("");
}
function check_student_register()
{
			"use strict";
			var t_active=$("#list_active_term").val();
			var id_student=$("#student_stu_reg").val();
			
			$.ajax({
			type:"POST",
			url:"class/register/info_ajax.php",  
			data:({type:'check_student', s:id_student ,t:t_active}),
			success:function(data){
				if((data.result)=='true')
					
						$('#result_check_stu').html(data.message);
						$('#name_stu_reg').val(data.name_student); 
						$('#ready_student').val(data.ready_student);
						$('#baghimande_money').val(data.mandeh);
						ready_student(data.mandeh);					
				}, 
			dataType:"json"});
			return false;
}
function ready_student(data_mandeh)
{
	var ready=$('#ready_student').val();
	if(ready=='yes')
	{   
		transfer(data_mandeh);which_dis();
		$('#class_stu_reg').focus(); 
	}
	else
	{
		lock_form();
	}
}
function transfer(baghimande)
{
	"use strict";
		if(baghimande <0)
			{$('#baghimande').html('<span class="red">مبلغ <b>'+baghimande+'</b> ریال بستانکار</span>');}
		else if(baghimande > 0)
			{$('#baghimande').html('<span class="red">مبلغ <b>'+baghimande+'</b> ریال بدهکار</span>');}
		if(baghimande ===0)
			{$('#baghimande').html('');}
			
		$('#baghimande_money').val(baghimande);
		var total_fee=parseInt($('#total_fee').val());
		var baghimande_money=parseInt($('#baghimande_money').val());
		var ghabell=total_fee+baghimande_money;
		$('#ghabel_pardakht').html(parseInt(ghabell));
}
function search_pop()
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
function fill(thisValue , ilevel)
{
	$('#class_stu_reg').val(thisValue);
	$('#ajax-modal').modal('toggle'); 
	code_class();
}
function code_class()
{
			var t_active=$("#list_active_term").val();
			var id_class=$("#class_stu_reg").val();
			var id_student=$("#student_stu_reg").val();
			if(id_class > 0)
			{
			$.ajax({
			type:"POST",
			url:"class/register/info_ajax.php",  
			data:({type:'class', c:id_class ,t:t_active,s:id_student}),
			success:function(data){
				if((data.result)=='true')
				{
					$('#result_check_class').html(data.message);
					$('#classname_stu_reg').val(data.name_class); 
					$('#ready_class').val(data.ready_class);
					$('#check_code_for_student').html(data.check_code_for_student);
					$('#code_class').val(data.code_class);
					$('#fee_finfee').val(data.fee_finfee);
					$('#tape_finfee').val(data.tape_finfee);
					$('#book_finfee').val(data.book_finfee);
					$('#cd_finfee').val(data.cd_finfee);
					$('#ch1').attr("disabled", false);
					$('#ch2').attr("disabled", false);
					$('#ch3').attr("disabled", false);
					$('#ch4').attr("disabled", false);
				}
				else
				if((data.result)=='false')
				{
					$('#result_check_class').html(data.message);
					$('#classname_stu_reg').val("");
					$('#check_code_for_student').html("");
					$('#ready_class').val(data.ready_class); 
					$('#code_class').val(data.code_class);
					$('#fee_finfee').val(data.fee_finfee);
					$('#tape_finfee').val(data.tape_finfee);
					$('#book_finfee').val(data.book_finfee);
					$('#cd_finfee').val(data.cd_finfee);
					$('#ch1').attr("disabled", true);
					$('#ch2').attr("disabled", true);
					$('#ch3').attr("disabled", true);
					$('#ch4').attr("disabled", true);
				}
				}, 
			dataType:"json"});
			return false;
			}
}
function quota()
{
	var id_finquo=$("#id_finquo").val();
	$.ajax({
			type:"POST",
			url:"class/register/info_ajax.php", 
			data:({type:'quota', q:id_finquo}),
			success:function(data){
				if((data.result)=='true')
					$('#quota_div').html(data.output);
					$('#quotatype').val(data.quotatype);
					$('#kasr_darsad').val(data.kasr_darsad);
					fee_accounting();
				}, 
			dataType:"json"});
			return false;
}
function fee_accounting()
{
			var sum_fee=0,name_text,value_tex,kasr_fee=0;
			var kasr_darsad=$('#kasr_darsad').val();
			var shahriye_sabet=$('#fee_finfee').val();
			$(":checkbox").each(function() 
			{
				if($(this).is(':checked'))
				{
					 name_text=$(this).attr('vfee');
					 value_tex=parseInt($('#'+name_text).val());
					 sum_fee=sum_fee+value_tex;
				}
				else
				{
					 name_text=$(this).attr('vfee');
				}
			})
			if(kasr_darsad > 0)
			{
				kasr_fee=(kasr_darsad*shahriye_sabet)/100;
				sum_fee=sum_fee-kasr_fee;
			}
			
			var baghimande_money=parseInt($('#baghimande_money').val());
			var ghabell=parseInt(sum_fee)+baghimande_money;
			$('#ghabel_pardakht').html(ghabell);
			$('#total_fee').val(sum_fee);
			$('#kasr_fee').val(kasr_fee);
}
function id_finquo_list()
{
	   var selected = $('#list_active_term').find('option:selected');
       var centerID = selected.data('center');
	   $.ajax({
			type:"POST",
			url:"class/register/info_ajax.php", 
			data:({type:'quota_list', ce:centerID}),
			success:function(data){
				if((data.result)=='true')
					$('#id_finquo_list').html(data.output);
				}, 
			dataType:"json"});
			return false;
}
//----------------------------------------------------------------------------ok
function add_fish(number)
{
		var selected = $('#list_active_term').find('option:selected');
        var centerID = selected.data('center');
		$.ajax({
				type:"POST",
				url:"class/register/info_ajax.php",  
				data:({type:'fish', ce:centerID ,n:number}),
				success:function(data){
					if((data.result)=='true')
						$('#add_fish_info_'+number).html(data.output);
						FormInputMask.init();
					}, 
				dataType:"json"});
				return false;
}
//----------------------------------------------------------------------------ok
function remove_fish_form(number)
{
	$('#main_fee_form_'+number).html('');
}
//----------------------------------------------------------------------------ok
function add_check(number)
{
	var selected = $('#list_active_term').find('option:selected');
        var centerID = selected.data('center');
		$.ajax({
				type:"POST",
				url:"class/register/info_ajax.php",  
				data:({type:'check', ce:centerID ,n:number}),
				success:function(data){
					if((data.result)=='true')
						$('#add_check_info_'+number).html(data.output);
						FormInputMask.init();
					}, 
				dataType:"json"});
				return false;	
}
//----------------------------------------------------------------------------ok
function remove_check_form(number)
{
	$('#main_check_form_'+number).html('');
}
//----------------------------------------------------------------------------ok
function save_print()
{
	
	$.ajax({
			type:"POST",
			url:"class/register/register_save.php",  
			data:($('#register_student_form').serialize()),
			
			success:function(data){
				if((data.result)=='true')
					{
						alert('دانشجو با موفقیت ثبت نام گردید');
						$('#print_area').html(data.print_content);
						window.print();
						reset_my_form();
					}
				else
					{
						alert('ثبت ناموفق');
					}
					
				}, 
			dataType:"json"});
	return false;
	
}
function reset_my_form()
{
		$("#name_stu_reg_img").hide();
		$("#classname_stu_reg_img").hide();
		$('#loading_save_form').hide();
		$("#quota_div_img").hide();		
		$('#class_stu_reg').val("");
		$('#id_finquo').val("no");
		$('#ready_class').val("no");
		$('#total_fee').val("");
		$('#quotatype').val("");
		$('#kasr_darsad').val("");
		$('#quota_who').val("");
		$('#classname_stu_reg').val("");
		$('#student_stu_reg').val("");
		$('#name_stu_reg').val("");
		$('#result_check_stu').html("");
		$('#check_code_for_student').html("");
		$('#result_check').html("");
		$('#quota_div').html("");
		$('#print_area').html("");
		$('#result_check_class').html("");
		$('#result_check_class').html("");
		$('#fee_finfee').val(0);
		$('#tape_finfee').val(0);
		$('#book_finfee').val(0);
		$('#cd_finfee').val(0);
		$('#kasr_fee').val(0);
		$('#total_fee').val(0);
		$('#baghimande').html('');
		$('#baghimande_money').val(0);
		$('#ghabel_pardakht').html('');
		$('#ch1').prop("checked", false);
		$('#ch2').prop("checked", false);
		$('#ch3').prop("checked", false);
		$('#ch4').prop("checked", false);
		$('#ch1').parent('span').removeClass('checked');
		$('#ch2').parent('span').removeClass('checked');
		$('#ch3').parent('span').removeClass('checked');
		$('#ch4').parent('span').removeClass('checked');
		$('#ch1').attr("disabled", true);
		$('#ch2').attr("disabled", true);
		$('#ch3').attr("disabled", true);
		$('#ch4').attr("disabled", true);
		$('#add_fish_info_0').html('');
		$('#add_check_info_0').html('');
		$("'input[type=checkbox]'").each(function(){
					var name_text=$(this).attr('vfee');
					 $(this).removeClass('checkbox');
					 $('#'+name_text).removeClass('checkbox');
			});
}
