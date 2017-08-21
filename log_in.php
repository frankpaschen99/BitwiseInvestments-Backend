<?php
session_start();
require_once("config.php");
require_once("functions.php");

$username = strtolower($_POST["username"]);
$password = $_POST["password"];

$stmt = $db->prepare("SELECT password FROM users WHERE username = :username");
$stmt->bindValue(':username', strtolower($username), PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch();

$hashed_password = $row["password"];
$query = userQuery("SELECT username FROM users WHERE username = ?", $db, $username);

if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
	$_SESSION["username"] = strtolower($username);
	header('Location: index.php');
}
else if (!empty($username) && !empty($password)) {
	echo '<div class="alert alert-dismissible alert-danger fade in" style="width: 60%; margin: auto; color:#FFF;">
				<strong>Oh no!</strong> Either your username or password is incorrect!
				</div>';
} 
?>
<!DOCTYPE html>
<html lang="en">
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
						<h2>Sign in to </h2>
						<p>Welcome Back!</p>
					</header>
				</div>
				<div class="container 50%">
					<form action="log_in.php" method="post">
						<div class="row uniform">
							<div class="6u 12u$(small)">
								<input name="username" id="username" value="" placeholder="Username" type="text">
							</div>
							<div class="6u$ 12u$(small)">
								<input name="password" id="password" value="" placeholder="Password" type="password">
							</div>
							<div class="12u$">
								<ul class="actions">
									<li><input value="Log In" class="special big" type="submit"></li>
								</ul>
							</div>
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

	</body>