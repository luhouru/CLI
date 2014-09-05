<?php
//set timezone for east coast
date_default_timezone_set('America/New_York');

//require supporting functions
/*require_once("/var/www/html/CLI/tablegen.php");
require_once("/var/www/html/CLI/genlogs.php");
require_once("/var/www/html/CLI/checklogin.php");
require_once("/var/www/html/CLI/addmessage.php");
require_once("/var/www/html/CLI/emailcalc.php");
require_once("/var/www/html/CLI/genchecklist.php");
require_once("/var/www/html/CLI/genlatestlogs.php");
require_once("/var/www/html/CLI/genlatestmsg.php");*/

require_once("tablegen.php");
require_once("genlogs.php");
require_once("checklogin.php");
require_once("addmessage.php");
require_once("emailcalc.php");
require_once("genchecklist.php");
require_once("genlatestlogs.php");
require_once("genlatestmsg.php");

//set login status and messages to default
$loggedin = FALSE;
$action = "home";
$warning = "redirect";
$alertset = FALSE;

//check to see if they're logging in
//note: load nothing until login is confirmed
if (isset($_GET['action'])) {
	if ($_GET['action'] == "login") {
		if (checklogin($_POST['username'],$_POST['password'])) {
		$loggedin = TRUE;
		$warning = "goodlogin";
		if (isset($_POST['remember'])) {
		$plustime = time();
		} else {
		$plustime = 3600;
		}
		setcookie("loggedin", TRUE, time()+$plustime);
		setcookie("username", $_POST['username'], time()+$plustime);
		} else {
		$warning = "badlogin&username=".$_POST['username'];
		}
	}
}

//check to see if they remain logged in
if(isset($_COOKIE["loggedin"]) && $_COOKIE['loggedin'] == TRUE) {
	$loggedin = TRUE;
	$warning = "goodlogin";
}

//if they're not logged in, send them back to the login page
//sorry!
if (!$loggedin) {
header('Location: login.php?warning='.$warning);
die();
}


//check to see if there are any other actions they want
//if not, show the general dashboard
if (isset($_GET['action'])) {
	switch($_GET['action']) {
	case "login":
		if (checklogin($_POST['username'],$_POST['password'])) {
		$loggedin = TRUE;
		$warning = "goodlogin";
		setcookie("loggedin", TRUE, time()+3600);
		setcookie("username", $_POST['username'], time()+3600);
		$_COOKIE['username'] = $_POST['username'];
		} else {
		$warning = "badlogin&username=".$_POST['username'];
		}
	break;
	
	case "logout":
		unset($_COOKIE['loggedin']);
        unset($_COOKIE['username']);
        setcookie("loggedin", null, -1);
        setcookie("username", null, -1);
		header('Location: login.php?warning=loggedout');
		die();
	break;
	
	case "addmessage":
	if (!isset($_POST['major'])) {
		$_POST['major'] = NULL;
	}
	if (!isset($_POST['minor'])) {
		$_POST['minor'] = NULL;
	}
	if (!isset($_POST['message'])) {
		$_POST['message'] = NULL;
	}
	
	$alert = addmessage($_POST['major'],$_POST['minor'],$_POST['message']);
	$alertset = TRUE;
	break;
	
	case "calculate":
	$alert_calc = return_el();
	break;
	
	default:
	$action = "home";
	break;
	}
} else {

}


//grab the user details
$db = mysqli_connect("localhost", "root", "continuum", "users");
$query = "SELECT * FROM users where username='".$_COOKIE['username']."'";
$result = mysqli_query($db, $query);
$userdetails = mysqli_fetch_assoc($result);
mysqli_close($db);

$subtitle = "";
if (isset($_GET['page'])) {
	switch($_GET['page']) {
		case "tools":
		$subtitle = "Report Tools";
		break;
			
		case "logs":
		$subtitle = "Error Logs";
		break;
				
		case "cron":
		$subtitle = "Cron Job Checklist";
		break;
				
		default:
		$subtitle = "Dashboard";
		break;
		}
	} else {
	//default page
	$subtitle = "Dashboard";
	}

	$cronalert = NULL;
	
