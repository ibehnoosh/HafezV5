<?php


$sql="SELECT `id` FROM `p_menu_option` WHERE `url` like :menu";
$stmt= $this->DB->prepare($sql);
$stmt->execute(['menu'=>$menu]);
// $data=$stmt->fetchAll(\PDO::FETCH_OBJ);
$num = $stmt->fetchColumn();
