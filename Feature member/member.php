<?php

require '../config.php';
if(empty($_SESSION["user_id"])){
    header("Location: ../Feature login reg/signinup.php");
} else {
    $user_id = $_SESSION["user_id"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
    $row = mysqli_fetch_assoc($result);

    $userResult = "SELECT * FROM user";
    $userRows = $conn->query($userResult);
}


// Function to validate email format
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate MemberID format
function isValidMemberID($memberID)
{
    return preg_match('/^M\d{3}$/', $memberID);
}

// Function to display member records
function displayMembers($conn)
{ 
    $sql = "SELECT member_id, first_name, last_name, birthday, email FROM member";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table border='1'>
        <tr>
            <th>Member ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Birthday</th>
            <th>Email</th>
            <th>Action</th>
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['member_id']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['birthday']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a href='?edit={$row['member_id']}' class='edit-btn' style='padding: 5px 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px;'>Edit</a>
                        <a href='?delete={$row['member_id']}' class='delete-btn' style='padding: 5px 10px; background-color: #f44336; color: white; text-decoration: none; border-radius: 3px;'>Delete</a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No members found";
    }
}


// Process form submission
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $memberID = strtoupper(filter_input(INPUT_POST, 'member_id', FILTER_SANITIZE_STRING));
        $firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // Validate email and MemberID formats
        if (isValidEmail($email) && isValidMemberID($memberID)) {
            $sql = "INSERT INTO member (member_id, first_name, last_name, birthday, email) 
                    VALUES ('$memberID', '$firstname', '$lastname', '$birthday', '$email')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('New record entered successfully');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Invalid email or MemberID format";
        }
    }

    // Process member update
    if (isset($_POST['update'])) {
        $memberID = strtoupper(filter_input(INPUT_POST, 'member_id', FILTER_SANITIZE_STRING));
        $firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $id = $_POST['id'];

        // Validate email and MemberID formats
        if (isValidEmail($email) && isValidMemberID($memberID)) {
            $sql = "UPDATE member 
                    SET member_id='$memberID', first_name='$firstname', 
                    last_name='$lastname', birthday='$birthday', email='$email' 
                    WHERE member_id='$id'";

            if ($conn->query($sql) === TRUE) {
                echo"<script>alert('member details updated sucessfully');</script>";
            } else {
                echo "Error updating details: " . $conn->error;
            }
        } else {
            echo "Invalid email or MemberID format";
        }
    }
}

// Process member deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // JavaScript confirmation dialog
    echo "<script>";
    echo "if(confirm('Are you sure you want to delete this member?')) {";
    echo "  window.location.href = '?confirmed_delete=$id';";
    echo "} else {";
    echo "  window.location.href = '?cancel_delete';";
    echo "}";
    echo "</script>";
}

// After the confirmation
if (isset($_GET['confirmed_delete'])) {
    $id = $_GET['confirmed_delete'];
    $sql = "DELETE FROM member WHERE member_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Member deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting member: " . $conn->error . "');</script>";
    }
}

// If deletion is canceled
if (isset($_GET['cancel_delete'])) {
    echo "<script>alert('Deletion canceled');</script>";
}

// Edit member record
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM member WHERE member_id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $editMemberID = $row['member_id'];
        $editFirstname = $row['first_name'];
        $editLastname = $row['last_name'];
        $editBirthday = $row['birthday'];
        $editEmail = $row['email'];
    }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Library Member Management</title>
    <style>
        /* Style for header */
        .header {
            background-color: #19233e;
            color: white;
            padding: 10px;
            margin: 0;
            border-bottom: 1px solid #19233e;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Style for logout link */
        .logout-link {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-right: 20px; /* Adjust margin as needed */
        }
    </style>
   
    
</head>
<body>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="member.css">
<div class="header">
        <h2 onclick="window.location.href='../index.php'">Library Member Management</h2>
        <a href="../logout.php" class="logout-link">Log Out</a>
    </div>
<h3 style="color: #f5f5f5; border-bottom: 2px solid white; padding-left: 10px;">Member profile</h3>



<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="background-color: #f5f5f6; padding: 40px; border-radius: 10px; height:50vh; width: 70%; margin: 0 auto;">

    <?php if (isset($editMemberID)) : ?>
        <input type="hidden" name="id" value="<?php echo $editMemberID; ?>">
    <?php endif; ?>

    <label for="member_id" style="font-size: 14px; text-align: justify; display: inline-block; width: 30%; padding: 10px;">Member ID:</label>
    <input type="text" name="member_id" pattern="M\d{3}" required placeholder="Enter Member ID" value="<?php echo isset($editMemberID) ? $editMemberID : ''; ?>" style="font-size: 14px; width: 65%; padding: 8px; margin-bottom: 10px; display: inline-block;"><br>

    <label for="first_name" style="font-size: 14px; text-align: justify; display: inline-block; width: 30%; padding: 10px;">Firstname:</label>
    <input type="text" name="first_name" required placeholder="Enter Firstname" value="<?php echo isset($editFirstname) ? $editFirstname : ''; ?>" style="font-size: 14px; width: 65%; padding: 8px; margin-bottom: 10px; display: inline-block;"><br>

    <label for="last_name" style="font-size: 14px; text-align: justify; display: inline-block; width: 30%; padding: 10px;">Lastname:</label>
    <input type="text" name="last_name" required placeholder="Enter Lastname" value="<?php echo isset($editLastname) ? $editLastname : ''; ?>" style="font-size: 14px; width: 65%; padding: 8px; margin-bottom: 10px; display: inline-block;"><br>

    <label for="birthday" style="font-size: 14px; text-align: justify; display: inline-block; width: 30%; padding: 10px;">Birthday:</label>
    <input type="date" name="birthday" required value="<?php echo isset($editBirthday) ? $editBirthday : ''; ?>" style="font-size: 14px; width: 65%; padding: 8px; margin-bottom: 10px; display: inline-block;"><br>

    <label for="email" style="font-size: 14px; text-align: justify; display: inline-block; width: 30%; padding: 10px;">Email Address:</label>
    <input type="email" name="email" required placeholder="Enter Email Address" value="<?php echo isset($editEmail) ? $editEmail : ''; ?>" style="font-size: 14px; width: 65%; padding: 8px; margin-bottom: 10px; display: inline-block;"><br>

    <div style="text-align: right;">
        <?php if (isset($editMemberID)) : ?>
            <input type="submit" name="update" value="Update" style="background-color: #4CAF50; color: white; border: none; padding: 10px 10px; border-radius: 2px;height:auto; cursor: pointer;">
        <?php else : ?>
            <input type="submit" name="register" value="Register" style="background-color: #4CAF50; color: white; border: none; padding: 10px 10px; border-radius: 3px; cursor: pointer;">
        <?php endif; ?>
    </div>
</form>

<h3 style="color: #f5f5f5; border-bottom: 2px solid white; padding-left: 10px;">Member Records</h3>

    <?php displayMembers($conn); ?>

</body>
</html>

<?php
$conn->close();
?>








