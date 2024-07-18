<?php
    include('../connect.php');

    $pid = $_POST['pid'];
    $sql = "select post_title, post_content from `posts` where pid=$pid";

    $records = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($records);

    $post_title = $data['post_title'];
    $post_content = $data['post_content'];

    $post_data = Array('post_title' => $post_title, 'post_content' => $post_content);

    // convert the associative array into JSON object, if we pass a normal 0-indexed array, we get an JSON array

    $json = json_encode($post_data);

    echo($json);
?>