var FormValidation = function () {
	"use strict";
    var handleValidation2 = function() {
            var form2 = $('#add_form');
            var error2 = $('#error', form2);
            var success2 = $('#okkk', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
				messages: {
                    exam_id: {
                        required: jQuery.validator.format("لازم است یک دوره را انتخاب نمایید."),
                    }
                },
                rules: {
					meli: {
                        number: true,
						minlength: 10,
						maxlength: 10
                    },
					mobile: {
						number: true,
						minlength: 11,
						maxlength: 11
					},
					student: {
						number: true,
						minlength: 8,
						maxlength: 8
					},
					email:{
						email:true
					},
					exam_id:{
						required:true
					}
                },
				
				
                invalidHandler: function (event, validator) { //display error alert on form submit              
					success2.hide();
                    error2.show();
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
					 form[0].submit();
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

jQuery(document).ready(function() {
    FormValidation.init();
});

function select_row(tr,id,fee)
{
	$('#table_list_class tr').removeClass('success');
	$('#exam_id').val(id);
	$('#fee').val(fee);
	$('#'+tr).addClass('success');
}