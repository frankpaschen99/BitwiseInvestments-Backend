<?php
	require_once("functions.php");
	require_once("config.php");
	
	echo "<h1>Withdraw</h1><br />";
	
	$amount = $_POST["inputAmount"];
	$address = $_POST["inputAddress"];
	
	echo "<h4>Processing your transaction... Thank you.</h3>";
	
	sleep(3);
	
	if (!isLoggedIn()) {
		echo "You are not logged in!<br />";
	} else if (empty($amount) || empty($address)) {
		echo "You did not fill in all of the required fields!<br />";
	} else if (getBalance($client) < $amount) {
		echo "You don't have that much!<br />";
	} else if ($amount < 0.0001) {
		echo "The amount you are trying to withdraw is below the minimum! <br />";
	} else {
		withdraw($amount, $address, $db, $client);
		echo "Sending " . $amount . " BTC to " . $address . "... Please wait.<br />";
		sleep(3);
	}
	echo "Click " . "<a href=https://.com/invest.php>here</a> to return to the Investment panel.";
?>