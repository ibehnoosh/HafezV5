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
					ch1 :{required: true},
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
	
function start_edit()
{
	code_class();
	quota();
	id_finquo_list();
	FormInputMask.init();
	FormValidation.init();
}
function code_class()
{
	
			var t_active=$("#list_active_termedit").val();
			var id_class=$("#class_stu_reg").val();
			var id_student=$("#student_stu_reg").val();
			if(id_class > 0)
			{
			$.ajax({
			type:"POST",
			url:"class/register/info_ajax_edit.php",  
			data:({type:'class', c:id_class ,t:t_active,s:id_student}),
			success:function(data){
				if((data.result)=='true')
				{
					$('#code_class_edit').val(data.code_class);
					$('#result_check_class').html(data.message);
					$('#classname_stu_reg').val(data.name_class); 
					$('#ready_class').val(data.ready_class);
					$('#check_code_for_student').html(data.check_code_for_student);
					
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
					$('#code_class_edit').val(data.code_class);
					$('#fee_finfee').val(data.fee_finfee);
					$('#tape_finfee').val(data.tape_finfee);
					$('#book_finfee').val(data.book_finfee);
					$('#cd_finfee').val(data.cd_finfee);
					$('#ch1').attr("disabled", true);
					$('#ch2').attr("disabled", true);
					$('#ch3').attr("disabled", true);
					$('#ch4').attr("disabled", true);
				}
				else
				if((data.result)=='befor')
				{
					
					$('#ready_class').val(data.ready_class);
					$('#classname_stu_reg').val(data.name_class); 
					$('#check_code_for_student').html(data.check_code_for_student);
					$('#code_class_edit').val(data.code_class);
					$('#ch1').attr("disabled", false);
					$('#ch2').attr("disabled", false);
					$('#ch3').attr("disabled", false);
					$('#ch4').attr("disabled", false);
					$('#fee_finfee').val(data.fee_finfee);
					$('#tape_finfee').val(data.tape_finfee);
					$('#book_finfee').val(data.book_finfee);
					$('#cd_finfee').val(data.cd_finfee);
					quota();
					fee_accounting();
				}
				}, 
			dataType:"json"});
			return false;
			}
}
function quota()
{
	var who_quoata=$('#quotawho_stu_re').val()
	var id_finquo=$("#id_finquo").val();
	var letter=$("#pre_letter").val();
	$.ajax({
			type:"POST",
			url:"class/register/info_ajax.php", 
			data:({type:'quota', q:id_finquo, who_quoata:who_quoata ,letter:letter}),
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
function id_finquo_list()
{
	   var selected = $('#list_active_term').find('option:selected');
       var centerID = selected.data('center');
	   var quotaid = $('#quotaid_stu_reg').val();
	   $.ajax({
			type:"POST",
			url:"class/register/info_ajax.php", 
			data:({type:'quota_list', ce:centerID,quotaid_selected:quotaid}),
			success:function(data){
				if((data.result)=='true')
					$('#id_finquo_list').html(data.output);
					quota();
				}, 
			dataType:"json"});
			return false;
}
function clear_form()
{
	id_finquo_list();
		$('#class_stu_reg').val("");
		$('#classname_stu_reg').val("");
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
		$('#quota_div').html("");
}