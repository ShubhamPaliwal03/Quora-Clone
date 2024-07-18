<?php
    if(isset($_POST['verify']))
    {
        include('connect.php');

        $sql = "select username from users";

        $record = mysqli_query($conn, $sql);

        $found = false;

        while($data = mysqli_fetch_assoc($record))
        {
            if($data['username'] === $_POST['username'])
            {
                $found = true;

                header("location:recover_password.php?username=$data[username]");
            }
        }
        
        if(!$found)
        {
            ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="forgot_password_style.css">
                    <title>Forgot Password</title>
                </head>
                <body>
                    <div class="outer-flex-container">
                        <h3>Forgot Password</h3>
                        <form action="forgot_password.php" method="post">
                            <div class="inner-flex-container">
                                <div>
                                    <fieldset>
                                        <legend>Username</legend>
                                        <input type="text" name="username" id="username">
                                    </fieldset>
                                </div>
                                <div id="error_msg">
                                        <div>Username doesn't exist!</div>
                                        <div><a href="register.php">Not Registered</a></div>
                                </div>
                                <div>
                                    <input type="submit" name="verify" value="Verify">
                                </div>
                            </div>
                        </form>
                    </div>
                </body>
                </html>
            <?php
        }
    }
    else
    {
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="forgot_password_style.css">
                <title>Forgot Password</title>
            </head>
            <body>
                <div class="outer-flex-container">
                    <h3>Forgot Password</h3>
                    <form action="forgot_password.php" method="post">
                        <div class="inner-flex-container">
                            <div>
                                <fieldset>
                                    <legend>Username</legend>
                                    <input type="text" name="username" id="username">
                                </fieldset>
                            </div>
                            <div>
                                <input type="submit" name="verify" value="Verify">
                            </div>
                        </div>
                    </form>
                </div>
            </body>
            </html>
        <?php
    }
?>