<?php

$host = '127.0.0.1';
// $db = 'Plane Spotter Storage';
$db ="Plane Spotter Storage";
$user = 'dbperson';           # vul hier uw database user in
$pass = '%o!Tr!LxRLfZ8cQV4%FVHNlSI$XQ2tqur';           # vul hier uw database wachtword in
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);

?>  