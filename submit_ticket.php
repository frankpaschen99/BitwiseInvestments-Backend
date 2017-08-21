<?php
	require_once("config.php");
	require_once("functions.php");
	
	$name = $_POST["name"];
	$email = $_POST["email"];
	$message = $_POST["message"];
	
	$stmt = $db->prepare("INSERT INTO tickets(user, email, content, submitted) VALUES(?, ?, ?, NOW())");
	$stmt->execute(array($name, $email, $message));
	
	header("Location: https://.com/");
?>