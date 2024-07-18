<?php
    include('../connect.php');

    $sql = "select username, user_image from `users` where username like '$_POST[search_query]%' limit 5";

    $records = mysqli_query($conn, $sql);

    $result = "";

    while($data = mysqli_fetch_assoc($records))
    {
        $result = $result.$data['username'].":".$data['user_image'].",";
    }

    echo($result);
?>