<?php
    require '../config.php';
    $email = $_REQUEST["email"];

    if ($email) {

        $sql = "SELECT * FROM user WHERE email = '$email'";
        $searchRows = $conn->query($sql);

        if(mysqli_num_rows($searchRows)>0) { 
?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The selected email is already in use.
            </div>
<?php   
        }
    }
?>