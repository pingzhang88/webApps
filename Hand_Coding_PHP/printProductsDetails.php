<?php
session_start();
@include('my_functions.php');

if (isset($_GET['id'])) {

    $db = connect_db();
    $query = "SELECT * FROM products WHERE ID = {$_GET['id']}";

    $result = mysqli_query($db, $query);
    if ($result && $row = mysqli_fetch_array($result)) {
        ?>
        {
        "pid" : "<?php print preg_replace("/\r|\n/", " ", $row['ID']); ?>",
        "product_title" : "<?php print preg_replace("/\r|\n/", " ", $row['product_title']); ?>",
        "image_name" : "<?php print preg_replace("/\r|\n/", " ", $row['image_name']); ?>",
        "product_desc" : "<?php print preg_replace("/\r|\n/", " ", $row['product_desc']); ?>",
        "cat_id" : "<?php print preg_replace("/\r|\n/", " ", $row['cat_id']); ?>",
        "feature_1" : "<?php print preg_replace("/\r|\n/", " ", $row['feature_1']); ?>",
        "feature_2" : "<?php print preg_replace("/\r|\n/", " ", $row['feature_2']); ?>",
        "feature_3" : "<?php print $feature_3 = preg_replace("/\r|\n/", " ", $row['feature_3']);
        ?>"
        }

        <?php
    } else {
        ?>
        {
        "pid" : "error_no_result",
        "product_title" : "error_no_result",
        "image_name" : "error_no_result",
        "product_desc" : "error_no_result",
        "cat_id" : "error_no_result",
        "feature_1" : "error_no_result",
        "feature_2" : "error_no_result",
        "feature_3" : "error_no_result"
        }
        <?php
    }
    close_db($db);
} else {
    ?>
    {
    "pid" : "error",
    "product_title" : "error",
    "image_name" : "error",
    "product_desc" : "error",
    "cat_id" : "error",
    "feature_1" : "error",
    "feature_2" : "error",
    "feature_3" : "error"
    }
    <?php
}
