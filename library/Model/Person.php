<?php
namespace App\Model;

class Person extends Model
{
    public function list_fld(): array
    {
        $q = $this->DB->prepare("DESCRIBE person_info");
        $q->execute();
        $table_fields = $q->fetchAll();

        return $table_fields;
    }

    public function show(int $id ): void
    {
        $fld = $this->list_fld();
        $stmt= $this->DB->prepare("select * from person_info where  id_per = :id");
        $stmt->execute(['id'=>$id]);
        $data=$stmt->fetch();
        foreach($fld as $column)
        {
            $filed=$column['Field'];
            $data[$filed] == '0000-00-00' ? $real_value = '' :$real_value = $data[$filed];
            $this->$filed = $real_value;
        }
    }


    public function is_access($menu, $person) //ok

    {
        if ($menu != '') {
            $sql = $this->DB->prepare("SELECT `id` FROM `p_menu_option` WHERE `url` LIKE '" . $menu . "'");
            $num = mysql_num_rows($sql);
            if ($num == 0) {
                $i = 0;
                $permision_sum = 0;
                $center_list = '0';
                $ar_per = array();
                $sql_submenu = $this->DB->prepare("SELECT `parent` FROM `p_menu_sub` WHERE `url` ='" . $menu . "'");
                $row_parent = mysql_fetch_object($sql_submenu);
                $id = $row_parent->parent;
                if ($id != '') {
                    $sql_permision = $this->DB->prepare("SELECT `permision`,`center` FROM `p_person_access` WHERE `permision` > 0 AND `person` =" . $person . " AND `menu` =" . $id);
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
                $sql_permision = $this->DB->prepare("SELECT `permision`,`center` FROM `p_person_access` WHERE `permision` > 0 AND `person` =" . $person . " AND `menu` =" . $id);
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
        $sql1 = $this->DB->prepare("SELECT * FROM `basic_center` ORDER BY `basic_center`.`name_b_center` ASC ");
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
        $sql = $this->DB->prepare("SELECT `name` FROM `p_center` WHERE `id` =" . $id);
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
        $res = $this->DB->prepare($sql);
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

        $res = $this->DB->prepare($sql);
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

        $res = $this->DB->prepare($sql);
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

        $res = $this->DB->prepare($sql);
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