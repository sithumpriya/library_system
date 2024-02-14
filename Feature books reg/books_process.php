<?php

require '../config.php';

// Update category
if (isset($_POST['update_book']))
{
    $bookID	= mysqli_real_escape_string($conn, $_POST['bookID']);
    $bookID_old	= mysqli_real_escape_string($conn, $_POST['bookID_old']);
    $bookName	= mysqli_real_escape_string($conn, $_POST['bookName']);
    $categories  = mysqli_real_escape_string($conn, $_POST['category_name']);

    $sql = "SELECT category_id FROM bookcategory WHERE category_Name = '$categories'";
    $cate_id = $conn->query($sql);
    $cate_id = mysqli_fetch_assoc($cate_id);
    $category_id = $cate_id['category_id'];

    $duplicate = mysqli_query($conn, "SELECT book_id FROM book WHERE book_id = ANY(SELECT book_id FROM book WHERE book_id = '$bookID' AND book_id != '$bookID_old')");

    if(mysqli_num_rows($duplicate) > 0) {
        $_SESSION['message'] = "Book Not Updated";
        header("Location: books.php");
        exit(0);
    } else {
        if($bookID == $bookID_old) {
            $query = "UPDATE book SET book_id='$bookID', book_name='$bookName', category_id='$category_id' WHERE book_id='$bookID'";
        } else {
            $query = "UPDATE book SET book_id='$bookID', book_name='$bookName', category_id='$category_id' WHERE book_id='$bookID_old'";
        }
    
        $query_run = mysqli_query($conn, $query);
    
        if($query_run)
        {
            $_SESSION['message'] = "Book Updated Succesfully";
            header("Location: books.php");
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Book Not Updated";
            header("Location: books.php");
            exit(0);
        }
    }
}


// Add Books
if(isset($_POST['add_books'])){
    $bookID = $_POST['bookID'];
    $bookName = $_POST['bookName'];
    $categories = $_POST['categories'];

    $query = "INSERT INTO book VALUES ('$bookID', '$bookName', '$categories')";

    $query_run = mysqli_query($conn, $query);

    if($query_run) 
    {
        $_SESSION['message'] = "Book Added Succesfully";
        header("Location: books.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Book Not Added";
        header("Location: books.php");
        exit(0);
    }

}

// Delete Book
if(isset($_GET['bookId'])){
    $bookID = $_GET['bookId'];

    $query = "DELETE FROM book WHERE book_id = '$bookID'";

    $query_run = mysqli_query($conn, $query);

    if($query_run) 
    {
        $_SESSION['message'] = "Book Deleted Succesfully";
        header("Location: books.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Book Not Deleted";
        header("Location: books.php");
        exit(0);
    }

}

?>