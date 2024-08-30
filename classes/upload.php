<?php 

class upload 
{
    //data needs img and target file 
    function upload_img($data) 
    {

        if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
            
            $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
            $uniqid = uniqid('img_', true);
            $newFileName = $uniqid. '.' . $imageFileType;
            $db_name = $uniqid. '.' . "webp";
            $target_file = $data["target_dir"] . $newFileName;
                            
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check == false) {
                return ("location:../index.php?fail=File is not an image.");
            }
            if ($imageFileType != "jpg" && $imageFileType != "png") {
                return ("location:../index.php?fail=Sorry, only JPG and PNG files are allowed.");
            }        
      
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // uploadRestData($data, $db_name, $pdo);
                echo shell_exec('./../uploads/optimize_images.sh ../uploads/' . htmlspecialchars($newFileName));
                return ("location:../index.php?success=The file has been uploaded as " . htmlspecialchars($newFileName) . ".");
            } else {
                return ("location:../index.php?fail=Sorry, there was an error uploading your file.");
            }
        } else {
            return ("location:../index.php?fail=No file was uploaded or there was an error uploading the file.");
        }
    }
}
