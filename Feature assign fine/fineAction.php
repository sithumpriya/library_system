<?php
    require '../config.php';

    if(isset($_GET['fine_id'])) {
        $fineId = $_GET['fine_id'];
        $query = "DELETE FROM fine WHERE fine_id='$fineId'";
        mysqli_query($conn,$query);

        echo "<script>history.back();</script>";
    }

    if(isset($_POST['edit'])) {
        $fineId = $_POST['edit'];
        $result = mysqli_query($conn, "SELECT * FROM fine WHERE fine_id = '$fineId'");
        $row = mysqli_fetch_assoc($result);
    }

    if(isset($_POST['updateFine'])) {
        $fineId = $_POST['fine_id'];
        $memberId = $_POST['mId'];
        $fineAmount = $_POST['fAmount'];

        date_default_timezone_set('Asia/Colombo');
        $dateTime = date("Y-m-d h:i:sa");

        // Verifies details and inserting
        $result = mysqli_query($conn, "SELECT member_id FROM member WHERE member_id = '$memberId'");

        if((mysqli_num_rows($result)>0)) {
            $query = "UPDATE fine SET member_id = '$memberId', fine_amount = '$fineAmount', fine_date_modified = '$dateTime' WHERE fine_id = '$fineId'";
            mysqli_query($conn,$query);
            $_SESSION['fineUpdateSuccess'] = time();
            header("Location: fine.php");
            die;
        } else {
            $_SESSION["invalidUpdate"] = time();
            header("Location: fine.php");
            die;
        }
        
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS file -->
    <link rel="stylesheet" type="text/css" href="fine.css">

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

        <!-- Details for Assign Fine -->
        <div class="container">
            <form action="" method="post" name="assignFine" autocomplete="off">
                <div class="row">
                    <div class="col-25">
                        <label for="fId">Fine ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="fId" name="fId" value="<?=$row['fine_id'];?>" required disabled>
                        <input type="hidden" id="fId" name="fine_id" value="<?=$row['fine_id'];?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="bId">Book ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="bId" name="bId" value="<?=$row['book_id'];?>" required disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="mId">Member ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="mId" name="mId" pattern="M[0-9]{3}" value="<?=$row['member_id'];?>" placeholder="Enter member id..(MXXX)" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fAmount">Fine Amount</label>
                    </div>
                    <div class="col-75">
                        <input type="number" id="fAmount" name="fAmount" min="2" max="500" value="<?=$row['fine_amount'];?>" placeholder="Enter fine amount.." required>
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
                    <input type="submit" value="Save" name="updateFine">
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