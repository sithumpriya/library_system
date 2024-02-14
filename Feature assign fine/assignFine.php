<?php
require '../config.php';

// Save fine details
if(isset($_POST['save'])) {
    $fineId = $_POST['fId'];
    $memberId = $_POST['mId'];
    $bookId = $_POST['bId'];
    $fineAmount = $_POST['fAmount'];

    date_default_timezone_set("Asia/Colombo");
    $dateTime = date("Y-m-d h:i:sa");

    // Verifies details and inserting
    $result1 = mysqli_query($conn, "SELECT fine_id FROM fine WHERE fine_id = '$fineId'");
    $result2 = mysqli_query($conn, "SELECT member_id FROM member WHERE member_id = '$memberId'");
    $result3 = mysqli_query($conn, "SELECT book_id FROM book WHERE book_id = '$bookId'");

    if((mysqli_num_rows($result1)<1) && (mysqli_num_rows($result2)>0) && (mysqli_num_rows($result3)>0)) {
        $query = "INSERT INTO fine VALUES('$fineId', '$bookId', '$memberId', '$fineAmount', '$dateTime')";
        //mysqli_query($conn, $query);
        $conn->query($query);
        $_SESSION['fineSaveSuccess'] = time();
        header("Location: fine.php");
        die;
    } else {
        $_SESSION["invalidFine"] = time();
        header("Location: fine.php");
        die;
    }
}