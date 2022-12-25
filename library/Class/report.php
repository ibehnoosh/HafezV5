<?php

class ReportMaster
{
    function GetParam($season, $year)
    {
        list($mainSeason, $preSeason) = $this->GetSeason($season);
        if ($season == '1')
            return array($year, $year - 1, $mainSeason, $preSeason);
        else
            return array($year, $year, $mainSeason, $preSeason);
    }

    function GetSeason($season)
    {
        switch ($season) {
            case 1:
                $mainSeason = 'بهار';
                $preSeason = 'زمستان';
                break;
            case 2:
                $mainSeason = 'تابستان';
                $preSeason = 'بهار';
                break;
            case 3:
                $mainSeason = 'پاییز';
                $preSeason = 'تابستان';
                break;
            case 4:
                $mainSeason = 'زمستان';
                $preSeason = 'پاییز';
                break;
        }
        return array($mainSeason, $preSeason);
    }

    function CountPointRegister($year, $season, $center, $master)
    {
        $sql_1 = mysql_query("SELECT COUNT(`t`.`count1`) AS `count1`
							FROM (
							SELECT DISTINCT `student_stu_reg` AS `count1`
							FROM `edu_term`,`edu_class` ,`student_register`
							WHERE 
							`year_e_term` LIKE '" . $year . "' 
							AND 
							`season_e_term` LIKE '" . $season . "' 
							AND `center_e_term` LIKE '" . $center . "'
							AND `id_e_master`='" . $master . "'
							AND `edu_term`.`id_e_term`=`edu_class` .`id_e_term`
							AND `edu_class` .`id_e_term`=`term_stu_reg`
							AND `edu_class` .`id_e_class`=`class_stu_reg`
							AND `type_stu_reg`='fix') AS `t`
							");
        $row1 = mysql_fetch_object($sql_1);
        return $row1->count1;
    }

    function CounttargetRegister($year1, $season1, $year2, $season2, $center, $master)
    {
        $sql_1 = mysql_query(
            "SELECT `stu` FROM 
                            (
                                SELECT DISTINCT `student_stu_reg` AS `stu`
                                FROM `edu_term`,`edu_class` ,`student_register`
                                WHERE `year_e_term` LIKE '" . $year2 . "' 
                                    AND `season_e_term` LIKE '" . $season2 . "' 
                                    AND `center_e_term` LIKE '" . $center . "'
                                    AND `id_e_master`='" . $master . "'
                                    AND `edu_term`.`id_e_term`=`edu_class` .`id_e_term`
                                    AND `edu_class` .`id_e_term`=`term_stu_reg`
                                    AND `edu_class` .`id_e_class`=`class_stu_reg`
                                    AND `type_stu_reg`='fix'
                            )  AS `s` 
                            , 
                            (
                                SELECT `id_e_term` AS `term`
                                FROM `edu_term`
                                WHERE `year_e_term` LIKE '" . $year1 . "' 
                                    AND `season_e_term` LIKE '" . $season1 . "' 
                                    AND `center_e_term` LIKE '" . $center . "'
                            ) AS `t`
                            ,`student_register`
                            WHERE `s`.`stu`=`student_stu_reg`
                            AND `t`.`term`=`term_stu_reg`
                            group by `stu`
                            "
        );
        $count = mysql_num_rows($sql_1);
        return $count;
    }

    function jazb($year, $season, $center, $master)
    {
        list($year1, $year2, $season1, $season2) = $this->GetParam($season, $year);

        $CountPointRegister = $this->CountPointRegister($year1, $season1, $center, $master);
        $CountPointRegister2 = $this->CountPointRegister($year2, $season2, $center, $master);
        $CounttargetRegister = $this->CounttargetRegister($year1, $season1, $year2, $season2, $center, $master);

        if ($CountPointRegister > 0 && $CounttargetRegister > 0) {
            $jazb = round(($CounttargetRegister / $CountPointRegister2), 2) * 100;
            $out = '<span class="font-red-thunderbird font-lg bold ">' . $jazb . '%</span>
            (ثبت نامی فصل مبدا: <b>' . $CountPointRegister2 . '</b>، ثبت نامی فصل مقصد: <b>' . $CountPointRegister . '</b> ، ثبت نامی مبدا در مقصد: <b>' . $CounttargetRegister . '</b>)';
        } else {
            $out = '';
        }

        return $out;
    }
    function jazb_master($year, $season, $center, $master)
    {
        list($year1, $year2, $season1, $season2) = $this->GetParam($season, $year);

        $CountPointRegister = $this->CountPointRegister($year1, $season1, $center, $master);
        $CountPointRegister2 = $this->CountPointRegister($year2, $season2, $center, $master);
        $CounttargetRegister = $this->CounttargetRegister($year1, $season1, $year2, $season2, $center, $master);

        if ($CountPointRegister > 0 && $CounttargetRegister > 0) {
            $jazb = round(($CounttargetRegister / $CountPointRegister2), 2) * 100;
            $out = '<span class="font-red-thunderbird font-lg bold ">' . $jazb . '%</span>';
        } else {
            $out = '';
        }

        return $out;
    }
}