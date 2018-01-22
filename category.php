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
			

			
					<div id="categorydiv">
						
						<div id="categorydiv2">
							<?php 

								$conn = mysqli_connect("localhost", "root", "", "cloudorangeforum");

								$category = $_GET[category];

								$query = mysqli_query ($conn, "SELECT * FROM Threads WHERE Category = '". $_GET['category']. "'ORDER BY UID DESC ");

								$query2 = mysqli_query ($conn, "SELECT * FROM Threads WHERE Category = '". $_GET['category']. "'LIMIT 1");

								echo '<div id="findback"><p><a href="forum.php">Forum</a> > <a href="Category.php?category=' . $category . '">' . $category . '</a></p> </div>';

								if (isset($_SESSION['ID'])) {


									while ($categoryTitle = mysqli_fetch_assoc($query2)) {


									echo '<div id="titleandcreate"><div id="categorytitle"><h1>' . $categoryTitle['Category'] . '</h1></div> <br>';
									echo '<a href="createthread.php"><div id="createthread">Create Thread</div></a></div>';
									

								} 
								} else {
									while ($categoryTitle = mysqli_fetch_assoc($query2)) {
									echo '<div id="titleandcreate"><div id="categorytitle"><h1>' . $categoryTitle['Category'] . '</h1></div></div><br>';
									}
								}

								

								while ($row = mysqli_fetch_assoc($query)) {
									
									$id = $_SESSION['ID'];
									$uid = $row['UID'];
									
									$conn2 = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
									$query3 = mysqli_query($conn2, "SELECT * FROM users WHERE ID = $id AND active = '2' ");
									
									
									echo '<div id="threadhighlight"><div id="highlighttitle"><div id="useranddate"><a href="Thread.php?id=' . $row['UID'] . '"> <h3>' . $row['Title'] . '</h3> </a></div><p>Posted by ' . $row['User'] . ' at ' . $row['Date'] . '</p></div></div><br>';
								
									

								}



							?>
						</div>					
					</div>
					
					
			
		</div>		

		</div>

		
	
	</div>

	<?php
				include 'footer.php';
		?>
 
</body>
</html>