<?php

$warningtext = "";

if (isset($_GET['warning'])) {
	switch($_GET['warning']) {
		case "badlogin":
		$warningtext = "<div class=\"alert alert-danger text-center\">Bad credentials - please try again.</div>";
		break;
		case "unknown":
		$warningtext = "<div class=\"alert alert-danger text-center\">An error has occurred. You have been logged out.</div>";
		break;
		case "loggedout":
		$warningtext = "<div class=\"alert alert-danger text-center\">You have been logged out. Thank you.</div>";
		break;
		default:
		$warningtext = "";
		break;
	}
}

?>



<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>C3 Logging Interface - Login</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body>

    <div class="container" id="cont">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
				<a href="login.php"><img style="display:block;margin-bottom:-50px;padding-top:100px;margin-left:auto;margin-right:auto;" height="250" src="http://i.imgur.com/ZyviXTe.png" /></a>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    	<i class="fa fa-sign-in fa-fw"></i> Please Sign In
                    </div>
                    <div class="panel-body">
                        <form action="index.php?action=login" method="POST" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" <?php if (isset($_GET['username'])) { echo "value=\"".$_GET['username']."\""; } ?>name="username" type="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="remember">Keep Me Logged In
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="sent" value="Login" class="btn btn-lg btn-warning btn-block">
                            </fieldset>
                        </form>
                    </div>
                </div>
				<?php echo $warningtext; ?>
            </div>
        </div>
    </div>

	<script type="text/javascript" src="assets/jquery-1.5.1.js"></script>
	<script type="text/javascript" src="jquery.videoBG.js"></script>
	<script type="text/javascript" src="assets/script.js"></script>

</body>

</html>
