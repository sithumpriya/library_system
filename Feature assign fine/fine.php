<?php
    require '../config.php';

    // Verifies user login authenticity
    if(empty($_SESSION["user_id"])){
        header("Location: Feature login reg/signinup.php");
    } else {
        $fineResult = "SELECT * FROM fine INNER JOIN member ON fine.member_id = member.member_id INNER JOIN book ON fine.book_id = book.book_id";
        $fineRows = $conn->query($fineResult);
    }

    if(!empty($_SESSION['invalidFine'])) {
        if((time()-$_SESSION['invalidFine'])>5) {
            unset($_SESSION['invalidFine']);
        }
    }
    if(!empty($_SESSION['fineSaveSuccess'])) {
        if((time()-$_SESSION['fineSaveSuccess'])>5) {
            unset($_SESSION['fineSaveSuccess']);
        }
    }
    if(!empty($_SESSION['fineUpdateSuccess'])) {
        if((time()-$_SESSION['fineUpdateSuccess'])>5) {
            unset($_SESSION['fineUpdateSuccess']);
        }
    }
    if(!empty($_SESSION['invalidUpdate'])) {
        if((time()-$_SESSION['invalidUpdate'])>5) {
            unset($_SESSION['invalidUpdate']);
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

    <!-- Section Assign Fine -->
    <div class="assignFine">
        
        <!-- Alert messages -->
        <?php
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
        if (!empty($_SESSION["fineUpdateSuccess"])) { ?>
            <div class="alertSuccess">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The update has been successfully completed.
            </div>
        <?php
        }
        if (!empty($_SESSION["invalidUpdate"])) { ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The update was unsuccessful due to invalid provided details.
            </div>
        <?php
        }
        ?>
        <div class="title">Assign Fine</div>

        <!-- Details for Assign Fine -->
        <div class="container">
            <form action="assignFine.php" method="post" name="assignFine" autocomplete="off">
                <div class="row">
                    <div class="col-25">
                        <label for="fId">Fine ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="fId" name="fId" pattern="F[0-9]{3}" placeholder="Enter fine id..(FXXX)" required>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-25">
                        <label for="bId">Book ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="bId" name="bId" pattern="B[0-9]{3}" placeholder="Enter book id..(BXXX)" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="mId">Member ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="mId" name="mId" pattern="M[0-9]{3}" placeholder="Enter member id..(MXXX)" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fAmount">Fine Amount</label>
                    </div>
                    <div class="col-75">
                        <input type="number" id="fAmount" name="fAmount" min="2" max="500" placeholder="Enter fine amount.." required>
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
                    <input type="submit" value="Save" name="save">
                </div>
            </form>
        </div>
    </div>

    <!-- Section fine records -->
    <div class="fineRecords">
        <div class="title">Fine Records</div>
        
        <div style="overflow-x:auto;">
            <table>
                <tr style="background: none;">
                    <th>Fine ID</th>
                    <th>Member ID</th>
                    <th>Member Name</th>
                    <th>Book Name</th>
                    <th>Fine Amount</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
                <?php
                    while($fineRow = mysqli_fetch_assoc($fineRows)){
                ?>
                        <tr>
                            <td><?php echo $fineRow["fine_id"]; ?></td>
                            <td><?php echo $fineRow["member_id"]; ?></td>
                            <td><?php echo $fineRow["first_name"]; ?> <?php echo $fineRow["last_name"]; ?></td>
                            <td><?php echo $fineRow["book_name"]; ?></td>
                            <td><?php echo $fineRow["fine_amount"]; ?></td>
                            <td><?php echo $fineRow["fine_date_modified"]; ?></td>
                            <td>
                                <form action="fineAction.php" method="POST"><button class="editBtn" name="edit" value="<?php echo $fineRow["fine_id"]; ?>">Edit</button>
                                <button type="button" class="deleteBtn" name="delete" value="<?php echo $fineRow["fine_id"]; ?>" onclick="verifyDelete(this.value)">Delete</button></form>
                            </td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </div>

    <script>
        setInterval(myTimer, 1000);
        function myTimer() {
            const d = new Date();
            let date_time = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() + " " + d.toLocaleTimeString();
            document.getElementById("dateTime").value = date_time;
        }

        function verifyDelete(value) {
            if(confirm("Are you sure? you will not be able to revert this!")) {
                let url = 'fineAction.php?fine_id=';
                url += value;
                window.location = url;
            }
        }
    </script>
</body>
</html>