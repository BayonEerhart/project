<?php

include "../connect.php";

 

if (isset($_POST["name"])  && isset($_POST["password"])  && isset($_POST["password2"]) && isset($_POST["email"])) {
    if  (!($_POST["password"]  == $_POST["password2"])) {
        header("location:../index.php?fail=!samepassword");
        exit();
    }
    
    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $token = base64_encode($_POST["name"]) . "." . base64_encode(time()) . "." .  hash_hmac('sha256', $hashed_password, 'secret');


    $stmt = $pdo->prepare("INSERT INTO user (name, email, pass, sudo, token) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST["name"], $_POST["email"], $hashed_password, 0, $token]);
    setcookie("token", $token, time() + (86400 * 30), "/");

    header("location:../index.php");
    exit();
} else {
    header("location:../index.php?fail=!filledin");
    exit();
}