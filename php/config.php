<?php
    $conn = mysqli_connect("localhost","root","","urlshortener");
        if(!$conn){   //if database is NOT conn
            echo "Database connection error".mysqli_connect_error();
        }
?>
