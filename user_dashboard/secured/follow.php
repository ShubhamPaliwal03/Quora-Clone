<?php
    if(isset($_COOKIE['uid']) && isset($_POST['following_user_id']))
    {
        include('../connect.php');

        $following_user_id = $_POST['following_user_id'];
        $user_id = $_COOKIE['uid'];

        $sql = "insert into `follow_records` (user_id, following_user_id) values ($user_id, $following_user_id)";
        mysqli_query($conn, $sql);
    }
    else
    {
        header('location:../login.php');
    }
?>