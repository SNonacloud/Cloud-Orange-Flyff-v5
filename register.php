<?php

session_start();


	include "error_reporting.php";
	
if (isset($_POST['register'])) {

	$errorsuser = array();
	$errorsuser2 = array();
	$errorspass = array();
	$errorsconfirm = array();
	$errorsquestion = array();
	$errorsanswer = array();
	$errorsemail = array();

	if (empty($_POST['username'])) {
		array_push($errorsuser, 'You did not submit a username');
	}
	if (empty($_POST['password'])) {
		array_push($errorspass, 'You did not submit a password');
	}
	if (empty($_POST['question'])) {
		array_push($errorsquestion, 'You did not submit a question');
	}
	if (empty($_POST['answer'])) {
		array_push($errorsanswer, 'You did not submit an answer');
	}
	if (empty($_POST['email'])) {
		array_push($errorsemail, 'You did not submit an email');
	}
	

	$old_usn = mysqli_query($mysqlconn, "SELECT * FROM users WHERE username = '".$_POST['username']."' LIMIT 1;");
	if (mysqli_num_rows($old_usn) > 0) {
		array_push($errorsuser2, 'Username taken');
	}

	$old_email = mysqli_query($mysqlconn, "SELECT * FROM users WHERE email = '".$_POST['email']."' LIMIT 1;");
	if (mysqli_num_rows($old_email) > 0) {
		array_push($errorsemail, 'This E-Mail is already registered');
	}

	if ($_POST['password'] != $_POST['confirm']) {
		array_push($errorsconfirm, 'Passwords dont match');
	}





	if (sizeof($errorsuser) == 0) {
		if (sizeof($errorspass) == 0) {
			if (sizeof($errorsconfirm) == 0) {
				if (sizeof($errorsquestion) == 0) {
					if (sizeof($errorsanswer) == 0) {
						if (sizeof($errorsemail) == 0) {	
				
			
			
		
								$username = $_POST["username"];
								$password = md5($_POST["password"]);
								$flyffpw = md5('kikugalanet' .$_POST['password']. '');
								$question = $_POST["question"];
								$answer = $_POST["answer"];							
								$confirm = $_POST["confirm"];
								$email = $_POST["email"];
								$emailcode = md5($_POST['username'] + microtime());
								$birthyear = $_POST["birthyear"];
								$month = $_POST["month"];
								$day = $_POST["day"];
								

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

								//v6 SQLSRV INSERT

									
									$servername = "WIN-HL5B9GQ0UQA\SQLEXPRESS, 49170";
									$connectioninfo = array ("UID"=>"sa", "PWD"=>"G4sfasgada", "Database"=>"ACCOUNT_DBF");
									$sqlsrvconn = sqlsrv_connect($servername, $connectioninfo);


		
										sqlsrv_query($sqlsrvconn, "INSERT INTO ACCOUNT_TBL(account,password,isuse,member,id_no1,id_no2,realname, cash)
										VALUES('$username', '$flyffpw', 'T', 'A', '', '', '', '0')");
											
										sqlsrv_query($sqlsrvconn, "INSERT INTO ACCOUNT_TBL_DETAIL(account,gamecode,tester,m_chLoginAuthority,regdate,BlockTime,EndTime,WebTime,isuse,secession, email)
										VALUES('$username','A000','2','F',GETDATE(),CONVERT(CHAR(8),GETDATE()-1,112),CONVERT(CHAR(8),DATEADD(year,10,GETDATE()),112),CONVERT(CHAR(8),GETDATE()-1,112),'T',NULL, '$email')");
											
										sqlsrv_query($sqlsrvconn, "INSERT INTO  AccountPlay (Account, PlayDate)
										SELECT '$username', convert(int, convert(char(8), getdate(), 112))");

								//END OF v6 SQLSRV INSERT

								//MYSQL INSERT
								//----------------------------------------------------------------------------------------------------------
								$mysqlconn = mysqli_connect("localhost","root", "", "cloudorangeflyffweb");
								$query = mysqli_query($mysqlconn, "INSERT INTO users (username, password, newpassword, question, answer, email, emailcode, recoverycode, birthyear, month, day, profilepic, country, gender, joindate, lastsignin, forumposts, food, drink, game, biography, ipaddress) 

									VALUES ('{$username}', '{$password}', '', '{$question}', '{$answer}', '{$email}', '{$emailcode}', '', '{$birthyear}', '{$month}', '{$day}', 'Profilepics/placeholder.jpg', '', '', '', '', '', '', '', '', '', '$ipaddress')");

								//--END OF MYSQL INSERT--
								if ($query) {
									
									$to = $email;
									$subject = "Please activate your account";
									
									$message = '
									<html>
										
										<center><div style="background-color:lightblue;width:600px;border:2px solid orange;border-radius:5px"> 

											<center><img style="margin-top:20px" src="http://i.imgur.com/QSADraX.png"></center>

											<center><h1 style="color:white">Welcome</h1><h1 style="color:blue"> ' . $username . ' </h1></center>

											<center><h2 style="color:white">Please press the button below to activate!</h2></center>

											<center><div style="background-color:orange;width:250px;border:1px solid blue;border-radius:5px;margin-bottom:20px;background: #f9c667;background: -moz-linear-gradient(top,  #f9c667 0%,#f79621 100%, #f9c667 0%);background: -webkit-linear-gradient(top,  #f9c667 0%,#f79621 100%, #f9c667 0%);background: linear-gradient(to bottom,  #f9c667 0%,#f79621 100%, #f9c667 0%)"><a style="text-decoration:none" href="http://CloudOrangeFlyff.com/activate.php?email=' . $email . '&emailcode=' . $emailcode . '"><h2>ACTIVATE</h2></a></center>

										</div></center>

										
									</html>';
									
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									mail($to, $subject, $message, $headers);
									header("Location: success.php");
									//END OF MAIL
								} 

								//<a href="http://localhost/activate.php?email=' . $email . '&emailcode=' . $emailcode .

								
								
								



						} //email
					} //answer
				} //question
			} //confirm
		} //pass
	} //user



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

		
			
			<div id=register>
				<h1 id="registertitle">Register</h1>

				<p id="registerinfo">Please fill in your details below to register an in-game account.<br>
				Your account is for your use alone, and must not be shared with anyone for any reason.<br>
				If you encounter any problems with registration, don't hesitate to ask for help on the forums. <br>

				<div id="errorsuser">
								<?php  
									error_reporting(0);
									foreach ($errorsuser as $e) {
										echo $e;
									}

								?>				
				</div>
				
				<div id="errorsuser2">
								<?php  
									error_reporting(0);
									foreach ($errorsuser2 as $e) {
										echo $e;
									}

								?>				
				</div>
				
				<div id="errorspass">
								<?php  
									error_reporting(0);
									foreach ($errorspass as $e) {
										echo $e;
									}

								?>				
				</div>

				<div id="errorsconfirm">
								<?php  
									error_reporting(0);
									foreach ($errorsconfirm as $e) {
										echo $e;
									}

								?>				
				</div>

				<div id="errorsquestion">
								<?php  
									error_reporting(0);
									foreach ($errorsquestion as $e) {
									echo $e;
									}

								?>				
				</div>

				<div id="errorsanswer">
								<?php  
									error_reporting(0);
									foreach ($errorsanswer as $e) {
										echo $e;
									}

								?>				
				</div>

				<div id="errorsemail">
								<?php  
									
									foreach ($errorsemail as $e) {
										echo $e;
									}


								?>				
				</div>


				

				<form  id="registerform" method="POST">
				Username <br>
				<input id="registerinput" type="text" name="username"> <br>

				Password <br>
				<input id="registerinput" type="password" name="password"> <br>

				Confirm Password <br>
				<input id="registerinput" type="password" name="confirm"> <br>

				Secret Question<br>
				<input id="registerinput" type="text" name="question"> <br>

				Secret Answer <br>
				<input id="registerinput" type="text" name="answer"> <br>

				Email <br>
				<input id="registerinput" type="email" name="email"> <br>

					<h3 id="bottomh3">Date of birth</h3>
							<br>
						
							
							<select id="birthyear" name="birthyear">
									<option value="2010">2010</option>
									<option value="2009">2009</option>
									<option value="2008">2008</option>
									<option value="2007">2007</option>
									<option value="2006">2006</option>
									<option value="2005">2005</option>
									<option value="2004">2004</option>
									<option value="2003">2003</option>
									<option value="2002">2002</option>
									<option value="2001">2001</option>
									<option value="2000">2000</option>
									<option value="1999">1999</option>
									<option value="1998">1998</option>
									<option value="1997">1997</option>
									<option value="1996">1996</option>
									<option value="1995">1995</option>
									<option value="1994">1994</option>
									<option value="1993">1993</option>
									<option value="1992">1992</option>
									<option value="1991">1991</option>
									<option value="1990">1990</option>
									<option value="1989">1989</option>
									<option value="1988">1988</option>
									<option value="1987">1987</option>
									<option value="1986">1986</option>
									<option value="1985">1985</option>
									<option value="1984">1984</option>
									<option value="1983">1983</option>
									<option value="1982">1982</option>
									<option value="1981">1981</option>
									<option value="1980">1980</option>
									<option value="1979">1979</option>
									<option value="1978">1978</option>
									<option value="1977">1977</option>
									<option value="1976">1976</option>
									<option value="1975">1975</option>
									<option value="1974">1974</option>
									<option value="1973">1973</option>
									<option value="1972">1972</option>
									<option value="1971">1971</option>
									<option value="1970">1970</option>
									<option value="1969">1969</option>
									<option value="1968">1968</option>
									<option value="1967">1967</option>
									<option value="1966">1966</option>
									<option value="1965">1965</option>
									<option value="1964">1964</option>
									<option value="1963">1963</option>
									<option value="1962">1962</option>
									<option value="1961">1961</option>
									<option value="1960">1960</option>								
							</select>
														
							<!-- Month dropdown -->
							<select name="month" id="month" onchange="" size="1">
								    <option value="01">January</option>
								    <option value="02">February</option>
								    <option value="03">March</option>
								    <option value="04">April</option>
								    <option value="05">May</option>
								    <option value="06">June</option>
								    <option value="07">July</option>
								    <option value="08">August</option>
								    <option value="09">September</option>
								    <option value="10">October</option>
								    <option value="11">November</option>
								    <option value="12">December</option>
							</select>
							
							<!-- Day dropdown -->
							<select name="day" id="day" onchange="" size="1">
									    <option value="01">01</option>
									    <option value="02">02</option>
									    <option value="03">03</option>
									    <option value="04">04</option>
									    <option value="05">05</option>
									    <option value="06">06</option>
									    <option value="07">07</option>
									    <option value="08">08</option>
									    <option value="09">09</option>
									    <option value="10">10</option>
									    <option value="11">11</option>
									    <option value="12">12</option>
									    <option value="13">13</option>
									    <option value="14">14</option>
									    <option value="15">15</option>
									    <option value="16">16</option>
									    <option value="17">17</option>
									    <option value="18">18</option>
									    <option value="19">19</option>
									    <option value="20">20</option>
									    <option value="21">21</option>
									    <option value="22">22</option>
									    <option value="23">23</option>
									    <option value="24">24</option>
									    <option value="25">25</option>
									    <option value="26">26</option>
									    <option value="27">27</option>
									    <option value="28">28</option>
									    <option value="29">29</option>
									    <option value="30">30</option>
									    <option value="31">31</option>
							</select>
							<br>

				<p id="registercheckbox"><input type="checkbox" name="" >
				It is important to read the Terms of Use and Privacy Policy thoroughly as they include the rules to the game.<br>
				By registering an account you agree to the game terms and conditions.<br></p>

				<input id="registersubmit" type="submit" name="register" value="Register">
				

			</form>
				
			</div>

	

			

		</div>

		
	
	</div>

	<?php
				include 'footer.php';
		?>
 
</body>
</html>