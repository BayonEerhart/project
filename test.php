<?php 


include "connect.php";


$stmt = $pdo->prepare("SELECT likes, dislike  FROM `data` WHERE `id` = ?;");
$stmt->execute([$data["id"]]);
$push = $stmt->fetch();

echo var_dump($push["dislike"]);
