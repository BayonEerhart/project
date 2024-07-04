<?php

include "../connect.php";

$data = json_decode(file_get_contents('php://input'), true);


if (!isset($_COOKIE["token"])) {
    echo json_encode(['success' => false, 'message' => 'u need to be logged in']);
    exit();
}


$stmt = $pdo->prepare("SELECT id FROM `likes` WHERE `user_id` = ? AND `image_id` = ?;");

$stmt->execute([$data["user_id"], $data["id"]]);
$prev = $stmt->fetchColumn();

if (!$prev) {
    if ($data["info"] == "liked"){
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, image_id, liked, disliked) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data["user_id"], $data["id"], 1, 0]);
        $stmt = $pdo->prepare("UPDATE data SET likes = likes + 1 WHERE id = ?;");
        $stmt->execute([$data["id"]]);
    }
    if ($data["info"] == "disliked"){
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, image_id, liked, disliked) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data["user_id"], $data["id"], 0, 1]);
        $stmt = $pdo->prepare("UPDATE data SET dislike = dislike + 1 WHERE id = ?;");
        $stmt->execute([$data["id"]]);
    }
} else {

    if ($data["info"] == "liked"){
        $stmt = $pdo->prepare("SELECT liked FROM `likes` WHERE `user_id` = ? AND `image_id` = ?;");
        $stmt->execute([$data["user_id"], $data["id"]]);
        $prev = $stmt->fetchColumn();
        if($prev == 0) {
            $stmt = $pdo->prepare("UPDATE likes SET liked= 1, disliked=0 WHERE `user_id` = ? AND `image_id` = ?;");
            $stmt->execute([$data["user_id"], $data["id"]]);
            $stmt = $pdo->prepare("UPDATE data SET likes = likes + 1 WHERE id = ?;");
            $stmt->execute([$data["id"]]);
            $stmt = $pdo->prepare("UPDATE data SET dislike = dislike - 1 WHERE id = ?;");
            $stmt->execute([$data["id"]]);
        }
    
    }
    if ($data["info"] == "disliked"){
        $stmt = $pdo->prepare("SELECT liked FROM `likes` WHERE `user_id` = ? AND `image_id` = ?;");
        $stmt->execute([$data["user_id"], $data["id"]]);
        $prev = $stmt->fetchColumn();
        if($prev == 1) {
            $stmt = $pdo->prepare("UPDATE likes SET liked = 0, disliked=1 WHERE `user_id` = ? AND `image_id` = ?;");
            $stmt->execute([$data["user_id"], $data["id"]]);
            $stmt = $pdo->prepare("UPDATE data SET dislike = dislike + 1 WHERE id = ?;");
            $stmt->execute([$data["id"]]);
            $stmt = $pdo->prepare("UPDATE data SET likes = likes - 1 WHERE id = ?;");
            $stmt->execute([$data["id"]]);
        }
    
    }

}

    
echo json_encode(['success' => true]);
exit();


