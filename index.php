<?php
	require_once("config.php");
	require_once("functions.php");
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
	<body class="landing">

		<!-- Header -->
			<header id="header">
				<h1><a href="index.php"></a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="invest.php">Dashboard</a></li>
						<li><a href="terms.php">Terms</a></li>
						<li><a href="https://bitcointalk.org/index.php?topic=1321732">Talk</a></li>
						<li><a href="index.php#three">Contact Us</a></li>
						<?php if(!isLoggedIn()){ echo "<li>|</li>
						<li><a href='log_in.php'>Sign In</a></li>
						<li><a href='register.php'' class='button special'>Sign Up</a></li>";}else{
							echo "<li><a href='log_out.php'>Log Out</a></li><li><a href='#'' class='button special'>" . getName() . "</a></li>";}?>
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner">
				<h2>Welcome to </h2>
				<p>The Smarter, Safer Way to Grow Your Bitcoin</p>
				<ul class="actions">
					<li>
						<a href="invest.php" class="button big">Invest Now</a>
					</li>
				</ul>
			</section>

		<!-- One -->
			<section id="one" class="wrapper style1 special">
				<div class="container">
					<header class="major">
						<h2>Why ?</h2>
						<p>Invest with  today and earn 16% daily compounding interest</p>
					</header>
					<div class="row 150%">
						<div class="4u 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color1 fa-bitcoin"></i>
								<h3>Broad Investment Spectrum</h3>
								<p>0.001btc Minimum Investment </br> 5btc Maximum Investment </br> Small or large investment- Choice is yours!</p>
							</section>
						</div>
						<div class="4u 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color9 fa-dashboard"></i>
								<h3>No Commitment Investing</h3>
								<p>Using our investment dashboard, you can divest partially or wholly instantly at any time- No strings attached!</p>
							</section>
						</div>
						<div class="4u$ 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color6 fa-line-chart"></i>
								<h3>No Fees, Big Growth</h3>
								<p> takes no fees off your investment. You will earn 16% daily compounding interest, guaranteed!</p>
							</section>
						</div>
					</div>
				</div>
			</section>

		<!-- Three -->
			<section id="three" class="wrapper style3 special">
				<div class="container">
					<header class="major">
						<h2>Questions? Concerns?</h2>
						<p>Email our admins!</p>
					</header>
				</div>
				<div class="container 50%">
					<form action="submit_ticket.php" method="post">
						<div class="row uniform">
							<div class="6u 12u$(small)">
								<input name="name" id="name" value="" placeholder="Name" type="text">
							</div>
							<div class="6u$ 12u$(small)">
								<input name="email" id="email" value="" placeholder="Email" type="email">
							</div>
							<div class="12u$">
								<textarea name="message" id="message" placeholder="Message" rows="6"></textarea>
							</div>
							<div class="12u$">
								<ul class="actions">
									<li><input value="Send Message" class="special big" type="submit"></li>
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
								<?php  if (isAdmin($db, getName()) && isLoggedIn()) {
									echo "<li><a href='admin_panel.php'>Admin Panel</a></li>";
								} ?>
							</ul>
						</div>
					</div>
				</div>
			</footer>

	</body>
</html>