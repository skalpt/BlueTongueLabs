<?php
    include("./includes/session.php");

    // Save data if a post was just made
    if($_POST) {
        // Get parameters
        $date = $_POST["input-date"];
        $hours = $_POST["input-hours"];
        $projectid = $_POST["select-project"];
        $task = ucfirst($_POST["input-task"]);
        $password = $_POST["input-password"];
        
        $query =
        "
            INSERT INTO time_Log (UserId, Date, Hours, ProjectId, Task)
                VALUES
                (
                    $userid,
                    '$date',
                    $hours,
                    $projectid,
                    '$task'
                );
        ";
        $result = mysql_query($query) or die("Error: " . mysql_error());
    }

    // Retrieve project details
    $query =
    "
        SELECT
            p.ProjectId,
            b.Name AS 'Business',
            p.Name AS 'Project'
        FROM
            time_Project p
            JOIN time_Business b ON
                b.BusinessId = p.BusinessId
        ORDER BY
            b.BusinessId,
            p.ProjectId;
    ";
    $projects = mysql_query($query) or die("Error: " . mysql_error());

    // Retrieve last 5 log entries
    $query =
    "
        SELECT
            u.Username,
            l.Date,
            l.Hours,
            b.Name AS 'Business',
            p.Name AS 'Project',
            l.Task
        FROM
            time_Log l
                JOIN time_User u ON
                    u.UserId = l.UserId
                JOIN time_Project p ON
                    p.ProjectId = l.ProjectId
                    JOIN time_Business b ON
                        b.BusinessId = p.BusinessId
        WHERE
            u.UserId = $userid
        ORDER BY
            l.LogId DESC
        LIMIT
            0, 5;
    ";
    $lastlogs = mysql_query($query) or die("Error: " . mysql_error());
?>

