<?php
ob_start();
session_start();
@include('my_functions.php');
$mistake_info = false;
if ($_POST) {
    if (!empty($_POST['user']) && !empty($_POST['password'])) {
        $user = strip_tags(trim($_POST['user']));
        $password = strip_tags(trim($_POST['password']));

        if (validate_user($user) == TRUE && validate_password($password) == TRUE) {
            if (validate_login($user, $password) == 1) {
                $_SESSION['user'] = $user;
                $_SESSION['loggedin'] = TRUE;

                ob_end_clean();
                header('Location: categories.php');
                exit();
            } else {
                $mistake_info = "Sorry, this user name doesn't exist or the password is not correct, please check your input.";
            }
        } else {
            $mistake_info = 'User name and password may contains <br /><br />only letters and digits, <br /><br />
                   and must be at least 6 characters long.';
        }
    } else {
        $mistake_info = 'Please enter both your <br /><br />user name and password!';
    }
}

define('TITLE', 'Sign In');
include('templates/header.php');
?>

<script>
    alert("Please Log In with \nUser:admin\nPass:12345678");
</script>

<div id = "content_1">
    <div id = "forms">
        <h2><?php echo TITLE; ?></h2>
<?php
if ($mistake_info) {
    print "<br />\n\t\t<p class = \"mistake_info\">" . $mistake_info . "</p>";
} elseif ($_SESSION['loggedin']) {
    header('Location:categories.php');
} else {
    ?>
            <form class="form-horizontal" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
            <fieldset>
					
    <?php
    if (isset($_POST['user'])) {
        $theuser = $_POST['user'];
    } elseif (isset($_COOKIE['theuser'])) {
        $theuser = $_COOKIE['theuser'];
    }
    $theuser = htmlspecialchars($theuser);
    ?>
                
                   <div class="control-group">
                        <label class="control-label" for="user">User Name</label>
                        <div class="controls">
                            <input id="name" name="user" type="text" placeholder="admin" class="input-small" required="required" >
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input id="password" name="password" type="password" placeholder="12345678" class="input-small" required="required">
                        </div>
                    </div>
                
                   <div class="control-group">
                        <label class="control-label" for="register">Actions</label>
                        <div class="controls">
                            <button id="login" name="login" class="btn btn-success">Log In</button>
                            <input type="reset" class="btn btn-default">
                        </div>
                    </div>
                </fieldset>
            </form>
            <?php
        }
        include('templates/company_info_0.php');
        include('templates/footer.php');

