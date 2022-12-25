<?php
class mellatbank
{
    public function show_error($id)
    {
        switch ($id) {
            case 0:$out = 'تراکنش با موفقیت انجام شد';
                break;
            case 11:$out = 'شماره کارت نا معتبر است';
                break;
            case 12:$out = 'موجودی کافی نیست';
                break;
            case 13:$out = 'رمز نادرست است';
                break;
            case 14:$out = 'تعداد دفعات وارد کردن رمز بیش از حد مجاز است';
                break;
            case 15:$out = 'کارت نا معتبر است';
                break;
            case 16:$out = 'دفعات برداشت وجه بیش از حد مجاز است';
                break;
            case 17:$out = 'کاربر از انجام تراکنش منصرف شده';
                break;
            case 18:$out = 'تاریخ انقضای کارت گذشته';
                break;
            case 19:$out = 'مبلغ برداشت وجه بیش از حد مجاز است';
                break;
            case 111:$out = 'صادر کننده کارت نا معتبر است';
                break;
            case 112:$out = 'خطای سوییچ صادر کننده کارت';
                break;
            case 113:$out = 'پاسخی از صادر کننده کارت دریافت نشد';
                break;
            case 114:$out = 'دارنده کارت مجاز به انجام این تراکنش نیست';
                break;
            case 21:$out = 'پذیرنده نا معتبر است';
                break;
            case 23:$out = 'خطای امنیتی رخ داده است';
                break;
            case 24:$out = 'اطلاعات کاربری پذیرنده نا معتبر است';
                break;
            case 25:$out = 'مبلغ نا معتبر است';
                break;
            case 31:$out = 'پاسخ نا معتبر است';
                break;
            case 32:$out = 'فرمت اطلاعات وارد شده صحیح نمی باشد';
                break;
            case 33:$out = 'حساب نا معتبر است';
                break;
            case 34:$out = 'خطای سیستمی';
                break;
            case 35:$out = 'تاریخ نا معتبر است';
                break;
            case 41:$out = 'شماره درخواست تکراری است';
                break;
            case 42:$out = 'تراکنش Sale یافت نشد';
                break;
            case 43:$out = 'قبلا درخواست Verify داده شده است';
                break;
            case 44:$out = 'درخواست Verify یافت نشد';
                break;
            case 45:$out = 'تراکنش Settle شده است';
                break;
            case 46:$out = 'تراکنش Settle نشده است';
                break;
            case 47:$out = 'تراکنش Settle یافت نشد';
                break;
            case 48:$out = 'تراکنش Reverse شده است';
                break;
            case 49:$out = 'تراکنش ReFund یافت نشد';
                break;
            case 412:$out = 'شناسه قبض نادرست است';
                break;
            case 413:$out = 'شناسه پرداخت نادرست است';
                break;
            case 414:$out = 'سازمان صادر کننده قبض نا معتبر است';
                break;
            case 415:$out = 'زمان جلسه کاری به پایان رسیده';
                break;
            case 416:$out = 'خطا در ثبت اطلاعات';
                break;
            case 417:$out = 'شناسه پرداخت کننده نا معتبر است';
                break;
            case 418:$out = 'اشکال در تعریف اطلاعات مشتری';
                break;
            case 419:$out = 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته اس';
                break;
            case 421:$out = 'IP نا معتبر است.';
                break;
            case 51:$out = 'تراکنش تکراری است';
                break;
            case 54:$out = 'تراکنش مرجع موجود نیست';
                break;
            case 55:$out = 'تراکنش نا معتبر است';
                break;
            case 61:$out = 'خطا در واریز';
                break;
        }
        return $out;
    }
    public function messeg2($result)
    {
        switch ($result) {
            case '-20':
                return "در درخواست کارکتر های غیر مجاز وجو دارد";
                break;
            case '-30':
                return " تراکنش قبلا برگشت خورده است";
                break;
            case '-50':
                return " طول رشته درخواست غیر مجاز است";
                break;
            case '-51':
                return " در در خواست خطا وجود دارد";
                break;
            case '-80':
                return " تراکنش مورد نظر یافت نشد";
                break;
            case '-81':
                return " خطای داخلی بانک";
                break;
            case '-90':
                return " تراکنش قبلا تایید شده است";
                break;
        }
    }
    public function messeg($resultCode)
    {
        switch ($resultCode) {
            case 110:
                return " انصراف دارنده کارت";
                break;
            case 120:
                return "   موجودی کافی نیست";
                break;
            case 130:
            case 131:
            case 160:
                return "   اطلاعات کارت اشتباه است";
                break;
            case 132:
            case 133:
                return "   کارت مسدود یا منقضی می باشد";
                break;
            case 140:
                return " زمان مورد نظر به پایان رسیده است";
                break;
            case 200:
            case 201:
            case 202:
                return " مبلغ بیش از سقف مجاز";
                break;
            case 166:
                return " بانک صادر کننده مجوز انجام  تراکنش را صادر نکرده";
                break;
            case 150:
            default:
                return " خطا بانک  $resultCode";
                break;
        }
    }
    public function check_money($fee_form, $id, $type)
    {
        if ($type == 'l') {
            $sql = "SELECT `fee` FROM `edu_class_taeen` WHERE `id`=" . $id;
            $res = mysql_query($sql);
            $row = mysql_fetch_object($res);
            $fee_main = $row->fee;
            if ($fee_form != $fee_main) {
                return false;
            } else {
                return true;
            }
        }
    }
    public function error_Saman($type)
    {
        switch ($type) {
            case 'Canceled By User':$out = 'تراکنش بوسیله خریدار کنسل شده';
                break;
            case 'Invalid Amount':$out = 'مبلغ سند برگشتی از مبلغ تراکنش اصلی بیشتر است';
                break;
            case 'Invalid Transaction':$out = 'درخواست برگشت تراکنش رسیده است در حالی که تراکنش اصلی پیدا نمی شود';
                break;
            case 'Invalid Card Number':$out = 'شماره کارت اشتباه است';
                break;
            case 'No Such Issuer':$out = 'چنین صادر کننده کارتی وجود ندارد';
                break;
            case 'Expired Card Pick Up':$out = 'از تاریخ انقضای کارت گذشته است';
                break;
            case 'Incorrect PIN':$out = 'رمز کارت اشتباه است pin';
                break;
            case 'No Sufficient Funds':$out = 'موجودی به اندازه کافی در حساب شما نیست';
                break;
            case 'Issuer Down Slm':$out = 'سیستم کارت بنک صادر کننده فعال نیست';
                break;
            case 'TME Error':$out = 'خطا در شبکه بانکی';
                break;
            case 'Exceeds Withdrawal Amount Limit':$out = 'مبلغ بیش از سقف برداشت است';
                break;
            case 'Transaction Cannot Be Completed':$out = 'امکان سند خوردن وجود ندارد';
                break;
            case 'Allowable PIN Tries Exceeded Pick Up':$out = 'رمز کارت 3 مرتبه اشتباه وارد شده کارت شما غیر فعال اخواهد شد';
                break;
            case 'Response Received Too Late':$out = 'تراکنش در شبکه بانکی تایم اوت خورده';
                break;
            case 'Suspected Fraud Pick Up':$out = 'اشتباه وارد شده cvv2 ویا ExpDate فیلدهای';
                break;
            case '-1':$out = 'خطای داخلی شبکه';
                break;
            case '-2':$out = 'سپرده ها برابر نیستند';
                break;
            case '-3':$out = 'ورودی ها حاوی کاراکترهای غیر مجاز میباشد';
                break;
            case '-4':$out = 'کلمه عبور یا کد فروشنده اشتباه است';
                break;
            case '-5':$out = 'خطای بانک اطلاعاتی';
                break;
            case '-6':$out = 'سند قبلا برگشت کامل خورده';
                break;
            case '-7':$out = 'رسید دیجیتالی تهی است';
                break;
            case '-8':$out = 'طول ورودی ها بیشتر از حد مجاز است';
                break;
            case '-9':$out = 'وجود کارکترهای غیر مجاز در مبلغ برگشتی';
                break;
            case '-10':$out = 'رسید دیجیتالی حاوی کارکترهای غیر مجاز است';
                break;
            case '-11':$out = 'طول ورودی ها کمتر از حد مجاز است';
                break;
            case '-12':$out = 'مبلغ برگشتی منفی است';
                break;
            case '-13':$out = 'مبلغ برگشتی برای برگشت جزیی بیش از مبلغ برگشت نخورده رسید دیجیتالی است';
                break;
            case '-14':$out = 'چنین تراکنشی تعریف نشده است';
                break;
            case '-15':$out = 'مبلغ برگشتی به صورت اعشاری داده شده';
                break;
            case '-16':$out = 'خطای داخلی سیستم';
                break;
            case '-17':$out = 'برگشت زدن تراکنشی که با کارت بانکی غیر از بانک سامان انجام شده';
                break;
            case '-18':$out = 'فروشنده نامعتبر است ip address';
                break;
        }
        return $out;
    }
    public function check_tref_correct($money_form, $id, $money_bank)
    {
        $sql = "SELECT `fee` FROM `edu_class_taeen` WHERE `id`=" . $id;
        $res = mysql_query($sql);
        $row = mysql_fetch_object($res);
        $fee_main = $row->fee;
        //print $money_bank.$fee_main;
        if ($money_bank == $fee_main) {
            return true;
        } else {
            return false;
        }
    }
}