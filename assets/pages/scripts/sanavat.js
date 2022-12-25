$(document).ready(function(e) {
	"use strict";
$('#id_student').blur(function(e) {
    $( "#family_stu" ).val("");
});
	
	 $( "#loading" ).hide();
	$( "#family_stu" ).autocomplete({
		source: "ajax/search_student.php",
				minLength: 2,
				autoFocus:true,
				select: function(event, ui) {
					$('#id_student').val(ui.item.id);
					$('#family_stu').val(ui.item.abbrev);
				}
	}); 
	  
});
$( document ).ajaxStart(function() { $( "#loading" ).show();});
function show_sanavat()
{
	$.ajax({
	type:"POST",
	url:"student/education/ajax_sanavat.php",  
	data:({type:'edu', id:$('#id_student').val()}),
	success:function(data){
	if((data.result)=='true')
		$("#result_div").html(data.output);
		$("#loading").html("");
	}, 
	dataType:"json"});
	return false;
}
function show_sanavat_mali()
{
	$.ajax({
	type:"POST",
	url:"student/financial/ajax_sanavat.php",  
	data:({type:'edu', id:$('#id_student').val()}),
	success:function(data){
	if((data.result)=='true')
		$("#result_div").html(data.output);
		$("#loading").html("");
	}, 
	dataType:"json"});
	return false;
}
function show_sanavat_delay()
{
	$.ajax({
	type:"POST",
	url:"student/report/ajax_delay.php",  
	data:({type:'edu', id:$('#id_student').val()}),
	success:function(data){
	if((data.result)=='true')
		$("#result_div").html(data.output);
		$("#loading").html("");
	}, 
	dataType:"json"});
	return false;
}
function edit_fish(id,stu)
{
	
	$.ajax({
	type:"POST",
	url:"student/financial/ajax_sanavat.php",  
	data:({type:'recipt', id:stu , recipt:id , money: $('#money_'+id).val()}),
	success:function(data){
	if((data.result)=='true')
		$('#f_'+id).html(" با موفقیت ذخیره گردید");
		show_sanavat_mali();
	}, 
	dataType:"json"});
	return false;
	
}
function add_kasr_show(s,t,c,reg)
{	
	$.ajax({
	type:"POST",
	url:"student/financial/ajax_sanavat.php",  
	data:({type:'addkasr', id:s , term:t , c:c, money: $('#money_add_kasr').val(),who:$("input[name='who']:checked"). val(), master: $('#master_add_kasr').val(), person: $('#person_add_kasr').val()}),
	success:function(data){
	if((data.result)=='true')
		$('#permas').html(" با موفقیت ذخیره گردید");
		show_sanavat_mali();
		
		var $modal = $('#ajax-modal');
		setTimeout(function(){
                  $modal.load('student/financial/sanavat_details.php?i='+reg, '', function(){
                  $modal.modal();
                });
              }, 1);
			
		
	}, 
	dataType:"json"});
	return false;
	
	
}
function delete_addpaymas(s,id,reg)
{
		$.ajax({
	type:"POST",
	url:"student/financial/ajax_sanavat.php",  
	data:({type:'deletepermas', id:s ,permas:id}),
	success:function(data){
	if((data.result)=='true')
		show_sanavat_mali();
		
		var $modal = $('#ajax-modal');
		setTimeout(function(){
                  $modal.load('student/financial/sanavat_details.php?i='+reg, '', function(){
                  $modal.modal();
                });
              }, 1);
			
		
	}, 
	dataType:"json"});
	return false;
	
}
function add_back_money(s,id)
{
		$.ajax({
	type:"POST",
	url:"student/financial/ajax_sanavat.php",  
	data:({type:'add_back_money',id_stu_reg:id, money: $('#money_back').val()}),
	success:function(data){
	if((data.result)=='true')
		show_sanavat_mali();
		var $modal = $('#ajax-modal');
		setTimeout(function(){
                  $modal.load('student/financial/sanavat_details.php?i='+id, '', function(){
                  $modal.modal();
                });
              }, 1);
			
		
	}, 
	dataType:"json"});
	return false;
	
}
function add_back_private_money(s,id)
{
		$.ajax({
	type:"POST",
	url:"student/financial/ajax_sanavat.php",  
	data:({type:'add_back_private_money',id_stu_reg:id, money: $('#money_back').val()}),
	success:function(data){
	if((data.result)=='true')
		show_sanavat_mali();
		var $modal = $('#ajax-modal');
		setTimeout(function(){
                  $modal.load('student/financial/sanavat_private_details.php?i='+id, '', function(){
                  $modal.modal();
                });
              }, 1);
			
		
	}, 
	dataType:"json"});
	return false;
	
}
