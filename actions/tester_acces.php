<?php

include "../connect.php";
include "../logic.php";


$stmt = $pdo->prepare("SELECT tester_token FROM testers WHERE user_id = ?");
$stmt->execute([user($pdo, "id")]);

$testers = ($stmt->fetch());

if  (isset($testers["tester_token"])){
    setcookie("tester", $testers["tester_token"], time() + (86400 * 30), "/");

} else {
    $set_tester_token_to = uniqid();
    $stmt = $pdo->prepare("INSERT INTO testers (user_id, tester_token) VALUES (?, ?)");
    $stmt->execute([user($pdo, "id"), $set_tester_token_to]);
    setcookie("tester", $set_tester_token_to, time() + (86400 * 30), "/");
}




exit();