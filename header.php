

<div id="headerdiv">

	<div id="onlinewrapper">


			<?php
			    $online = @fsockopen("92.244.19.225", 5400, $errno, $errstr, 1);
			    if($online >= 1) {

				echo '<div id="online"></div>';

				} else {
					echo '<div id="offline"></div>';
				}

			?>
			





<?php 

	$servername = "WIN-HL5B9GQ0UQA\SQLEXPRESS, 49170";
		$connectioninfo = array ("UID"=>"sa", "PWD"=>"G4sfasgada", "Database"=>"ACCOUNT_DBF");
		$sqlsrvconn = sqlsrv_connect($servername, $connectioninfo);
		$result = "SELECT * FROM ACCOUNT_TBL_DETAIL WHERE isuse  = 'J'";


		$query = sqlsrv_query($sqlsrvconn, $result, array(), array( "Scrollable" => 'static' ));

				$onlinerow = sqlsrv_num_rows($query);
				
				
				echo "<div id='userssonline'>" . $onlinerow . "</div>";


?>






</div>
			












			<ul id="header">
				<li><a href="Index.php">Home</a></li>
				<li><a href="downloads.php">Downloads</a></li>
				<li><a href="forum.php">Forum</a></li>
				<li><a href="register.php">Register</a></li>
				
				<li><a href="ranking.php">Ranking</a></li>
				<li><a href="vote.php">Vote</a></li>
				<?php  	

						if (isset($_SESSION['ID'])) {
							echo '<li><a href="Profile.php?ID=' . $_SESSION["ID"] . '">My Profile</a></li>';
						} else {
						echo '<li>My Profile</li>';

						}
					?>
				<li><a href="faq.php">F.A.Q</a></li>
			</ul>

			<!-- <img id="flyingboy" src="Assets/flyingboy.png">
			<img id="flyinggirl" src="Assets/flyinggirl.png"> -->

		</div> 

