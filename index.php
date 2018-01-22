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
	<link href="themes/1/js-image-slider.css" rel="stylesheet" type="text/css">
    <script src="themes/1/js-image-slider.js" type="text/javascript"></script>
   
</head>

<body>

	
	<?php  
		include 'logo.php';
	?>

	

	<div id="container">
		
		<!--<img id="sun" src="Assets/sun.png">-->

		<?php  
			include 'header.php';
		?>

		<div id="lmrcontainer">

			<?php
				include 'left.php';
				include 'middle.php';
				include 'right.php';

			?>

			

			

		</div>

		
	
	</div>

	
		<?php
				include 'footer.php';
		?>
			
	


 
</body>
</html>