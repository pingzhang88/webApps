<?php

session_start();
@include('my_functions.php');

$db = connect_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//1. get the data
//2. validate
    $pid = test_input($_POST['pid']);
    $product_title = test_input($_POST['product_title']);
    $image_name = test_input($_POST['image_name']);
    $product_desc = test_input($_POST['product_desc']);
    $cat_id = test_input($_POST['cat_id']);
    $feature_1 = test_input($_POST['feature_1']);
    $feature_2 = test_input($_POST['feature_2']);
    $feature_3 = test_input($_POST['feature_3']);
}

//3. insert into db
$query = "update products SET "
        . "product_title='$product_title',"
        . "image_name='$image_name',"
        . "product_desc='$product_desc',"
        . "cat_id='$cat_id',"
        . "feature_1='$feature_1',"
        . "feature_2='$feature_2',"
        . "feature_3='$feature_3' "
        . "WHERE ID='$pid';";
$result = mysqli_query($db, $query);

//4. send message back
if ($result)
    print "ok";
else
    print "error - " . mysqli_error($db);

close_db($db);


