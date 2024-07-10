<?php


include "../connect.php";

$data = json_decode(file_get_contents('php://input'), true);


if (!isset($_COOKIE["token"])) {
    echo json_encode(['success' => false, 'message' => 'u need to be logged in']);
    exit();
}


$stmt = $pdo->prepare("INSERT INTO commands (user_id, image_id, textarea) VALUES (?, ?, ?)");
$stmt->execute([$data["user_id"], $data["image_id"], $data["text"]]);





echo json_encode(['success' => true, ]);
exit();