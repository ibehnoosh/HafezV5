
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
            handleInputMasks();
			hilight_table() }
    };}();
$(document).ready(function(e) {
    FormInputMask.init();
});


function hilight_table() //------------------------------ok
{	
	$("tr.row_values").click(function(){
		operatino(this)
	})
}

function operatino(element) //---------------------------ok
{
	$("#grade_list_table tbody tr").removeClass('success');
	$(element).addClass('success');
		
	var a=$(element).attr('id')+'b';
	var s=$(element).attr('id')+'s';
	var v=$(element).attr('id')+'v';
	var sum=0.0;
			
	$('input:text').each(function(){
		
		if($(this).attr('id').search(a) > -1)
		{
			if($(this).val() > 0 )
			{
				sum=parseFloat(sum)+parseFloat($(this).val());
				
			}
		}
				
	});
	
	$('#'+s).html(sum);
}

function save_grad_form()//------------------------------ok
{	 
	
	$.ajax({
	type:"POST",
	url:"assessment/save_grade.php", 
	data:($(":input").serialize()),
	success:function(data){
		if((data.result)=='true')
			$('#query_result_div').html(data.output);
		}, 
	dataType:"json"});
	return false;
}
function save_grad_form_one(id,a,b,id_buttom)//----------ok
{
	$(id_buttom).attr("disabled", true);	
	var formdata=$(":input").serialize();
	$.ajax({
	type:"POST",
	url:"assessment/save_grade.php", 
	data:(formdata+'&a_one='+a+'&b_one='+b+'&save_one=yes'),
	success:function(data){
		if((data.result)=='true')
			$(id_buttom).attr("disabled", false);	
		}, 
	dataType:"json"});
	return false;
	
}