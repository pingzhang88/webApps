<?php
ob_start();
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    ob_end_clean();
    header("Location: index.php"); // Go back to sign in page if not logged in
    exit();
}

@include('my_functions.php');
define('TITLE', 'Product Categories');
@include('templates/header.php');
?>

<div id = "content_1_cat">
</div>

<div id = "content_2">
    <h2><?php echo TITLE; ?></h2>

    <ul id = "categories_big">

        <?php 
            print_category();
        ?>

    </ul>
</div>

<?php
    include('templates/footer.php');
?>
