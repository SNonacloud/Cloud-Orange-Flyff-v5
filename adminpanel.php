<?php

include "error_reporting.php";

session_start();

$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
		$title = $_POST['newstitle'];
		$text = $_POST['newstext'];
		$text = nl2br($text);
		$user = $_SESSION['username'];
		date_default_timezone_set("Europe/Stockholm");
		$date = date("o/j/n");

		if (isset($_POST['newssubmit'])) {
			mysqli_query($conn, "INSERT INTO news (title, text, username, date) VALUES ('$title','$text','CloudOrangeStaff','$date')");
			header('Location: index.php');
		}

		$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
		$deacuser = $_POST['deactivateuser'];
		if (isset($_POST['deactivatesubmit'])) {
			mysqli_query($conn, "UPDATE users SET active = '0' WHERE username = '$deacuser'");
			$query = mysqli_query($conn, "UPDATE users SET active = '0' WHERE username = '$deacuser'");
			if ($query) {
				echo "User deactivated";
			} else {
				echo "Could not deactivate user";
			}
		}

		$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
		$acuser = $_POST['activateuser'];
		if (isset($_POST['activatesubmit'])) {
			mysqli_query($conn, "UPDATE users SET active = '1' WHERE username = '$acuser'");
			$query = mysqli_query($conn, "UPDATE users SET active = '1' WHERE username = '$acuser'");
			if ($query) {
				echo "User activated";
			} else {
				echo "Could not activate user";
			}
		}

		$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
		$faqtext = $_POST['faqtext'];
		if (isset($_POST['faqsubmit'])) {
			mysqli_query($conn, "UPDATE faq SET text = '$faqtext'");
			$query = mysqli_query($conn, "UPDATE users SET active = '1' WHERE username = '$acuser'");
			if ($query) {
				echo "F.A.Q updated";
			} else {
				echo "Error updating F.A.Q";
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
		<h1 id="adminpaneltitle">Adminpanel</h1>
		
		<br>

		<center><a id="backtofront" href="index.php">Back to front</a></center>

		<br>
	

		<div id="adminticketdiv">
			<h2>Tickets</h2>

			<div id="adminfinished">

				<h3>Finished tickets</h3>

				<?php  
				$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
				$query = mysqli_query($conn, "SELECT * FROM tickets WHERE finished = '1'");

				while ($row = mysqli_fetch_assoc($query)) {
					echo '<a href="ticketb.php?id=' . $row["UID"] . '">' . $row['title'] . '</a><br>';
				}

				?>

			</div>

			<div id="adminongoing">

				<h3>Unfinished tickets</h3>

				<?php  
				$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
				$query = mysqli_query($conn, "SELECT * FROM tickets WHERE ongoing = '1'");

				while ($row = mysqli_fetch_assoc($query)) {
					echo '<a href="ticketb.php?id=' . $row["UID"] . '">' . $row['title'] . '</a><br>';
				}

				?>

			</div>

		</div>

		<br>

		<center>

		<div id="admincreatenews">
		<h2>Create News</h2>

		<br>

		 <form method="POST">
		 	<input id="createnewstitle" type="text" name="newstitle" placeholder="Title" method="POST">
		 	<br><br>
		 	<textarea id="createnewsarea" type="text" name="newstext" placeholder="Text" method="POST"></textarea>
		 	<br>
		 	<input id="createnewssubmit" type="submit" name="newssubmit" value="Create News">
		 	
		 </form>

		 </div>
		 </center>



		<div id="useractivation">

			<h2>User activation</h2>
			<br>
			<div id="deactivateuser">
				<h3>Deactivate User</h3>

				<form method="POST">
					<input type="text" name="deactivateuser" placeholder="Enter username" method="POST">
					<br>
					<br>
					<input type="submit" name="deactivatesubmit" value="Deactivate" method="POST">
				</form>

			</div>

			<div id="activateuser">


			<h3>Activate User</h3>

				<form method="POST">
					<input type="text" name="activateuser" placeholder="Enter username" method="POST">
					<br>
					<br>
					<input type="submit" name="activatesubmit" value="Activate" method="POST">
				</form>

			</div>

		</div>

		<br>


		<div id="faqdiv">

			<center>
			<h2>F.A.Q</h2>

			<br>

			<form method="POST">

			<?php  
				$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
				$query = mysqli_query($conn, "SELECT * FROM FAQ");
				while ($row = mysqli_fetch_assoc($query)) {
					echo '<textarea id="faqarea" name="faqtext" method="POST">' . $row['Text'] . '</textarea>';
				}
			?>


			
				
				<br>
				<input type="submit" name="faqsubmit" value="Update F.A.Q" method="POST">
			</form>
			</center>
		</div>

		<br>

		<center><a id="backtofront" href="index.php">Back to front</a></center>

	</div>

	
		<?php
				include 'footer.php';
		?>
			
	


 
</body>
</html>