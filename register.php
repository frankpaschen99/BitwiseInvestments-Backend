<?php
	require_once("config.php");
	require_once("libraries/vendor/autoload.php");
	require_once("libraries/captcha/autoload.php");
	use Coinbase\Wallet\Resource\Account;
	use Coinbase\Wallet\Client;
    use Coinbase\Wallet\Configuration;
	use Coinbase\Wallet\Resource\Address;
	
	session_start();
	
	$public_key = '';
	$private_key = '';
	
	if (isset( $_POST['submitbutton']) && !empty($_POST) && isset($_POST["g-recaptcha-response"])) {
		@$username = strtolower(htmlentities($_POST['username'], ENT_COMPAT | ENT_HTML401, 'UTF-8'));
		@$password = htmlentities($_POST['password'], ENT_COMPAT | ENT_HTML401, 'UTF-8');
		@$password_confirm = htmlentities($_POST["password_confirmed"], ENT_COMPAT | ENT_HTML401, 'UTF-8');
		
		@$email = $_POST['email'];
		$password_hash = password_hash($password, PASSWORD_BCRYPT);
		$account = new Account(['name' => $username]);
		$address = new Address(['name' => $username]);
		
		$recaptcha = new \ReCaptcha\ReCaptcha($private_key);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		
		$res = $db->query("SELECT username FROM users WHERE username='$username'");
		
		if ($res->rowCount() > 0) {
			echo '<div class="alert alert-dismissible alert-danger fade in" style="width: 60%; margin: auto; color:#FFF; ">
				  <strong style=color:#FFF>Oh snap! That username is taken!</strong> Choose a new one and try submitting again.
				  </div>';
		} else if (strlen($username) > 30) {
			echo '<div class="alert alert-dismissible alert-danger fade in" style="width: 60%; margin: auto; color:#FFF; ">
				  <strong>Your username is too long! It must be 30 characters or less.</strong> Choose a new one and try submitting again.
				  </div>';
		} else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) {
			echo '<div class="alert alert-dismissible alert-danger fade in" style="width: 60%; margin: auto; color:#FFF; ">
				  <strong>These characters are not allowed in a username: /[\'^£$%&*()}{@#~?><>,|=_+¬-]/</strong> Choose a new one and try submitting again.
				  </div>';
		} else if (!$resp->isSuccess()) {
			echo '<div class="alert alert-dismissible alert-danger fade in" style="width: 60%; margin: auto; color:#FFF; ">
				  <strong>The CAPTCHA was not filled out correctly.</strong>
				  </div>';
		} else {
			$client->createAccount($account);
			$client->createAccountAddress($account, $address);
			
			$deposit_address = $address->getAddress();

			$stmt = $db->prepare("INSERT INTO users(username, password, email, deposit_address, date_registered) VALUES(?, ?, ?, ?, NOW())");
			$stmt->execute(array(strtolower($username), $password_hash, $email, $deposit_address));
			
			$_SESSION["username"] = $username;
			header("location: https://.com/invest.php");
			die("registered");
		}
	}
?>
<html lang='en'>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="A new, safer way to grow your bitcoin!" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body class="landing" style="background-color:#383b43">
			<section id="three" class="wrapper style3 special">
				<div class="container">
					<header class="major">
						<h2>Create an account</h2>
						<p>Start investing today!</p>
					</header>
				</div>
				<div class="container 50%">
					<form id="register" action="register.php" method="POST">
						<input style="display:none" type="text" name="fakeusernameremembered"/>
						<input style="display:none" type="password" name="fakepasswordremembered"/>
						<div class="row uniform">
							<div class="6u 12u$(small)">
								<input type="text" id="inputUsername" class="form-control" placeholder="Username" required="" autofocus="" name="username">
							</div>
							<div class="6u$ 12u$(small)">
								<input type="email" id="inputEmail" class="form-control" placeholder="Email (optional but recommended)" autofocus="" name="email">
							</div>
							<div class="6u 12u$(small)">
								<input type="password" id="inputPassword" class="form-control" placeholder="Password" required="" autofocus="" name="password">
							</div>
							<div class="6u$ 12u$(small)">
								<input type="password" id="inputPasswordConfirm" class="form-control" placeholder="Confirm Password" required="" name="password_confirmed">
							</div>
							<div class="12u$">
								<div class="g-recaptcha" data-sitekey="6LffbhQTAAAAABC-WF-gGLNxK6dJR0jkOE_RsICk"></div>
								<ul class="actions">
									<li><input id="submit"value="Register" class="special big" type="submit" name="submitbutton"></li>
								</ul>
							</div>
							<p><a href="log_in.php">Already have an account? Log in!</a></p>
						</div>
					</form>
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<div class="row">
						<div class="8u 12u$(medium)">
							<ul class="copyright">
								<li>&copy; . All rights reserved.</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
	<script>
		$(document).ready(function() {
	    $( "#register" ).submit(function( event ) {
	 
	        if($('#inputPassword').val() != $('#inputPasswordConfirm').val()) {
	            alert("Password and Confirm Password don't match");
	            // Prevent form submission
	            event.preventDefault();
	        }
	         
	    });
	});
	</script>
	</body>
</html>
