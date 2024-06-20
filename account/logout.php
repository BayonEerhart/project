<?php


if (isset($_COOKIE["token"])) {
    setcookie("token", "", -(86400 * 30), "/");
    header("location:../index.php");
}


?>