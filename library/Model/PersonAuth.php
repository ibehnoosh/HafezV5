<?php

namespace App\Model;



class PersonAuth extends Model
{
    public function showMenu(int $id, string $url): string

    {
        $class='';$output='';

        $sql=<<<SQL
        SELECT * FROM (
            SELECT `p_menu_group`.`id`,`p_menu_group`.`name`,`icon`,`p_menu_group`.`order`
            FROM `p_person_access`, `p_menu_option`,`p_menu_group`
            WHERE `person` = ?
              AND `permision`>0
              AND `p_menu_option`.`id`=`p_person_access`.`menu`
              AND `p_menu_option`.`group`=`p_menu_group`.`id`
            GROUP BY `p_menu_group`.`id`) AS `temp`
            ORDER BY `temp`.`order`
        SQL;

        $stmt = $this->DB->executeQuery($sql , [$id]);
        $data=$stmt->fetchAllAssociative();


        foreach ($data as $row) {

            $stmtUrl= $this->DB->executeQuery("SELECT `group` FROM `p_menu_option` WHERE `url`=?",[$url]);
            $dataUrl=$stmtUrl->fetchAllAssociative();
            foreach ($dataUrl as $valUrl)
            {
                ($row['id'] == $valUrl['group']) ?? $class='active open';
            }
            $output.= <<<HTML
                            <li class="nav-item {$class}">
                            <a href="#" class="nav-link nav-toggle">
                               <i class=" {$row['icon']}"></i>
                                <span class="title">{$row['name']}</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                            HTML;
            $output.=$this->showSubmenu($row['id'], $id, $url);
            $output.= '</ul>
            </li>';
        }
        return $output;
    }

    public function showSubmenu(int $group, int $person, string $url) : string

    {
        $class=''; $output='';
        $sql=<<<SQL
                SELECT DISTINCT `name` , `url`
                        FROM  `p_person_access`, `p_menu_option`
                        WHERE `person` = ?
                        AND `permision`>0
                        AND `group`= ?
                        AND `p_menu_option`.`id`=`p_person_access`.`menu` ORDER BY `order`
                SQL;
        $stmtUrl = $this->DB->executeQuery($sql,[$person,$group]);
        $dataUrl=$stmtUrl->fetchAllAssociative();
        foreach ($dataUrl as $row) {
                ($url == $row['url']) ?? $class='active open';

            $output.=<<<HTML
                            <li class="nav-item {$class}">
                            <a href="index.php?screen={$row['url']}" class="nav-link ">
                            <span class="">{$row['name']}</span>
                            </a>
                            </li>
                            HTML;
        }
        return $output;
    }

    public function isAccess(string $menu,int $person): array{
        $permision=0;
        if(isset($menu))
        {
           $sql="SELECT `id` FROM `p_menu_option` WHERE `url` like ?";
            $stmt= $this->DB->executeQuery($sql,[$menu]);
            $res=$stmt->fetchAllAssociative();
            $id = $res['id'] ?? 0; 
            if ($id == 0) {
                $i = 0;
                $permision_sum = 0;
                $center_list = '0';
                $ar_per = array();
                $sql_submenu="SELECT `parent` FROM `p_menu_sub` WHERE `url` like ?";
                $stmt_submenu= $this->DB->executeQuery($sql_submenu,[$menu]);
                $row_parent=$stmt_submenu->fetchAssociative();
                $parent= $row_parent['parent'] ?? 0;
                if ($parent > 0) {

                    $sql_permision="SELECT `permision`,`center` FROM `p_person_access` WHERE `permision` > 0 AND `person` =? AND `menu` = ?";
                    $stmt_permision= $this->DB->executeQuery($sql_permision,[$person,$parent]);
                    $row_permision=$stmt_permision->fetchAllAssociative();
                    foreach ($row_permision as $row ) {
                        $ar_per[$i][0] = $center = $row['center'];
                        $ar_per[$i][1] = $permision = $row['permision'];
                        $i++;
                        $permision_sum += $permision;
                        $center_list .= ',' . $center;
                    }
                }
                else {
                    $permision = 0;
                }

            }
            else
            {
                $i = 0;
                $permision_sum = 0;
                $center_list = '0';
                $ar_per = array();
                $sql_permision="SELECT `permision`,`center` FROM `p_person_access` WHERE `permision` > 0 AND `person` =? AND `menu` = ?";
                $stmt_permision= $this->DB->executeQuery($sql_permision,[$person,$id]);
                $row_permision=$stmt_permision->fetchAllAssociative();

                foreach ($row_permision as $row ) {

                    $ar_per[$i][0] = $center = $row['center'];
                    $ar_per[$i][1] = $permision = $row['permision'];
                    $i++;
                    $permision_sum += $permision;
                    $center_list .= ',' . $center;
                }
            }
        }
        else {
            $permision = 0;
        }


        return $permision > 0 ? array($id, $i, $permision, $center_list, $ar_per) :  array(0, 0, 0, 0, 0);

    }

}