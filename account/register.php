<?php

include "../connect.php";

$data = json_decode(file_get_contents('php://input'), true);
 

if (isset($data["name"])  && isset($data["password"])  && isset($data["password2"]) && isset($data["email"])) {
    if  (!($data["password"]  == $data["password2"])) {
        echo json_encode(['success' => false, 'message' => 'password is not the same']);
        exit();
    }
    
    $hashed_password = password_hash($data["password"], PASSWORD_DEFAULT);
    $token = base64_encode($data["name"]) . "." . base64_encode(time()) . "." .  hash_hmac('sha256', $hashed_password, 'secret');


    $stmt = $pdo->prepare("INSERT INTO user (name, email, pass, sudo, token) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$data[  "name"], $data["email"], $hashed_password, 0, $token]);
    setcookie("token", $token, time() + (86400 * 30), "/");

    echo json_encode(['success' => true]);
    exit();
} else {
    echo json_encode(['success' => false, 'message' => 'not all forms are filled in']);
    exit();
}