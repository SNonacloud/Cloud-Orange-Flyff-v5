<?php

include "error_reporting.php";

session_start();
	
	if (isset($_POST['removepost'])) {
											$uid = $_GET	['id'];
											$conn = mysqli_connect("localhost", "root", "", "cloudorangeforum");
											mysqli_query($conn, "DELETE FROM Threads WHERE UID = '$uid'");
											mysqli_query($conn, "DELETE FROM Replies WHERE ThreadID = '$uid'");
	}

	if (isset($_POST['submitreply'])) {
						$connx = mysqli_connect("localhost","root", "", "cloudorangeforum");

						$replytext = $_POST['replytext'];
						$threadInsertID = $_GET['id'];
						$user = $_SESSION['username'];
						$userid = $_SESSION['ID'];

						date_default_timezone_set("Europe/Stockholm");
						$date = date("o/j/n G:i");
						ob_start();
						mysqli_query($connx, "INSERT INTO Replies (ThreadID, Reply, User, UserID, Date) VALUES ('$threadInsertID', '$replytext', '$user', '$userid','$date')");
						$currentpage = $_GET['id'];
						

						header('Location: abc123.php?id=' . $currentpage . '');
					} 

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

			

			<div id="threaddiv">
			<div id="threaddiv2">

				<?php 

					$conn = mysqli_connect("localhost", "root", "", "cloudorangeforum");

					$Thread = $_GET[id];

					$query2 = mysqli_query ($conn, "SELECT * From Threads WHERE UID = '$Thread'");


					while ($row = mysqli_fetch_assoc($query2)) {
						echo '<div id="findback"><p><a href="forum.php">Forum</a> > <a href="Category.php?category=' . $row['Category'] . '">' . $row['Category'] . '</a> > <a href="Thread.php?id=' . $Thread . '">' . $row['Title'] . '</a></p> </div>';
					}

									$id = $_SESSION['ID'];
									$conn2 = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
									$query3 = mysqli_query($conn2, "SELECT * FROM users WHERE ID = $id AND active = '2' ");
									
									if (mysqli_num_rows($query3) > 0) {

										echo '<form method="POST"><input type="submit" name="removepost" value="Remove Post" method="POST"></form>';	

									} 

				?>

			<div id="threaddiv3">
				

				<?php 
				

					$conn = mysqli_connect("localhost", "root", "", "cloudorangeforum");
					$conn2 = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");

					$category = $_GET[category];

					$query = mysqli_query ($conn, "SELECT * FROM Threads WHERE UID = '". $_GET['id']. "' ");

					if ($row = mysqli_fetch_assoc($query)) {
						$idfromuser = $row['User'];
					}



					$query2 = mysqli_query ($conn2, "SELECT * FROM users where Username = '$idfromuser'");

					if ($row2 = mysqli_fetch_assoc($query2)) {
						$ID = $row2['ID'];
						
					}

				
					$conn = mysqli_connect("localhost", "root", "", "cloudorangeforum");
					$query = mysqli_query ($conn, "SELECT * FROM Threads WHERE UID = '". $_GET['id']. "' ");


					while ($row = mysqli_fetch_assoc($query)) {
						echo '<div id="a1234"><h1>' . $row['Title'] . '</h1><br>' . $row['Content'] . '<br><br>Submitted by <a href="Profile.php?ID=' . $ID . '">' . $row['User'] . '</a> at ' . $row["Date"] . '</div><br>';

					}

					echo '</div>';

					echo '<h2>Replies</h2>';

					echo '<br>';

					$replyQuery = mysqli_query ($conn, "SELECT * FROM Replies WHERE ThreadID = '" . $_GET['id'] . "' ");

					error_reporting(0);			

					if ($row = mysqli_fetch_assoc($replyquery)) {
					 	$idfromuser = $row['User'];
					}

					error_reporting(1);		

					$conn2 = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");

					$query = mysqli_query($conn2, "SELECT * FROM users WHERE ID = '$idfromuser'");

					if ($row = mysqli_fetch_assoc($query)) {
						$ID = $row['ID'];
					}

					$conn = mysqli_connect("localhost", "root", "", "cloudorangeforum");



					while ($replies = mysqli_fetch_assoc($replyQuery)) {
						echo '<div id="threadreply">' . $replies["Reply"] . '<br><br>Submitted by <a id="Replyuserlink" href="Profile.php?ID=' . $replies['UserID'] . '">' . $replies["User"] . '</a> at ' . $replies["Date"] .'</div><br>';

					}

					if (isset($_SESSION['ID'])) {

					$replytext = $_POST['replytext'];
					$threadInsertID = $_GET['id'];
					$user = $_SESSION['username'];

					date_default_timezone_set("Europe/Stockholm");
					$date = date("o/j/n G:i");


					
				

				 ?>	

				

						<form  id="replybox" method="POST">
							<table>
								<tr>
									<td><h3>Post reply here!</h3></td>
								</tr>
											
							
								<tr>
									<td><textarea id="replytext" type="text" name="replytext" placeholder="Message" cols="50" rows="10"></textarea></td>
								</tr>
								

								<tr>
									<td><input id="submitreply" type="submit" name="submitreply" value="Post"></td>
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

		
	
	</div>

	<?php
				include 'footer.php';
		?>
 
</body>
</html>