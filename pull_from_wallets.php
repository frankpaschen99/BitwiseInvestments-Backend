<?php
	require_once("functions.php");
	require_once("config.php");
	if (!isAdmin($db, getName()) || !isLoggedIn()) {
		header("https://bitwiseinvestments.com/");
		die();
	}
	
	transfer_wallets_to_pot($client, $db);
	header("Location: admin_panel.php");
?>
