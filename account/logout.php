<?php


if (isset($_COOKIE["token"])) {
    setcookie("token", "", -(86400 * 30), "/");
    echo json_encode(['success' => true]);
}
exit();


?>