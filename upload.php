<?php
header('Access-Control-Allow-Origin: *');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// echo $target_file;
$err_msg = "";

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $err_msg = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $err_msg = "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $err_msg = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $err_msg = "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $err_msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $err_msg = "Sorry, your file was not uploaded.";
    $list = array('status' => false, 'message' => $err_msg);
	echo json_encode($list);
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $list = array('status' => true, 'message' => 'Photo Uploaded Successfully.');
	    echo json_encode($list);
    } else {
        // echo "Sorry, there was an error uploading your file.";
        $list = array('status' => false, 'message' => $err_msg);
	    echo json_encode($list);
    }
}
?>