<!DOCTYPE html>
<html>
<head>
    <title>BlueTongue Time Logger</title>

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
    <!-- <link rel="stylesheet" href="https://rawgithub.com/arschmitz/jquery-mobile-datepicker-wrapper/v0.1.1/jquery.mobile.datepicker.css" /> -->
    <link rel="stylesheet" href="./assets/css/add2home.css" />
    <style>
        /* .ui-header .ui-title, .ui-footer .ui-title {
            margin: 0 5px;
        } */
        
        .ui-btn span {
            text-align: left;
            font-weight: normal;
        }
    </style>
    
    <script type="application/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="application/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script type="application/javascript" src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
    <!-- <script type="application/javascript" src="https://rawgithub.com/jquery/jquery-ui/1.10.4/ui/jquery.ui.datepicker.js"></script>
    <script id="mobile-datepicker" type="application/javascript" src="https://rawgithub.com/arschmitz/jquery-mobile-datepicker-wrapper/v0.1.1/jquery.mobile.datepicker.js"></script></head> -->
    <script type="application/javascript" src="./assets/js/add2home.js"></script>
    <script>
       function setCookie(cname,cvalue,exdays) {
            var d = new Date();
            d.setTime(d.getTime()+(exdays*24*60*60*1000));
            var expires = "expires="+d.toGMTString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i].trim();
                if (c.indexOf(name)==0) return c.substring(name.length,c.length);
            }
            return "";
        } 

        $(document).ready( function() {
        
            <?php if($_POST) { ?>
                $("#collapsible-lastlogs").collapsible("option", "collapsed", false);
                $("#table-lastlogs tbody tr:first").effect("highlight", {}, 3000);
                
                /* $("#table-lastlogs tbody tr:first").css("background-color", "rgba(0, 170, 0, 0.25)");
                
                setTimeout(function() {
                    $("#table-lastlogs tbody tr:first").animate({backgroundColor: "rgba(0, 0, 0, 0.04)"}, 1000);
                }, 3000); */
            
                setCookie("projectId",<?php echo $projectid; ?>,365);
            <?php } ?>

            var d = new Date();
            $('#input-date').val(d.getFullYear() + '-' + ('0' + (d.getMonth()+1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2));
            
            var projectId = getCookie("projectId");
            if (projectId != "") { $('#select-project').val(projectId).selectmenu("refresh"); }
        });
    </script>
</head>
<body>
    <div data-role="page">
    
        <div data-role="header">
            <h1>BlueTongue Time Logger</h1>
            <a href="logout.php" data-role="button" data-ajax="false" data-shadow="false" class="ui-btn-right">Logout</a> 
        </div><!-- /header -->

        <div role="main" class="ui-content">

            <div id="collapsible-lastlogs" data-role="collapsible">
                <h4>Last 5 entries</h4>

                <table data-role="table" id="table-lastlogs" data-mode="reflow" class="table-stripe ui-responsive">
                    <thead>
                        <tr>
                            <th data-priority="1">Name</th>
                            <th data-priority="2">Date</th>
                            <th data-priority="3">Hours</th>
                            <th data-priority="4">Business</th>
                            <th data-priority="5">Project</th>
                            <th data-priority="6">Task</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Add log items to table
                            while($row = mysql_fetch_array($lastlogs))
                            {
                                $username = $row["Username"];
                                $mysqldate = strtotime($row["Date"]);
                                $hours = $row["Hours"];
                                $business = $row["Business"];
                                $project = $row["Project"];
                                $task = $row["Task"];
                                
                                $phpdate = date("d/m/Y", $mysqldate);
                                
                                echo "<tr>";
                                    echo "<td>" . $username . "</td>";
                                    echo "<td>" . $phpdate . "</td>";
                                    echo "<td>" . (float)$hours . "</td>";
                                    echo "<td>" . $business . "</td>";
                                    echo "<td>" . $project . "</td>";
                                    echo "<td>" . $task . "</td>";
                                echo "</tr>";
                            }
                            mysql_data_seek($lastlogs, 0);
                        ?>
                    </tbody>
                </table>
            </div>

            <form method="post" data-ajax="false">

                <div class="ui-field-contain">
                    <label for="input-date">Date:</label>
                    <input
                        name="input-date"
                        id="input-date"
                        type="date"
                        title="Date (yyyy-mm-dd)"
                        placeholder="e.g. 2000-01-01"
                        pattern="(?:2)[0-9]{3}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2]))-(?:30)|(?:0[13578]|1[02])-(?:31))"
                        data-clear-btn="true"
                        required>
                </div>

                <div class="ui-field-contain">
                    <label for="input-hours">Hours:</label>
                    <input
                        name="input-hours"
                        id="input-hours"
                        type="number"
                        step="any"
                        title="Hours (#.#)"
                        placeholder="e.g. 1.5"
                        pattern="[0-9]*[.]?[0-9]+"
                        data-clear-btn="true"
                        required>
                </div>

                <div class="ui-field-contain">
                    <label for="select-project">Project:</label>
                    <select
                        name="select-project"
                        id="select-project"
                        title="project">
						<option value="-1">Select project</option>
						<?php
							// Add projects to drop-down
							$curbus = null;
							while($row = mysql_fetch_array($projects))
							{
								$projectid = $row["ProjectId"];
								$business = $row["Business"];
                                $project = $row["Project"];
                                
								if ($business != $curbus)
								{
									if ($curbus) echo "</optgroup>";
									echo "<optgroup label='" . $business . "'>";
									$curbus = $business;
								}
                                
								echo "<option value='" . $projectid . "'>";
								echo $project . "</option>";
							}
							if ($curbus) echo "</optgroup>";
                            mysql_data_seek($projects, 0);
						?>
                    </select>
                </div>
                
                <div class="ui-field-contain">
                    <label for="input-task">Task:</label>
                    <input
                        name="input-task"
                        id="input-task"
                        type="text"
                        title="Task"
                        placeholder="e.g. Researching themed decoration providers"
                        data-clear-btn="true"
                        required>
                </div>

                <button name="submit" id="submit" type="submit" class="ui-shadow ui-btn ui-corner-all ui-mini">Submit</button>
                
            </form>
        </div><!-- /content -->
    
        <div data-role="footer">
            <h4></h4>
        </div><!-- /footer -->

    </div><!-- /page -->
</body>
</html>