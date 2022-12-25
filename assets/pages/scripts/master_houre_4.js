// JavaScript Document
$(function() {
	
 $('.selecttr').click(function(e) {
     var tr_id=$(this).val();
	if($(this).is(':checked'))
	{
		 $('#tr_'+tr_id).show();
	}
	else
	{
		$('#tr_'+tr_id).hide();
	}
});
	show_class();
});
function CallPrint()
        {
			var prints='0';
			var taeens='0';
			$('input[type=checkbox]').each(function () {
           if (this.checked) {
			  var va=$(this).val();
              var ids=$('#ids'+va).val(); 
			  var taee=$('#idt'+va).val();			  
			  	if($('#ids'+va).length )
				{
					prints+=','+ids;
				}
				if($('#idt'+va).length )
				{
					taeens+=','+taee;
				}
           }});
		   //-------------------------------------------------------
		   $.ajax({
			type:"POST",
			url:"report/ajax_master_hour_4.php",  
			data:({type:'printadd', prints:prints , taeens:taeens}),
			success:function(data){
				if((data.result)=='true')
				$('#print_area').removeClass("visible-print");
				$('#table4print tr:visible td:first-child').each(function(i){
				$(this).html(i+1);
				});		
				window.print();
				$('#print_area').addClass("visible-print");
				}, 
			dataType:"json"});
			return false;
		   //-------------------------------------------------------	
		   	
        }
function CallPrint2()
        {
			
			var prints='0';
			var taeens='0';
			$('input[type=checkbox]').each(function () {
           if (this.checked) {
			  var va=$(this).val();
              var ids=$('#ids'+va).val(); 
			  var taee=$('#idt'+va).val(); 
			  	if($('#ids'+va).length )
				{
					prints+=','+ids;
				}
				if($('#idt'+va).length )
				{
					taeens+=','+taee;
				}
           }});
		   
		   //-------------------------------------------------------
		   $.ajax({
			type:"POST",
			url:"report/ajax_master_hour_4.php",  
			data:({type:'print2', prints:prints , taeens:taeens}),
			success:function(data){
				if((data.result)=='true')
				$('#print_area').removeClass("visible-print");
				$('#table4print tr:visible td:first-child').each(function(i){
				$(this).html(i+1);
				});		
				window.print();
				$('#print_area').addClass("visible-print");
				}, 
			dataType:"json"});
			return false;
		   //-------------------------------------------------------		
        }
function removePrint()
        {
			var prints='0';
			$('input[type=checkbox]').each(function () {
           if (this.checked) {
			  var va=$(this).val();
              var ids=$('#ids'+va).val(); 
			  var taee=$('#idt'+va).val(); 
			  	if($('#ids'+va).length )
				{
					prints+=','+ids;
				}
				if($('#idt'+va).length )
				{
					taeens+=','+taee;
				}
           }});
		   
		   //-------------------------------------------------------
		   $.ajax({
			type:"POST",
			url:"report/ajax_master_hour_4.php",  
			data:({type:'printremove', prints:prints , taeens:taeens}),
			success:function(data){
				if((data.result)=='true')
				alert('تغییرات اعمال گردید.');
				}, 
			dataType:"json"});
			return false;
		   //-------------------------------------------------------		
        }
function show_class()
{
	var date=$('#date').val();
	var date2=$('#date2').val();
	var master=$('#id_e_master').val();
	var levels_select=$('#levels_select').val();
	$.ajax({
			type:"POST",
			url:"report/ajax_master_hour_4.php",  
			data:({type:'show_classes', date:date ,date2:date2 , master:master , levels_select:levels_select}),
			success:function(data){
				if((data.result)=='true')
				$('#result_div').html(data.out);
				}, 
			dataType:"json"});
			return false;
	
}