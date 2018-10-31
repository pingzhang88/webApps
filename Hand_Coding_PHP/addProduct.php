<?php
session_start();
@include('my_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//1. get the data
//2. validate
    //$pid = test_input($_POST['pid']);
    $product_title = test_input($_POST['product_title']);
    $image_name = test_input($_POST['image_name']);
    $product_desc = test_input($_POST['product_desc']);
    $cat_id = test_input($_POST['cat_id']);
    $feature_1 = test_input($_POST['feature_1']);
    $feature_2 = test_input($_POST['feature_2']);
    $feature_3 = test_input($_POST['feature_3']);
}

$db = connect_db();
$query = "SELECT * FROM products WHERE product_title = '" . $product_title . "';";

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) == 0) {
    
    // file upload
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
    }

//3. insert into db
    $query = "INSERT INTO products (product_title,image_name,product_desc,cat_id,feature_1,feature_2,feature_3) VALUES ('" . $product_title . "', '" . $image_name . "', '" . $product_desc . "', '" . $cat_id . "', '" . $feature_1 . "', '" . $feature_2 . "', '" . $feature_3 . "');";


    $result = mysqli_query($db, $query);

//4. send message back
    if ($result)
        print "ok";
    else
        print "error - " . mysqli_error($db);
}else {
    echo "The product already exists.";
}

close_db($db);
?>

