<?php
    // Define connection parameters
    $mysql_hostname = "localhost";
    $mysql_user = "thenewd1_btl";
    $mysql_password = "B1u3T0n6u3!";
    $mysql_database = "thenewd1_btl";

    // Connect to SQL server and select database
    $con = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Error: " . mysql_error());
    $result = mysql_select_db($mysql_database, $con) or die("Error: " . mysql_error());
?>