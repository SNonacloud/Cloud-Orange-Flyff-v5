<?php

session_start();

include "error_reporting.php";
	
	if (isset($_POST['login'])) {
		$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
		
		$username = strip_tags($_POST['username']);
		$password = strip_tags($_POST['password']);
		

		$username = stripslashes($username);
		$password = stripslashes($password);

		$username = mysqli_real_escape_string($conn, $username);
		$password = mysqli_real_escape_string($conn, $password);

		$md5password = md5($password);
		$errors = array();

		$sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);
		$id = $row['ID'];
		$email = $row['email'];
		$db_password = $row['password'];
		$db_active = $row['active'];

		

		$chkpass = mysqli_query($conn, "SELECT * FROM users WHERE password = '$md5password' AND username = '$username'");
		if (mysqli_num_rows($chkpass) < 1) {
			array_push($errors, "<p id='error'><b>The username or password is incorrect</b></p>");
		}	

		$checkact = mysqli_query($conn, "SELECT * FROM users WHERE username ='$username' AND active = 0");
		if (mysqli_num_rows($checkact) == 1) {
		array_push($errors, "<p id='error'><b>This account is not activated</p>");
								
		} 

		

		if (sizeof($errors) == 0) {

			
			$_SESSION['username'] = $username;
			$_SESSION['ID'] = $id;
			$_SESSION['email'] = $email;
			header("Location: index.php");
		}
	} 

	$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
	$polloption = $_POST['polloption'];
	$user = $_SESSION['username'];
	
	if (isset($_POST['votesubmit'])) {
		mysqli_query($conn, "INSERT INTO pollvotes (Voteoption, User) VALUES ('$polloption','$user')");
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>CloudOrangeFlyff</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
</head>
<body>
	
	<?php  
		include 'logo.php';
	?>


	<div id="container">

		<?php  
			include 'header.php';
		?>

		<div id="lmrcontainer">

			<?php  
				include 'left.php';
			?>



			<div id="profilediv">

				<?php  
					$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
					$conn2 = mysqli_connect("localhost","root", "", "cloudorangeforum");
					$profileid = $_GET['ID'];
					$query = mysqli_query ($conn, "SELECT * from users WHERE ID = '$profileid'");

					while ($row = mysqli_fetch_assoc($query)) {
						
						$user = $_SESSION['ID'];
						$byear = $row['birthyear'];
						$cyear = date("o");
						$year = $cyear - $byear;

						$query2 = mysqli_query($conn2, "SELECT * FROM replies WHERE UserID = '$user'");

						if ($query2) {
							if ($row2 = mysqli_num_rows($query2)) {
								$forumposts = $row2;
							}
						} else {
							$forumposts = 'No posts';
						}

						
						

						echo '<div id="profilepic"><center><img src="' . $row["profilepic"] . '"></center></div>';
						echo '<div id="profileusername"><h2>' . $row['username'] . '</h2></div><br>';
						echo '<div id="information"><h3>Information</h3>Gender : ' . $row['gender'] .  '<br>Country : ' . $row['country'] . '<br>Age : ' . $year . '<br>Forum posts : ' . $forumposts . '<br>Last sign in : ' . $row['lastsignin'] . '<br>';
						
						
						echo  '<br><h3>Favorites</h3>Food : <p>' . $row['food'] . '</p><br>Drink : <p>', $row['drink'] . '</p><br>Game : <p>', $row['game'] . '</p></div><br>';


						echo '<div id="biography"><h3>Biography</h3>' . $row["biography"] . '</div>';
					}

					$id = $_GET['ID']; 
					$queryx = mysqli_query($conn, "SELECT * FROM users WHERE ID = '$id'");
					while ($rowx = mysqli_fetch_assoc($queryx)) {
						$user = $rowx['username'];
					}

					/*
					echo '<div id="Profilemediadiv"><h2>Media</h2></div>';

					$query = mysqli_query($conn, "SELECT * FROM mediapictures WHERE user = '$user'");

					echo '<div id="profilemediawrapper">';
					while ($row = mysqli_fetch_assoc($query)) {
						echo '<div id="profilemedia"><img src="' . $row['name'] .'"></div>';
					}
					echo '</div>';
					*/

					echo '<div id="Profilecommenttitlediv"><h2>Comments</h2></div>';

					$query = mysqli_query ($conn, "SELECT * from profilecomments WHERE ProfileID = '$profileid'");

					while ($row = mysqli_fetch_assoc($query)) {
						
						echo '<div id="profilecomment">' . $row["Comment"] . '<br><br>Posted by <a href="Profile.php?ID=' . $row["PosterID"] . '"> ' . $row["PosterUsername"] . '</a> at ' . $row["Date"] . '</div>';
						
					}	



					if (isset($_SESSION['ID'])) {					


					$profilecomment = $_POST['commenttext'];
					$profilecomment = htmlentities($profilecomment);
					$profilecomment = mysqli_real_escape_string($conn, $profilecomment);
					$threadInsertID = $_GET['ID'];

					$user = $_SESSION['username'];
					$ID = $_SESSION['ID'];
					date_default_timezone_set("Europe/Stockholm");
					$date = date("o/j/n G:i");

					if (isset($_POST['submitcomment'])) {

						$profilecomment = nl2br($profilecomment);
						mysqli_query($conn, "INSERT INTO profilecomments (ProfileID, PosterUsername, PosterID, Comment, Date) 
							VALUES ('$threadInsertID', '$user', '$ID','$profilecomment', '$date')");

					
					
				}

				 ?>		

						


						<form  id="profilecommentbox" method="POST">
							<table>
								<tr>
									<td><h3>Post comment here!</h3></td>
								</tr>
											
							
								<tr>
									<td><textarea id="replytext" type="text" name="commenttext" placeholder="Message" cols="50" rows="10"></textarea></td>
								</tr>
								

								<tr>
									<td><input id="submitreply" type="submit" name="submitcomment" value="Post"></td>
								</tr>

												
							</table>					
						</form>

				<?php 
					
					} else { ?>

					<br>You must be logged in to comment


					<?php

					}
				 




				?>
				
			</div>
			

			

		</div>

		
	
	</div>

	<?php
				include 'footer.php';
		?>
 
</body>
</html>