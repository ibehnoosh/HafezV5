<?php session_start(); 

include("../load.php");
include("../library/login/mylogin.php");

if(isset($_REQUEST['msg'])&&($_REQUEST['msg']=='3')){
    $loginSys = new login();
    $loginSys->logout();
}

if (isset($_POST['Submit'])) {
    $check = 1;
    if ($check) {
        if ((!$_POST['Username']) || (!$_POST['Password'])) {
            header('location: login.php?msg=1');
            exit;
        }

        $log = new login();
        $rerult_login = $log->dologin($_POST['Username'], $_POST['Password']);

        if ($rerult_login) {
            header('location: index.php');
        } else {
            header('location: login.php?msg=2');
            exit;
        }
    } else {
        header('location: login.php?msg=4');
        exit;
    }
}

function showMessage($id)
{
    $messeage='';
    switch ($id) {
        case 1:
            $messeage = 'لطفا تمامی فیلد ها را پر نمایید';
            break;

        case 2:
            $messeage = 'اطلاعات وارد شده توسط شما نادرست می باشد';
            break;

        case 3:
            $messeage = 'با موفقیت از سیستم خارج شده اید.';
            break;

        case 4:
            $messeage = 'مجوز ورود به سیستم را ندارید.';
            break;
    }
    print $messeage;
}
?>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8" />
    <title><?=TITLECENTER?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap/css/bootstrap-rtl.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="../assets/global/css/components-rtl.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="../assets/global/css/plugins-rtl.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->

    <link href="../assets/pages/css/login-5-rtl.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../assets/layouts/layout/fonts/fonts-fa.css">
    <link rel="stylesheet" type="text/css" href="../assets/layouts/layout/css/custom-rtl.css">
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->

<body class=" login">
    <!-- BEGIN : LOGIN PAGE 5-1 -->
    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 bs-reset">
                <div class="login-bg" style="background-image:url(../assets/pages/img/login/bg1.jpg)">
                    <img class="login-logo" src="../assets/pages/img/login/logo.png" />
                </div>
            </div>
            <div class="col-md-6 login-container bs-reset">
                <div class="login-content">
                    <h1 class="font-yellow-gold">ورود به سیستم آموزش</h1>
                    <p class="bg-yellow-crusta bg-font-yellow-crusta" style="padding:10px;">
                        <?php
                        isset($_REQUEST['msg']) ? showMessage($_REQUEST['msg']) : print '';
                        ?>
                    </p>
                    <form action="login.php" class="login-form" method="post">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span>نام کاربری و کلمه عبور خود را وارد نمایید.</span>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="نام کاربری" name="Username" required />
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="کلمه عبور" name="Password" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="forgot-password pull-left">
                                    <a href="javascript:;" id="forget-password" class="forget-password">کلمه عبور خود را فراموش کردید؟</a>
                                </div>
                                <input type="hidden" name="Submit" value="yes">
                                <button name="Submit" class="btn yellow-gold" type="submit">ورود</button>
                            </div>
                        </div>
                    </form>
                    <!-- BEGIN FORGOT PASSWORD FORM -->
                    <form class="forget-form" action="javascript:;" method="post">
                        <h3 class="font-green">کلمه عبور خود را فراموش کردید؟</h3>
                        <p> پست الکترونیکی خود را وارد نمایید تا رمز عبور برای شما ارسال گردد. </p>
                        <div class="form-group">
                            <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Email" name="email" />
                        </div>
                        <div class="form-actions">
                            <button type="button" id="back-btn" class="btn grey btn-default">برگشت</button>
                            <button type="submit" class="btn yellow-gold btn-success uppercase pull-right">ارسال</button>
                        </div>
                    </form>
                    <!-- END FORGOT PASSWORD FORM -->
                </div>
                <div class="login-footer">
                    <div class="row bs-reset">
                        <div class="col-xs-5 bs-reset">
                            <ul class="login-social">
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-dribbble"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-7 bs-reset">
                            <div class="login-copyright text-right">
                                <p>حقوق مادی و معنوی متعلق به موسسه زبان حافظ میباشد.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END : LOGIN PAGE 5-1 -->
    <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../assets/pages/scripts/login-5.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>