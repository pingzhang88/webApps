<?php
ob_start();
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    ob_end_clean();
    header("Location: index.php"); // Go back to sign-in page if not logged in
    exit();
}

include('my_functions.php');
define('TITLE', 'Product Search');
include('templates/header.php');
?>

<div id = "left_bar">   
    <h2><?php echo TITLE; ?></h2>
    <ul id = "categories_leftbar">
        <?php print_category(); ?>                          
    </ul>
</div>


<div id = "right_content">
    <?php
    if ($_GET) {
        $search_str = strip_tags(trim($_GET['search']));

        if (!validate_search_str($search_str)) {
            echo '<p class = "mistake_info">Please enter a valid search string</p>';
        } else {
            $db = connect_db();
            $query = "SELECT * FROM products WHERE product_title LIKE '%$search_str%' OR product_desc LIKE '%$search_str%' ORDER BY ID ASC LIMIT 3";
            $result = mysqli_query($db, $query);

            if (!$result) {
                die("<p class = 'mistake_info'>Error executing sql: $query<br>\n" . mysqli_error($db) . "</p>");
            } elseif (mysqli_num_rows($result) == 0) {
                print '<p class = "mistake_info">Sorry, there is no results, please try another term.</p>';
            }


            echo<<<END
                                            <h3>Result for search term <span class='search_markup'>'{$search_str}'</span></h3>
                                            <ul id ="catalist_search">
END;

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <li>
                    <div class = "cata_text">
                        <h3><?php echo markup_searched_term($search_str, $row['product_title']); ?></h3>
                <?php
                if ($_SESSION['user'] == "admin") {
                    echo<<<END
                                                                <input type="button" onclick="showDeleteConfirm($row[ID])" value="Delete" />
                                                                <input type="button" onclick="getProductDetails($row[ID])" value="Update" />
END;
                }
                ?>

                        <p><?php echo markup_searched_term($search_str, $row['product_desc']); ?></p>
                        <ul class = "features">
                            <li><?php echo $row['feature_1']; ?></li>
                            <li><?php echo $row['feature_2']; ?></li>
                            <li><?php echo $row['feature_3']; ?></li>
                        </ul> 
                    </div>

                    <div class = "cata_img">
                        <img src = "images/products/<?php echo $row['image_name']; ?>.jpg" height = "160px" max alt = "<?php echo $row['product_title']; ?>"/>
                    </div>
                </li>
        <?php
        }
        print "</ul>";
        close_db($db);
    }
}
?>
</ul>         
</div>


    <?php
    include('templates/adminForm.php');
    include('templates/footer.php');