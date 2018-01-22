<?php  
$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");

error_reporting(0);

$mail = trim($_GET['email']);
$recoverycode = trim($_GET['recoverycode']);
$newpasswordmd5 = md5($newpassword);

$validate = mysqli_query($conn, "SELECT * FROM users WHERE email = '$mail' AND recoverycode = '$recoverycode'");

if ($validate) {
	$result = mysqli_query($conn, "SELECT newpassword FROM users WHERE email = '$mail' AND recoverycode = '$recoverycode'");

	$row = mysqli_fetch_row($result);

	mysqli_query($conn, "UPDATE users SET password = '$row[0]' WHERE email = '$mail' AND recoverycode = '$recoverycode'");





?>

<html>
<head>
	<title>CloudOrangeFlyff</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
</head>
<body>

<center><img id="logo" src="Assets/logo2.png"></center>

<div id="container">

<?php

	include 'header.php';
	echo "<br><br>";
	echo '<center><h2>You have now updated your password!</h2></center>';
	echo "<br><br>";
	echo '<center><h3><a href="index.php">Click here to return home</a></h3></center>';
	

} else {
	include 'header.php';
	echo "<br><br>";
	echo '<center></h2>Updating password failed, please try again. <br> If the Problem persists please contact admin.</h2></center>';
	echo "<br><br>";
	echo '<center><h3><a href="index.php">Click here to return home</a></h3></center>';
}


?>



</div>
</body>
</html>