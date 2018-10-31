<?php
ob_start();
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    ob_end_clean();
    header("Location: index.php"); // Go back to sign in page if not logged in
    exit();
}
@include('templates/header.php');
define('TITLE', 'Contact Us');
?>
<div id = "content_1">

    <div id = "forms_contact">
        <h2><?php echo TITLE; ?></h2>                
        <strong>Email:</strong>
        <p>contact_us@atlanticsoutheastxray.com</p>
        <strong>Mailing Address:</strong>
        <p>P.O. Box 654321 Athens,123456 U.S</p>
        <strong>Telephone:</strong>
        <p>Toll Free: 800-123-456789</p>
        <p>International: 1-000-123-4567</p>
        <strong>FAX:</strong>
        <p>1-000-123-4567</p>

        <?php
        include('templates/company_info.php');

        include('templates/footer.php');
        ?>
