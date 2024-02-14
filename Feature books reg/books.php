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
    <!-- Books CSS file -->
    <link rel="stylesheet" type="text/css" href="./books.css">
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

    <!-- Section My Books -->
    <div class="userProfile">

        <div class="title">Add Book Item</div>
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
                <form action="books_process.php" method="post" name="editBooks" autocomplete="off">
                    <div class="row">
                        <div class="col-25">
                            <label for="bookID">Book ID</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="bookID" name="bookID" pattern="B[0-9]{3}" placeholder="Enter Book ID..(BXXX)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="bookName">Book Name</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="bookName" name="bookName" placeholder="Enter Book Name..">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="bookCategory">Book Category</label>
                        </div>
                        <div class="col-75">
                            <div class="category-select" style="width:100%;">
                                <select name="categories">
                                    <?php
                                        include '../config.php';
                                        $query = "SELECT * FROM bookcategory";
                                        $categories = mysqli_query($conn, $query);
                                        while($c = mysqli_fetch_array($categories)){
                                    ?>  
                                    <option value="<?php echo $c['category_id'] ?>"><?php echo $c['category_Name']?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Buttons for save changes -->
                    <div class="row" id="button">
                        <input type="submit" value="Add Book" name="add_books">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Section user records -->
    <div class="userRecords">
        <div class="title">Book Records</div>
        
        <div style="overflow-x:auto;">
            <table>
                <tr style="background: none;">
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Book Category</th>
                    <th>Action</th>
                </tr> 
                <?php
                    $bookResult = "SELECT * FROM book INNER JOIN bookcategory ON book.category_id = bookcategory.category_id";
                    $bookRows = $conn->query($bookResult);

                    while($bookRow = mysqli_fetch_assoc($bookRows)){
                ?>
                        <tr>
                            <td><?php echo $bookRow["book_id"]; ?></td>
                            <td><?php echo $bookRow["book_name"]; ?></td>
                            <td><?php echo $bookRow["category_Name"]; ?></td>
                            <td>
                                <button class="edit"><a href="edit_books.php?bookID=<?= $bookRow["book_id"]; ?>"><i class='bx bxs-edit'></i>Edit</a></button>
                                <form action="books_process.php" method="POST" style="display:inline;">
                                    <button class="delete" type="button" onclick="verifyDelete(this.value)" name="deleteBook" value="<?= $bookRow["book_id"]; ?>" style="color:#FFF; cursor:pointer;">
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
                let url = 'books_process.php?bookId=';
                url += value;
                window.location = url;
            }
        }
    </script>

</body>
</html>