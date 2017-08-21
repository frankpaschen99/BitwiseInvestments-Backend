<?php
	require_once("config.php");

	use Coinbase\Wallet\Client;
	use Coinbase\Wallet\Configuration;
	use Coinbase\Wallet\Enum\CurrencyCode;
	use Coinbase\Wallet\Value\Money;
	use Coinbase\Wallet\Resource\Transaction;
	use Coinbase\Wallet\Resource\Account;

	session_start();

	/* Test if the SESSION variable username is empty.
	If so, return false (not logged in). Else, return true (logged in) */
	function isLoggedIn() {
		return !empty($_SESSION["username"]);
	}
	/* Return the email of a user from the database as a string */
	function fetchEmail( $username, $db ) {
		$row = userQuery("SELECT email FROM users WHERE username = ?", $db, $username);
		
		return $row['email'];
	}
	/* Return the date registered of a user from the database */
	function fetchRegisterDate( $username, $db ) {
		$row = userQuery("SELECT date_registered FROM users WHERE username = ?", $db, $username);
		
		return $row['date_registered'];
	}
	/* Return the ID of a user from the database */
	function fetchUserID( $username, $db ) {
		$row = userQuery("SELECT id FROM users WHERE username = ?", $db, $username);
		
		return $row['id'];
	}
	/* Query the database WHERE username = ? using secure prepared statements */
	function userQuery( $query, $db, $username ) {
		$stmt = $db->prepare($query);
		$stmt->bindValue(1, $username, PDO::PARAM_STR);
		$stmt->execute();
		$row = $stmt->fetch();
		
		return $row;
	}
	/* Return the balance of a user from the database as a decimal with (16,8) precision */
	function getBalance($client) {
		if (!isLoggedIn()) {
			return "0.00";
		}
		$user_acct = getAccount(getName(), $client);
		return $user_acct->getBalance()->getAmount();
	}
	function getAccount($username, $client) {
		foreach ($client->getAccounts() as $acct) {
			if ($acct->getName() == $username) 
			{
				return $acct;
			}
		}
	}
	/* Return the username of the current logged in user as a string */
	function getName() {
		if (isLoggedIn()) {
			return $_SESSION["username"];
		} else {
			return "not logged in";
		}
	}
	/* Query the database to test if a user is an admin and return true/false accordingly */
	function isAdmin($db, $username) {
		if (!isLoggedIn()) {
			return;
		}
		$query = userQuery("SELECT admin FROM users WHERE username = ?", $db, $username);
		return $query["admin"];
	}
	/* Return the deposit address of a user from the database as a string */
	function getWallet($db) {
		if (isLoggedIn()) {
			$query = userQuery("SELECT deposit_address FROM users WHERE username = ?" , $db, $_SESSION["username"]);
			return $query["deposit_address"];
		} else {
			return "not logged in";
		}
	}
	function calc_stake($client ) {
		if (!isLoggedIn()) {
			return;
		}
		$total = 0.00;
		$userBalance = getBalance($client);
		foreach($client->getAccounts() as $acct) {
			if ($acct->getName() == "BTC Wallet" || $acct->getName() == "Cold Wallet") {
				continue;
			}
			$total += $acct->getBalance()->getAmount();
		}
		return ($userBalance / $total) * 100;	
	}
	function calc_profit($client) {
		return sprintf('%.8F',(getBalance($client) + (getBalance($client) * $GLOBALS["ROI"])));
	}
	/* Processes a withdraw using the Coinbase API. If the transaction succeeds, the user is 
	credited in the database the negative amount they are withdrawing. */
	function withdraw($amount, $address, $db, $client) {	
		$user_wallet = getWallet($db);
		$user_acct = getAccount(getName(), $client);

		$transaction = Transaction::send([
			'toBitcoinAddress' => $address,
			'amount'           => new Money($amount, CurrencyCode::BTC),
			'description'      => 'Withdrawal from .com to ' . $address
		]);
		$client->createAccountTransaction($user_acct, $transaction);
	}
	/* This function updates the balance of a user in the database. */
	function credit_user($username, $amount, $db) {
		// note: backticks for columns, single quotes for fields
		$db->query("UPDATE users SET `balance` = '$amount' WHERE `username` = '$username'");
		echo "User " . $username . " has been credited " . $amount . " BTC in the database.<br />";
	}
	/* Don't call this manually. Use transfer_wallets_to_pot(). */
	function credit_all_users($db, $client) {
		foreach($client->getAccounts() as $acct) {
			$amount = $acct->getBalance()->getAmount();
			$username = $acct->getName();
			
			$stmt = $db->prepare("UPDATE users SET balance = ? WHERE username = ?");
			$stmt->bindValue(1, $amount * $GLOBALS["ROI"], PDO::PARAM_STR);
			$stmt->bindValue(2, $username, PDO::PARAM_STR);
			$stmt->execute();
		}
	}
	function reset_credit($db) {
		$db->exec("UPDATE users SET balance = 0");
	}
	function transfer_wallets_to_pot($client, $db) {
		credit_all_users($db, $client);
		foreach($client->getAccounts() as $acct) {
			if ($acct->getName() == "BTC Wallet") {
				// Skip the iteration when it comes across the BTC Wallet because that's the wallet we're paying into.
				continue;
			}
			if ($acct->getName() == "Cold Wallet") {
				// We don't want to pull any money from the Cold Wallet either.
				continue;
			}
			if ($acct->getBalance()->getAmount() < 0.001 || $acct->getBalance()->getAmount() > 5.0000) {
				// Only pull money from accounts with a balance of > 0.001 and < 5.0000
				continue;
			}
			$transaction = Transaction::send([
				'toBitcoinAddress' => '',	// Address of the BTC Wallet
				'amount'           => new Money($acct->getBalance()->getAmount(), CurrencyCode::BTC),
				'description'      => 'Transfer to main pot. User credited in database.'
			]);
			$client->createAccountTransaction($acct, $transaction);
		}
	}
	function return_profits($client, $db) {
		foreach($client->getAccounts() as $acct) {
			$wallet_sql = userQuery("SELECT deposit_address FROM users WHERE username = ?", $db, $acct->getName());
			$user_wallet = $wallet_sql["deposit_address"];
			$user_credit = get_credit($db, $acct->getName());
			$return_on_investment = ($user_credit * $GLOBALS["ROI"]);
			$main_wallet = getAccount("BTC Wallet", $client);
			
			$transaction = Transaction::send([
				'toBitcoinAddress' => $user_wallet,
				'amount'           => new Money($return_on_investment, CurrencyCode::BTC),
				'description'      => '16% Return on Investment'
			]);
			$client->createAccountTransaction($main_wallet, $transaction);
		}
		reset_credit($db);
	}
	function get_credit($db, $username) {
		$query = userQuery("SELECT balance FROM users WHERE username = ?", $db, $username);
		return $query["balance"];
	}
	function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
?>
