<?php
    if(isset($_POST['create_account']))
    {
        include('connect.php');

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $security_question = mysqli_real_escape_string($conn, $_POST['security_question']);
        $answer = mysqli_real_escape_string($conn, $_POST['answer']);
        $user_image = "default_user_image.webp";
        $user_title = "none";

        $sql = "insert into users (username, password, security_question, security_answer, user_image, user_title) values ('$username', '$password', '$security_question', '$answer', '$user_image', '$user_title')";

        if(mysqli_query($conn, $sql))
        {
            header("location:login.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register_style.css">
    <title>Register</title>
</head>
<body>
    <div class="outer-flex-container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <div class="inner-flex-container">
                <div>
                    <fieldset>
                        <label for="username"></label>
                        <legend>Username</legend>
                        <input type="text" id="username" name="username">
                    </fieldset>
                </div>
                <div>
                    <fieldset>
                        <!-- <label for="password">Password</label> -->
                        <legend>Password</legend>
                        <input type="password" id="password" name="password">
                    </fieldset>
                </div>
                <div>
                    <fieldset id="confirm_password_fieldset">
                        <!-- <label for="confirm_password">Confirm Password</label> -->
                        <legend>Confirm Password</legend>
                        <input type="password" id="confirm_password" name="confirm_password">
                        <div id="error_msg">Passwords do not match!</div>
                    </fieldset>
                </div>
                <div>
                    <!-- <label for="security_question">Security Question</label> -->
                     <fieldset>
                        <legend>Security Question</legend>
                        <select name="security_question" id="security_question">
                            <option>What is the name of the city in which you were born?</option>
                            <option>What is the name of your pet?</option>
                            <option>What was the first job that you got?</option>
                            <option>Which year did you graduate?</option>
                            <option>What is the date of birth of your mom?</option>
                            <option>What is your most favourite food?</option>
                            <option>What is the thing that you can't live without?</option>
                            <option>What do you dislike the most?</option>
                            <option>What do you like the most?</option>
                            <option>What is your most favourite travel location?</option>
                        </select>
                     </fieldset>
                </div>
                <div>
                    <!-- <label for="answer">Answer</label> -->
                     <fieldset>
                        <legend>Answer</legend>
                        <input type="text" id="answer" name="answer">
                     </fieldset>
                </div>
                <div>
                    <input type="submit" value="Create Account" name="create_account" id="create_account" disabled>
                </div>
                <div>
                    <a href="login.php">Already Registered</a>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="register_script.js"></script>
</body>
</html>