<?php
    require '../config.php';
    $username = $_REQUEST["username"];

    if ($username) {

        $sql = "SELECT * FROM user WHERE username = '$username'";
        $searchRows = $conn->query($sql);

        if(mysqli_num_rows($searchRows)>0) { 
?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The selected username is already in use.
            </div>
<?php   
        }

    }
?> 