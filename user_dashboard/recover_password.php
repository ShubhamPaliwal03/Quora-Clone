<?php

    include('connect.php');

    if(isset($_GET['username']))
    {
        $username = $_GET['username'];
    }
    else
    {
        $username = $_POST['username'];
    }

    $sql = "select * from users where username = '$username'";

    $records = mysqli_query($conn, $sql);

    $data = mysqli_fetch_assoc($records);

    $security_question = $data['security_question'];
    $security_answer = $data['security_answer'];
    $password = $data['password'];

    if(isset($_POST['proceed']))
    {
        header("recover_password.php?username=$username");

        if($security_answer === $_POST['security_answer'])
        {
            if($_POST['choice'] === 'change_password')
            {
                header("location:change_password.php");
            }
            else if($_POST['choice'] === 'show_password')
            {
                ?>
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" href="recover_password_style.css">
                        <title>Show Password</title>
                    </head>
                    <body>
                        <div class="outer-container">
                            <h1>Hey, <?php echo $username;?></h1>
                            <br>
                            <h2>Your Password is : <b><?php echo $password;?></b></h2>
                            <br>
                            <a href="login.php">Login</a>
                            <br>
                            <br>
                            <h3>Pro Tip : A handful of almonds a day, keeps the need of password recovery away :&rpar;</h2>
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
                    <link rel="stylesheet" href="recover_password_style.css">
                    <title>Recover Password</title>
                </head>
                <body>
                    <div class="outer-container">
                        <h2>Recover Password</h2>
                        <form action="recover_password.php" method="post">
                            <div class="inner-flex-container">
                                <div>
                                    <fieldset>
                                        <legend>Security Question</legend>
                                        <div id="security_question-container">
                                            <?php echo $security_question;?>
                                        </div>
                                    </fieldset>
                                </div>
                                <div>
                                    <fieldset>
                                        <legend>Answer</legend>
                                        <input type="text" name="security_answer">
                                        <div id="error-msg">
                                            <div>Answer doesn't match!</div>
                                            <!-- <a href="forgot_password.php">Try with different username</a> -->
                                        </div>
                                    </fieldset>
                                </div>
                                <div>
                                    <fieldset>
                                        <legend>Select Your Choice</legend>
                                        <input type="radio" value="change_password" name="choice" id="change_password" checked>
                                        <label for="change_password">Change Password</label>
                                        <input type="radio" value="show_password" name="choice" id="show_password">
                                        <label for="show_password">Show Password</label>
                                    </fieldset>
                                </div>
                                <br>
                                <div>
                                    <input type="text" hidden name="username" value="<?php echo $username;?>">
                                    <input type="submit" value="Verify and Proceed" name="proceed">
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
                <link rel="stylesheet" href="recover_password_style.css">
                <title>Recover Password</title>
            </head>
            <body>
                <div class="outer-container">
                    <h2>Recover Password</h2>
                    <form action="recover_password.php" method="post">
                        <div class="inner-flex-container">
                            <div>
                                <fieldset>
                                    <legend>Security Question</legend>
                                    <div id="security_question-container">
                                        <?php echo $security_question;?>
                                    </div>
                                </fieldset>
                            </div>
                            <div>
                                <fieldset>
                                    <legend>Answer</legend>
                                    <input type="text" name="security_answer">
                                </fieldset>
                            </div>
                            <div>
                                <fieldset>
                                    <legend>Select Your Choice</legend>
                                    <input type="radio" value="show_password" name="choice" id="show_password" checked>
                                    <label for="show_password">Show Password</label>
                                    <input type="radio" value="change_password" name="choice" id="change_password">
                                    <label for="change_password">Change Password</label>
                                </fieldset>
                            </div>
                            <br>
                            <div>
                                <input type="text" hidden name="username" value="<?php echo $username;?>">
                                <input type="submit" value="Verify and Proceed" name="proceed">
                            </div>
                        </div>
                    </form>
                </div>
            </body>
            </html>
        <?php
    }
?>