<?php

include "error_reporting.php";

session_start();

	$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");

	if (isset($_POST['messagesubmit'])) {
		$text = $_POST['messagereply'];
		$text = htmlentities($text);
		$text = mysqli_real_escape_string($conn, $text);
		
		$convid = $_GET['ID'];
		$user = $_SESSION['username'];
		date_default_timezone_set("Europe/Stockholm");
		$date = date("o/j/n");

		$query = mysqli_query($conn, "SELECT * FROM conversations WHERE UID = '$convid'");
		while ($row = mysqli_fetch_assoc($query)) {
			if ($user == $row['user1']) {
				$receiver = $row['user2'];
			} else {
				$receiver = $row['user1'];
			}

			
		}

	

		$query2 = mysqli_query($conn, "INSERT INTO messages (conversationID, username, receiver, opened, text, date) VALUES ('$convid', '$user', '$receiver', '', '$text', '$date')");
		if ($query2) {
			
		} else {
			echo "Error sending message";
		}
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

			<div id="messagediv">
				
			

			<?php


				

				$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
				$user = $_SESSION['username'];
				$id = $_GET['ID'];

				mysqli_query($conn, "UPDATE messages SET opened = '1' WHERE conversationID = '$id' AND receiver = '$user'");


				$query2 = mysqli_query($conn, "SELECT user1, user2 FROM conversations WHERE UID = '$id'");
				while ($row2 = mysqli_fetch_assoc($query2)) {
				 	if ($user == $row2['user1']) {
				 		echo '<h1>' . $row2['user2'] . '</h1><br>';
				 	} else {
				 		echo '<h1>' . $row2['user1'] . '</h1><br>';
				 	}
				 } 

		
				$query = mysqli_query($conn, "SELECT * FROM messages WHERE conversationID = '$id' ORDER BY UID");

				while ($row = mysqli_fetch_assoc($query)) {
					$rowuser = $row['username'];
					$user = $_SESSION['username'];
					
					if ($user == $rowuser) {
						echo '<div id="messageleft">' . $row["text"] . '<br>' . $row["username"] . ' at ' . $row['date'] . '</div><br><br>';
					} else {
						echo '<div id="messageright">' . $row["text"] . '<br>' . $row["username"] . ' at ' . $row['date'] . '</div><br><br>';
					}

					echo '<br>';
					echo '<br>';
				}
				


				

			?>
			<center><div id="messageformdiv">
				<form id="messageform" method="POST">
					<textarea name="messagereply"></textarea>
					<br>
					<input type="submit" name="messagesubmit">
				</form>
			</div>
			</center>			

			</div>
			

		</div>

		
	
	</div>

	<?php
				include 'footer.php';
		?>
 
</body>
</html>