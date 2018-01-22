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

			<div id="threaddiv">
			<div id="threaddiv2">
				

				<?php 
				

					$conn = mysqli_connect("localhost", "root", "", "cloudorangeforum");

					if (isset($_POST['submitthread'])) {
						$user = $_SESSION['username'];

						$threadtext = $_POST['threadtext'];
						$threadtext = nl2br($threadtext);
						$threadtext = htmlentities($threadtext);
						$threadtext = mysqli_real_escape_string($conn, $threadtext);

						$threadtitle = $_POST['threadtitle'];
						$threadtitle = htmlentities($threadtitle);
						$threadtitle = mysqli_real_escape_string($conn, $threadtitle);

						$category = $_POST['category'];
						date_default_timezone_set("Europe/Stockholm");
						$date = date("o/j/n");

						$postOk = 1;

						if (empty($_POST['threadtitle'])) {
							echo "Please enter a title";
							$postOk = 0;
						}


						if (empty($_POST['threadtext'])) {
							echo "Please enter a text";
							$postOk = 0;
						}


						if ($postOk == 0) {
						} else {
							mysqli_query($conn, "INSERT INTO Threads (Category, Title, Content, User, Date) VALUES ('$category', '$threadtitle', '$threadtext', '$user', '$date') ");
							echo "Thread was uploaded";
						}
						
						
					}

					
					

				 ?>		

				 		

						<form  id="categorypost" method="POST">

							<h1>Create Thread</h1> <br>

							<h3>Select Category</h3>

							<select name="category" form="categorypost">
							  <?php 
							  $categoryquery = mysqli_query($conn, "SELECT Name FROM Categories");
							  	while ($row = mysqli_fetch_assoc($categoryquery)) {
							  		echo '<option value="' . $row["Name"] . '">' . $row["Name"] . '</option>';
							  		
							  	}
							  ?>
							
							</select>

							<br>
							<br>

							<table>
								<tr>
									<td><h3>Title</h3></td>
								</tr>

								<tr>
									<td><input type="text" name="threadtitle"></td>	
								</tr>

								<tr>
									<td><h3>Message</h3></td>
								</tr>

								<tr>
									<td><textarea id="threadtext" type="text" name="threadtext" placeholder="Message" cols="50" rows="10"></textarea></td>
								</tr>
								
									
								<tr>
									<td><input id="submitthread" type="submit" name="submitthread" value="Post"></td>
								</tr>

												
							</table>					
						</form>

				
			</div>	 
			</div>
			

			

		</div>

		
	
	</div>

	<?php
				include 'footer.php';
		?>
 
</body>
</html>