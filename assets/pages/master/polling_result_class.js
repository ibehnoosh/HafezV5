$(document).ready(function(){
	$('#polling').click(function(e) {
		var ids=$('#polling').val();	
        $.ajax({
			type:"POST",
			url:"polling/result_class_ajax.php",  
			data:({type:'master', i:ids}),
			success:function(data){
				if((data.result)=='true')
					$('#master_list').html(data.output);
				}, 
			dataType:"json"});
			return false;
    });
});

function show_result()
{
	var idm=$('#master').val();
	var idp=$('#polling').val();
	var idg=$('#group').val();	
	 $.ajax({
			type:"POST",
			url:"polling/result_class_ajax.php",  
			data:({type:'result', idm:idm , i:idp , idg:idg}),
			success:function(data){
				if((data.result)=='true')
					$('#result_div').html(data.output);
				}, 
			dataType:"json"});
			return false;
}
function print_polling(ddd)
{
	$('#'+ddd).jqprint();
}