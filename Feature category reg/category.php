<?php
require '../config.php';
// Verifies user login authenticity
if(empty($_SESSION["user_id"])){
    header("Location: ../Feature login reg/signinup.php");
}
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
    <link rel="stylesheet" type="text/css" href="./category.css">
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <title>Library System</title>
</head>
<body>

    <!-- Navigation bar -->
    <div class="navbar">
        <span style="cursor: pointer;" onclick="window.location.href='../index.php'">Library System</span>
        <a href="../logout.php">Log out</a>
    </div>

    <!-- Section My Category -->
    <div class="userProfile">

        <div class="title">Add Category Item</div>

        <?php if(isset($_SESSION['message'])): ?>

            <div class="alert" role="alert">
                <p><strong>Hey!</strong> <?= $_SESSION['message']; ?></p>
            </div>
        
        <?php 
            unset($_SESSION['message']);
            endif; 
        ?>
        <!-- User details for update -->
        <div class="container">
            <form action="catprocess.php" method="post" name="action" autocomplete="off">
                <div class="row">
                    <div class="col-25">
                        <label for="categoryID">Category ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="categoryID" name="categoryID" pattern="C[0-9]{3}" placeholder="Enter category id..(CXXX)" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="categoryName">Category Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="categoryName" name="categoryName" placeholder="Enter Category Name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="dateModified">Date Modified</label>
                    </div>
                    <div class="col-75" >
                        <input type="datetime-local" id="dateModified" name="dateModified"/>
                    </div>
                </div>
                
                <!-- Buttons for save changes -->
                <div class="row" id="button">
                    <input type="submit" value="Add" name="addCategory">
                </div>
            </form>
        </div>
    </div>

 

    <!-- Section user records -->
    <div class="userRecords">
        <div class="title">Category Records</div>
        
        <div style="overflow-x:auto;">
            <table>
                <tr style="background: none;">
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Date Modified</th>
                    <th>Action</th>
                </tr>
                <?php
                    $categoryResult = "SELECT * FROM bookcategory";
                    $categoryRows = $conn->query($categoryResult);

                    while($categoryRow = mysqli_fetch_assoc($categoryRows)){
                ?>
                        <tr>
                            <td><?php echo $categoryRow["category_id"]; ?></td>
                            <td><?php echo $categoryRow["category_Name"]; ?></td>
                            <td><?php echo $categoryRow["date_modified"]; ?></td>
                            <td>
                                <button class="edit"><a href="edit_category.php?category_id=<?= $categoryRow["category_id"]; ?>"><i class='bx bxs-edit'></i>Edit</a></button>
                                <form action="catprocess.php" method="POST" style="display:inline;">
                                    <button onclick="verifyDelete(this.value)" class="delete" type="button" name="delete_category" value="<?= $categoryRow["category_id"]; ?>" style="color:#FFF; cursor:pointer;">
                                        <i class='bx bx-x' ></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </div>

        <script>
            function verifyDelete(value) {
                if(confirm("Are you sure? you will not be able to revert this!")) {
                    let url = 'catprocess.php?delete_category=';
                    url += value;
                    window.location = url;
                }
            }
        </script>
</body>
</html>
