$(document).ready(function(){
	$('#polling').click(function(e) {
		
		var ids=$('#polling').val();	
        $.ajax({
			type:"POST",
			url:"polling/result_ajax.php",  
			data:({type:'polling', i:ids}),
			success:function(data){
				if((data.result)=='true')
					$('#master_list').html(data.output);
				}, 
			dataType:"json"});
			return false;
    });
});
function master_change()
{
	var idm=$('#master').val();
	var idp=$('#polling').val();	
	 $.ajax({
			type:"POST",
			url:"polling/result_ajax.php",  
			data:({type:'master', idm:idm , i:idp}),
			success:function(data){
				if((data.result)=='true')
					$('#group_list').html(data.output);
				}, 
			dataType:"json"});
			return false;
}