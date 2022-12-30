<?php

require '../Boot.php';
use App\Tools\Dbal;

$conn=new Dbal();

use Doctrine\DBAL\DriverManager;

$test=$conn->connect();

$sql = "SELECT * FROM person_info";
$stmt = $test->query($sql); // Simple, but has several drawbacks
while (($row = $stmt->fetchAssociative()) !== false) {
    echo $row['family_per'];
}