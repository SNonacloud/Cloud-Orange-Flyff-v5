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

		
			<div id="forumdiv">
				<h1>Forum</h1>

				<p id="forumwelcome">If this is your first visit, be sure to check out the FAQ by clicking the link above. You have to register before you can post: click the register link above to proceed. To start viewing messages, select the forum that you want to visit from the selection below.</p>


				<div id="forumtop">
				<h3 id="ett">Category</h3>
				<h3 id="tva">Latest Thread</h3>
				<h3 id="tre">Threads</h3>
				</div>

				<br>

				

				<div id="categoryecho">
				<?php  

				$conn = mysqli_connect("localhost","root", "", "cloudorangeforum");

				$query = mysqli_query($conn, "SELECT Name FROM Categories");

				$number = 1;

				while ($row = mysqli_fetch_assoc($query)) {


					
					echo '<div id="separation"><div id="categoryname"><h3><a href="Category.php?category=' . $row["Name"] . '">' . $row["Name"]  . '</a></h3>';

					$desc = $row["Name"];
					$descquery = mysqli_query($conn, "SELECT * FROM Categories WHERE Name = '$desc'");

					while ($row3 = mysqli_fetch_assoc($descquery)) {
						echo $row3['categorydesc'];
					}

					echo "</div>";

					$key = $row['Name'];
					$key2 = $row['ID'];

					$query2 = mysqli_query($conn, "SELECT * FROM Threads WHERE Category = '$key' ORDER BY UID DESC LIMIT 1");

					while ($row2 = mysqli_fetch_assoc($query2)) {
						$conn = mysqli_connect("localhost","root", "", "cloudorangeforum");
						echo '<div id="forumlatesttitle"><a href="Thread.php?id=' . $row2["UID"] . '"><h3>' . $row2["Title"] . '</h3></a>By ' . $row2['User'] .' at ' . $row2['Date'] . '</div>';
						
					}

					$query3 = mysqli_query($conn, "SELECT * FROM Threads WHERE Category = '$key'");

					$query4 = mysqli_query($conn, "SELECT * FROM Replies WHERE ThreadID = '$key2'");



					

					if ($row = mysqli_num_rows($query3)) {
						echo '<div id="totalthreads">' . $row . '</div><br><br>';
					}

					

					

					echo "</div>";


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