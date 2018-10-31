<?php
session_start();

if (isset($_FILES['file'])) {
    $allowedExts = array("bmp", "gif", "jpeg", "jpg", "png");
    $allowedMimeTypes = array("image/bmp", "image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);

    // Check for image type and extension
    if (in_array($_FILES["file"]["type"], $allowedMimeTypes) && in_array($extension, $allowedExts)) {
        // Check for image size and loading errors
        if ($_FILES["file"]["size"] > 100000000) {
            echo "Error: File is too big, maximum allowed is 100 Kb<br/>";
        } else if ($_FILES["file"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"] . "<br/>";
        } else {
            /*
              echo "Upload: " . $_FILES["file"]["name"] . "<br/>";
              echo "Type: " . $_FILES["file"]["type"] . "<br/>";
              echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br/>";
              echo "Stored in: " . $_FILES["file"]["tmp_name"];
              print_r ($_FILES);
             * 
             */

            if (!file_exists("upload")) {
                mkdir("upload");
            }

            if (file_exists("upload/" . $_FILES["file"]["name"])) {
                // TODO - Ask the user to overwrite the file
                echo $_FILES["file"]["name"] . " already exists. ";
            }

            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
            //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
            $image_name = "upload/" . $_FILES["file"]["name"];
        }
    } else {
        echo 'Invalid file!';
    }
} else {
    echo "$_FILE not set";
}
