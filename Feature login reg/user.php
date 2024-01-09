<?php
require '../config.php';

// Verifies user login authenticity
if(empty($_SESSION["user_id"])){
    header("Location: signinup.php");
} else {
    $user_id = $_SESSION["user_id"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
    $row = mysqli_fetch_assoc($result);

    $userResult = "SELECT * FROM user";
    $userRows = $conn->query($userResult);
}

// unset alert messages
if (!empty($_SESSION['lastSuccessUpdateTime'])) {
    if((time() - $_SESSION['lastSuccessUpdateTime']) > 5) {
        unset($_SESSION['lastSuccessUpdateTime']);
    }
}
if (!empty($_SESSION['lastExistUpdateTime'])) {
    if((time() - $_SESSION['lastExistUpdateTime']) > 5) {
        unset($_SESSION['lastExistUpdateTime']);
    }
}
if (!empty($_SESSION['lastInvalidEmailTime'])) {
    if((time() - $_SESSION['lastInvalidEmailTime']) > 5) {
        unset($_SESSION['lastInvalidEmailTime']);
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
    <link rel="stylesheet" type="text/css" href="user.css">

    <title>Library System</title>
</head>
<body>

    <!-- Navigation bar -->
    <div class="navbar">
        <span style="cursor: pointer;" onclick="window.location.href='../index.php'">Library System</span>
        <a href="../logout.php">Log out</a>
    </div>

    <!-- Section my_profile -->
    <div class="userProfile">
        <div class="title">My Profile</div>

        <!-- Alert messages -->
        <?php
        if (!empty($_SESSION["lastExistUpdateTime"])) { ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The entered details are already in use.
            </div>
        <?php
        }
        if (!empty($_SESSION["lastInvalidEmailTime"])) { ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The email provided is invalid.
            </div>
        <?php
        }
        if (!empty($_SESSION["lastSuccessUpdateTime"])) { ?>
            <div class="alertSuccess">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The update has been completed successfully.
            </div>
        <?php
        }
        ?>

        <!-- User details for update -->
        <div class="container">
            <form action="userAction.php" method="post" name="myProfile" autocomplete="off">
                <div class="row">
                    <div class="col-25">
                        <label for="firstName">First Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="firstName" name="firstName" value="<?php echo $row["first_name"]; ?>" onkeydown="funDisplay()" placeholder="Enter first name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lastName">Last Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="lastName" name="lastName" value="<?php echo $row["last_name"]; ?>" onkeydown="funDisplay()" placeholder="Enter last name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="userId">User Id</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="userId" name="userId" value="<?php echo $row["user_id"]; ?>" pattern="U[0-9]{3}" onkeydown="funDisplay()" placeholder="Enter user id..(UXXX)" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="username" name="username" value="<?php echo $row["username"]; ?>" onkeydown="funDisplay()" placeholder="Enter username.." required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-75">
                        <input type="email" id="email" name="email" value="<?php echo $row["email"]; ?>" onkeydown="funDisplay()" placeholder="Enter email address..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="password" name="password" value="<?php echo $row["password"]; ?>" onclick="this.value=''" onfocus="funDisplay()" onchange="validatePassword()" placeholder="Set a new password..(optional)">
                    </div>
                </div>
                <!-- Buttons for save and cancel the changes -->
                <div class="row" id="button" style="display: none;">
                    <input type="submit" value="Save" name="update">
                    <input type="reset" value="Cancel" onclick="funHide()">
                </div>
            </form>
        </div>
    </div>

    <!-- Section user records -->
    <div class="userRecords">
        <div class="title">User Records</div>
        
        <div style="overflow-x:auto;">
            <table>
                <tr style="background: none;">
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>User Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
                <?php
                    while($userRow = mysqli_fetch_assoc($userRows)){
                ?>
                        <tr>
                            <td><?php echo $userRow["first_name"]; ?></td>
                            <td><?php echo $userRow["last_name"]; ?></td>
                            <td><?php echo $userRow["user_id"]; ?></td>
                            <td><?php echo $userRow["username"]; ?></td>
                            <td><?php echo $userRow["email"]; ?></td>
                            <td><?php echo $userRow["password"]; ?></td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </div>

    <script>
        // When the user onkeydown display save and cancel buttons
        function funDisplay() {
            document.getElementById("button").style.display = "block";
        }

        // When the user clicks cancel button hide save and cancel buttons
        function funHide() {
            document.getElementById("button").style.display = "none";
        }

        // Validate new password
        function validatePassword() {
            let x = document.forms["myProfile"]["password"].value;
            if (x.length < 8 || isNaN(x)) {
                alert("Must contain at least 8 digits or more");
                return false;
            }
        }
    </script>
</body>
</html>