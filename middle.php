<div id="middle">

	<div id="sliderFrame">
				        <div id="slider">
				            
				           	<img src="Assets/Slide/1.jpg"/>
				            <a href="register.php"><img src="Assets/Slide/2.jpg"/></a>
				            <img src="Assets/Slide/3.png"/>
				            <img src="Assets/Slide/4.jpg"/>
				        </div>
				        
			  </div>


				<div id="news">

					<div id="newstitle">
					<h2>News</h2>
					</div>
					
					<?php
					$conn3 = mysqli_connect("localhost", "root", "", "cloudorangeflyffweb");

					$query = mysqli_query ($conn3, "SELECT * FROM news ORDER BY ID DESC LIMIT 10 ");

					while ($row = mysqli_fetch_assoc($query)) {
						echo '<div id="newsrow"><a href="news.php?id=' . $row['ID'] .'"><div id="newsleft">' . $row['title'] . '</div></a><div id="newsright">' . $row['date'] . '</div></div> <br>';
					}

					?>

				</div>

				<div id="images">

					<div id="imagetitle">
						<h2>Media</h2>

					</div>
						
					<div id="video">
					<iframe width="410" height="250" src="https://www.youtube.com/embed/uy6GT788rgs" frameborder="0" allow="autoplay; encrypted-media" showinfo=0 modestbranding=0  fs=0></iframe>
					</div>

				</div>
			
			</div>