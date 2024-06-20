<?php 
 
include "connect.php";
include "logic.php";

$stmt = $pdo->prepare("SELECT * FROM `data` WHERE `id` = ?; (8)");
$stmt->execute([$_GET["id"]]);
$data = $stmt->fetch();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>planes</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid ">
        <a class="navbar-brand" href="index.php">
            <img src="logo.png" alt="logo"  width="180" height="120">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse grid gap-0 column-gap-3" id="navbarSupportedContent">
            <?php if ($data["name"]): ?> 
                 
                <button type="button" class="btn nav-link active fs-2" data-bs-target="#login"><?=$data["name"];?></button>

            <?php endif ?>
      
        </div>
    </div>
</nav>

<div>
    <div>

        <picture>
            <source srcset="uploads/<?= pathinfo($data['image_id'], PATHINFO_FILENAME) ?>.webp" type="image/webp">
        <img loading="lazy" src="uploads/<?= $data['image_id'] ?>" class="img-fluid" alt="<?= htmlspecialchars($data['name_plane'], ENT_QUOTES) ?>">
    </picture>
    <p>uploaded by<?php     
        $stmt = $pdo->prepare("SELECT name FROM user WHERE id = ?");
        $stmt->execute([$data["user_id"]]);
        echo $stmt->fetch()["user_id"];
        ?></p>
    </div>   

</div>
    <h1>soon</h1>
    <p>place where u can see all info of the img but for now there is nothing  here</p>
</body>
</html>