<?php
    require '../config.php';
    $userId = $_REQUEST["userId"];

    if ($userId) {

        $sql = "SELECT * FROM user WHERE user_id = '$userId'";
        $searchRows = $conn->query($sql);

        if(mysqli_num_rows($searchRows)>0) { 
?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                The selected User ID is already in use.
            </div>
<?php   
        }

    }
?> 