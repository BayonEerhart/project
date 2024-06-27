<?php 
 
include "connect.php";
include "logic.php";

$stmt = $pdo->prepare("SELECT * FROM `data` WHERE `id` = ?;");
$stmt->execute([$_GET["id"]]);
$data = $stmt->fetch();
if ((user($pdo, "id") != 1)) {
    $stmt = $pdo->prepare("UPDATE data SET views = views + 1 WHERE id = ?;");
    $stmt->execute([$data['id']]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>planes</title>
    <style>
    .custom-img {
      width: 75%; /* Default width for larger screens */
    }

    @media (max-width: 576px) {
      .custom-img {
        width: 100%; /* Full width on small screens */
      }
    }
  </style>
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
    <div class="container-fluid p-0 d-block d-md-none">
        <picture>
            <source srcset="uploads/<?= pathinfo($data['image_id'], PATHINFO_FILENAME) ?>.webp" type="image/webp">
            <img loading="lazy" src="uploads/<?= $data['image_id'] ?>" class="img-fluid" alt="<?= htmlspecialchars($data['name_plane'], ENT_QUOTES) ?>">
        </picture>
    </div>
    
    <div class="d-flex ">
        <div class="w-75 custom-container d-none d-md-block" >

            <picture >
                <source srcset="uploads/<?= pathinfo($data['image_id'], PATHINFO_FILENAME) ?>.webp" type="image/webp">
                <img loading="lazy" src="uploads/<?= $data['image_id'] ?>" class="img-fluid img-thumbnail" alt="<?= htmlspecialchars($data['name_plane'], ENT_QUOTES) ?>">
            </picture>
        </div>
        <div class="p-2 flex-fill">
            <div>
                <p>uploaded by <?= id_name($pdo, $data["user_id"])?></p>
                <p>views : <?= $data["views"] + 1?></p>
                <p>plane : <?= $data["name_plane"]?></p>
                <p>upload date : <?= $data["entry_date"]?></p>
            </div>
            <div>

            </div>
        </div>
    </div>   
    <div>
        <?php for ($i = 1; $i <= 4; $i++):?>
            <h2> <?= $data["title_textarea_$i"]?></h2>
            <p> <?= $data["textarea_$i"]?></p>
        <?php endfor;?>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>