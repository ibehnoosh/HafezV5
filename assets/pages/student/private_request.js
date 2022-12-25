                
var FormValidation = function () {
	"use strict";
    var handleValidation2 = function() {
            var form2 = $('#form_sample_1');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);
            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    sessions: {
                        number: true,
						minlength: 2,
						maxlength: 2
                    },
					sessions2: {
                        number: true,
						minlength: 1,
						maxlength: 2
                    }
                },
				
				
                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    success2.show();
                    error2.hide();
                    form[0].submit(); // submit the form
                }
            });


    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation2();

        }

    };

}();

$(document).ready(function(e) {
    	$('#ssess_1').show();$('#ssess_2').hide();
		$('#sessions').prop('disabled', false);
		$('#sessions2').prop('disabled', true);
	FormValidation.init();
});
function show_level()
{
	$.ajax({		
	type:"POST",
	url:"private/ajax_request.php",  
	data:({type:'level',lang:$('#lang').val()}),
	success:function(data){
	if((data.result)==='true')
	{
		$("#master_level_div").html(data.output);}
	}, 
	dataType:"json"});
	return false;
}

function calcute_fee()
{
	var lang=$('#lang').val();
	var level=$('#master_level').val();
	var place=$('#place').val();
	var type_class=$('#type').val();
	var off_code=$('#off_code').val();
	var sessions=0;
	var general=$("#general").is(':checked');
	
	if(($("#khnowing").val() === 'تمدید دوره') || $("#general").is(':checked'))
	{ 
		$('#ssess_2').show();$('#ssess_1').hide();
		$('#sessions').prop('disabled', true);
		$('#sessions2').prop('disabled', false);
		sessions=$('#sessions2').val();

	}
	else
	{
		$('#ssess_1').show();$('#ssess_2').hide();
		$('#sessions').prop('disabled', false);
		$('#sessions2').prop('disabled', true);
		sessions=$('#sessions').val();
	}
	//alert(general);
	
	$.ajax({		
	type:"POST",
	url:"private/ajax_request.php",  
	data:({type:'calcute_fee',lang:lang ,level:level,sessions:sessions , place:place , type_class:type_class , off_code:off_code, general:general}),
	success:function(data){
		if((data.result)==='true')
		{
		$("#fee_div").html(data.output);
		FormValidation.init();
		}
	}, 
	dataType:"json"});
	return false;
}
function check_code_off()
{
	$.ajax({		
	type:"POST",
	url:"private/ajax_request.php",  
	data:({type:'off_code',off_code:$('#off_code').val()}),
	success:function(data){
	if((data.result)==='true')
	{
		$("#off_code_result").html(data.output);
		calcute_fee();
		}
	}, 
	dataType:"json"});
	return false;
}
function wplace()
{
	if($('#place').val()==='Home')
	{
		$('#home_address').html('<input type="text" name="address" value="" placeholder="آدرس منزل" class="form-control" required>');
	}
	else
	{
		$('#home_address').html('');
	}
}

