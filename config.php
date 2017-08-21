<?php
	require_once("libraries/vendor/autoload.php");
	use Coinbase\Wallet\Resource\Account;
	use Coinbase\Wallet\Client;
	use Coinbase\Wallet\Configuration;
	use Coinbase\Wallet\Resource\Address;
	
	$GLOBALS["ROI"] = 0.16; // 160% ROI for now
	
	// Configure the database here
	$DB_USER = "";
	$DB_NAME = "";
	$DB_PASS = "";
	$DB_HOST = "";
	
	$db = new PDO("mysql:dbname=$DB_NAME;host=$DB_HOST", $DB_USER, $DB_PASS);
	// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Configure the Coinbase api and create a Client object
	$configuration = Configuration::apiKey('', '');
	$client = Client::create($configuration);
?>