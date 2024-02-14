<?php
require 'config.php';

// Verifies user login authenticity
if(empty($_SESSION["user_id"])){
    header("Location: Feature login reg/signinup.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- External CSS file -->
    <link rel="stylesheet" type="text/css" href="index.css">

    <title>Library System</title>
</head>
<body>
    <!-- Navigation bar -->
    <div class="navbar">
        <span style="cursor: pointer;" onclick="window.location.href='index.php'">Library System</span>
        <a href="logout.php">Log out</a>
    </div>

    <!-- Features gallery -->
    <div class="responsive">
        
        <div class="feature">
            <a href="Feature login reg/user.php">
                <img src="Resource/1.jpg" alt="LIBRARY STAFF">
                <div class="desc">LIBRARY STAFF</div>
            </a>           
        </div>

        <div class="feature">
            <a href="Feature books reg/books.php">
                <img src="Resource/2.jpg" alt="BOOKS">
                <div class="desc">BOOKS</div>
            </a>           
        </div>

        <div class="feature">
            <a href="Feature category reg/category.php">
                <img src="Resource/3.jpg" alt="BOOK CATEGORY">
                <div class="desc">BOOK CATEGORY</div>
            </a>           
        </div>

        <div class="feature">
            <a href="Feature member/member.php">
                <img src="Resource/4.jpg" alt="LIBRARY MEMBERS">
                <div class="desc">LIBRARY MEMBERS</div>
            </a>           
        </div>

        <div class="feature">
            <a href="Feature book borrow/bookBorrow.php">
                <img src="Resource/5.jpg" alt="BOOKS BORROW">
                <div class="desc">BOOK BORROW</div>
            </a>           
        </div>

        <div class="feature">
            <a href="Feature assign fine/fine.php">
                <img src="Resource/6.jpg" alt="FINES">
                <div class="desc">FINES</div>
            </a>           
        </div>

    </div>
</body>
</html>