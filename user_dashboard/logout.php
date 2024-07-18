<?php
    setcookie("username", $_GET['username'], time()-60*60);

    setcookie("uid", $_GET['uid'], time()-60*60);

    header("location:login.php");
?>