if (isset($_GET['action']) && $_GET['action'] == "post" && $_GET['page'] == "cron") {

$host = "localhost";
$users = "logchecks";
$pass = "logger";
$base = "logchecks";

$success = TRUE;

$images_status   = 0;
$subnets_status  = 0;
$billings_status = 0;
$cron_status     = 0;

$connect = mysqli_connect($host, $users, $pass, $base);

$time = date('jS F Y h:i:s A',time());
$uid = time();
$user = $userdetails['firstname'];

$images_text     = $_POST['aws_describe_images_text'];
$subnets_text    = $_POST['aws_describe_subnets_text'];
$billings_text   = $_POST['get_save_billings_text'];
$cron_text       = $_POST['cron_test_msp_text'];

$images_status   = $_POST['aws_describe_images_status'];
$subnets_status  = $_POST['aws_describe_subnets_status'];
$billings_status = $_POST['get_save_billings_status'];
$cron_status     = $_POST['cron_test_msp_status'];
	
if (mysqli_query($connect, "INSERT INTO logchecks (uid, time, images_status, images_text, subnets_status, subnets_text, billings_status, billings_text, cron_status, cron_text, user) VALUES ($uid, '$time', '$images_status', '$images_text', '$subnets_status', '$subnets_text', '$billings_status', '$billings_text', '$cron_status', '$cron_text', '$user')")) {
$cronalert = "posted";
} else {
$cronalert = "failed";
}
mysqli_close($connect);
}

	
	
