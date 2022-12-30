<link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet"
    type="text/css" />
<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet"
    type="text/css" />
<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript">
</script>
<script src="../assets/pages/scripts/table-datatables-buttons.js" type="text/javascript"></script>
<div class="page-content">
    <div class="tiles">
        <?php
//$notification = new notification;
//print $notification->show($_SESSION[PREFIXOFSESS . 'idp']);
?>
    </div>
    <div class="note note-info">
        <h4 class="block">برنامه کلاسی امروز موسسه</h4>
    </div>
    <div class="note note-warning">مشاهده برنامه کامل سه مرکز در نوبت صبح <a href="../../morning.php"
            class="btn yellow-crusta" target="_blank">کلیک</a> و بعد از ظهر <a href="../../afternone.php"
            class="btn yellow-crusta" target="_blank">کلیک</a></div>
    <?php

if (($per->level > 0) && ($per->level < 3)) {
    $today = date("y-m-d");

    $tmpstartDate = new DateTime($today);
    $tmpstartDate->modify('-3 day');
    $date_2_day = $tmpstartDate->format('Y-m-d');

    $Converter = new Converter;
    list($year, $month, $day) = preg_split('/-/', $date_2_day);
    $g2j = $Converter->GregorianToJalali($year, $month, $day);
    if ($g2j[1] < 10) {
        $m2 = '0' . $g2j[1];
    } else {
        $m2 = $g2j[1];
    }

    if ($g2j[2] < 10) {
        $ddd = '0' . $g2j[2];
    } else {
        $ddd = $g2j[2];
    }

    $date2dayes = $g2j[0] . "/" . $m2 . "/" . $ddd;

    $sql = "UPDATE `edu_class_days`
		SET `lock`=1 , `lock_date`=NOW()
		WHERE `date` <='" . $date2dayes . "' AND `lock` IS NULL AND `comfirm` >0 AND `comfirm1`>0";
    mysql_query($sql);
}

mysql_query("UPDATE `edu_class_days` SET `statuse`='0' WHERE `statuse`=''");
?>
    <div class="tabbable-line">
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="#tab_1" data-toggle="tab"> مرکز پسرانه - صبح</a></li>
            <li><a href="#tab_2" data-toggle="tab"> مرکز پسرانه - بعد از ظهر</a> </li>
            <li><a href="#tab_3" data-toggle="tab"> مرکز دخترانه - صبح </a></li>
            <li><a href="#tab_4" data-toggle="tab"> مرکز دخترانه - بعد از ظهر </a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">برنامه های امروز در مرکز پسرانه -
                                <?=$date_persian?> (صبح) </span>
                        </div>
                        <div class="tools"> </div>
                    </div>

                    <div class="portlet-bodyز greenز">
                        <table class="table table-striped table-bordered table-hover sample_1">
                            <?php
$tr_row = '';
$sql_60 = "SELECT distinct  `time`
FROM `edu_class_days`,`edu_class`
WHERE `date` LIKE '" . $date_persian . "' AND `time` <= '12:59'  AND `class`=`id_e_class` AND `id_e_center`=1
ORDER BY `edu_class_days`.`time` ASC";
$res = mysql_query($sql_60);
$one_array = array();
$one_count = array();
$k = 0;
while ($r = mysql_fetch_object($res)) {
    $g = 0;
    $th .= '<th colspan="4">' . $r->time . '</th>';
    $td .= '<th>#</th><th>استاد</th><th>نوع</th><th>محل</th>';
    $sql2_60 = "SELECT
	`type`, `date`, `time`, `locat`,`code_e_class`,`family_mas`,`name_mas`,`name_e_level`,`comment`,`delay`
	FROM `edu_class_days`,`edu_class`,`master_info`,`edu_level`
	WHERE `date` LIKE '" . $date_persian . "' AND `class`=`id_e_class` AND `id_e_center`=1
	AND `master`=`master_info`.`id_mas` AND `time`='" . $r->time . "'
	AND `edu_level`.`id_e_level`=`edu_class`.`id_e_level`
	ORDER BY `locat`,`code_e_class` ASC";
    $res2 = mysql_query($sql2_60);
    while ($r2 = mysql_fetch_object($res2)) {
        $g++;
        $one = '<td class="success">' . $g . '</td>
				<td>' . $r2->family_mas . ' ' . $r2->name_mas . ' <b>' . $r2->name_e_level . ' - ' . $r2->code_e_class . '</b></td>
				<td>' . $r2->type . '</td><td>' . $r2->locat . '</td>';
        $one_array[$k][$g] = $one;
    }
    array_push($one_count, $g);
    $k++;
}
$max_a = max($one_count);
for ($aa = 0; $aa <= $max_a; $aa++) {
    $td_row = '';
    for ($bb = 0; $bb < $k; $bb++) {
        if (is_null($one_array[$bb][$aa])) {
            $td_row .= '<td></td><td></td><td></td><td></td>';
        } else {
            $td_row .= $one_array[$bb][$aa];
        }

    }
    $tr_row .= '<tr>' . $td_row . '</tr>';
}
print '<thead><tr>' . $th . '</tr><tr>' . $td . '</tr></thead>';
print '<tbody>' . $tr_row . '</tbody>';
?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_2">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">برنامه های امروز در مرکز پسرانه -
                                <?=$date_persian?> (بعد از ظهر) </span>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body green">
                        <table class="table table-striped table-bordered table-hover sample_1">
                            <?php
