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
		<meta name="description" content="" />
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
	<body>

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
							echo "<li><a href='#'' class='button special'>" . getName() . "</a></li>";}?>
				</nav>
			</header>


		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">

					<header class="major">
						<h2>Terms and Conditions</h2>
						<p>Please take the time to read and understand our Terms and Conditions.</p>
					</header>

			 		<p>The following is the legal contact between You (Client) and . By registering an account with us you automatically state that you have read, fully understood, accept and agree to abide by our Terms and Conditions when using our services. Terms and Conditions defines  Invesment's services including Client and  Invesments obligations in regard to any transactions through the  Invesments website.</p>
			        <h4>1. General</h4>
			        <p>1.1. Residents of any country can open an investment account at .</p>
			        <p>1.2.  requires you to act as an individual and not on behalf of any other entity or authority.</p>  
			        <h4>2. Investment Plans</h4>
			        <p>2.1. Client deposits will be entered into the following plan: 16% daily interest, for an unlimited investment period.</p>
			        <p>2.2. The minimum for depositing to investment plan is 0.001 BTC and the maximum is 5btc.</p>
			        <p>2.3.  can modify investment plan conditions any time.</p>
			        <h4>3. Depositing funds</h4>
			        <p>3.1. You must deposit funds to the cryptocurrency address given in Investor Dashboard. You can make as many deposits as you want to the addresses. </p>
			        <p>3.2. After 3 confirmations in the blockchain, the database will register your investment as valid and your interest accrual will begin (it takes from 10 minutes to 1 hour to get 1 confirmation from the network). </p>
			        <h4>4. Payouts</h4>
			        <p>4.1.  investment plan earnings are paid once every week.</p>
			        <p>4.2. The unavailability of the  website due to technical reasons will not affect payouts.</p>
			        <p>4.3. Withdrawal of an investment (or part of an investment) may be done by a user at any point in time during the investment maturation period.</p>
			        <p>4.4. Large withdrawals may require admin confirmation, if this is the case the Client will be notified (large withdrawls usually process within 6hours of request).</p>
			        <h4>5. Warranties</h4>
			        <p>5.1.  warrants the safety of the invested amounts and interest stability.</p>
			        <p>5.2.  guarantees all payments made in time and under the terms stipulated in this Agreement.</p>
			        <p>5.3.  is not associated with any cryptocurrency payment system and not liable for any problems in their performance.</p>
			        <h4>6. Accepting Terms and Conditions</h4>
			        <p>6.1. Accepting our Terms and Conditions is the same with signing a contract, your registration on this website will act like an electronic signature on a contract. You agree that your age is legal in your country to participate in investment programs, and in all the cases your minimal age must be 18 years of age.</p>
			        <p>6.2. The Client agress to invest money which he/she can afford to lose. You understand that in all investment arrangements past performance is no guarantee of future performance.  has the right to reconfigure our existing investment plans at anytime.</p>
			        <p>6.3. You acknowledge that you are acting as an individual and not for any other entity. By investing, you agree, acknowledge, and accept that all information you receive is unsolicited, private communications of privileged, proprietary, and confidential information for you only and you agree to keep it private, confidential, and protected from any disclosure unless the information is obviously of a public nature.</p>
			        <h4>7. Copyright</h4>
			        <p>7.1. We respect the intellectual property rights of others, and require that the people who use  do the same.</p>
			        <p>7.2. The contents of this site is protected by copyright and trademark laws, and are the property of . Unless we say otherwise, you may access the materials located within  only for your personal use. </p>
			        <p>7.3. You may not modify, copy, publish, display, transmit, adapt or in any way exploit the content of  website. Only if you obtain prior written consent from us - and from all other entities with an interest in the relevant intellectual property - you may publish, display or commercially exploit any material from . To seek our permission, you may contact us. </p>
			        <h4>8. Liability and Force Majeure</h4>
			        <p>8.1.  is not responsible for delays in transmission of an order due to any reasons beyond its control.  does not control signal power, data transmission and receipt via Internet, or configuration of the Client`s computer equipment and reliability of its connection. </p>
			        <p>8.2.  is not accountable for any damage or loss of data caused by any events, actions or omissions, that lead to delay or distortions in the transmission of information, requests and orders due to a breakdown in any transmission facilities that are beyond the control of . </p>
			        <p>8.3.  cannot be held responsible for any data communication failure, distortion or delay if problems are from Client`s side. </p>
			        <p>8.4.  is not liable for any default under this Agreement resulted from force majeure circumstances, including but not limited to military actions, wars, strikes, rebellions, natural disasters, governmental bans, any breakdown in normal communications or utilities infrastructure services, etc. </p>
			        <h4>9. Terms and Conditions Amendments</h4>
			        <p>9.1.  reserves the right to modify Terms and Conditions at any time. You should check Terms and Conditions periodically for changes. By using this site after we post any changes to these terms and conditions, you agree to accept those changes, whether or not you have reviewed them. If at any time you choose not to accept these terms and conditions of use, please send in a support ticket and we will close down your account.</p>

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
</html>