<?php

include "error_reporting.php";

session_start();

if (!isset($_SESSION['ID'])) {
	header('Location: index.php');
}

$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
$user = $_SESSION['username'];
$ticketid = $_GET['id'];

$query2 = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user' AND active = '2'");

if (mysqli_num_rows($query2) < 1) {
	header('Location: index.php');
}

if (isset($_POST['ticketanswersubmit'])) {
	$ticketanswertext = $_POST['ticketanswertext'];
	$ticketanswertext = nl2br($ticketanswertext);
	$ticketid = $_GET['id'];
	$user = $_SESSION['username'];

	mysqli_query($conn, "INSERT INTO ticketreplies (ticketid, user, text) VALUES ('$ticketid','$user','$ticketanswertext')");

	
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
		$text = $_POST['tickettext'];
		$submit = $_POST['ticketsubmit'];
		$user = $_SESSION['username'];

		mysqli_query($conn, "INSERT INTO tickets (title, text, user) VALUES ('$title','$text','$user')");
	}

	if (isset($_POST['finishedsubmit'])) {
		$ticketid = $_GET['id'];
		$query1 = mysqli_query($conn, "UPDATE tickets SET ongoing = '0' WHERE UID = '$ticketid'");
		$query2 = mysqli_query($conn, "UPDATE tickets SET finished = '1' WHERE UID = '$ticketid'");

		if ($query1 & $query2) {
			echo "Ticket finished";
		} else {
			echo "Couldn't finish ticket";
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


				

				<?php  
						$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
						$uid = $_GET['id'];
						$query = mysqli_query($conn, "SELECT * from tickets WHERE UID = '$uid'");
						
						while ($row = mysqli_fetch_assoc($query)) {
							$user = $row['user'];

							$query = mysqli_query($conn, "SELECT * from users WHERE username = '$user'");
							while ($row3 = mysqli_fetch_assoc($query)) {
								$userid = $row3['ID']; 
								
							}

							echo '<div id="tickettop"><h1>' . $row["title"] . '</h1> <br> <p id="tickettext">' . $row['text'] . '</p> <a href="Profile.php?ID=' . $userid . '"><p id="tickettopuser">' .  $row['user'] . '</p></a></div>';


							echo '';
						}

						$user = $_SESSION['username'];
						$getid = $_GET['id'];
						$queryx = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user' AND active = '2'");
						$queryz = mysqli_query($conn, "SELECT * FROM tickets WHERE finished = '1' AND UID = '$getid'");
						
						if (mysqli_num_rows($queryz) < 1) {
							while ($rowx = mysqli_fetch_assoc($queryx)) {
							echo '
							<form method="POST">
							<input type="submit" name="finishedsubmit" value="Finish" method="POST">
							</form>';
							
							}
						}
						



						$query = mysqli_query($conn, "SELECT * FROM ticketreplies WHERE ticketid = '$uid'");

						while ($row = mysqli_fetch_assoc($query)) {
							$user = $row['user'];
							$query2 = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user'");
							while ($row2 = mysqli_fetch_assoc($query2)) {
								$id = $row2['ID'];
							}
							if ($row['user'] == $_SESSION['username']) {
								echo '<div id="ticketanswer"><div id="ta">' . $row['text'] .   ' <br> <a href="profile.php?ID=' . $id . '">'  . $row['user'] . '</a></div></div><br>';
							} else {
								echo '<div id="ticketanswer2">' . $row['text'] .   ' <br> <a href="profile.php?ID=' . $id . '">'  . $row['user'] . '</a></div><br>';
							}
						}

						$getid = $_GET['id'];
						$query = mysqli_query($conn, "SELECT * FROM tickets WHERE UID = '$getid' AND finished = '1'");
						if (!mysqli_num_rows($query) > 0) {
							echo '<center><form method="POST"><textarea id="ticketanswertext" name="ticketanswertext"></textarea><br><input id="ticketanswersubmit" type="submit" name="ticketanswersubmit" value="Submit answer" method="POST"></form></center>';
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