var FormInputMask = function () {
    
    var handleInputMasks = function () {
        $(".nomarat").inputmask("mask", {
            "mask": "99.99",
			"autoUnmask" : false,
			"oncomplete": function(){  var index = $('.nomarat').index(this) + 1;
         									$('.nomarat').eq(index).focus();}
        }); 
		
    }
    return {
		    init: function () {
            handleInputMasks();}
    };}();
$(document).ready(function(e) {
    FormInputMask.init();
});