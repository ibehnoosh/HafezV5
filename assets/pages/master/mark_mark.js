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
  
   $('input:text').blur(function() {
    focusinput(this);
   //alert('fffff');
});
    FormInputMask.init();
	hilight_table();
});

function operatino(element) //---------------------------ok
{
	
	$("#grade_list_table tbody tr").removeClass('success');
	$(element).addClass('success');
		
	var a=$(element).attr('id')+'b';
	var s=$(element).attr('id')+'s';

	var sum=0.0;
	var vall=0;		
	$('input:text').each(function(){
		if($(this).attr('id').search(a) > -1)
		{	
			if ((isNaN($(this).val())) || ($(this).val() === ''))
			{
				vall=0;
			}
			else
			{
				vall= parseFloat(Number($(this).val()).toFixed(2));
			}
			//alert(vall);
			sum=vall+sum;
		}
				
	});
	$('#'+s).html(sum);
}
function hilight_table() //------------------------------ok
{	
	$("tr.row_values").click(function(){
		operatino(this);
	});
}
function focusinput(element)
{
	
	var nnn=$(element).attr('id');	
	var a=nnn.substring(0,nnn.indexOf("b"));
	var s=$(element).attr('id')+'s';

	var sum=0.0;
			
	$('input:text').each(function(){
		if($(this).attr('id').search(a) > -1)
		{	
			if ($(this).val() !== null)
			{
				sum+=parseFloat($(this).val());
			}
			else
			{
				sum+=0;
			}
		}
				
	});
	$('#'+s).html(sum);
}