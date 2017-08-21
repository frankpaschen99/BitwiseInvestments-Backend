<?php
	require_once("functions.php");
	require_once("config.php");
	if (!isAdmin($db, getName()) || !isLoggedIn()) {
		header("https://.com/");
		die();
	}
	
	return_profits($client, $db);
	header("Location: admin_panel.php");
?>