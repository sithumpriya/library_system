<?php
    require '../config.php';

    if(isset($_GET['brId'])) {
        $brId = $_GET['brId'];
        $query = "DELETE FROM bookborrower WHERE borrow_id='$brId'";
        mysqli_query($conn,$query);

        echo "<script>history.back();</script>";
    }

    if(isset($_POST['edit'])) {
        $brId = $_POST['edit'];
        $result = mysqli_query($conn, "SELECT * FROM bookborrower WHERE borrow_id = '$brId'");
        $row = mysqli_fetch_assoc($result);
    }

    if(isset($_POST['updateBorrow'])) {
        $brId = $_POST['brId'];
        $memberId = $_POST['mId'];
        $status = $_POST['status'];
        $bookId = $_POST['bId'];

        date_default_timezone_set('Asia/Colombo');
        $dateTime = date("Y-m-d h:i:sa");

        $query = "UPDATE bookborrower SET member_id = '$memberId', book_id = '$bookId', borrow_status = '$status', borrower_date_modified = '$dateTime' WHERE borrow_id = '$brId'";
        mysqli_query($conn,$query);

        header("Location: bookBorrow.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS file -->
    <link rel="stylesheet" type="text/css" href="bookBorrow.css">

    <title>Library System</title>
</head>
<body>

    <!-- Navigation bar -->
    <div class="navbar">
        <span style="cursor: pointer;" onclick="window.location.href='../index.php'">Library System</span>
        <a href="../logout.php">Log out</a>
    </div>

    <!-- Section Update Fine -->
    <div class="assignFine">
        <div class="title">Update Fine</div>

        <!-- Alert messages -->
        <?php
        if (!empty($_SESSION["lastExistUpdateTime"])) { ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The entered details are already in use.
            </div>
        <?php
        }
        if (!empty($_SESSION["invalidFine"])) { ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The details provided are invalid.
            </div>
        <?php
        }
        if (!empty($_SESSION["fineSaveSuccess"])) { ?>
            <div class="alertSuccess">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The fine has been successfully assigned.
            </div>
        <?php
        }
        ?>

        <!-- Details for Assign Fine -->
        <div class="container">
            <form action="" method="post" name="assignFine" autocomplete="off">
                <div class="row">
                    <div class="col-25">
                        <label for="brId">Borrow ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="brId" name="brId" value="<?=$row['borrow_id'];?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="bId">Book ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="bId" name="bId" value="<?=$row['book_id'];?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="mmId">Member ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="mmId" name="mmId" pattern="M[0-9]{3}" value="<?=$row['member_id'];?>" disabled placeholder="Enter member id..(MXXX)" required>
                        <input type="hidden" id="mId" name="mId" pattern="M[0-9]{3}" value="<?=$row['member_id'];?>" placeholder="Enter member id..(MXXX)" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="status">Borrow Status</label>
                    </div>
                    <div class="col-75">
                        <select style="padding-left:10px;" id="status" name="status">
                            <option value="available">Available</option>
                            <option value="borrowed" selected>Borrowed</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="dateTime">Date Modified</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="dateTime" name="dateTime" disabled required>
                    </div>
                </div>

                <!-- Button for save -->
                <div class="row" id="button">
                    <input type="submit" value="Save" name="updateBorrow">
                    <input type="button" class="btnCancel" value="Cancel" onclick="history.back()">
                </div>
            </form>
        </div>
    </div>

    <script>
        setInterval(myTimer, 1000);
        function myTimer() {
            const d = new Date();
            let date_time = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() + " " + d.toLocaleTimeString();
            document.getElementById("dateTime").value = date_time;
        }
    </script>
</body>
</html>