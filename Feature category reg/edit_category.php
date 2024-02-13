<?php
require '../config.php';
// Verifies user login authenticity
if(empty($_SESSION["user_id"])){
    header("Location: ../Feature login reg/signinup.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS file -->
    <link rel="stylesheet" type="text/css" href="../Feature login reg/user.css">
    <!-- Category CSS file -->
    <link rel="stylesheet" type="text/css" href="./category.css">

    <title>Library System</title>
</head>
<body>

    <!-- Navigation bar -->
    <div class="navbar">
        <span style="cursor: pointer;" onclick="window.location.href='../index.php'">Library System</span>
        <a href="category.php">Back</a>
    </div>

    <!-- Section my_profile -->
    <div class="userProfile">
        <div class="title">Update Category Item</div>

        <!-- display messages -->
        <?php if(isset($_SESSION['message'])): ?>

            <div class="alert" role="alert">
                <p><strong>Hey!</strong> <?= $_SESSION['message']; ?></p>
            </div>

        <?php 
            unset($_SESSION['message']);
            endif; 
        ?>

        <?php

            // Edit Category Items
            if(isset($_GET['category_id']))
            {
                $category_id = mysqli_real_escape_string($conn, $_GET['category_id']);
                $query = "SELECT * FROM bookcategory WHERE category_id='$category_id'";
                $query_run = mysqli_query($conn, $query);

                if (mysqli_num_rows($query_run) > 0) 
                {
                    $category = mysqli_fetch_array($query_run);

                    ?>
                        <!-- User details for update -->
                        <div class="container">
                            <form action="catprocess.php" method="post" name="editCategory" autocomplete="off">
                                <div class="row">
                                    <div class="col-25">
                                        <label for="categoryID">Category ID</label>
                                    </div>
                                    <div class="col-75">
                                    <input type="text" id="categoryID" name="categoryID" value="<?= $category["category_id"]; ?>" pattern="C[0-9]{3}" placeholder="Enter category id..(CXXX)" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="categoryName">Category Name</label>
                                    </div>
                                    <div class="col-75">
                                        <input type="text" id="categoryName" name="categoryName" value="<?= $category["category_Name"]; ?>" placeholder="Enter Category Name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="dateModified">Date Modified</label>
                                    </div>
                                    <div class="col-75">
                                    <input type="datetime-local" id="dateModified" name="dateModified" value="<?= $category["date_modified"]; ?>"/>
                                    </div>
                                </div>
                                
                                <!-- Buttons for save changes -->
                                <div class="row" id="button">
                                    <input type="submit" value="Save" name="update_category">
                                </div>
                            </form>
                        </div>

                    <?php
                }
                else
                {
                    echo "<h4>No Such Id Found</h4>";
                }
                
            } 

        ?>
    </div>

    
        
    
</body>
</html>
