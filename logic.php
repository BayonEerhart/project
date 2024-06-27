<?php

function user($pdo, $column)
{
    if (isset($_COOKIE["token"])) {
        $allowed_columns = ['id', 'name', 'token', 'sudo', 'email', 'uploads'];
        if (!in_array($column, $allowed_columns)) {
            return null;
        }
        $stmt = $pdo->prepare("SELECT $column FROM user WHERE token = ?");
        $stmt->execute([$_COOKIE["token"]]);
        return  ($stmt->fetch())[$column];
    } else{
        return null;
    }
}

function id_name($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT name FROM user WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch()["name"];
}


?>