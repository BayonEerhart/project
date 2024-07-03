<?php

include "../connect.php";

$data = json_decode(file_get_contents('php://input'), true);


if (!isset($_COOKIE["token"])) {
    echo json_encode(['success' => false, 'message' => 'u need to be logged in']);
    exit();
}
if (isset($data["id"])) {
    
}



?>

