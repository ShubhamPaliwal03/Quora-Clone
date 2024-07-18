<?php
    if(isset($_COOKIE['uid']) && isset($_POST['following_user_id']))
    {
        include('../connect.php');

        $following_user_id = $_POST['following_user_id'];
        $user_id = $_COOKIE['uid'];

        $sql = "delete from `follow_records` where user_id = $user_id && following_user_id = $following_user_id";
        mysqli_query($conn, $sql);
    }
    else
    {
        header('location:../login.php');
    }
?>