<?php 
 
include "connect.php";
include "logic.php";




if (!isset($_GET["id"])){
    header("Location: error-pages/404.html"); 
    exit();
}
    
$stmt = $pdo->prepare("SELECT * FROM `data` WHERE `id` = ?;");
$stmt->execute([$_GET["id"]]);
$data = $stmt->fetch();
if (!isset($data["id"])){
    header("Location: error-pages/404.html"); 
    exit();

}
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
    <link rel="stylesheet" href="style.css">
    <title>planes</title>
     <script defer src="functions.js"></script>
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
            <div class="ustom-container d-none d-md-block">
                <p>uploaded by <?= id_name($pdo, $data["user_id"])?></p>
                <p>views : <?= $data["views"] + 1?></p>
                <p>plane : <?= $data["name_plane"]?></p>
                <p>upload date : <?= $data["entry_date"]?></p>
  
                <form  onsubmit="likez(event, 'liked', <?=$data['id']?>, <?=user($pdo, 'id')?>)">
                    <button  id="likes" type="submit" class="btn btn-success">likes : <?= $data["likes"]?></button>
                </form>
                <form  onsubmit="likez(event, 'disliked', <?=$data['id']?>, <?=user($pdo, 'id')?>)">
                    <button id="dislikes" type="submit" class="btn btn-danger">dislikes : <?= $data["dislike"]?></button>
                </form>
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


<div>
    <?php if (easlyacces($pdo)):?>
        <p class="bg-success">not yet</p>
        <form id="command-form" onsubmit="commands(event, <?=$data['id']?>, <?=user($pdo, 'id')?>)">
            <textarea name="text" id="command" class="form-control" placeholder="Leave a comment here" rows="3" maxlength="800"></textarea>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <p class="bg-success"></p>

            <?php 
            $stmt = $pdo->prepare("SELECT * FROM `commands` WHERE `image_id` = ?;");
            $stmt->execute([$_GET["id"]]);
            $data = $stmt->fetchall();
            foreach ($data as $id => $value):
            ?>
        <p>
            <img id="profile-pic" class="img-thumbnail " src="<?= pfp(1) ?>" alt="pfp">
            <h5><?= id_name($pdo, $value["user_id"])?></h5>
            <p><?= $value["textarea"];?></p>
        </div>
            <?php endforeach ?>
    <?php elseif (isset($_COOKIE["token"])):?>
        <p class="bg-danger">not yet</p>
    <?php else: ?>
        <div class="d-flex  justify-content-center">
            <h2 class="bg-danger">to see all the comands u need to be logged in</h2>
        </div>
        <div class="d-flex  justify-content-center ">
                <form id="loginForm" onsubmit="login(event)">
                    <div class="mb-3">
                        <label for="name" class="form-label">name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">password</label>
                        <input type="password"  class="form-control" id="password" name="password" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">login</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new" disabled>register</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif?>
</div>

<div class="modal " id="fail" tabindex="1" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content shake-element">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="add">fail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex">
                <p id="error-output"></p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>