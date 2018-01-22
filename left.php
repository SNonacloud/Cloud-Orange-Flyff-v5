<div id="left">
				
			

				<?php  if (!isset($_SESSION['ID']))  { ?>
				

			<div id="login">
				
				
				<div id="logintitle">
					<h2>Login</h2>		
				</div>

				<div id="logincontent">
					<form action="index.php" method="POST">
						
						<input id="username" type="text" name="username"> 
												
						<input id="password" type="password" name="password"> <br>
														
						<center><input id="loginbutton" type="submit" name="login" value="Login"></center> <br><br>
						
					</form>

				<div id="errordiv">
				<?php 
				
				error_reporting(0);
				
				foreach ($errors as $e) {
				echo "$e";
				echo "<br>";
				}
				
				error_reporting(1);
				?>
				</div>
				<div id="noaccdiv">
					<h6 id="noacc">No account? <a href="register.php">Register</a> <a id="forgot" href="recover.php">Forgot Password?</a></h6>
				</div>	

				</div><!-- end of Logincontent -->
			</div> <!-- end of Login -->
			
			<?php 

			} else {

				?>

				
		

				<div id="loggedin">



				<?php 

				$user = $_SESSION['username'];
				date_default_timezone_set("Europe/Stockholm");
				$date = date("o/j/n");
				

				mysqli_query($conn, "UPDATE users SET lastsignin = '$date' WHERE username = '$user'");
				$user = $_SESSION['username'];
				$id = $_SESSION['ID'];
				
				?>
				<div id="usernametitle"><h2> <?php $user = $_SESSION['username']; echo "$user"; ?></h2></div><br>

				<div id="loggedincontent">
					<?php  
						echo '<a id="bla" href="Profile.php?ID=' . $_SESSION["ID"] . '">My Profile</a><br>';

							echo '<div id="messages"><a id ="bla" href="messages.php">Messages</a>';

								$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
								$user = $_SESSION['username'];
								$query = mysqli_query($conn, "SELECT * FROM messages WHERE receiver = '$user' AND opened = '0'");
								
								if ($row = mysqli_num_rows($query)) {
									echo '<div id="message">' . $row .  '</div>';
								} else {
									
								}

							echo "</div>";

					

					echo '<a id="bla" href="settings.php?ID=' . $id . '">Settings</a><br>';

					echo '<a id="bla" href="ticket.php">Tickets</a><br>';
					
					  
					$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
					$query = mysqli_query($conn, "SELECT active FROM users WHERE username = '$user' and active = 2");

					if (mysqli_num_rows($query) == 1) {
						echo '<a id="bla" href="adminpanel.php">Adminpanel</a><br>';
					}


					


					?>


				</div>

				<?php 
					$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
					$profileid = $_SESSION['username'];
					$query = mysqli_query ($conn, "SELECT * from users WHERE username = '$profileid'");

					while ($row = mysqli_fetch_assoc($query)) {
						
						echo '<div id="leftprofilepic"><img src="' . $row["profilepic"] . '"></div>';

					}

				?>

				<br>

				<div id="logout"><a href='logout.php'>Logout</div></a>


				

				
				</div> <!-- end of Login -->

						<?php


			}	

			?>

					

				<div id="latestposts">
					<div id=latestpoststitle> <h2>Latest Threads</h2> </div>
					<?php
						$conn2 = mysqli_connect("localhost", "root", "", "cloudorangeforum");
						$query2 = mysqli_query($conn2, "SELECT * FROM Threads ORDER BY UID DESC LIMIT 20");

						while ($row = mysqli_fetch_assoc($query2)) {
							echo '<a href="Thread.php?id=' . $row["UID"] . '">' . $row["Title"]. '</a><br>';
						}


					?>
					
				</div>
			</div>