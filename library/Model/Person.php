<?php
namespace App\Model;

use App\Tools\DB;

class Person
{
    private $DB;
    public function __construct()
    {
        $this->DB=new DB();
    }

    public function list_fld():array

    {
        $fld = array();
        $columns = $this->DB->listTableColumns('person_info');
        foreach ($columns as $column) {
            array_push($fld, $column->getName());
        }
        return $fld;
    }

    public function show($id) //ok

    {
      // $fld = $this->list_fld();
        $sql= 'select * from person_info where  id_per = 1';
        var_dump($this->DB);
       // $stmt=$this->DB->query($sql);
/*
        $stmt->bindValue("id", $id);
        $stmt->executeQuery();
        $row =$stmt->fetchAssociative();

        foreach ($fld as $key => $val) {
            if ($row[$val] == '0000-00-00') {
                $real_value = '';
            } else {
                $real_value = $row[$val];
            }

            $this->$val = $real_value;
        }
*/
    }

    public function show_menu($id, $url) //ok

    {
        $sql = $this->DB->query("SELECT
			`p_menu_group`.`id`,`p_menu_group`.`name`,`icon`
			FROM
			`p_person_access`, `p_menu_option`,`p_menu_group`
			 WHERE `person` = " . $id . "
			AND `permision`>0
			AND
			`p_menu_option`.`id`=`p_person_access`.`menu`
			AND
			`p_menu_option`.`group`=`p_menu_group`.`id`
			GROUP BY `p_menu_group`.`id`
			ORDER BY `p_menu_group`.`order` ASC ");
        while ($row = mysql_fetch_object($sql)) {
            $sql_active_open = $this->DB->query("SELECT `group` FROM `p_menu_option` WHERE `url`='" . $url . "'");
            $rr = mysql_fetch_object($sql_active_open);
            if ($row->id == $rr->group) {
                $clas = 'active open';
            } else {
                $clas = '';
            }

            print '
			<li class="nav-item ' . $clas . '">
                            <a href="#" class="nav-link nav-toggle">
                               <i class="' . $row->icon . '"></i>
                                <span class="title">' . $row->name . '</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">';
            $this->show_submenu($row->id, $id, $url);
            print '</ul>
            </li>';
        }
    }

    public function show_submenu($group, $person, $url) //ok

    {

        $sql = $this->DB->query("SELECT DISTINCT `name` , `url`
		FROM  `p_person_access`, `p_menu_option`
		WHERE `person` = " . $person . "
		AND `permision`>0
		AND `group`=" . $group . "
		AND `p_menu_option`.`id`=`p_person_access`.`menu` ORDER BY `order`");
        while ($row = mysql_fetch_object($sql)) {
            if ($url == $row->url) {
                $clas = 'active open';
            } else {
                $clas = '';
            }

            print '
			<li class="nav-item ' . $clas . '">
                                    <a href="index.php?screen=' . $row->url . '" class="nav-link ">
                                        <span class="">' . $row->name . '</span>
                                    </a>
                                </li>';
        }
    }

    public function is_access($menu, $person) //ok

    {
        if ($menu != '') {
            $sql = $this->DB->query("SELECT `id` FROM `p_menu_option` WHERE `url` LIKE '" . $menu . "'");
            $num = mysql_num_rows($sql);
            if ($num == 0) {
                $i = 0;
                $permision_sum = 0;
                $center_list = '0';
                $ar_per = array();
                $sql_submenu = $this->DB->query("SELECT `parent` FROM `p_menu_sub` WHERE `url` ='" . $menu . "'");
                $row_parent = mysql_fetch_object($sql_submenu);
                $id = $row_parent->parent;
                if ($id != '') {
                    $sql_permision = $this->DB->query("SELECT `permision`,`center` FROM `p_person_access` WHERE `permision` > 0 AND `person` =" . $person . " AND `menu` =" . $id);
                    while ($row = mysql_fetch_object($sql_permision)) {
                        $ar_per[$i][0] = $center = $row->center;
                        $ar_per[$i][1] = $permision = $row->permision;
                        $i++;
                        $permision_sum += $permision;
                        $center_list .= ',' . $center;
                    }
                } else {
                    $permision = 0;
                }

            } else {
                $i = 0;
                $permision_sum = 0;
                $center_list = '0';
                $ar_per = array();
                $res = mysql_fetch_object($sql);
                $id = $res->id;
                $sql_permision = $this->DB->query("SELECT `permision`,`center` FROM `p_person_access` WHERE `permision` > 0 AND `person` =" . $person . " AND `menu` =" . $id);
                while ($row = mysql_fetch_object($sql_permision)) {
                    $ar_per[$i][0] = $center = $row->center;
                    $ar_per[$i][1] = $permision = $row->permision;
                    $i++;
                    $permision_sum += $permision;
                    $center_list .= ',' . $center;
                }
            }
        } else {
            $permision = 0;
        }

        if ($permision > 0) {
            return array($id, $i, $permision, $center_list, $ar_per);
        } else {
            return array(0, 0, 0, 0, 0);
        }

    }
    public function per_of_center($arr, $value, $numofi) // با دادن ارایه و مرکز مشخص میکنیم چه پرمیشنی داره

    {
        for ($j = 0; $j <= $numofi; $j++) {
            if ($arr[$j][0] == $value) {
                return $arr[$j][1];
            }

        }
    }

    public function center_list($selected)
    {
        $sql1 = $this->DB->query("SELECT * FROM `basic_center` ORDER BY `basic_center`.`name_b_center` ASC ");
        print '<option value="all">-انتخاب-</option>';
        while ($row1 = mysql_fetch_object($sql1)) {
            if ($row1->id_b_center == $selected) {
                print '<option value="' . $row1->id_b_center . '" selected="selected">' . $row1->name_b_center . '</option>';
            } else {
                print '<option value="' . $row1->id_b_center . '">' . $row1->name_b_center . '</option>';
            }

        }
    }

    public function show_active($active)
    {
        if (($active == '0') || ($active == 'no')) {
            return '<i class="glyphicon glyphicon-remove font-red-thunderbird"></i>';
        } else {
            return '<i class="glyphicon glyphicon-ok font-green-jungle"></i>';
        }

    }

    public function witch_center($id)
    {
        $sql = $this->DB->query("SELECT `name` FROM `p_center` WHERE `id` =" . $id);
        $row = mysql_fetch_object($sql);
        return $row->name;
    }

    public function center_list_4_person($person, $menu, $selected, $permision)
    {
        if ($permision == 1) {
            $sql = "SELECT `name_b_center` AS `name`, `id_b_center` FROM `p_person_access`, `basic_center` WHERE `person` =" . $person . " AND `menu` = " . $menu . " AND `permision`>0 AND `center`=`id_b_center` ORDER BY `name_b_center`  ASC";
        } else {
            $sql = "SELECT `name_b_center` AS `name`, `id_b_center` FROM `p_person_access`, `basic_center` WHERE `person` =" . $person . " AND `menu` =  " . $menu . " AND `permision`= " . $permision . " AND `center`=`id_b_center` ORDER BY `name_b_center`  ASC";
        }

        //print $sql;
        $res = $this->DB->query($sql);
        while ($row = mysql_fetch_object($res)) {
            if ($row->id_b_center == $selected) {
                print '<option value="' . $row->id_b_center . '" selected="selected">' . $row->name . '</option>';
            } else {
                print '<option value="' . $row->id_b_center . '">' . $row->name . '</option>';
            }

        }
    }

    public function center_list_4_edit($i, $array, $selected)
    {
        $cen = '';
        for ($j = 0; $j <= $i; $j++) {
            if ($array[$j][1] == 2) {
                $cen .= ',' . $array[$j][0];
            }

        }

        $sql = "SELECT * FROM `basic_center`  WHERE `id_b_center` IN (0" . $cen . ") ";

        $res = $this->DB->query($sql);
        while ($row = mysql_fetch_object($res)) {
            if ($row->id_b_center == $selected) {
                print '<option value="' . $row->id_b_center . '" selected="selected">' . $row->name_b_center . '</option>';
            } else {
                print '<option value="' . $row->id_b_center . '">' . $row->name_b_center . '</option>';
            }

        }
    }
    public function center_list_4_show($i, $array, $selected)
    {
        $cen = '';
        for ($j = 0; $j <= $i; $j++) {
            if ($array[$j][1] > 0) {
                $cen .= ',' . $array[$j][0];
            }

        }

        $sql = "SELECT * FROM `basic_center`  WHERE `id_b_center` IN (0" . $cen . ") ";

        $res = $this->DB->query($sql);
        while ($row = mysql_fetch_object($res)) {
            if ($row->id_b_center == $selected) {
                print '<option value="' . $row->id_b_center . '" selected="selected">' . $row->name_b_center . '</option>';
            } else {
                print '<option value="' . $row->id_b_center . '">' . $row->name_b_center . '</option>';
            }

        }
    }

    public function center_4_op($menu, $user, $per)
    {
        if ($per == 2) {
            $sql = "SELECT group_concat(`center`) AS `c`  FROM `p_person_access` WHERE `permision` =" . $per . " AND `person` =" . $user . " AND `menu` = " . $menu;
        } else {
            $sql = "SELECT group_concat(`center`) AS `c`  FROM `p_person_access` WHERE `permision` > 0 AND `person` =" . $user . " AND `menu` = " . $menu;
        }

        $res = $this->DB->query($sql);
        $row = mysql_fetch_object($res);
        return $row->c;
    }

    public function show_gender($id_gender)
    {
        switch ($id_gender) {
            case 1:
                $gender_name = 'مذکر';
                break;

            case 2:
                $gender_name = 'مونث';
                break;

            default:
                $gender_name = 'مشخص نشده است';
        }
        return $gender_name;
    }
}