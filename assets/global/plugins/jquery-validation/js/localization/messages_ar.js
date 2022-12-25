(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: AR (Arabic; العربیة)
 */
$.extend($.validator.messages, {
	required: "هذا الحقل إلزامی",
	remote: "یرجى تصحیح هذا الحقل للمتابعة",
	email: "رجاء إدخال عنوان برید إلكترونی صحیح",
	url: "رجاء إدخال عنوان موقع إلكترونی صحیح",
	date: "رجاء إدخال تاریخ صحیح",
	dateISO: "رجاء إدخال تاریخ صحیح (ISO)",
	number: "رجاء إدخال عدد بطریقة صحیحة",
	digits: "رجاء إدخال أرقام فقط",
	creditcard: "رجاء إدخال رقم بطاقة ائتمان صحیح",
	equalTo: "رجاء إدخال نفس القیمة",
	extension: "رجاء إدخال ملف بامتداد موافق علیه",
	maxlength: $.validator.format("الحد الأقصى لعدد الحروف هو {0}"),
	minlength: $.validator.format("الحد الأدنى لعدد الحروف هو {0}"),
	rangelength: $.validator.format("عدد الحروف یجب أن یكون بین {0} و {1}"),
	range: $.validator.format("رجاء إدخال عدد قیمته بین {0} و {1}"),
	max: $.validator.format("رجاء إدخال عدد أقل من أو یساوی (0}"),
	min: $.validator.format("رجاء إدخال عدد أكبر من أو یساوی (0}")
});

}));