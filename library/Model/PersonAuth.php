<?php

namespace App\Model;



class PersonAuth extends Model
{
    public function show_menu(int $id, string $url): string

    {
        $class='';$output='';

        $sql=<<<SQL
            SELECT `p_menu_group`.`id`,`p_menu_group`.`name`,`icon`
            FROM `p_person_access`, `p_menu_option`,`p_menu_group`
            WHERE `person` = :id
              AND `permision`>0
              AND `p_menu_option`.`id`=`p_person_access`.`menu`
              AND `p_menu_option`.`group`=`p_menu_group`.`id`
            GROUP BY `p_menu_group`.`id`
            ORDER BY `p_menu_group`.`order` ASC
        SQL;

        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $data=$stmt->fetchAll(\PDO::FETCH_OBJ);


        foreach ($data as $row) {

            $stmtUrl= $this->DB->prepare("SELECT `group` FROM `p_menu_option` WHERE `url`=:url");
            $stmtUrl->execute(['url'=> $url]);
            $dataUrl=$stmtUrl->fetchAll(\PDO::FETCH_OBJ);
            foreach ($dataUrl as $valUrl)
            {
                ($row->id == $valUrl->group) ?? $class='active open';
            }
            $output.= <<<HTML
                            <li class="nav-item {$class}">
                            <a href="#" class="nav-link nav-toggle">
                               <i class=" {$row->icon}"></i>
                                <span class="title">{$row->name}</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                            HTML;
            $output.=$this->show_submenu($row->id, $id, $url);
            $output.= '</ul>
            </li>';
        }
        return $output;
    }

    public function show_submenu(int $group, int $person, string $url) : string

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

}