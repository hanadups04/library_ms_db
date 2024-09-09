<?php
    $conn = mysqli_connect("localhost", "root", "", "libraryms");

    if(!$conn){
        die("connection failed: " . mysqli_connect_error());
    } 
    else {
        //echo "Database connection established!";
    }
?>