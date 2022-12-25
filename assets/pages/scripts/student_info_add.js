var FormValidation = function () {
	"use strict";
    var handleValidation2 = function() {
            var form2 = $('#add_stu_form');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);
            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    email: {
                        email: true
                    },
                    meli_stu: {
                        number: true,
						minlength: 10,
						maxlength: 10
                    },
					shenasnameh_stu: {
						number: true
					},
					mobile_stu: {
						number: true,
						minlength: 11,
						maxlength: 11
					},
					fmobile_stu: {
						number: true,
						minlength: 11,
						maxlength: 11
					},
					mmobile_stu: {
						number: true,
						minlength: 11,
						maxlength: 11
					},
					 gender_stu: {
                        required: true
                    },
					email_stu:{
						email:true
					}
                },
				
				messages: { // custom messages for radio buttons and checkboxes
                    gender_stu: {
                        required: "لطفا جنسیت را مشخص نمایید."
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
 var handleWysihtml5 = function() {
        if (!jQuery().wysihtml5) {
            
            return;
        }
        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": ["../assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            });
        }
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