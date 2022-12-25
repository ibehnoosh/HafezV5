<?php

$stmt= $this->DB->prepare("select * from person_info where  id_per = :id");
$stmt->execute(['id'=>$id]);
$data=$stmt->fetch();
