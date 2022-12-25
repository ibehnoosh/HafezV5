jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
function show_reciver()
{
	$('#selectithem').val('id_person_list');
	$('#form_inbox').submit();
}
function enter_event(e)
{
	 if (e.keyCode == 13)
	{
		$('#selectithem').val('search_yes');
		$('#form_inbox').submit();
	}
}
function checkAll()
{
	if($('#checkall').is(':checked'))
	{
		$('.emi').prop("checked", true);
		$('.emi').parent('span').addClass('checked');
	}
	else
	{
		$('.emi').prop("checked", false);
		$('.emi').parent('span').removeClass('checked');
	}
}