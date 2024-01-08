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

    <title>Library System</title>
</head>
<body>

</body>
</html>