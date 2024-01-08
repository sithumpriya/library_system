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
            <a href="">
                <img src="Resource/1.jpg" alt="Library staff">
                <div class="desc">Library staff</div>
            </a>           
        </div>

    </div>
</body>
</html>