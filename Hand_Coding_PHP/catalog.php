<?php
ob_start();
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    ob_end_clean();
    header("Location: index.php"); // Go back to sign-in page if not logged in
    exit();
}

@include('my_functions.php');
define('TITLE', 'Product Details');
define("PAGE_SIZE", 2);
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
    $catid_get = $_GET['cat_ID'];
    $db = connect_db();

    //Display left bar
    $query = "SELECT * FROM categories WHERE ID = {$_GET['cat_ID']}";
    $result = mysqli_query($db, $query);


    if (!$result) {
        die("Error executing sql: $query<br>\n" . mysqli_error($db) . "</body></html>");
    }

    if ($result && $row = mysqli_fetch_array($result)) {
        $cat_id = $row['ID'];
        $cat_title = $row['cat_title'];
        $catalog_desc = $row['catalog_details'];
        ?>

            <?php
            print "<h1>$cat_title</h1>";
            print "<p>$catalog_desc";
            if ($_SESSION['user'] == "admin") {
                echo<<<END
                                     <input type="button" onclick="showAddProductWindow($catid_get)" value="Add Product" id="showAdd_bt"/></p>
END;
            }
        }

        //get total pages from mysql procedure
        /*
          begin
          set @strsqlcount=concat('select CEIL(count(1)/',_pagesize,') as pagecount from ',_table,_condition);
          prepare stmtsqlcount from @strsqlcount;
          execute stmtsqlcount;
          deallocate prepare stmtsqlcount;
          end
         */
        $query = "CALL `count_pages`(" . PAGE_SIZE . ",'products', ' WHERE cat_id = {$cat_id} '); ";

        $result = mysqli_query($db, $query);

        if ($result && $row = mysqli_fetch_array($result)) {
            $TotalPage = $row['pagecount'];
            //print $TotalPage;
        }
        close_db($db);

        //print pagination buttons

        print "<ul class=\"pagination\">";
        for ($x = 1; $x <= $TotalPage; $x++) {
            echo "<li><a href=\"catalog.php?cat_ID={$cat_id}&CurrentPage={$x}\">$x</a></li>";
        }
        echo " </ul>";
        ?>



        <ul id = "catalist">
        <?php
        // Display products list

        /* Mysql Procedure for Pagination -- Built in Mysql database Routines

          $query = "
          DROP PROCEDURE IF EXISTS `pagination_output_1`;"; // Must seperate from the following create script
          mysqli_query($db, $query);

          $query = "
          CREATE DEFINER=`root`@`localhost`
          PROCEDURE `pagination_output_1`(
          IN `_pagecurrent` INT,
          IN `_pagesize` INT,
          IN `_where` VARCHAR(100),
          IN `_order` VARCHAR(100),
          IN `__output` VARCHAR(200))
          NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
          BEGIN

          if _pagesize<=1 then set _pagesize=3; end if; if _pagecurrent >3 then set _pagecurrent = 1; end if;

          set @strsql = concat('select ',__output,' from ',_where,' ',_order,' limit ',_pagecurrent*_pagesize-_pagesize,',',_pagesize);
          prepare stmtsql from @strsql;
          execute stmtsql;
          deallocate prepare stmtsql;
          END
          ";
          mysqli_query($db, $query);
         */

        $db = connect_db();

        /* not work when together
          $query = "SET @p0='2'; SET @p1='3'; SET @p2='products'; SET @p3='order by ID'; SET @p4=' * '; "
          . "CALL `pagination_output`(@p0, @p1, @p2, @p3, @p4); ";

         */

        $currentpage = $_GET['CurrentPage'];

        if ($TotalPage > 0) {
            if ($currentpage > $TotalPage) {
                $currentpage = $TotalPage;
            } elseif ($currentpage < 1) {
                $currentpage = 1;
            }

            $query = "CALL `pagination_output`({$currentpage}, " . PAGE_SIZE . " , 'products', ' order by ID ', ' * ', ' WHERE cat_id = {$cat_id} '); ";

            $result = mysqli_query($db, $query);

            if (!$result) {
                die("Error executing sql: $query<br>\n" . mysqli_error($db) . "</body></html>");
            }

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <li>
                        <div class = "cata_text">
                            <h3><?php echo $row['product_title']; ?></h3>
                    <?php
                    if ($_SESSION['user'] == "admin") {
                        echo<<<END
                                                        <input type="button" onclick="showDeleteConfirm($row[ID])" value="Delete" />
                                                        <input type="button" onclick="getProductDetails($row[ID])" value="Update" />
END;
                    }
                    ?>

                            <p><?php echo $row['product_desc']; ?></p>
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
    }
    close_db($db);
}

?>

    </ul>

</div>


        <?php
        include('templates/adminForm.php');
        include('templates/footer.php');
