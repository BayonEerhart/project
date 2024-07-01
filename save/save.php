<?php 
include_once "../connect.php";

set_time_limit(0); // Set maximum execution time to unlimited
ini_set('memory_limit', '-1'); // Set memory limit to unlimited

// echo  "<pre>" . var_dump($_POST) . "</pre>";

$stmt = $pdo->prepare("SELECT sudo FROM user WHERE token = ?");
$stmt->execute([$_COOKIE["token"]]);
$sudo = ($stmt->fetch())["sudo"];
if (!$sudo) {

    $stmt = $pdo->prepare("SELECT uploads FROM user WHERE token = ?");
    $stmt->execute([$_COOKIE["token"]]);
    $uploads = ($stmt->fetch()["uploads"]);
    if ($uploads >= 3) {
        header ("location:../index.php?fail=max 3 uploads do you think this is unfair and want more contact bayon.");
        exit();
    }
}

function uploadRestData($data, $name_img, $pdo){
    
    if (!isset($data["name"]) && $data["name"] != "" &&
        !isset($data["name_plane"]) && $data["name_plane"] != "" &&
        !isset($data["title_textarea_1"]) && $data["title_textarea_1"] != "" &&
        !isset($data["input1"]) && $data["input1"] != "" &&
        !isset($name_img) 
    ) {
        unlink("../uploads/" . $name_img);
        header ("location:../index.php?fail=basic values are not filled in.");
        exit();
    }
    $stmt = $pdo->prepare("SELECT id FROM user WHERE token = ?");
    $stmt->execute([$_COOKIE["token"]]);
    $user_id = ($stmt->fetch())["id"];

    $condition = "INSERT INTO data (user_id, image_id, name, name_plane, title_textarea_1, textarea_1) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$user_id, $name_img, $data["name"], $data["name_plane"], $data["title_textarea_1"], $data["input1"]];

    if (    isset($data["title_textarea_2"]) && $data["title_textarea_2"] != "" &&
        isset($data["input2"]) && $data["input2"]) {
        $condition = "INSERT INTO data (user_id, image_id, name, name_plane, title_textarea_1, textarea_1, title_textarea_2, textarea_2) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $values = [$user_id, $name_img, $data["name"], $data["name_plane"], $data["title_textarea_1"], $data["input1"], $data["title_textarea_2"], $data["input2"]];
    }
    if (    isset($data["title_textarea_3"]) && $data["title_textarea_3"] != "" &&
            isset($data["input3"]) && $data["input3"]) {
        $condition = "INSERT INTO data (user_id, image_id, name, name_plane, title_textarea_1, textarea_1, title_textarea_2, textarea_2, title_textarea_3, textarea_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $values = [$user_id, $name_img, $data["name"], $data["name_plane"], $data["title_textarea_1"], $data["input1"], $data["title_textarea_2"], $data["input2"], $data["title_textarea_3"], $data["input3"]];
    }
    if (    isset($data["title_textarea_4"]) && $data["title_textarea_4"] != "" &&
            isset($data["input4"]) && $data["input4"]) {
        $condition = "INSERT INTO data (user_id, image_id, name, name_plane, title_textarea_1, textarea_1, title_textarea_2, textarea_2, title_textarea_3, textarea_3, title_textarea_4, textarea_4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $values = [$user_id, $name_img, $data["name"], $data["name_plane"], $data["title_textarea_1"], $data["input1"], $data["title_textarea_2"], $data["input2"], $data["title_textarea_3"], $data["input3"], $data["title_textarea_4"], $data["input4"]];
    }
    $stmt = $pdo->prepare("SELECT id FROM user WHERE token = ?");
    $stmt->execute([$_COOKIE["token"]]);
    $stmt = $pdo->prepare("SELECT id FROM user WHERE token = ?");
    $stmt->execute([$_COOKIE["token"]]);
    $stmt = $pdo->prepare($condition);
    $stmt->execute($values);
    $stmt = $pdo->prepare("UPDATE user SET uploads = uploads + 1 WHERE token = ?;");
    $stmt->execute([$_COOKIE["token"]]);

    }





if (isset($data["submit"])) {
    // header  $_FILES["fileToUpload"]["error"];
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "/var/www/html/project/uploads/";
        
        $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $uniqid = uniqid('img_', true);
        $newFileName = $uniqid. '.' . $imageFileType;
        $db_name = $uniqid. '.' . "webp";
        $target_file = $target_dir . $newFileName;
                
        $uploadOk = 1;

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            header ("location:../index.php?fail=File is not an image.");
            exit();
        }

        if ($imageFileType != "jpg" && $imageFileType != "png") {
            header ("location:../index.php?fail=Sorry, only JPG and PNG files are allowed.");
            exit();
        }

        if ($uploadOk == 0) {
            header ("location:../index.php?fail=unknown error");
            exit();
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                uploadRestData($data, $db_name, $pdo);
                echo shell_exec('./../uploads/optimize_images.sh ../uploads/' . htmlspecialchars($newFileName));
                header ("location:../index.php?success=The file has been uploaded as " . htmlspecialchars($newFileName) . ".");
                exit();
            } else {
                header ("location:../index.php?fail=Sorry, there was an error uploading your file.");
                exit();
            }
        }
    } else {
        header ("location:../index.php?fail=No file was uploaded or there was an error uploading the file.");
        exit();
    }
} else {
    header ("location:../index.php?fail=Submit button was not clicked.");
    exit();
}

?>
