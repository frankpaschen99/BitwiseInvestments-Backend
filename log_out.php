<?php
	session_start();
	$_SESSION['logged-in'] = false;
	$_SESSION['username'] = null;
	header('Location: https://bitwiseinvestments.com/');
	die("Log out successful.");
?>