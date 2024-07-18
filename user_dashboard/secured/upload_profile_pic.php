<?php
    if(isset($_COOKIE['username']) && isset($_COOKIE['uid']) && isset($_FILES['user_image']))
    {
        $uid = $_COOKIE['uid'];

        $image_name = $_FILES['user_image']['name'];
        $tmp_image_name = $_FILES['user_image']['tmp_name'];
        $image_type = $_FILES['user_image']['type'];
        
        $image_extension = substr($image_type, 6, strlen($image_type));
        $image_db_save_name = "user$uid"."_image.$image_extension";

        if($image_extension === "jpeg" || $image_extension === "jpg" || $image_extension === "png")
        {
            include('../connect.php');
    
            $sql = "SELECT `user_image` FROM `users` WHERE `uid` = $uid";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $prev_user_image = $data['user_image'];
    
            // remove the previous file user-set file from the user_images folder

            if($prev_user_image !== "default_user_image.webp") 
            {
                unlink("./user_images/$prev_user_image");
            }
            else
            {
                // update the 'users' table of the database with the new value of user_image
                
                $sql_update = "UPDATE `users` SET `user_image` = '$image_db_save_name' WHERE `uid` = $uid";
                mysqli_query($conn, $sql_update);
            }

            // permanently upload the new user_image to the server

            move_uploaded_file($tmp_image_name, "./user_images/$image_db_save_name");
        }
        else
        {
            echo("Only .jpg / .jpeg and .png picture formats are supported!");
        }
    }
    else
    {
        echo('Access Denied...Request From Unknown Source!');

        header('refresh:2;url=./index.php');
    }
?>