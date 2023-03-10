<?php
require '../Boot.php';
$HTML = require '../Lang/general.php';
$ERROR= require '../Lang/error.php';

use App\Tools\Date;
use App\Tools\logger;
use App\Model\Person;
use App\Model\PersonAuth;
use View\Person\index;
use \View\General\Error;
$dateOb=new Date();

/*
require_once "../library/login/makeSecure_person.php";
*/
$_SESSION[PREFIXOFSESS . 'idp']=1;
$person = new Person();
$person->show($_SESSION[PREFIXOFSESS . 'idp']);

$personAuth=new PersonAuth();

$logg = new logger();

$access = true;

$myIp= $_SERVER['REMOTE_ADDR'];
$_SERVER['REQUEST_URI'] ? $pageLoad = $_SERVER['REQUEST_URI'] :  $pageLoad = 'index';
$_SESSION[PREFIXOFSESS . 'year_term'] = $_SESSION[PREFIXOFSESS . 'year_term'] ?? $dateOb->thisYear();



if (isset($_REQUEST['screen'])) {
    if (isset($_REQUEST['gol'])) {
        $menu_to_show = $_REQUEST['screen'] . '&gol=' . $_REQUEST['gol'];
    } else {
        $menu_to_show = $_REQUEST['screen'];
    }

    $url = $_REQUEST['screen'];
    list($menuId, $numOfI, $permision, $centerList, $ar_per) = $personAuth->isAccess($menu_to_show, $_SESSION[PREFIXOFSESS . 'idp']);
    settype($permision, 'integer');
    $_SESSION[PREFIXOFSESS . 'ar_per'] = $ar_per;
    $_SESSION[PREFIXOFSESS . 'numOfI'] = $numOfI;
    $_SESSION[PREFIXOFSESS . 'center_id'] = $centerList;
    $include = $url . ".php";
} else {
    $menu = $include = "index_default_" . PREFIXOFSESS . ".php";
    $permision = true;
    $url='';
}

?>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title><?=TITLECENTER?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?php
        print (new index())->mainIndex();
    ?>
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <input type="hidden" name="url_show" id="url_show" value="<?=$url?>">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="index.php"><?=TITLECENTER?></a>
                <div class="menu-toggler sidebar-toggler e"> </div>
            </div>
            <a href="javascript:" class="menu-toggler responsive-toggler e" data-toggle="collapse"
                data-target=".navbar-collapse"> </a>
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                            data-close-others="true">
                            <span class="username username-hide-on-mobile e"><?=$person->family_per?></span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="index.php?screen=info/setting/myinfo">
                                    <i class="icon-user"></i><?=$HTML['MyInfo']?> </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="login.php?msg=3">
                                    <i class="icon-key"></i> <?=$HTML['LogOut']?>  </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-quick-sidebar-toggler">
                        <a href="login.php?msg=3" class="dropdown-toggle">
                            <i class="icon-logout e"></i>
                        </a>
                    </li>
                    <li><a href="#"><?=$dateOb->dayWeekName() .' '. $dateOb->today() . ' | ' . date("h:i:s")?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200" style="padding-top: 20px">
                    <li class="sidebar-toggler-wrapper hide">
                        <div class="sidebar-toggler"> </div>
                    </li>
                    <li class="nav-item start">
                        <a href="index.php" class="nav-link nav-toggle">
                            <i class="icon-home"></i>
                            <span class="title"><?=$HTML['HomePage']?></span>
                        </a>
                    </li>
                    <?php print $personAuth->showMenu($_SESSION[PREFIXOFSESS . 'idp'], $url);?>
                </ul>
            </div>
        </div>
        <div class="page-content-wrapper"><div class="page-content">
            <?php
            if ($permision) {
                if(file_exists($include)){
                    include $include;
                }else {
                    print (Error::show(['title' => $ERROR['error'] , 'description'=> $ERROR['noFile']]));
                    }
            } else {
                print (Error::show(['title' => $ERROR['error'], 'description'=> $ERROR['noAddress']]));
            }
            ?>
            </div></div>
        <a href="javascript:" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>
    </div>
    <div class="page-footer">
        <div class="page-footer-inner">???????? 5.1
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
</body>
</html>