$tr_row = '';
$th = '';
$td = '';
$sql_60 = "SELECT distinct  `time`
FROM `edu_class_days`,`edu_class`
WHERE `date` LIKE '" . $date_persian . "' AND `time` > '12:59'  AND `class`=`id_e_class` AND `id_e_center`=1
ORDER BY `edu_class_days`.`time` ASC";
$res = mysql_query($sql_60);
$one_array = array();
$one_count = array();
$k = 0;
while ($r = mysql_fetch_object($res)) {
    $g = 0;
    $th .= '<th colspan="4">' . $r->time . '</th>';
    $td .= '<th>#</th><th>استاد</th><th>نوع</th><th>محل</th>';
    $sql2_60 = "SELECT
	`type`, `date`, `time`, `locat`,`code_e_class`,`family_mas`,`name_mas`,`name_e_level`,`comment`,`delay`
	FROM `edu_class_days`,`edu_class`,`master_info`,`edu_level`
	WHERE `date` LIKE '" . $date_persian . "' AND `class`=`id_e_class` AND `id_e_center`=1
	AND `master`=`master_info`.`id_mas` AND `time`='" . $r->time . "'
	AND `edu_level`.`id_e_level`=`edu_class`.`id_e_level`
	ORDER BY `locat`,`code_e_class` ASC";
    $res2 = mysql_query($sql2_60);
    while ($r2 = mysql_fetch_object($res2)) {
        $g++;
        $one = '<td class="success">' . $g . '</td>
				<td>' . $r2->family_mas . ' ' . $r2->name_mas . ' <b>' . $r2->name_e_level . ' - ' . $r2->code_e_class . '</b></td>
				<td>' . $r2->type . '</td><td>' . $r2->locat . '</td>';
        $one_array[$k][$g] = $one;
    }
    array_push($one_count, $g);
    $k++;
}
$max_a = max($one_count);
for ($aa = 0; $aa <= $max_a; $aa++) {
    $td_row = '';
    for ($bb = 0; $bb < $k; $bb++) {
        if (is_null($one_array[$bb][$aa])) {
            $td_row .= '<td></td><td></td><td></td><td></td>';
        } else {
            $td_row .= $one_array[$bb][$aa];
        }

    }
    $tr_row .= '<tr>' . $td_row . '</tr>';
}
print '<thead><tr>' . $th . '</tr><tr>' . $td . '</tr></thead>';
print '<tbody>' . $tr_row . '</tbody>';
?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_3">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">برنامه های امروز در مرکز دخترانه -
                                <?=$date_persian?> (صبح) </span>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body green">
                        <table class="table table-striped table-bordered table-hover sample_1">
                            <?php
