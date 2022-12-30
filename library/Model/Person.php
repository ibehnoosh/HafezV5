<?php
namespace App\Model;

class Person extends Model
{
    private function list_fld() :array
    {
        $sm = $this->DB->getSchemaManager();
        $columns=  $sm->listTableColumns("person_info");
        return $columns;
    }
    private function createProperties():void
    {
        $fld = $this->list_fld();
        foreach($fld as $column)
        {
            $filed=$column->getName();
            $this->{$filed};
        }
    }
    public function show(int $id ): void
    {
        $fld = $this->list_fld();
        $queryBuilder = $this->DB->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('person_info')
            ->where('id_per = ?')
            ->setParameter(0, $id);
        $data=$queryBuilder->fetchAssociative();

        foreach($fld as $column)
        {
            $filed=$column->getName();
            $data[$filed] == '0000-00-00' ? $real_value = '' :$real_value = $data[$filed];
            $this->{$filed} = $real_value;
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