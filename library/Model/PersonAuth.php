<?php

namespace App\Model;



class PersonAuth extends Model
{
    public function showMenu(int $id, string $url): string

    {
        $class='';$output='';

        $sql=<<<SQL
            SELECT `p_menu_group`.`id`,`p_menu_group`.`name`,`icon`
            FROM `p_person_access`, `p_menu_option`,`p_menu_group`
            WHERE `person` = ?
              AND `permision`>0
              AND `p_menu_option`.`id`=`p_person_access`.`menu`
              AND `p_menu_option`.`group`=`p_menu_group`.`id`
            GROUP BY `p_menu_group`.`id`
            ORDER BY `p_menu_group`.`order` ASC
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
                        WHERE `person` = :person
                        AND `permision`>0
                        AND `group`= :group 
                        AND `p_menu_option`.`id`=`p_person_access`.`menu` ORDER BY `order`
                SQL;
        $stmtUrl = $this->DB->prepare($sql);
        $stmtUrl->execute(['person'=> $person, ':group'=> $group]);
        $dataUrl=$stmtUrl->fetchAll(\PDO::FETCH_OBJ);
        foreach ($dataUrl as $row) {
                ($url == $row->url) ?? $class='active open';

            $output.=<<<HTML
                            <li class="nav-item {$class}">
                            <a href="index.php?screen={$row->url}" class="nav-link ">
                            <span class="">{$row->name}</span>
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
            $sql="SELECT `id` FROM `p_menu_option` WHERE `url` like :menu";
            $stmt= $this->DB->prepare($sql);
            $stmt->execute(['menu'=>$menu]);
            $res=$stmt->fetch(\PDO::FETCH_OBJ);
            if ($res && $res->id == 0) {
                $i = 0;
                $permision_sum = 0;
                $center_list = '0';
                $ar_per = array();
                $sql_submenu="SELECT `parent` FROM `p_menu_sub` WHERE `url` like ?";
                $stmt_submenu= $this->DB->prepare($sql_submenu);
                $stmt_submenu->execute([$menu]);
                $row_parent=$stmt_submenu->fetch(\PDO::FETCH_OBJ);
                if ($row_parent) {
                    $sql_permision="SELECT `permision`,`center` FROM `p_person_access` WHERE `permision` > 0 AND `person` =: person AND `menu` = :menu";
                    $stmt_permision= $this->DB->prepare($sql_permision);
                    $stmt_permision->execute(['menu'=>$menu,'person'=>$person]);
                    $row_permision=$stmt->fetch(\PDO::FETCH_OBJ);
                    foreach ($row_permision as $row ) {
                        $ar_per[$i][0] = $center = $row->center;
                        $ar_per[$i][1] = $permision = $row->permision;
                        $i++;
                        $permision_sum += $permision;
                        $center_list .= ',' . $center;
                    }
                }
                else {
                    $permision = 0;
                }

            } else
            {
                $i = 0;
                $permision_sum = 0;
                $center_list = '0';
                $ar_per = array();
                $id = $res->id ?? 0;
                $sql_permision="SELECT `permision`,`center` FROM `p_person_access` WHERE `permision` > 0 AND `person` = :person AND `menu` = :menu";
                $stmt_permision= $this->DB->prepare($sql_permision);
                $stmt_permision->execute(['menu'=>$id,'person'=>$person]);
                $row_permision=$stmt_permision->fetchAll(\PDO::FETCH_OBJ);
                foreach ($row_permision as $row ) {

                    $ar_per[$i][0] = $center = $row->center;
                    $ar_per[$i][1] = $permision = $row->permision;
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