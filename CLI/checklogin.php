<?php

function checklogin($username, $password) {

$db = mysqli_connect("localhost", "root", "continuum", "users");
		
	if (!$db) {
		return 2;
	}
	
	$password = sha1($password);
	$result = mysqli_query($db,"SELECT * FROM users WHERE username = '$username' AND password = '$password'");
	if (!$result) {
		return FALSE;
	} else {
		$real = mysqli_fetch_assoc($result);
		if ($real['username'] == $username && $real['password'] == $password) {
		return TRUE;
		} else {
			echo "Wrong Username or Password";
		return FALSE;
		}
	}

	return FALSE;
}

?>