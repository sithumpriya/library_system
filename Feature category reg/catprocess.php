<?php

require "../config.php";

// Delete Category
if (isset($_GET['delete_category'])) {
    $category_id = mysqli_real_escape_string($conn, $_GET['delete_category']);

    $query = "DELETE FROM bookcategory WHERE category_id='$category_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Category Deleted Successfully";
        header("Location: category.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Category Not Deleted. Error: " . mysqli_error($conn);
        header("Location: category.php");
        exit(0);
    }
}

// Update category
if (isset($_POST['update_category']))
{
    $category_id	= mysqli_real_escape_string($conn, $_POST['categoryID']);
    $category_Name	= mysqli_real_escape_string($conn, $_POST['categoryName']);
    $date_modified  = mysqli_real_escape_string($conn, $_POST['dateModified']);

    $query = "UPDATE bookcategory SET category_id='$category_id', category_Name='$category_Name', date_modified='$date_modified' WHERE category_id='$category_id'";

    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Category Updated Succesfully";
        header("Location: category.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Category Not Updated";
        header("Location: category.php");
        exit(0);
    }

}

// Add Category
if(isset($_POST['addCategory'])){
    

    $category_id	= mysqli_real_escape_string($conn, $_POST['categoryID']);
    $category_Name	= mysqli_real_escape_string($conn, $_POST['categoryName']);
    $date_modified  = mysqli_real_escape_string($conn, $_POST['dateModified']);

    $query = "INSERT INTO bookcategory (category_id, category_Name, date_modified) VALUES 
            ('$category_id', '$category_Name', '$date_modified')";

    $query_run = mysqli_query($conn, $query);

    if($query_run) 
    {
        $_SESSION['message'] = "Category Added Succesfully";
        header("Location: category.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Category Not Added";
        header("Location: category.php");
        exit(0);
    }

}



?>