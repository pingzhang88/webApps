<?php

function connect_db() {    
	
    $db_hostname = "";
    $db_name = "";
    $db_username = "";
    $db_password = "";
    

$db  = new mysqli($db_hostname, $db_username, $db_password, $db_name);

    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    return $db;
}

// CLOSE DB
function close_db($db) {
   $db->close();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//validate the user name by regExp
function validate_user($user) {
    // rules for user name: the user name entered cannot be empty, 
    // should contain only letters and digits, and must be at least 6 characters long.
    // an additionnal condition: maximum 30 characters
    $pattern_user = "/^[a-z\d]{3,30}$/i";

    if (preg_match($pattern_user, $user)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//validate the password by regExp
function validate_password($password) {
    // rules for password: the password entered cannot be empty, 
    // should contain only letters and digits, and must be at least 6 characters long.
    // additionnal condition: maximum 18 characters, 
    $pattern_password = "/^[a-z\d]{3,18}$/i";

    if (preg_match($pattern_password, $password)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function validate_login($user, $password) {
    $db = connect_db();
    $found = 0;

    // Query Database to validate user
    $query = "SELECT * FROM member WHERE user='$user'";
    $result = mysqli_query($db, $query);

    // Analyse Results
    // There should be only 1 result, username unique
    if ($result && $row = mysqli_fetch_array($result)) {
        // Re-Encrypt password from Salt in Database
        $salt = $row['salt'];
        $encrypted_pw = crypt($password, $salt);
        
//        echo "encrypted_pw: ".$encrypted_pw." recorded pass: ".$row['password']." input: ". $password;

        // Compare with encrypted password in database
        if ($encrypted_pw == $row['password']) {
            $found = 1;
        }
    }

    $db->close();

    return ($found == 1);
}

// To check if the user name already exists
function repeated_user_checker($user) {
    // Query Database to validate user
    $query = "SELECT * FROM member WHERE Username='" . $username . "'";
    $result = mysqli_query($db, $query);
    $is_repeated = TRUE;
    if (mysqli_num_rows($result) == 0) {
        $is_repeated = FALSE;
    }
    return $is_repeated;
}

// Registration 
function register_me($user, $password, $password_confirm) {
    if (!empty($user) && !empty($password) && !empty($password_confirm)) {
        if ($password == $password_confirm) {
            if (validate_user($user) == TRUE && validate_password($password) == TRUE) {
                //insert_new_user($user, $password);
                $db = connect_db();
                $query = "SELECT * FROM member WHERE user='" . $user . "'";
                $result = mysqli_query($db, $query);
                // 1 - If user doesn't exist in the database
                if (mysqli_num_rows($result) == 0) {
                    // 2 - Random salt  for remote server, using a old PHP VERSION, WHERE mcrypt_create_iv not exist
                    $salt = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);

                    // 3 - Encrypt password with salt
                    $encrypted_pw = crypt($password, $salt);

                    // 4 - Insert user in database
                    $query = "INSERT INTO member (`user`, `password`, `salt`) VALUES ('" . $user . "', '" . $encrypted_pw . "', '" . $salt . "');";
                    mysqli_query($db, $query);
                    //todo cookie to display username when redirect to login page.
                } else {
                    $mistake_info = "Failed to create user, username already taken!";
                }
                $db->close();
                $_SESSION['registered'] = $user; // must be put outside the last block
                setcookie('theuser', $user, time() + 3600 * 24);
            } else {
                $mistake_info = 'User name and password may contains <br /><br />only letters and digits, <br /><br />
					   and must be at least 6 characters long.';
            }
        } else {
            $mistake_info = "Two passwords don't match.";
        }
    } else {
        $mistake_info = 'Invalide username or password!';
    }

    return $mistake_info;
}

// To print the list of categories that the user can select from, for both categories.php and the leftbar of catalog.php
function print_category() {
    $db = connect_db();
    $query = "SELECT * FROM categories ORDER BY ID ASC";
    $result = mysqli_query($db, $query);
    if (!$result) {
    //if (mysqli_num_rows($result) == 0)
        die("Error executing sql: $query<br>\n" . mysqli_error($db) . "</body></html>");
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $catalogurl_name = str_replace(" ", "+", $row['cat_title']);
        $category_desc = "";
        $li_class = '';

        if (TITLE != 'Product Catalog' && TITLE != 'Product Search') {
            $category_desc = "<p>{$row['cat_desc']}</p>";
        } else {
            if ((isset($_GET['category'])) && $row['cat_title'] == $_GET['category'] && TITLE != 'Product Search') {
                $li_class = ' class = "get_this"';
            }
        }
        print
                '<li' . $li_class
                . '><a href = "catalog.php?cat_ID=' . $row['ID']
                . '"><img src = "images/products/' . $row['cat_name'] . '.jpg" alt = "' . $row[cat_title] . '" /></a>' .
                '<h3><a href="catalog.php?cat_ID=' . $row['ID'] . '">' . $row['cat_title'] . '</a></h3>'
                . $category_desc . '</li>' . "\n\t\t\t\t";
    }
    $db->close();
}

//validate the search string by regExp
function validate_search_str($search_str) {
    // should contain only letters, digits and space, and must be at least 6 characters long.
    $pattern_search_str = "/^[a-z\d]{1,20}([ -._][a-z\d]{1,20}){0,3}$/i";

    if (preg_match($pattern_search_str, $search_str)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// Markup searched term in the results
function markup_searched_term($search_str, $string) {
    $search_str_markup = '<span class="search_markup">' . $search_str . '</span>';
    $string_markedup = str_ireplace($search_str, $search_str_markup, $string);
    return $string_markedup;
}
