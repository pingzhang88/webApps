<?php
session_start();
@include('my_functions.php');

$db = connect_db();
$pid = $_POST['pid'];
$query = "DELETE FROM products WHERE ID='$pid'";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Error executing sql: $query" . mysqli_error($db));
}

close_db($db);
?>
