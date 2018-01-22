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

			<div id="rankingwrapper">
				<h1>Ranking</h1>

				<div id="playerguildswap">
					<a href="players"><div id="players">Players</div></a>
					<a href="guilds"><div id="guilds">Guilds</div></a>


				</div>
				<?php  

					/* $query = mysqli_query($conn, "SELECT * FROM ranking ORDER BY UID");
					$num = 1;
					while ($row = mysqli_fetch_assoc($query)) {

						echo '<div id="rankingnamewrap"><div id="ranknum">' . $num++ . '</div><div id="rankingusername">' . $row['username'] . '</div></div><br>';
					}
					*/

					$servername = "WIN-HL5B9GQ0UQA\SQLEXPRESS, 49170";
						$connectioninfox = array ("UID"=>"sa", "PWD"=>"G4sfasgada", "Database"=>"CHARACTER_01_DBF");
						$sqlsrvconnx = sqlsrv_connect($servername, $connectioninfox);
						
						$result = "SELECT m_szName FROM CHARACTER_TBL ORDER BY m_nExp1 DESC" ;
						$query = sqlsrv_query($sqlsrvconnx, $result, array(), array( "Scrollable" => SQLSRV_CURSOR_DYNAMIC ));

					$tmp_ranking = "";
						$number = 1;
						while ($row = array_unique(sqlsrv_fetch_array($query))) {
							foreach($row as $key)
							{
						 		echo '<div id="rankingnamewrap"><div id="ranknum">' . $number++ . ' </div>' . "$tmp_ranking"  .'<div id="rankingusername">' . $key . ' </div></div>'. $tmp_ranking;
						 		//echo "<div id='ranknamn'>".$key."<br> </div>";
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