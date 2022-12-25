
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
    $('#home_address').html('');
	FormValidation.init();
});
function show_level()
{
	$.ajax({		
	type:"POST",
	url:"private/add/ajax_request.php",  
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
	var sessions=$('#sessions').val();
	var place=$('#place').val();
	var type_class=$('#type').val();
	var off_code=$('#off_code').val();
	if($("#govahi").is(':checked'))
	{ var govahi=1;
	}
	else
	{
		var govahi=0;
	}
	if($("#check").is(':checked'))
	{ var check=1;
	}
	else
	{
		var check=0;
	}
	$.ajax({		
	type:"POST",
	url:"private/add/ajax_request.php",  
	data:({type:'calcute_fee',lang:lang ,level:level,sessions:sessions , place:place , type_class:type_class , off_code:off_code, govahi:govahi , check:check}),
	success:function(data){
	if((data.result)==='true')
	{
		$("#fee_div").html(data.output);}
	}, 
	dataType:"json"});
	return false;
}
function check_code_off()
{
	$.ajax({		
	type:"POST",
	url:"private/add/ajax_request.php",  
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


