<?php
    include("./includes/config.php");
    session_start();
    
    if($_POST)
    {
        // Username and password sent from form
        $myusername = addslashes($_POST['username']);
        $mypassword = addslashes($_POST['password']);

        $query =
        "
            SELECT
                UserId
            FROM
                time_User
            WHERE
                Username = '$myusername'
                AND Password = '$mypassword';
        ";
        $result = mysql_query($query) or die("Error: " . mysql_error());
        $count = mysql_num_rows($result);

        if ($count == 1) {
            $r = mysql_fetch_row($result);
            $myuserid = $r[0];

            if ($myuserid > 0) {
                $_SESSION['login_userid'] = $myuserid;
                header("location: ./");
            } else {
                $error = "Login failed, please try again.";
            }
        } else {
            $error = "Your username or password is invalid.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>BlueTongue Time Logger: Login</title>

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />

    <script type="application/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="application/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script type="application/javascript" src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
</head>
<body>
    <div data-role="page">
    
        <div data-role="header">
            <h1>Login</h1>
        </div><!-- /header -->

        <div role="main" class="ui-content">

            <form method="post" data-ajax="false">

                <div class="ui-field-contain">
                    <label for="username">Username:</label>
                    <input name="username" id="username" type="text" title="Username" required>
                </div>

                <div class="ui-field-contain">
                    <label for="password">Password:</label>
                    <input name="password" id="password" type="password" title="Password" required>
                </div>

                <?php if ($error) { echo "<p style=\"color: red;\">$error</p>"; } ?>
                
                <button name="submit" id="submit" type="submit" class="ui-shadow ui-btn ui-corner-all ui-mini">Submit</button>
            
            </form>
        </div><!-- /content -->
    
        <div data-role="footer">
            <h4></h4>
        </div><!-- /footer -->

    </div><!-- /page -->
</body>
</html>