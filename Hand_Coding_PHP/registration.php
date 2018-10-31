<?php
ob_start();
session_start();
include('my_functions.php');

$mistake_info = false;

if ($_POST) {     // To check whether the form is submitted//
    $user = strip_tags(trim($_POST['user']));
    $password = strip_tags(trim($_POST['password']));
    $password_confirm = strip_tags(trim($_POST['password_confirm']));
    $mistake_info = register_me($user, $password, $password_confirm);  //using function to register
}

define('TITLE', 'Sign Up - Create a new Account');
include('templates/header.php');
?>
<div id = "content_1">        

    <div id = "forms">
        <?php
        if ($mistake_info) {
            print "<br />\n\t\t<p class = \"mistake_info\">" . $mistake_info . "</p>";
        } elseif (isset($_SESSION['registered']) && !empty($_SESSION['registered'])) {
            ?>
            <h3>Welcome: <strong><?php echo $_SESSION['registered']; ?></strong><br />
                Registration is successful.</h3><br />
            <p id = "sign_in_2"><a href = "index.php">sign_in</a></p>
            <?php
        } else {
            ?>

            <form class="form-horizontal" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                <fieldset>


                    <!-- Text input-->
                    <div class="control-group">
                        <label class="control-label" for="user">User Name</label>
                        <div class="controls">
                            <input id="user" name="user" type="text" placeholder="User Name" class="input-small" required="">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="control-group">
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input id="password" name="password" type="password" placeholder="Password" class="input-small" required="">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="control-group">
                        <label class="control-label" for="password_confirm">Password Confirm</label>
                        <div class="controls">
                            <input id="password_confirm" name="password_confirm" type="password" placeholder="Password Confirm" class="input-small" required="">

                        </div>
                    </div>

                    <!-- Button (Double) -->
                    <div class="control-group">
                        <label class="control-label" for="register">Actions</label>
                        <div class="controls">
                            <button id="register" name="register" class="btn btn-success">Register</button>
                            <input type="reset" class="btn btn-default">
                        </div>
                    </div>

                </fieldset>
            </form>

    <?php
}

unset($_SESSION);
$_SESSION = array();
session_destroy();

include('templates/company_info.php');

include('templates/footer.php');
