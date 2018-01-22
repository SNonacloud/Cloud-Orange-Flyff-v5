<div id="footer">
			<div id="logo2div">	
				<img id="logo2" src="Assets/logo.png">
			</div>

			<div id="footermenu">
				<ul>
							<li><a href="Index.php">Home</a></li>
							<li><a href="downloads.php">Downloads</a></li>
							<li><a href="forum.php">Forum</a></li>
							<li><a href="register.php">Register</a></li>
							
				</ul>
			</div>

			<div id="footermenu3">
				<ul>
							
							<li><a href="vote.php">Vote</a></li>
							<li><a href="about.php">About</a></li>
							<?php  	

									if (isset($_SESSION['ID'])) {
										echo '<li><a href="Profile.php?ID=' . $_SESSION["ID"] . '">My Profile</a></li>';
									} else {
									echo '<li><a href="index.php">My Profile</a></li>';

									}
								?>
							<li><a href="faq.php">F.A.Q</a></li>
				</ul>
			</div>



			<div id="footermenu2">
				<ul>
							<li><a href="index.php">Kontakta Mig</a></li>
							<li><a href="index.php">Hitta Mig</a></li>
							<li><a href="index.php">Vanliga Frågor</a></li>
							<li><a href="index.php">Om Cookies</a></li>
				</ul>
			</div>

			

		</div>

		<div>
			<img id="bottompic" src="Assets/footer.png">
			
		</div>