<?php
/*
 */
define('COMPANY', 'Atlantic Southeast X-Ray Co. Ltd');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>	
        <?php
        //create title and description
        if (defined('TITLE')) {
            $title = TITLE . " | " . COMPANY;
            $description = COMPANY . " is a famous company in medical X-ray industry." .
                    "This is a " . TITLE . " page";
        } else {
            $title = COMPANY;
            $description = COMPANY . " is a famous company in medical X-ray industry.";
        }
        ?>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $description; ?>" >
        <meta name="robots" content="noindex, nofollow">

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>    

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>       

        <link rel="stylesheet" type="text/css" href="images/style_bootstrap.css" />
        
        <script src="js/createrequest.js" type="text/javascript"></script>
        <script src="js/function.js"></script>  

    </head>

     <body>

          <div id="mycontainer">

               <div id="logo">
<?php
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    print
            '<p id="sign_in"><a href="index.php">sign_in</a></p>' .
            "\n\t\t" . '<p id="sign_up"><a href="registration.php"><img src="images/bg_1/button_transparent.png"></a></p>' . "\n";
} else {
    print
            '<p id="welcome"><strong>Welcome ' . $_SESSION['user'] . '</strong></p>' .
            "\n\t\t" . '<p id="log_out"><a href="logout.php"><img src="images/bg_1/button_transparent.png"></a></p>' . "\n";
}
?>
              </div>

            <div id="main">

                <div id="menu">
                    <ul>
                        <li><a href="index.php" target="_self">HOME</a></li>
                        <li><a href="categories.php" target="_self">Products</a></li>
                        <li><a href="contact.php" target="_self">Contact Us</a></li>
                    </ul>
                    <div id="search">
                        <form action="search.php" method="get">
                            <input type="search" name="search" placeholder="Search Products" size="15" />
                            <input type="submit" value="Submit" />
                        </form>
                    </div>
                </div>