// JavaScript Document
$(document).ready(function(e) {
	var sum = 0;
	$('.grades').each(function(){
    sum += parseFloat($(this).val()); 
});
	$('#sum_of_grade').html('Sum : <b>'+sum+'</b>');
});

function save(t)//ok
{
	
	$.ajax({
	type:"POST",
	url:"exam/ajax.php",  
	data:({type:'save', fit:$(t).attr("name"), fiv:$(t).val(), checkk:$(t).is(":checked") }),
	success:function(data){
		
	//	alert(data.output);
	}, 
	dataType:"json"});
	return false;
}

function grade_order(t,i,og)
{
	//alert(og);	
	
	var sum = 0;
	$('.grades').each(function(){
    sum += parseFloat($(this).val()); 
});
	$('#sum_of_grade').html('Sum : <b>'+sum+'</b>');
	
	$.ajax({
	type:"POST",
	url:"exam/ajax.php",  
	data:({type:og, fit:i , fiv:$(t).val() }),
	success:function(data){}, 
	dataType:"json"});
	return false;
}

function pre_after(t,i,og)
{
	$.ajax({
	type:"POST",
	url:"exam/ajax.php",  
	data:({type:og, fit:i , fiv:$(t).val() }),
	success:function(data){}, 
	dataType:"json"});
	return false;
	
}
function save_grade(t)//ok
{
	$.ajax({
	type:"POST",
	url:"exam/ajax.php",  
	data:({type:'save_grade', fit:$(t).attr("name"), fiv:$(t).val() }),
	success:function(data){
		
	//	alert(data.output);
	}, 
	dataType:"json"});
	return false;
}