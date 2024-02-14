<?php
require '../config.php';

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
    <link rel="stylesheet" type="text/css" href="./books.css">

    <title>Library System</title>
</head>
<body>

    <!-- Navigation bar -->
    <div class="navbar">
        <span style="cursor: pointer;" onclick="window.location.href='../index.php'">Library System</span>
        <a href="books.php">Back</a>
    </div>

    <!-- Section my_profile -->
    <div class="userProfile">
        <div class="title">Update Book Item</div>

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

            // Edit Book Items
            if(isset($_GET['bookID']))
            {
                $bookID = mysqli_real_escape_string($conn, $_GET['bookID']);
                $query = "SELECT * FROM book INNER JOIN bookcategory ON book.category_id = bookcategory.category_id WHERE book_id='$bookID'";
                $query_run = mysqli_query($conn, $query);

                

                if (mysqli_num_rows($query_run) > 0) 
                {
                    $book = mysqli_fetch_array($query_run);

                    ?>
                        <!-- User details for update -->
                        <div class="container">
                            <form action="books_process.php" method="post" name="edit_books" autocomplete="off">
                                <div class="row">
                                    <div class="col-25">
                                        <label for="bookID">Book ID</label>
                                    </div>
                                    <div class="col-75">
                                    <input type="text" id="bookID" name="bookID" value="<?= $book["book_id"]; ?>" pattern="B[0-9]{3}" placeholder="Enter book id..(BXXX)" required>
                                    <input type="hidden" id="bookID_old" name="bookID_old" value="<?= $book["book_id"]; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="bookName">Book Name</label>
                                    </div>
                                    <div class="col-75">
                                        <input type="text" id="bookName" name="bookName" value="<?= $book["book_name"]; ?>" placeholder="Enter Book Name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-25">
                                        <label for="category_id">Category Name</label>
                                    </div>
                                    <div class="col-75">
                                    <input type="hidden" id="category_id" name="category_id" value="<?= $book["category_id"]; ?>"/>
                                    <input type="text" id="category_name" name="category_name" value="<?= $book["category_Name"]; ?>"/>
                                    </div>
                                </div>
                                
                                <!-- Buttons for save changes -->
                                <div class="row" id="button">
                                    <input type="submit" value="Save" name="update_book">
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