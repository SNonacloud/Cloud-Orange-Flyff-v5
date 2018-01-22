<?php

include "error_reporting.php";

session_start();

if (!isset($_SESSION['ID'])) {
	header('Location: index.php');
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


	if (isset($_POST['ticketsubmit'])) {
		$title = $_POST['tickettitle'];
		$title = htmlentities($title);
		$title = mysqli_real_escape_string($conn, $title);

		$text = $_POST['tickettext'];
		$text = nl2br($text);
		$text = htmlentities($text);
		$text = mysqli_real_escape_string($conn, $text);

		$submit = $_POST['ticketsubmit'];
		$user = $_SESSION['username'];

		if (empty($title)) {
			echo '<p id="ticketsubmiterror">Enter a title</p>';
			$submiterror = 1;	
		} else {
			$submiterror = 0;
		}

		
		if (empty($_POST['tickettext'])) {
			echo '<p id="ticketsubmiterror">Enter ticket</p> ';
			$submiterror = 1;	
		} else {
			$submiterror = 0;	
		}

		
		if ($submiterror == 1) {
			echo "Ticket Not submitted";
		} else {
			mysqli_query($conn, "INSERT INTO tickets (title, text, user) VALUES ('$title','$text','$user')");
			echo "Ticket submitted";
		}

		
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>CloudOrangeFlyff</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
	<link href="themes/1/js-image-slider.css" rel="stylesheet" type="text/css">
    <script src="themes/1/js-image-slider.js" type="text/javascript"></script>
   
</head>

<body>

	
	<?php  
		include 'logo.php';
	?>


	<div id="container">
		<!-- <img id="spd" src="Assets/f1.png"> -->

		<?php  
			include 'header.php';
		?>

		<div id="lmrcontainer">

			<?php
				include 'left.php';
				
			?>

			<div id="ticket">
				<h1>Tickets</h1>

				<div id="finong">
					<div id=finished>
					<h2>Finished Tickets</h2>

					<?php  
							$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
							$user = $_SESSION['username'];
							$query = mysqli_query($conn, "SELECT * from tickets WHERE user = '$user' AND finished = '1'");
							
							while ($row = mysqli_fetch_assoc($query)) {
								echo '<a href="ticketa.php?id=' . $row['UID'] . '">' . $row["title"] . '</a><BR>';
							}


						?>
					</div>
					<div id=ongoing>
					<h2>Ongoing Tickets</h2>

					<?php  
							$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
							$user = $_SESSION['username'];
							$query = mysqli_query($conn, "SELECT * from tickets WHERE user = '$user' AND ongoing = '1'");
							
							while ($row = mysqli_fetch_assoc($query)) {
								echo '<a href="ticketa.php?id=' . $row['UID'] . '">' . $row["title"] . '</a><br>';
							}


						?>
					</div>

						<center>
					

				<div id="newticket">	
					<h2>New Ticket</h2>

					<form method="POST">
						<input type="text" name="tickettitle" placeholder="Title" method="POST">
						<br>
						<br>
						<textarea id="newticketarea" type="text" name="tickettext" method="POST" placeholder="Text"></textarea>
						<br>
						<br>
						<input type="submit" name="ticketsubmit" method="POST">
					</form>
				</div>
				</center>
				</div>
				
			
			</div>

			

			

		</div>

		
	
	</div>

	
		<?php
			include 'footer.php';
		?>
			
	


 
</body>
</html>