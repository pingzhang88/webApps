<?php
ob_start();
session_start();

unset($_SESSION);
$_SESSION = array();
session_destroy();

setcookie("theuser", "", time() - 3600);

ob_end_clean();
header('Location: index.php');
exit();