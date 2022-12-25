var FormValidation = function () {
	"use strict";
    var handleValidation2 = function() {
            var form2 = $('#add_stu_form');
            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
					capacity: {
						number: true,
						minlength: 1,
						maxlength: 2
					}
                },
				
                submitHandler: function (form) {
                    form[0].submit(); // submit the form
                }
            });
    }
    return {
        init: function () {
            handleValidation2();
        }
    };
}();
$(document).ready(function() {
	FormValidation.init();
	$('#id_e_person').attr("disabled" , true);
	$('#id_e_master').attr("disabled" , true);
		
	$('#who_m').click(function(){
		$('#id_e_master').attr("disabled" , false);
		$('#id_e_master').prop('required', true);
		$('#id_e_person').attr("disabled" , true);
		$('#id_e_person').prop('required', false);
		});
	$('#who_p').click(function(){
		$('#id_e_master').attr("disabled" , true);
		$('#id_e_master').prop('required', false);
		$('#id_e_person').attr("disabled" , false);
		$('#id_e_person').prop('required', true);
		});
});