<?php
    include('config.php');
    session_start();
    
    $userid = $_SESSION['login_userid'];

    $query =
    "
        SELECT
            Username
        FROM
            time_User
        WHERE
            UserId = '$userid';
    ";
    $result = mysql_query($query) or die("Error: " . mysql_error());
    $count = mysql_num_rows($result);

    if($count != 1) {
        header("Location: login.php");
    }
?>