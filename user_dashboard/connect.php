<?php

    $servername = "localhost";
    $username = "root";
    $password = "" ;
    $dbname = "quora_clone";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn)
    {
        die('Oops...Connection failed :('.mysqli_connect_error());
    }
?>