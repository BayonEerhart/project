<?php
// header("location:../");
include "connect.php";
include "logic.php";

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>planes</title>
    <link rel="stylesheet" href="style.css">
    <script src="functions.js"></script>
</head>
<body class="">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid ">
        <a class="navbar-brand" href="#">
            <img src="logo.png" alt="logo"  width="180" height="120">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse grid gap-0 column-gap-3" id="navbarSupportedContent">
            <?php if (!isset($_COOKIE["token"])): ?> 

                <button type="button" class="btn nav-link active fs-2" data-bs-toggle="modal" data-bs-target="#login">login</button>
            <?php else: ?>
                
                <button type="button" class="btn nav-link active fs-2 " data-bs-toggle="modal" data-bs-target="#profiel">welcome <?= user($pdo, "name")?></button>
                <button type="button" class="btn nav-link active fs-2 " data-bs-toggle="modal" data-bs-target="#upload">upload</button>

            <?php endif ?>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
            <!-- <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
        </div>
    </div>
</nav>



<div class="d-flex justify-content-evenly gap-4 flex-wrap">
    <?php 
        $stmt = $pdo->prepare("SELECT * FROM data ORDER BY RAND() LIMIT 20;");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($data as $load_id => $value) : 
        if (!($value["id"] == 8)) {?>

            <a href="image-page.php?id=<?=$value["id"]?>">
                <div class="card" style="width: 18rem;">
                    <picture>
                        <source srcset="uploads/<?= pathinfo($value['image_id'], PATHINFO_FILENAME) ?>.webp" type="image/webp">
                        <img loading="lazy" src="uploads/<?= $value['image_id'] ?>" class="card-img-top" alt="<?= htmlspecialchars($value['name_plane'], ENT_QUOTES) ?>">
                    </picture>
                    <div class="card-body">
                        <h3 class="card-title"><?= htmlspecialchars($value['name_plane'], ENT_QUOTES) ?></h3>
                    </div>
                </div>
            </a>

        <?php } endforeach; ?>
</div>




<div id="displayon" style="display: none;">
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" onsubmit="login(event)">
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">login</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new">register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="new" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" onsubmit="register(event)">
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password2" class="form-label">repeat password</label>
                            <input type="password" class="form-control" id="password2" name="password2" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <button type="submit" class="btn btn-primary">register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="profiel" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">profiel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex">
                    <?php if (isset($_COOKIE["token"])): ?> 
                    
                        <img src="image/<?= user($pdo, "id")?>.jpeg"  width = "200" height = "200" class="object-fit-cover border rounded" alt="profiel" >
                        <div>
                            <table>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>name</td>
                                    <td>:</td>
                                    <td><?=user($pdo, "name")?></td>
                                </tr>
                                <tr>
                                    <td>email</td>
                                    <td>:</td>
                                    <td><?=user($pdo, "email")?></td>
                                </tr>
                                <tr>
                                    <td>id</td>
                                    <td>:</td>
                                    <td><?=user($pdo, "id")?></td>
                                </tr>
                                <tr>
                                    <td>sudo</td>
                                    <td>:</td>
                                    <td><?=user($pdo, "sudo")?></td>
                                </tr>
                                <tr>
                                    <td>uploads</td>
                                    <td>:</td>
                                    <td><?=user($pdo, "uploads")?></td>
                                </tr>
                            </table>
                        <form action="account/logout.php" method="post">
                            <button type="submit" class="btn btn-primary">logout</button>
                        </form>
                        </div>
                    <?php endif ?>
                </div>

            </div>
        </div>
    </div>


    <div class="modal " id="fail" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog ">
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

    <div class="modal " id="success" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-success ">
                    <h5 class="modal-title" id="add">success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex">
                    <p id="error-output"></p>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="upload" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add">upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="save/save.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Image</label>
                            <input class="form-control" type="file" id="fileToUpload" name="fileToUpload" required>
                        </div>
                        <div id="" class="mb-3">
                            <label for="name" class="form-label">title :</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="100" required>
                        </div>
                        <div id="" class="mb-3">
                            <label for="name_plane" class="form-label">plane model :</label>
                            <input type="text" class="form-control" id="name_plane" name="name_plane" maxlength="100" required>
                            
                        </div>
                        <div class="mb-3">
                            <label for="title_textarea_1" class="form-label">title textarea 1</label>
                            <input type="text" class="form-control" id="title_textarea_1" name="title_textarea_1" maxlength="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="input1" class="form-label">text area 1 :</label>
                            <textarea class="form-control" id="input1" name="input1"  rows="4" cols="50" maxlength="800" required></textarea>
                        </div>
                        <div class="mb-3" style="display: none;"  id="Tinv2">
                            <label for="title_textarea_2" class="form-label">title textarea 2</label>
                            <input type="text" class="form-control" id="title_textarea_2" name="title_textarea_2" maxlength="100">
                        </div>
                        <div class="mb-3" style="display: none;"  id="inv2" >
                            <label for="input2" class="form-label">text area 2 :</label>
                            <textarea class="form-control" id="input2" name="input2"  rows="4" cols="50" maxlength="800" >x</textarea>
                        </div>
                        <div class="mb-3" style="display: none;"  id="Tinv3">
                            <label for="title_textarea_3" class="form-label">title textarea 3</label>
                            <input type="text" class="form-control" id="title_textarea_3" name="title_textarea_3" maxlength="100">
                        </div>
                        <div class="mb-3" style="display: none;"  id="inv3" >
                            <label for="input3" class="form-label">text area 3 :</label>
                            <textarea class="form-control" id="input3" name="input3"  rows="4" cols="50" maxlength="800" >x</textarea>
                        </div>
                        <div class="mb-3" style="display: none;"  id="Tinv4">
                            <label for="title_textarea_4" class="form-label">title textarea 4</label>
                            <input type="text" class="form-control" id="title_textarea_4" name="title_textarea_4" maxlength="100">
                        </div>
                        <div class="mb-3" style="display: none;" id="inv4">
                            <label for="input4" class="form-label">text area 4 :</label>
                            <textarea class="form-control" id="input4" name="input4"  rows="4" cols="50" maxlength="800">x</textarea>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" id="addBox">add box</button>
                            <button type="button" style="display: contents;" class="btn btn-primary" id="removeBox" disabled>remove box</button>
                            <input type="submit" value="Upload" class="btn btn-primary" name="submit">
                        </div>
                        <div style="display: none;">
                            <input type="text" class="form-control" id="value" name="value"  required value="1">

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="script.js" ></script>


<?php if (isset($_GET["fail"])): ?>
<script>
    let myModal = new bootstrap.Modal(document.getElementById('fail'));
    myModal.show();
    document.getElementById("error-output").innerHTML = "<?= $_GET["fail"]?>";
    history.pushState({}, "", "index.php");
</script>
<?php endif ?>
<?php if (isset($_GET["success"])): ?>
<script>
    let Modalsucces = new bootstrap.Modal(document.getElementById('success'));
    Modalsucces.show();
    console.log("kek")
    document.getElementById("error-output").innerHTML = "<?= $_GET["success"]?>";
    history.pushState({}, "", "index.php");
</script>
<?php endif ?>

</body>
</html>







