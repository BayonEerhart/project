<?php
include "../connect.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$plain_password = $data['password'];

$stmt = $pdo->prepare('SELECT pass, token FROM user WHERE name = ?');
$stmt->execute([$name]);
$user = $stmt->fetch();

if ($user) {
    $hashed_password = $user['pass'];
    if (password_verify($plain_password, $hashed_password)) {
        setcookie("token", $user["token"], time() + (86400 * 30), "/");

        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid password']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid username']);
    exit();
}
?>