?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Continuum Logging Interface</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="css/plugins/timeline/timeline.css" rel="stylesheet">
	
    <!-- Page-Level Plugin CSS - Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php echo "<b>C3 Logging Interface:</b> Welcome, ".$userdetails['firstname'].". The date is ".date('F jS, Y',time()) .". It is ".date('h:iA',time())."."; ?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="index.php?page=admin"><i class="fa fa-gear fa-fw"></i> Admin Panel</a>
                        </li>
                        <li><a href="index.php?action=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
							<div style="margin-top: -20px;margin-bottom:-8px;" class="panel-heading">
                            <center><small><b>Error Code Lookup</b></small></center>
							</div>
							<form action="index.php?page=<?php if (isset($_GET['page'])) { echo $_GET['page']; } else { echo "search"; } ?>&action=lookup" method="POST" role="form">
                            <div class="input-group custom-search-form">
                                <input type="text" name="codesearch" class="form-control" placeholder="Ex: 1_0_20, 0-0-12">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
							</form>
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Error Dashboard</a>
                        </li>
						<li>
                            <a href="index.php?page=logs"><i class="fa fa-bar-chart-o fa-fw"></i> Error Logs</a>
                        </li>
						<li>
                            <a href="index.php?page=tools"><i class="fa fa-wrench fa-fw"></i> Report Tools</a>
                        </li>
						<li>
                            <a href="index.php?page=cron"><i class="fa fa-table fa-fw"></i> Cron Checklist</a>
                        </li>
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 style="line-height:60px;" class="page-header"><b>CLI</b> <small><?php echo $subtitle; ?></small> <img style="vertical-align:middle;float:right;" height="60" src="http://static.spiceworks.com/images/vendor_page/0002/7221/continuum_CO.png" /></h1>
					
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<?php
				//alert for message addition
				$alertmessage = NULL;
				if (isset($alert[0])) {
					$alertmessage .= "<tr><td width=30><b>".$alert[0]."</b></td><td width=30> - </td><td>".$alert[1]."</td></tr>";
				}
				if (isset($alert[2])) {
					$alertmessage .= "<tr><td width=30><b>".$alert[2]."</b></td><td width=30> - </td><td>".$alert[3]."</td></tr>";
				}
					if (isset($alert[4])) {
				$alertmessage .= "<tr><td width=30><b>".$alert[4]."</b></td><td width=30> - </td><td>".$alert[5]."</td></tr>";
				}
					
				if ($alertmessage != NULL) {
					echo "<div class=\"alert alert-info\" style=\"padding-bottom: 0px;\"><b><center>New Messages Added</b></center><table style=\"margin-top:11px;margin-bottom: 0px;\" class=\"table\"><tbody>".$alertmessage."</tbody></table></div>";
				} else if (empty($alertmessage) && $alertset) {
					echo "<div class=\"alert alert-danger\"><b><center>No message added. Please input a message.</center></b></div>";
				}
				
				//alert for email calculator
				if (isset($alert_calc)) {
					echo "<div class=\"alert alert-info\"><b><center>Email Code: $alert_calc</center></b></div>";
				}
				
				if ($cronalert == "posted") {
					echo "<div class=\"alert alert-info\"><b><center>Successfully posted new cron status.</center></b></div>";
				} else if ($cronalert == "failed") {
					echo "<div class=\"alert alert-danger\"><b><center>Database error: failed to post new cron status.</center></b></div>";
				}
				
				if (isset($_GET['action']) && isset($_POST['codesearch']) && $_GET['action'] == "lookup") {
				preg_match_all('!\d+!', $_POST['codesearch'], $matches);
				$caser = count($matches[0]);
				
				$con = mysqli_connect("localhost", "root", "continuum", "reporting");
				
				switch ($caser) {
				case 0:
				$strings = "Invalid error code entered - please format as a series of three numbers.";
				break;
				case 1:
				$major_query = "SELECT text FROM messages WHERE (code=".$matches[0][0]." AND type=1)";
				$major_result = mysqli_fetch_assoc(mysqli_query($con, $major_query));
				$strings = "<b>Error Code Lookup:</b><br>Major: ".$major_result['text'];
				break;
				case 2:
				$major_query = "SELECT text FROM messages WHERE (code=".$matches[0][0]." AND type=1)";
				$major_result = mysqli_fetch_assoc(mysqli_query($con, $major_query));
				$minor_query = "SELECT text FROM messages WHERE (code=".$matches[0][1]." AND type=2)";
				$minor_result = mysqli_fetch_assoc(mysqli_query($con, $minor_query));
				$strings = "<b>Error Code Lookup:</b><br>Major: ".$major_result['text']."<br>Minor: ".$minor_result['text'];
				break;
				case 3:
				$major_query = "SELECT text FROM messages WHERE (code=".$matches[0][0]." AND type=1)";
				$major_result = mysqli_fetch_assoc(mysqli_query($con, $major_query));
				$minor_query = "SELECT text FROM messages WHERE (code=".$matches[0][1]." AND type=2)";
				$minor_result = mysqli_fetch_assoc(mysqli_query($con, $minor_query));
				$message_query = "SELECT text FROM messages WHERE (code=".$matches[0][2]." AND type=3)";
				$message_result = mysqli_fetch_assoc(mysqli_query($con, $message_query));
				$strings = $major_result['text']." ".$minor_result['text']."<br>".$message_result['text'];
				break;
				default:
				$strings = "Invalid error code entered - please format as a series of three numbers.";
				break;
				}
				
				mysqli_close($con);
				
				echo "<div class=\"alert alert-info\"><b><center>$strings</center></b></div>";
				}
				
				if (isset($_GET['page'])) {
				switch($_GET['page']) {
				case "tools":
				require_once("tools.php");
				break;
				
				case "logs":
				require_once("logs.php");
				break;
				
				case "cron":
				require_once("checklist.php");
				break;
                    
				default:
				require_once("dash.php");
				break;
				}
				} else {
				//default page
				require_once("dash.php");
				}
				
			?>
			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

	<!-- Page-Level Plugin Scripts - Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
	
    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

    <script>
    $(document).ready(function() {
		$.extend( $.fn.dataTable.defaults, {
			"iDisplayLength": 12
		} );
        $('#dataTables-example').dataTable();
    });
    </script>
	
	<script>
    $(document).ready(function() {
		$.extend( $.fn.dataTable.defaults, {
			"iDisplayLength": 10,
			"order": [[ 0, "desc" ]]
		} );
        $('#dataTables-latest').dataTable();
    });
    </script>
	
	    <script>
    $(document).ready(function() {
		$.extend( $.fn.dataTable.defaults, {
			"iDisplayLength": 12
		} );
        $('#dataTables-errors').dataTable();
    });
    </script>
	
	    <script>
    $(document).ready(function() {
		$.extend( $.fn.dataTable.defaults, {
			"iDisplayLength": 12
		} );
        $('#dataTables-data').dataTable();
    });
    </script>
	
	    <script>
    $(document).ready(function() {
		$.extend( $.fn.dataTable.defaults, {
			"iDisplayLength": 12
		} );
        $('#dataTables-php').dataTable();
    });
    </script>
	
	    <script>
    $(document).ready(function() {
		$.extend( $.fn.dataTable.defaults, {
			"iDisplayLength": 12
		} );
        $('#dataTables-lost').dataTable();
    });
    </script>
	
		    <script>
    $(document).ready(function() {
		$.extend( $.fn.dataTable.defaults, {
			"iDisplayLength": 12
		} );
        $('#dataTables-sync').dataTable();
    });
    </script>
	
	<?php
	$db = mysqli_connect("localhost", "root", "continuum", "reporting");
	$result = mysqli_query($db,"SELECT file, COUNT(*) FROM (SELECT file FROM errors UNION ALL SELECT file FROM data UNION ALL SELECT file FROM php) s GROUP BY file ORDER BY COUNT(*) DESC;");
	$errors = mysqli_fetch_all($result);
	$datas = "";
	foreach ($errors as &$val) {
		$val[0] = basename($val[0]);
		$datas .= "{ y: '$val[0]', a: $val[1]},";
	}
	?>
	
	<script>
	Morris.Bar({
		element: 'morris-file-bar',
		data: [
		<?php echo $datas; ?>
			],
		xkey: 'y',
		ykeys: ['a'],
		labels: ['Count']
	});
	</script>
	
</body>

</html>
