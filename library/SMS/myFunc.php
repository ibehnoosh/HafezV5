<?php

function error_sms($error_number)
{
	switch($error_number)
	{
		case '1':
			$error='شماره های گیرنده نامعتبر است';
		break;
		case '3':
			$error='پارامتر encoding نا معتبر است';
		break;
		case '4':
			$error='پارامتر messageClass نا معتبر است';
		break;
		case '6':
			$error='پارامتر UDH نا معتبر است';
		break;
		case '13':
			$error='پیامک ترکیبudh و message خالی است.';
		break;
		case '14':
			$error='حساب دارای شارژ کافی نمی باشد.';
		break;
		case '15':
			$error='لطفا پیام ها را دوباره ارسال نمایی';
		break;
		case '16':
			$error='حساب غیر فعال می باشد';
		break;
		case '17':
			$error='حساب منقضی شده است.';
		break;
		case '18':
			$error='نام کاربری و یا کلمه عبور نادرست است';
		break;
		case '19':
			$error='درخواست دارای اعتبار نمی باشد';
		break;
		case '22':
			$error='استفاده از این سرویس برای این حساب مقدور نمی باشد';
		break;
		case '23':
			$error='به دلیل ترافیک بالا سرور آمادگی دریافت پیام جدید ندارد. دوباره سعی نمایید';
		break;
		case '24':
			$error='شناسه پیامک معتبر نمی باشد';
		break;
		case '25':
			$error='نوع سرویس درخواستی نامعتبر است';
		break;
		case '101':
			$error='طول آرایه پارامتر message با طول آرایه گیرندگان تطابق ندارد';
		break;
		case '102':
			$error='طول آرایه پارامتر messageClass با طول آرایه گیرندگان تطابق ندارد';
		break;
		case '104':
			$error='طول آرایه پارامتر UDHS با طول آرایه گیرندگان تطابق ندارد';
		break;
		case '105':
			$error='طول آرایه پارامتر priorities با طول آرایه گیرندگان تطابق ندارد';
		break;
		case '106':
			$error='آرایه گیرندگان خالی می باشد';
		break;
		case '107':
			$error='طول آرایه پارامتر گیرندگان بیشتر از طول مجاز است';
		break;
		case '108':
			$error='آرایه فرستندگان خالی می باشد';
		break;
		case '109':
			$error='طول آرایه پارامتر priorities با طول آرایه گیرندگان تطابق ندارد';
		break;
	}
	return $error;
}
?>