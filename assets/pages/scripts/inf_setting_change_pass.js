var FormValidation = function () {
	"use strict";
    var handleValidation2 = function() {
            var form2 = $('#change_pass');
            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    Password1:
					{
						required:true
					},
					Password2: {
						equalTo:Password,required:true
                    }
                },
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