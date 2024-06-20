<?php
include "../connect.php";

$_COOKIE;

$name = $_POST['name'];
$plain_password = $_POST['password'];

$stmt = $pdo->prepare('SELECT pass FROM user WHERE name = ?');
$stmt->execute([$name]);
$user = $stmt->fetch();

if ($user) {
    $hashed_password = $user['pass'];
    if (password_verify($plain_password, $hashed_password)) {

        $stmt = $pdo->prepare('SELECT token FROM user WHERE name = ?');
        $stmt->execute([$name]);
        $user = $stmt->fetch();

        setcookie("token", $user["token"], time() + (86400 * 30), "/");

        header("location:../index.php");
        exit();
    } else {
        header("location:../index.php?fail=password");
        exit();
    }
} else {
    header("location:../index.php?fail=name");
    exit();
}

?>