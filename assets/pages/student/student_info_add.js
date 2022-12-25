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
                    meli: {
                        number: true,
						minlength: 10,
						maxlength: 10
                    },
					birth: {
                        number: true,
						minlength: 4,
						maxlength: 4
                    },
					birth_en: {
                        number: true,
						minlength: 4,
						maxlength: 4
                    },
					shenasnameh: {
						number: true
					},
					passport: {
						number: true
					},
					mobile: {
						number: true,
						minlength: 11,
						maxlength: 11
					},
					fmobile: {
						number: true,
						minlength: 11,
						maxlength: 11
					},
					mmobile: {
						number: true,
						minlength: 11,
						maxlength: 11
					},
					email:{
						email:true
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

jQuery(document).ready(function() {
    FormValidation.init();
});