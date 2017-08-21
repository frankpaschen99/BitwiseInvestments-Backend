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
	<body>
		<?php
			
			$_SESSION["balance"] = getBalance($client);
			$_SESSION["stake"] = calc_stake($client);
			$_SESSION["profit"] = calc_profit($client)
			
		?>
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


		<!-- One -->
			<section id="one" class="wrapper style4 special">
				<div class="container">
					<header class="major">
						<h2>Investor Dashboard</h2>
						<p>Manage your investment</p>
					</header>
					<div class="row 150%">
						<div class="4u 12u$(medium)">
							<section class="box infobox">
								<h3 style="color:#474747;">Your Balance</h3>
								<p style="color:#858585;">&#3647; <?php echo $_SESSION["balance"]; ?></p>
							</section>
						</div>
						<div class="4u 12u$(medium)">
							<section class="box infobox">
								<h3 style="color:#474747;">Your Stake</h3>
								<p style="color:#858585;"><?php echo round($_SESSION["stake"], 2); ?>%</p>
							</section>
						</div>
						<div class="4u$ 12u$(medium)">
							<section class="box infobox">
								<h3 style="color:#474747;">Your Projected Profit</h3>
								<p style="color:#858585;">&#3647; <?php echo $_SESSION["profit"]; ?>/day</p>
							</section>
						</div>
					</div>
				</div>
			</section>
			<section id="one" class="wrapper style1 special">
				<div class="container">
					<div class="row 150%">
						<div class="4u 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color9 fa-arrow-up"></i>
								<h3>Invest</h3>
							    <?php 
							    echo("<img src=https://chart.googleapis.com/chart?cht=qr&chs=192x192&chl=" . getWallet($db) . "/>");
							    ?>
								<p><?php echo getWallet($db);?></p>
							</section>
						</div>
						<div class="4u 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color1 fa-exchange"></i>
								<h3>Instantly Invest or Divest</h3>
							</section>
						</div>
						<div class="4u$ 12u$(medium)">
							<section class="box">
								<i class="icon big rounded color6 fa-arrow-down"></i>
								<h3>Divest</h3>
								<form method="post" action="divest.php">
								<div class="row uniform 50%">
									<input type="text" id="inputAddress" name="inputAddress" value="" placeholder="your wallet address" /> </br>
									<input type="text" id="inputAmount" name="inputAmount" value="" placeholder="amount to divest" />
									<div class="12u$">
										<ul class="actions">
											<li><input type="submit" value="Confirm Divestment" class="special" /></li>
										</ul>
									</div>
								</div>
							</form>
							</section>
						</div>
					</div>
				</div>
				<div class="container" style="text-align:left;">
					<h4>Transaction History</h4>
					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
									<th>Date</th>
									<th>Description</th>
									<th>Status</th>
									<th>Amount</th>
									<th>Type</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (isLoggedIn()) {
									$transactions = $client->getAccountTransactions(getAccount(getName(), $client));
									foreach($transactions as $t) {
									$date = $t->getCreatedAt();
									$result = $date->format('Y-m-d H:i:s');
									
									echo '<td>' . $result . '</td>';
									echo '<td>' . $t->getDescription() . '</td>';
									echo '<td>' . $t->getStatus() . '</td>';
									echo '<td>' . $t->getAmount()->getAmount() . '</td>';
									echo '<td>' . $t->getType() . '</td>';
									echo '</tr>';
									}
								}
								?>
							</tbody>
						</table>
					</div>
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
<!--
	                 !#########       #
               !########!          ##!
            !########!               ###
         !##########                  ####
       ######### #####     Scruffix    ######
        !###!      !####!              ######
          !           #####            ######!
                        !####!         #######
                           #####       #######
                             !####!   #######!
                                ####!########
             ##                   ##########
           ,######!          !#############
         ,#### ########################!####!
       ,####'     ##################!'    #####
     ,####'            #######              !####!
    ####'                                      #####
    ~##                                          ##~
-->
