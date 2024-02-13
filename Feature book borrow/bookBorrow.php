<?php
    require '../config.php';

    // Verifies user login authenticity
    if(empty($_SESSION["user_id"])){
        header("Location: Feature login reg/signinup.php");
    } else {
        $vorrowResult = "SELECT * FROM bookborrower INNER JOIN member ON bookborrower.member_id = member.member_id INNER JOIN book ON bookborrower.book_id = book.book_id";
        $borrowRows = $conn->query($vorrowResult);
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

    <!-- Section Assign Fine -->
    <div class="assignFine">
        <div class="title">Add Borrow Details</div>

        <!-- Details for Assign Fine -->
        <div class="container">
            <form action="addBorrow.php" method="post" name="assignFine" autocomplete="off">
                <div class="row">
                    <div class="col-25">
                        <label for="brId">Borrow ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="brId" name="brId" pattern="BR[0-9]{3}" placeholder="Enter borrow id..(BRXXX)" required>
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
                        <label for="status">Borrow Status</label>
                    </div>
                    <div class="col-75">
                        <select style="padding-left:10px;" id="status" name="status">
                            <option value="available">Available</option>
                            <option value="borrowed">Borrowed</option>
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
                    <th>Book ID</th>
                    <th>Member name</th>
                    <th>Book Name</th>
                    <th>Borrow Status</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
                <?php
                    while($borrowRow = mysqli_fetch_assoc($borrowRows)){
                ?>
                        <tr>
                            <td><?php echo $borrowRow["book_id"]; ?></td>                            
                            <td><?php echo $borrowRow["first_name"]; ?> <?php echo $borrowRow["last_name"]; ?></td>
                            <td><?php echo $borrowRow["book_name"]; ?></td>
                            <td><?php echo $borrowRow["borrow_status"]; ?></td>
                            <td><?php echo $borrowRow["borrower_date_modified"]; ?></td>
                            <td>
                                <form action="borrowAction.php" method="POST"><button class="editBtn" name="edit" value="<?php echo $borrowRow["borrow_id"]; ?>">Edit</button>
                                <button type="button" class="deleteBtn" name="delete" value="<?php echo $borrowRow["borrow_id"]; ?>" onclick="verifyDelete(this.value)">Delete</button></form>
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
                let url = 'borrowAction.php?brId=';
                url += value;
                window.location = url;
            }
        }
    </script>
</body>
</html>