<div id="right">
				

				<div id="ranking">
					<center><h2><p id="rankingtitle">Ranking</p></h2></center>

					<?php 
						/* $conn = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb"); 
						$query = mysqli_query($conn, "SELECT * FROM ranking");
						$number = 1;
						while ($row = mysqli_fetch_assoc($query)) {
							echo '<div id="p1"><p id="ranknummer">' . $number++ . '</p><p id="ranknamn">' . $row['username'] . '</p></div>';
						}*/

						$servername = "WIN-HL5B9GQ0UQA\SQLEXPRESS, 49170";
						$connectioninfox = array ("UID"=>"sa", "PWD"=>"G4sfasgada", "Database"=>"CHARACTER_01_DBF");
						$sqlsrvconnx = sqlsrv_connect($servername, $connectioninfox);
						
						$result = "SELECT TOP 10 m_szName FROM CHARACTER_TBL ORDER BY m_nExp1 DESC" ;
						$query = sqlsrv_query($sqlsrvconnx, $result, array(), array( "Scrollable" => SQLSRV_CURSOR_DYNAMIC ));

							
						
						$tmp_ranking = "";
						$number = 1;
						while ($row = array_unique(sqlsrv_fetch_array($query))) {
							foreach($row as $key)
							{
						 		$ja = '<div id="p1"><p id="ranknummer">' . $number++ . ' </p><p id="ranknamn">' . $key . ' </p></div>';
						 		//echo "<div id='ranknamn'>".$key."<br> </div>";
							}
							echo $ja;
						}
						
					?>


					
					
					


				</div>

				<form action="index.php" id="poll" method="POST">
					<div id="Polltitle"><h2>Poll</h2></div>

					<?php

					$conn3 = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");

					$query = mysqli_query ($conn3, "SELECT * FROM poll LIMIT 7");

					$user = $_SESSION['username'];

					$query2 = mysqli_query($conn3, "SELECT * FROM pollvotes WHERE User = '$user'");

					if (mysqli_num_rows($query2) < 1) {

						while ($row = mysqli_fetch_assoc($query)) {
						echo 

						'<div id="pollquestion">' . $row["Question"] . '</div><br><div id="polloptions">
						
						<div id="polloptionsradio"><input type="radio" name="polloption" method="POST" value="O1" id="O1"></div>
							<label for="O1">' . $row["O1"] . '</label><br>
						<div id="polloptionsradio"><input type="radio" name="polloption" method="POST" value="O2" id="O2"></div> 
							<label for="O2">' . $row["O2"] . '</label><br>
						<div id="polloptionsradio"><input type="radio" name="polloption" method="POST" value="O3" id="O3"></div> 
							<label for="O3">' . $row["O3"] . '</label><br>
						<div id="polloptionsradio"><input type="radio" name="polloption" method="POST" value="O4" id="O4"></div> 
							<label for="O4">' . $row["O4"] . '</label><br>
						<div id="polloptionsradio"><input type="radio" name="polloption" method="POST" value="O5" id="O5"></div> 
							<label for="O5">' . $row["O5"] . '</label><br>
						<div id="polloptionsradio"><input type="radio" name="polloption" method="POST" value="O6" id="O6"></div>
							<label for="O6">' . $row["O6"] . '</label><br>
						</div>';

						if (isset($_SESSION['ID'])) {
							echo '<center><input type="submit" name="votesubmit" value="Vote" method="POST"></center>';
						} else {
							echo '<p id="Logintovote">Log in to vote</p>';
						}
					}
					
					} else {

						$conn3 = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");
						$query = mysqli_query ($conn3, "SELECT * FROM poll LIMIT 7");
						
						while ($row = mysqli_fetch_assoc($query)) {
						echo '
						<div id="pollquestion">' . $row["Question"] . '</div><br>

						<div id="polloptions">';

						$o1 = $row['O1'];
						$o2 = $row['O2'];
						$o3 = $row['O3'];
						$o4 = $row['O4'];
						$o5 = $row['O5'];
						$o6 = $row['O6'];

						$x1 = mysqli_query($conn3, "SELECT * FROM pollvotes WHERE Voteoption = 'O1'");
						$x2 = mysqli_query($conn3, "SELECT * FROM pollvotes WHERE Voteoption = 'O2'");
						$x3 = mysqli_query($conn3, "SELECT * FROM pollvotes WHERE Voteoption = 'O3'");
						$x4 = mysqli_query($conn3, "SELECT * FROM pollvotes WHERE Voteoption = 'O4'");
						$x5 = mysqli_query($conn3, "SELECT * FROM pollvotes WHERE Voteoption = 'O5'");
						$x6 = mysqli_query($conn3, "SELECT * FROM pollvotes WHERE Voteoption = 'O6'");


						

						if ($row = mysqli_num_rows($x1)) {
							echo $o1, '<div id="polloptionsradio">' . $row . '</div>';	
					
						}

						echo "<br>";

						if ($row = mysqli_num_rows($x2)) {
							echo $o2, '<div id="polloptionsradio">' . $row . '</div>';	
					
						}

						echo "<br>";

						if ($row = mysqli_num_rows($x3)) {
							echo $o3, '<div id="polloptionsradio">' . $row . '</div>';	
					
						}

						echo "<br>";

						if ($row = mysqli_num_rows($x4)) {
							echo $o4, '<div id="polloptionsradio">' . $row . '</div>';	
					
						}

						echo "<br>";

						if ($row = mysqli_num_rows($x5)) {
							echo $o5, '<div id="polloptionsradio">' . $row . '</div>';	
					
						}

						echo "<br>";

						if ($row = mysqli_num_rows($x6) > 0) {
							echo $o6, '<div id="polloptionsradio">' . $row . '</div>';	
					
						}

						echo "<br>";

						$user = $_SESSION['username'];
						$query = mysqli_query($conn3, "SELECT * FROM pollvotes WHERE User = '$user'");
						while ($row = mysqli_fetch_assoc($query)) {
							$voteoption = $row['Voteoption'];
							
						}

						$query2 = mysqli_query($conn3, "SELECT * FROM poll");
						while ($row2 = mysqli_fetch_assoc($query2)) {
							$voteselection = $row2[$voteoption];
							
						}

						

						echo "</div>";
						echo "<br>";
						echo '<center><p id="voted">You voted<br>' . $voteselection . '</p></center>';

					}
					}




					
					?>


				


			</form>

				<br>

				

				

				
</div>



