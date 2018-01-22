<?php  
$conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");

error_reporting(0);

$mail = trim($_GET['email']);
$emailcode = trim($_GET['emailcode']); 

$validate = mysqli_query($conn, "SELECT * FROM users WHERE email = '$mail' AND emailcode = '$emailcode'");

if ($validate) {
	mysqli_query($conn, "UPDATE users SET active = 1 WHERE email = '$mail' AND emailcode = '$emailcode'");
	$servername = "WIN-HL5B9GQ0UQA\SQLEXPRESS, 49170";
	$connectioninfo = array ("UID"=>"sa", "PWD"=>"G4sfasgada", "Database"=>"ACCOUNT_DBF");
	$sqlsrvconn = sqlsrv_connect($servername, $connectioninfo);
	
	

		
	sqlsrv_query($sqlsrvconn, "INSERT INTO ACCOUNT_TBL(account,password,isuse,member,id_no1,id_no2,realname, cash)
	VALUES('$username', '$flyffpw', 'T', 'A', '', '', '', '0')");
		
	sqlsrv_query($sqlsrvconn, "INSERT INTO ACCOUNT_TBL_DETAIL(account,gamecode,tester,m_chLoginAuthority,regdate,BlockTime,EndTime,WebTime,isuse,secession, email)
	VALUES('$username','A000','2','F',GETDATE(),CONVERT(CHAR(8),GETDATE()-1,112),CONVERT(CHAR(8),DATEADD(year,10,GETDATE()),112),CONVERT(CHAR(8),GETDATE()-1,112),'T',NULL, '$email')");
		
	sqlsrv_query($sqlsrvconn, "INSERT INTO  AccountPlay (Account, PlayDate)
	SELECT '$username', convert(int, convert(char(8), getdate(), 112))");

	?>




<html>
<head>
	<title>CloudOrangeFlyff</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
</head>
<body>




<?php

	include 'logo.php';

	echo '<div id="container">';
	include 'header.php';
	
	echo '<br><br>';

	echo '<center><h2><center>You have now activated! enjoy your stay!</h2></center>';
	echo '<br><br>';

	echo '<center><h3><a href="index.php">Click here to return home</a></h3></center>';

	echo '</div><br><br>';


} else {

	include 'logo.php';

	echo '<div id="container">';
	include 'header.php';
	
	echo '<br><br>';

	echo '<center></h2>Activation error, please try again. <br> If the Problem persists please contact admin.</h2></center>';

		echo '<br><br>';

	echo '<center><h3><a href="index.php">Click here to return home</a></h3></center>';

	echo '</div><br><br>';
}


?>



</body>
</html>