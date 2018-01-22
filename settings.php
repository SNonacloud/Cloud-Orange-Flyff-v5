<?php  
include "error_reporting.php";

$errors = array();
$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
session_start();
$user = $_SESSION['username'];
$ID = $_SESSION['ID'];


/*------------------------------------------Upload profileimage--------------------------------------------------------*/

$file = $_FILES['file'];
$target_dir = "Profilepics/";
$target_file = $target_dir . basename($file ["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$ext = $file ['type'];
$ext = explode("/", $ext);



if (isset($_POST['imagesave'])) {
	$check = getimagesize($file ["tmp_name"]);
	if ($check !== false) {
		$uploadOk = 1;
	} else {		
		$uploadOk = 0;
	}

	if ($file ['size'] > 500000) {
	echo "Sorry your file is too large";
	$uploadOk = 0;
	}

	if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "png") {
		echo "Only JPG, PNG and GIFs are allowed";
		$uploadOk = 0;
	}




	if ($uploadOk == 0) {
		
	} else {
	if (move_uploaded_file($file ["tmp_name"], $target_dir.$user."." . $ext[1])) {
		
		$extension = $ext[1];


		mysqli_query($conn, "UPDATE users SET profilepic = 'Profilepics/$user.$extension' WHERE username = '$user'");

	}
}

} 

/*------------------------------------------Upload mediaimages--------------------------------------------------------

$file = $_FILES['file'];
$target_dir2 = "mediapics/";
$target_file2 = $target_dir2 . basename($file ["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file2, PATHINFO_EXTENSION));

if (isset($_POST['imagemediasave'])) {
	$check = getimagesize($file ["tmp_name"]);
	if ($check !== false) {
		$uploadOk = 1;
	} else {		
		$uploadOk = 0;
	}

	if ($file ['size'] > 500000) {
	echo "Sorry your file is too large";
	$uploadOk = 0;
	}

	if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "png") {
		echo "Only JPG, PNG and GIFs are allowed";
		$uploadOk = 0;
	}

	$user = $_SESSION['username'];
	$query = mysqli_query($conn, "SELECT * FROM mediapictures WHERE user = '$user'");
	if ($row = mysqli_num_rows($query) >= 3) {
		echo "You can only upload 3 pictures";
		$uploadOk = 0;
	}

	if ($uploadOk == 0) {
		
	} else {
	if (move_uploaded_file($file ["tmp_name"], $target_file2)) {

		date_default_timezone_set("Europe/Stockholm");
		$date = date("o/j/n");
		$extension = $ext[1];
		$filename = $target_file2;

		$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
		$user = $_SESSION['username'];
		echo $filename;
		
		$abc = mysqli_query($conn, "INSERT INTO mediapictures (name, date, user) VALUES ('$filename', '$date', '$user')");

		if ($abc) {
			echo "ja";
		} else {
			echo "nej";
		}

	}
}

} 



/*--------------------------------------------------------------------------------------------------------------*/


if (isset($_SESSION['username'])) {
	
	if (isset($_POST['save'])) {
		
		$password = md5($_POST['password']);
		$query = mysqli_query($conn, "SELECT * FROM users where password = '$password'");
		if (mysqli_num_rows($query) < 1) {
		array_push($errors, 'Your current password is incorrect');

		}
			
		if ($_POST['newpassword'] != $_POST['confirm']) {
			array_push($errors, 'Passwords dont match');
		}


		
		if (sizeof($errors) == 0) {
			$newpassword = md5($_POST['newpassword']);
			$cpquery = mysqli_query($conn, "UPDATE users SET password = '$newpassword' WHERE ID = '$ID'");
			
			if ($cpquery) {
				echo "You have succesfully changed your password";
			} else {
				echo "Password change failed!";
		
			}

		}

		if (!empty($_POST['food'])) {
			$food = $_POST['food'];
			$food = htmlentities($food);
			$food = mysqli_real_escape_string($conn, $food);
			$ID = $_SESSION['ID'];
			$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
			mysqli_query($conn, "UPDATE users SET food = '$food' WHERE ID = '$ID'");
		} 

		if (!empty($_POST['drink'])) {
			$drink = $_POST['drink'];
			$drink = htmlentities($drink);
			$drink = mysqli_real_escape_string($conn, $drink);
			$ID = $_SESSION['ID'];
			$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
			mysqli_query($conn, "UPDATE users SET drink = '$drink' WHERE ID = '$ID'");
		} 

		if (!empty($_POST['game'])) {
			$game = $_POST['game'];
			$game = htmlentities($game);
			$game = mysqli_real_escape_string($conn, $food);
			$ID = $_SESSION['ID'];
			$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
			mysqli_query($conn, "UPDATE users SET game = '$game' WHERE ID = '$ID'");
		} 

		if (!empty($_POST['biography'])) {
			$biography = $_POST['biography'];
			$biography = nl2br($biography);
			$biography = htmlentities($biography);
			$biography = mysqli_real_escape_string($conn, $biography);
			$ID = $_SESSION['ID'];
			$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
			mysqli_query($conn, "UPDATE users SET biography = '$biography' WHERE ID = '$ID'");
		} 

		
		if (!empty($_POST['gender'])) {
			$gender = $_POST['gender'];
			$gender = nl2br($gender);
			$gender = htmlentities($gender);
			$gender = mysqli_real_escape_string($conn, $biography);
			$ID = $_SESSION['ID'];
			$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
			mysqli_query($conn, "UPDATE users SET gender = '$gender' WHERE ID = '$ID'");
		} 

		if (!empty($_POST['country'])) {
			$country = $_POST['country'];
			$country = nl2br($country);
			$country = htmlentities($country);
			$country = mysqli_real_escape_string($conn, $country);
			$ID = $_SESSION['ID'];
			$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
			mysqli_query($conn, "UPDATE users SET country = '$country' WHERE ID = '$ID'");
		} 
		
	}

} else {
	header("Location: index.php");
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

			<div id="settings">
				<h1>Settings</h1>
				<h2 id="apa">Profile Picture</h2></p>
				<?php 
					$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
					$profileid = $_SESSION['username'];
					$query = mysqli_query ($conn, "SELECT * from users WHERE username = '$profileid'");

					while ($row = mysqli_fetch_assoc($query)) {
						
						echo '<center><div id="settingsprofilepic"><img src="' . $row["profilepic"] . '"></div></center>';

					}
				?>

				<form id="settingsform" method="POST" enctype="multipart/form-data">

				<center>
				<input id="imgfile" type="file" name="file" method="POST">
				<br>
				<br>
				<input id="imgsave" type="submit" name="imagesave" value="Save image" method="POST">
				</center>

				<center>

				<!--
				<h2>Upload Media</h2>
				<div id="settingmediawrap">
					<?php 
						$conn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
						$profileid = $_SESSION['username'];
						$query = mysqli_query ($conn, "SELECT * from mediapictures WHERE user = '$profileid'");

						while ($row = mysqli_fetch_assoc($query)) {
							
							echo '<div id="settingsmediapic"><img src="' . $row["name"] . '"></div>';

						}
					?>
				</div>
				<input id="imgfile" type="file" name="file" method="POST">
				<br>
				<br>
				<input id="imgsave" type="submit" name="imagemediasave" value="Upload Media" method="POST">
				</center>


				!-->
				
				<center>
				<?php
				$ipaddress = '';
			    if ($_SERVER['HTTP_CLIENT_IP'])
			        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
			        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			    else if($_SERVER['HTTP_X_FORWARDED'])
			        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			    else if($_SERVER['HTTP_FORWARDED_FOR'])
			        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			    else if($_SERVER['HTTP_FORWARDED'])
			        $ipaddress = $_SERVER['HTTP_FORWARDED'];
			    else if($_SERVER['REMOTE_ADDR'])
			        $ipaddress = $_SERVER['REMOTE_ADDR'];
			    else
			        $ipaddress = 'UNKNOWN';
			 
			    echo $ipaddress;

				  ?>
				<h2>Account Details</h2>
					<input type="text" placeholder="Username" name="">
					<input type="text" placeholder="Email" name="">
				<h2>Information</h2>
					<input type="text" placeholder="Gender" name="gender" method="POST">
					<input type="text" placeholder="Country" name="country" method="POST">
				<h2>Change Password</h2>
					<input type="text" placeholder="Old password" name="password" method="POST">
					<input type="text" placeholder="New password" name="newpassword" method="POST">
					<input type="text" placeholder="Verify new password" name="confirm" method="POST">
				<h2>Favorites</h2>
					<input type="text" placeholder="Food" name="food" method="POST">
					<input type="text" placeholder="Drink" name="drink" method="POST">
					<input type="text" placeholder="Game" name="game" method="POST">
				
				<h2>Biography</h2>
					<textarea id="settingsarea" type="text" placeholder="Biography" name="biography"></textarea>
					<br>
				
				<input type="submit" name="save">
				</center>

				</form>
			</div>



		</div>



	</div>


	
		<?php
			include 'footer.php';
		?>
			
	


 
</body>
</html>