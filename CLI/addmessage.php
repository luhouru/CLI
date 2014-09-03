<?php

function addmessage($major, $minor, $message) {

	// Connecting to database
	$connection = mysql_connect("localhost", "chrisluk", "continuum");
	if (!$connection) { 	// Database connect failed
		echo "Could not connect to database" . mysql_error;
		error_log("in function: express_mail, "."could not connect to database." . mysql_error);
		exit();
	}

	$db_name = 'reporting';
	if (!mysql_select_db($db_name, $connection)) {
		die("Could not select database" . mysql_error());
		error_log("in function: table");
	}
/* 	
	// INSERT INTO TABLE VALUES FROM FORM
	$major = $_POST['major'];
	$sub_input = $_POST['minor'];
	$msg_input = $_POST['message']; */
	
	// grab max id value for major, subtype, AND message
	$max_major_query = "SELECT MAX(code) AS code FROM messages WHERE type=1;";
	$max_major_result = mysql_query($max_major_query);
	$max_major_row = mysql_fetch_assoc($max_major_result);
	$max_major_val = $max_major_row['code'];
	$major_max = $max_major_val + 1;
	
	$max_sub_query = "SELECT MAX(code) AS code FROM messages WHERE type=2;";
	$max_sub_result = mysql_query($max_sub_query);
	$max_sub_row = mysql_fetch_assoc($max_sub_result);
	$max_sub_val = $max_sub_row['code'];
	$sub_max = $max_sub_val + 1;
	
	$max_msg_query = "SELECT MAX(code) AS code FROM messages WHERE type=3;";
	$max_msg_result = mysql_query($max_msg_query);
	$max_msg_row = mysql_fetch_assoc($max_msg_result);
	$max_msg_val = $max_msg_row['code'];
	$msg_max = $max_msg_val + 1;
	
	$uid_query = "SELECT MAX(uid) AS uid FROM messages;";
	$uid_result = mysql_query($uid_query);
	$uid_row = mysql_fetch_assoc($uid_result);
	$uid_val = $uid_row['uid'];
	$uid_max = $uid_val + 1;
	$uid_maxx = $uid_max+1;
	$uid_maxxx = $uid_maxx+1;
	
	// insert the new form inputs into the database
	$insert_major_query = "INSERT INTO messages VALUES ('$uid_max', 1, '$major_max', '$major')";
	$insert_sub_query = "INSERT INTO messages VALUES ('$uid_maxx', 2, '$sub_max', '$minor')";
	$insert_msg_query = "INSERT INTO messages VALUES ('$uid_maxxx', 3, '$msg_max', '$message')";
	
	// Insert into tables
	if (!empty($major)) {
		if (!mysql_query($insert_major_query)) {
			die("Error: " . mysql_error());
		}
	} else { $major_max = NULL;
	}
	
	if (!empty($minor)) {
		if (!mysql_query($insert_sub_query)) {
			die("Error: " . mysql_error());
		}
	} else { $sub_max = NULL;
	}
	
	if (!empty($message)) {
		if (!mysql_query($insert_msg_query)) {
			die("Error: " . mysql_error());
		}
	} else { $msg_max = NULL;
	}
#array(major code, major, minor code, minor, message code, message)
$array = array($major_max, $major, $sub_max, $minor, $msg_max, $message);
return $array;
}
?>