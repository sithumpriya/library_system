<?php
require '../config.php';

// Verifies user login authenticity
if(!empty($_SESSION["user_id"])){
    header('Location: ../index.php');
}

// unset alert messages
if (!empty($_SESSION['lastDuplicateTime'])) {
    if((time() - $_SESSION['lastDuplicateTime']) > 5) {
        unset($_SESSION['lastDuplicateTime']);
    }
}
if (!empty($_SESSION['lastSuccessTime'])) {
    if((time() - $_SESSION['lastSuccessTime']) > 5) {
        unset($_SESSION['lastSuccessTime']);
    }
}
if (!empty($_SESSION['lastEmailInvalidTime'])) {
    if((time() - $_SESSION['lastEmailInvalidTime']) > 5) {
        unset($_SESSION['lastEmailInvalidTime']);
    }
}
if (!empty($_SESSION['lastInvalidLoginTime'])) {
    if((time() - $_SESSION['lastInvalidLoginTime']) > 5) {
        unset($_SESSION['lastInvalidLoginTime']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS file -->
    <link rel="stylesheet" type="text/css" href="signinup.css">
    
    <title>Library System</title>
</head>

<body>
    <!-- Alert messages -->
    <?php
    if (!empty($_SESSION["lastDuplicateTime"])) { ?>
        <div class="alert"style="margin: 10px 8% 0px 8%;">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            The entered details are already in use.
        </div>
    <?php
    }
    if (!empty($_SESSION["lastSuccessTime"])) { ?>
        <div class="alertSuccess" style="margin: 10px 8% 0px 8%;">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            Registration has been completed successfully.
        </div>
    <?php
    }
    if (!empty($_SESSION["lastEmailInvalidTime"])) { ?>
        <div class="alert" style="margin: 10px 8% 0px 8%;">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            The email provided is invalid.
        </div>
    <?php
    }
    ?>

    <!-- Welcome text -->
    <div class="welcomeText">
        <p class="text1">Welcome to the Library System</p>
        <p class="text2">Log in to continue...</p>
    </div>

    <!--Login form-->
    <div class="loginContainer">

        <!-- title for login container -->
        <h1 style="color: #f5f5f5;">Log in</h1>
        <form action="signInUpAction.php" method="post" autocomplete="off">

            <!-- Alert messages for invalid login -->
            <?php
            if (!empty($_SESSION["lastInvalidLoginTime"])) { ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    Invalid login, please try again.
                </div>
            <?php
            }
            ?>

            <!-- Input field for username -->
            <div class="text_field">
                <input type="text" name="lUsername" id="lUsername" required>
                <span></span>
                <label>Username</label>
            </div>
            <!-- Input field for password -->
            <div class="text_field">
                <input type="password" name="lPassword" id="lPassword" required>
                <span></span>
                <label>Password</label>
            </div>
            <!-- Login button -->
            <button class="buttonLogin" style="vertical-align:middle" type="submit" name="signin">
                <span>Log in</span>
            </button>
        </form>
        <!-- Sign up form modal popup button -->
        <div class="signUpText">  
            <span style="color: #999;">Don't have an account?<span><br><button class="buttonSignUp" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Sign up now</button>
        </div>
    </div>


    <!-- Sign up form modal -->
    <div id="id01" class="modal">
  
        <form class="modal-content animate" action="signInUpAction.php" method="post" autocomplete="off">
            <!-- Modal close button -->
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close">&times;</span>
            </div>
        
            <div class="container">
                <!-- Title for sign up container -->
                <h2 style="text-align: center; margin: 12px 0 24px 0; position: relative; color:#f5f5f5;">Sign Up</h2>
                <hr style="border: 1px solid silver; margin-bottom: 12px;">

                <!-- Alert messages -->
                <div id="txt2"></div>
                <div id="txt3"></div>
                <div id="txt4"></div>

                <!-- Input field for sign up -->
                <div class="row">
                    <div class="col-25">
                        <label for="firstName">First Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" class="inputField" id="firstName" name="firstName" placeholder="enter first name" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="lastName">Last Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" class="inputField" id="lastName" name="lastName" placeholder="enter last name" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="userId">User Id</label>
                    </div>
                    <div class="col-75">
                        <input type="text" class="inputField" id="userId" name="userId" onchange="checkUserId(this.value)" pattern="U[0-9]{3}" placeholder="UXXX" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="username">Username</label>
                    </div>
                    <div class="col-75">
                        <input type="text" class="inputField" id="username" name="username" onchange="checkUsername(this.value)" placeholder="enter username" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-75">
                        <input type="email" class="inputField" id="email" name="email" onchange="checkEmail(this.value)" placeholder="enter email address" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-75">
                        <input type="password" class="inputField" id="password" name="password" pattern="[0-9]{8,}" title="Must contain at least 8 digits or more" placeholder="8 digits or more" required>
                    </div>
                </div>
                <!-- Sign up button -->
                <div class="row">
                    <input type="submit" value="Sign Up" name="signup">                    
                </div>
            </div>
        </form>
    </div>

    <script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
    </script>
</body>
</html>