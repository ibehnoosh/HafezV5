function checkAll()
{
	if($('#checkall').is(':checked'))
	{
		$('.id_y').prop("checked", true);
		$('.id_y').parent('span').addClass('checked');
	}
	else
	{
		$('.id_y').prop("checked", false);
		$('.id_y').parent('span').removeClass('checked');
	}
}
function save_stat(thhis)
{
	var locate=$('#locate'+thhis).val();
	var type=$('#type'+thhis).val();
	var state=$('#state'+thhis).val();
	var id_e_master=$('#id_e_master'+thhis).val();
	var comment=$('#comment'+thhis).val();
	$.ajax({
			type:"POST",
			url:"class/finance/ajax_class.php",  
			data:({t:'statuse', id:thhis ,locate:locate,type:type,state:state,id_e_master:id_e_master,comment:comment}),
			success:function(data){
				if((data.result)=='true')
				$('#esult_div').html('ذخیره گردید');
				}, 
			dataType:"json"});
			return false;
}