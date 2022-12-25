// JavaScript Document
function check_search()
{
	if((document.getElementById('id_filter').value=='')&&(document.getElementById('meli_filter').value=='')&&(document.getElementById('family_filter').value=='')&&(document.getElementById('mobile_filter').value==''))
	{
		alert('برای جستجو لازم است که یکی از موارد # دار را وارد نمایید');
		return false;
	}
	else if((document.getElementById('id_filter').value.length < 6) && (document.getElementById('id_filter').value.length > 0))
	{
		alert('برای جستجو بر اساس شماره دانشجویی لازم است حداقل 6 شماره آن را وارد نمایید');
		return false;
	}
	else if((document.getElementById('meli_filter').value.length < 7)&& (document.getElementById('meli_filter').value.length > 0))
	{
		alert('برای جستجو بر اساس شماره ملی لازم است حداقل 7 شماره آن را وارد نمایید');
		return false;
	}
	else if((document.getElementById('family_filter').value.length < 3)&& (document.getElementById('family_filter').value.length > 0))
	{
		alert('برای جستجو بر اساس نام خانوادگی لازم است حداقل 3 حرف آن را وارد نمایید');
		return false;
	}
	else if((document.getElementById('mobile_filter').value.length < 7)&& (document.getElementById('mobile_filter').value.length > 0))
	{
		alert('برای جستجو بر اساس شماره همراه لازم است حداقل 7 حرف آن را وارد نمایید');
		return false;
	}
	else
	{
		return true;
	}
}