$tr_row = '';
$th = '';
$td = '';
$sql_60 = "SELECT distinct  `time`
FROM `edu_class_days`,`edu_class`
WHERE `date` LIKE '" . $date_persian . "' AND `time` <= '12:59'  AND `class`=`id_e_class` AND `id_e_center`=2
ORDER BY `edu_class_days`.`time` ASC";
$res = mysql_query($sql_60);
$one_array = array();
$one_count = array();
$k = 0;
while ($r = mysql_fetch_object($res)) {
    $g = 0;
    $th .= '<th colspan="4">' . $r->time . '</th>';
    $td .= '<th>#</th><th>استاد</th><th>نوع</th><th>محل</th>';
    $sql2_60 = "SELECT
	`type`, `date`, `time`, `locat`,`code_e_class`,`family_mas`,`name_mas`,`name_e_level`,`comment`,`delay`
	FROM `edu_class_days`,`edu_class`,`master_info`,`edu_level`
	WHERE `date` LIKE '" . $date_persian . "' AND `class`=`id_e_class` AND `id_e_center`=2
	AND `master`=`master_info`.`id_mas` AND `time`='" . $r->time . "'
	AND `edu_level`.`id_e_level`=`edu_class`.`id_e_level`
	ORDER BY `locat`,`code_e_class` ASC";
    $res2 = mysql_query($sql2_60);
    while ($r2 = mysql_fetch_object($res2)) {
        $g++;
        $one = '<td class="success">' . $g . '</td>
				<td>' . $r2->family_mas . ' ' . $r2->name_mas . ' <b>' . $r2->name_e_level . ' - ' . $r2->code_e_class . '</b></td>
				<td>' . $r2->type . '</td><td>' . $r2->locat . '</td>';
        $one_array[$k][$g] = $one;
    }
    array_push($one_count, $g);
    $k++;
}
$max_a = max($one_count);
for ($aa = 0; $aa <= $max_a; $aa++) {
    $td_row = '';
    for ($bb = 0; $bb < $k; $bb++) {
        if (is_null($one_array[$bb][$aa])) {
            $td_row .= '<td></td><td></td><td></td><td></td>';
        } else {
            $td_row .= $one_array[$bb][$aa];
        }

    }
    $tr_row .= '<tr>' . $td_row . '</tr>';
}
print '<thead><tr>' . $th . '</tr><tr>' . $td . '</tr></thead>';
print '<tbody>' . $tr_row . '</tbody>';
?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_4">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">برنامه های امروز در مرکز دخترانه -
                                <?=$date_persian?> (بعد از ظهر) </span>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body green">
                        <table class="table table-striped table-bordered table-hover sample_1">
                            <?php
$tr_row = '';
$th = '';
$td = '';
$sql_60 = "SELECT distinct  `time`
FROM `edu_class_days`,`edu_class`
WHERE `date` LIKE '" . $date_persian . "' AND `time` > '12:59'  AND `class`=`id_e_class` AND `id_e_center`=2
ORDER BY `edu_class_days`.`time` ASC";
$res = mysql_query($sql_60);
$one_array = array();
$one_count = array();
$k = 0;
while ($r = mysql_fetch_object($res)) {
    $g = 0;
    $th .= '<th colspan="4">' . $r->time . '</th>';
    $td .= '<th>#</th><th>استاد</th><th>نوع</th><th>محل</th>';
    $sql2_60 = "SELECT
	`type`, `date`, `time`, `locat`,`code_e_class`,`family_mas`,`name_mas`,`name_e_level`,`comment`,`delay`
	FROM `edu_class_days`,`edu_class`,`master_info`,`edu_level`
	WHERE `date` LIKE '" . $date_persian . "' AND `class`=`id_e_class` AND `id_e_center`=2
	AND `master`=`master_info`.`id_mas` AND `time`='" . $r->time . "'
	AND `edu_level`.`id_e_level`=`edu_class`.`id_e_level`
	ORDER BY `locat`,`code_e_class` ASC";
    $res2 = mysql_query($sql2_60);
    while ($r2 = mysql_fetch_object($res2)) {
        $g++;
        $one = '<td class="success">' . $g . '</td>
				<td>' . $r2->family_mas . ' ' . $r2->name_mas . ' <b>' . $r2->name_e_level . ' - ' . $r2->code_e_class . '</b></td>
				<td>' . $r2->type . '</td><td>' . $r2->locat . '</td>';
        $one_array[$k][$g] = $one;
    }
    array_push($one_count, $g);
    $k++;
}
$max_a = max($one_count);
for ($aa = 0; $aa <= $max_a; $aa++) {
    $td_row = '';
    for ($bb = 0; $bb < $k; $bb++) {
        if (is_null($one_array[$bb][$aa])) {
            $td_row .= '<td></td><td></td><td></td><td></td>';
        } else {
            $td_row .= $one_array[$bb][$aa];
        }

    }
    $tr_row .= '<tr>' . $td_row . '</tr>';
}
print '<thead><tr>' . $th . '</tr><tr>' . $td . '</tr></thead>';
print '<tbody>' . $tr_row . '</tbody>';
?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>