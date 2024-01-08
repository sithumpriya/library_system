<?php
require '../config.php';

// Sign up actions
if (isset($_POST["signup"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $userId = $_POST["userId"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Checks user entered details are already in use
    $duplicate = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' OR username = '$username' OR user_id = '$userId'");

    if (mysqli_num_rows($duplicate) > 0) {
        // Establish alert message for duplicate
        $_SESSION['lastDuplicateTime'] = time();
    } else {
        // Verifies user entered email
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            // Establish alert message for invalid email
            $_SESSION['lastEmailInvalidTime'] = time();
        } else {
            // Creates a password hash using a strong one-way hashing algorithm
            $newPassword=password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO user VALUES('$userId','$email','$firstName','$lastName','$username','$newPassword')";
            mysqli_query($conn,$query);

            // Establish alert message for success
            $_SESSION['lastSuccessTime'] = time();
        }
    }
    header("Location: signinup.php");
}