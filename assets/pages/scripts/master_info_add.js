var FormValidation = function () {
	"use strict";
    var handleValidation2 = function() {
            var form2 = $('#form_add_master');
            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    email: {
                        email: true
                    },
                    meli_per: {
                        number: true,
						minlength: 10,
						maxlength: 10
                    },
					mobile_per: {
						number: true,
						minlength: 11,
						maxlength: 11
					},
					birth_per: {
                        number: true,
						minlength: 2,
						maxlength: 2
                    }
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