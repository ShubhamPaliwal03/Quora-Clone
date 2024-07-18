<?php

    if(isset($_COOKIE['username']))
    {
        header("location:./secured/index.php");
    }

    if(isset($_POST['login']))
    {
        include('connect.php');

        $sql = "select * from users where username='$_POST[username]'";
    
        $records = mysqli_query($conn, $sql);

        if($data = mysqli_fetch_assoc($records))
        {
            if($data['password'] === $_POST['password'] && $data['username'] === $_POST['username'])
            {
                setcookie('username', $_POST['username'], time()+60*60);

                setcookie('uid', $data['uid'], time()+60*60);

                header("location:./secured/index.php");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_style.css">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <div class="outer-flex-container">
            <h2>Login</h2>
            <div>
                <label for="username">Username : &nbsp;</label>
                <input type="text" id="username" name="username">
            </div>
            <div>
                <label for="password">Password &nbsp;: &nbsp;</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <input type="submit" value="Login" name="login">
            </div>
            <div>
                <span><a href="register.php">Not Registered</a></span>
                <span><a href="forgot_password.php">Forgot Password</a></span>
            </div>
        </div>
    </form>
</body>
</html>