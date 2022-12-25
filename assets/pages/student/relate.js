var FormValidation = function () {
	"use strict";
    var handleValidation2 = function() {
            var form2 = $('#add_form');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);
            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    stud1: {
                        number: true,
						minlength: 8,
						maxlength: 8
                    },
					stud2: {
                        number: true,
						minlength: 8,
						maxlength: 8
                    },
					stud3: {
                        number: true,
						minlength: 8,
						maxlength: 8
                    },
					stud4: {
                        number: true,
						minlength: 8,
						maxlength: 8
                    },
					stud5: {
                        number: true,
						minlength: 8,
						maxlength: 8
                    }
					
                },
				 success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
				
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
