<?php
require '../config.php';

// Verifies user login authenticity
if(empty($_SESSION["user_id"])){
    header("Location: signinup.php");
} else {
    $user_id = $_SESSION["user_id"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
    $row = mysqli_fetch_assoc($result);
}

// Update actions
if (isset($_POST["update"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $userId = $_POST["userId"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Checks user entered details are already in use
    $duplicate = mysqli_query($conn, "SELECT * FROM user WHERE email = ANY (SELECT email FROM user WHERE user_id != '$user_id' AND email = '$email') OR username = ANY (SELECT username FROM user WHERE user_id != '$user_id' AND username = '$username') OR user_id = ANY (SELECT user_id FROM user WHERE user_id != '$user_id' AND user_id = '$userId')");

    if (mysqli_num_rows($duplicate) > 0) {
        // Establish alert message for duplicate
        $_SESSION['lastExistUpdateTime'] = time();
    } else {
        if (!empty($email)) {
            // Verifies user entered email
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                // Establish alert message for invalid email
                $_SESSION['lastInvalidEmailTime'] = time();
                header("Location: user.php");
                die;
            }
        } 
        // Validates if the password is new or not
        if (is_numeric($password)) {
            // Creates a password hash using a strong one-way hashing algorithm
            $newPassword=password_hash($password, PASSWORD_DEFAULT);

            $query = "UPDATE user SET email = '$email', first_name = '$firstName', last_name = '$lastName', username = '$username', user.password = '$newPassword' WHERE user_id = '$user_id'";
            mysqli_query($conn,$query);                
        } else {
            $query = "UPDATE user SET email = '$email', first_name = '$firstName', last_name = '$lastName', username = '$username' WHERE user_id = '$user_id'";
            mysqli_query($conn,$query);
        }
        // Validates if the user id is new or not
        if ($userId != ($_SESSION["user_id"])) {
            $query = "UPDATE user SET user_id = '$userId' WHERE user_id = '$user_id'";
            mysqli_query($conn,$query);
            
            $_SESSION["user_id"] = $userId;
        } else {
            $query = "UPDATE user SET user_id = '$userId' WHERE user_id = '$user_id'";
            mysqli_query($conn,$query);
        }
        // Establish alert message for success
        $_SESSION['lastSuccessUpdateTime'] = time();
    }
    header("Location: user.php");
}
?>