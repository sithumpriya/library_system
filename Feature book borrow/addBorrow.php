<?php
require '../config.php';

// Save borrow details
if(isset($_POST['save'])) {
    $brId = $_POST['brId'];
    $memberId = $_POST['mId'];
    $bookId = $_POST['bId'];
    $status = $_POST['status'];

    date_default_timezone_set("Asia/Colombo");
    $dateTime = date("Y-m-d h:i:sa");

    $query = "INSERT INTO bookborrower VALUES('$brId', '$bookId', '$memberId', '$status', '$dateTime')";
    //mysqli_query($conn, $query);
    $conn->query($query);
    $_SESSION['borrowSaveSuccess'] = time();
    header("Location: bookBorrow.php");
    die;
}