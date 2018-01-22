<?php

session_start();

include "error_reporting.php";




								error_reporting(0);
								$email = $_POST['recovermail'];
								$recoverycode = md5($_POST['recovermail'] + microtime());
								
								$errorrecemail = array();

								 

								//--END OF MYSQL INSERT--
								if (isset($_POST["recoversubmit"])) {

									if (empty($_POST['recovermail'])) {
										array_push($errorrecemail, 'You did not submit an email');
									

										} else {
										$conn = mysqli_connect("localhost","root", "", "cloudOrangeflyffweb");
										$newpassword = mt_rand(100000,1000000);
										$newpasswordmd5 = md5($newpassword);
										
										mysqli_query($conn, "UPDATE users SET recoverycode = '$recoverycode' WHERE email = '$email'");
										mysqli_query($conn, "UPDATE users SET newpassword = '$newpasswordmd5' WHERE email = '$email'");

										
										

										
										
										$to = $email;
										$subject = "Password reset";
										
										$message = '
										<html>
											
											<center><div style="background-color:lightblue;width:600px;border:2px solid orange;border-radius:5px"> 

												<center><img style="margin-top:20px;margin-bottom:20px" src="http://i.imgur.com/QSADraX.png"></center>

												

												<center><h1 style="color:white">Your new password is ' .  $newpassword . '</h1></center>

												<center><h1 style="color:white">Click below to activate it!</h1></center>

												<center><div style="background-color:orange;width:250px;border:1px solid blue;border-radius:5px;margin-bottom:20px;background: #f9c667;background: -moz-linear-gradient(top,  #f9c667 0%,#f79621 100%, #f9c667 0%);background: -webkit-linear-gradient(top,  #f9c667 0%,#f79621 100%, #f9c667 0%);background: linear-gradient(to bottom,  #f9c667 0%,#f79621 100%, #f9c667 0%)"><h1><a style="color:blue;text-decoration:none" href="http://cloudorangeflyff.com/recoverysuccess.php?email=' . $email . '&recoverycode=' . $recoverycode . '">Use new password</a></h2></center>

											</div></center>

											
										</html>';
										
										$headers  = 'MIME-Version: 1.0' . "\r\n";
										$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
										mail($to, $subject, $message, $headers);
										header("Location: recoverymailsent.php");
										//END OF MAIL
								

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

			
			

			<div id="forgotpassworddiv">

					<h1>Password Recovery</h1>
					<br>
					<p>
					Please type in your mail that you registered your account with. <br>
					You will receive a new code which you will need to activate before you can use it! <br>
					If you experience any trouble, please head over to the forums for help. <br>
					</p><br>
					
					<form method="POST">
						<input id="recovermail" type="text" name="recovermail" method="POST" placeholder="Enter email">
						<input id="recoversubmit" type="submit" name="recoversubmit" method="POST">
						

					</form>

			</div>



			

			

		</div>

		
	
	</div>

	<?php
				include 'footer.php';
		?>
 
</body>
</html>