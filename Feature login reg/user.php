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

        <!-- User details for update -->
        <div class="container">
            <form action="" method="post" autocomplete="off">
                <div class="row">
                    <div class="col-25">
                    <label for="firstName">First Name</label>
                    </div>
                    <div class="col-75">
                    <input type="text" id="firstName" name="firstName" value="<?php echo $row["first_name"]; ?>" placeholder="Enter first name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    <label for="lastName">Last Name</label>
                    </div>
                    <div class="col-75">
                    <input type="text" id="lastName" name="lastName" value="<?php echo $row["last_name"]; ?>" placeholder="Enter last name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    <label for="userId">User Id</label>
                    </div>
                    <div class="col-75">
                    <input type="text" id="userId" name="userId" value="<?php echo $row["user_id"]; ?>" pattern="U[0-9]{3}" placeholder="Enter user id..(UXXX)" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    <label for="username">Username</label>
                    </div>
                    <div class="col-75">
                    <input type="text" id="username" name="username" value="<?php echo $row["username"]; ?>" placeholder="Enter username.." required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    <label for="email">Email</label>
                    </div>
                    <div class="col-75">
                    <input type="email" id="email" name="email" value="<?php echo $row["email"]; ?>" placeholder="Enter email address..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    <label for="password">Password</label>
                    </div>
                    <div class="col-75">
                    <input type="text" id="password" name="password" value="<?php echo $row["password"]; ?>" onclick="this.value=''" placeholder="Set a new password..(optional)">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>