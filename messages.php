<?php

include "error_reporting.php";

session_start();


	
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

			<div id="messagesdiv">
				
			<h1>Messages</h1>

			<?php

				$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
				$user = $_SESSION['username'];
				$query = mysqli_query($conn, "SELECT * FROM conversations WHERE user1 = '$user' OR user2 = '$user' ");

				while ($row = mysqli_fetch_assoc($query)) {

					$id = $row['UID'];
					$query2 = mysqli_query($conn, "SELECT * from messages WHERE conversationID = '$id' ORDER BY UID DESC LIMIT 1 ");
					while ($row2 = mysqli_fetch_assoc($query2)) {
						$text = $row2['text'];
					}

					if ($user == $row['user1']) {
						echo '<h2><a href="message.php?ID=' . $row['UID'] . '">' . $row['user2'] . '<br><h6>' . $text . '</h6></h2><br>';
					} else {
						echo '<h2><a href="message.php?ID=' . $row['UID'] . '">' . $row['user1'] . '<br><h6>' . $text . '</h6></h2><br>';
					}
					
					
				
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