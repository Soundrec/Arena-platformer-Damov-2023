<?php
	require_once('api/config.php'); // Include the config file
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	
	
?>
<html>
	
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images//icon.png" type="image/x-icon">
		<title>
			Doom Arena
		</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="script.js"></script>
		<link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">
	</head>
	<body onload="reauth()">
		<div id="container">
			<canvas id="canvas" class="layer1">
			</canvas>
			
			<a href="#authorization">
				<div id="overlay" class="test">
					<!-- <div class="btn btn-one"> -->
					<!-- <span>SIGN IN</span> -->
					<!-- <p class="uname">VEE  </p> -->
					<img src='images\signin.png' class='signin-img'>
					<!-- </div> -->
				</div>
			</a>
			
			
			<a href="#game1">
				<div id="overlay" class="box-1">
					<div class="btn btn-one">
						<span>START GAME</span>
					</div>
				</div>
			</a>
			<a href="#scores">
				<div id="overlay" class="box-2">
					<div class="btn btn-one">
						<span>RECORDS</span>
					</div>
				</div>
			</a>	
			<!-- <a href="#authorization">
				<div id="overlay" class="box-3">
				<div class="btn btn-one">
				<span>SIGN IN</span>
				</div>
				</div>
			</a> -->
			<div id="overlay" class="box-3">
				<span class="tooltip"> 
					<div class="btn btn-one">
						ABOUT
						<span class="tooltiptext">
							This game and website were made by students of Siberian State Aerospace University in 2023
						</span>
					</span>
				</div>
			</div>
			
			
		</div>
		
		<a href="#x" class = "goverlay" id="game1"> </a>
		<div class = "popup">  
			
			<iframe src="game.html" rel ="preload" class = "gameframe"></iframe>
			<a class="close" href="#close"> </a> 
		</div>
		
	</div>	
	
	<a href="#x" class = "goverlay" id="authorization"> </a>
	<div class = "popup">
		<!-- <div class = "reg_form"> -->
		<h2>SIGN IN</h2>
		
		<form id="auth">
		    <p><input type="text" name="aname" placeholder = "Name">
			</p>
	    	<p>
				<input type="password" name="apwd" placeholder = "Password">
			</p>
		    
			<a href="#close">
				<div id="overlay" class="box-reg">
					<div class="btn btn-one" onclick="submitAuth()">
						<span> CONFIRM </span>
					</div>
				</div>
			</a>
			<br>
			<br>
			<a href="#registration">
				<div id="overlay" class="box-reg">
					<div class="btn btn-one">
						<span> SIGN UP </span>
					</div>
				</div>
			</a>
			
		</form>
		<a class="close" href="#close"></a> 
	</div>
	
	<a hres="#x" class = "goverlay" id="registration"> </a>
	<div class = "popup">
		<h2>SIGN UP</h2>
		
		<form id="register">
		    <p><input type="text"  name="rname" placeholder = "Name">
			</p>
	    	<p>
				<input type="password" name="rpwd1" placeholder = "Password">
			</p>
		    <p>
				<input type="password" name="rpwd2" placeholder = "Repeat password">
			</p>
			
			<a href="#close">
				<div id="overlay" class="box-reg">
					<div class="btn btn-one" onclick="submitRegistration()">
						<span> CONFIRM </span>
					</div>
				</div>
			</a>
			<br>
			<br>
			<a href="#authorization">
				<div id="overlay" class="box-reg">
					<div class="btn btn-one">
						<span> SIGN IN </span>
					</div>
				</div>
			</a>
			
		</form>
		<a class="close" href="#close"></a> 
	</div>			
	
	
	<a href="#x" class = "goverlay" id="scores"> </a>
	<div class = "popup">
		<h2>HIGHSCORES</h2>
		<?php
			function toTime($milliseconds) {
				$t = round($milliseconds/1000);
				return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
			}
			// Retrieve data from the players table
			//$sql = "SELECT username, time, score FROM temp";
			//$result = mysqli_query($conn, $sql);
			
			// Create HTML table header
			echo "<center><table>";
			echo "<tr><th><p>Username</p></th><th><p>Time</p></th><th><p>Score</p></th></tr>";
			
			$player_scores = array();
			
			$sql = "SELECT player_sessions.player_id, MAX(player_sessions.time) AS time, players.player_name
			FROM player_sessions
			INNER JOIN players ON player_sessions.player_id = players.id
			GROUP BY player_sessions.player_id";
			$result = mysqli_query($conn, $sql);
			
			if ($result->num_rows > 0) {
				// Loop through each player's best session
				while ($row = $result->fetch_assoc()) {
					$player_id = $row["player_id"];
					$player_name = $row["player_name"];
					$time = $row["time"];
					
					// Calculate score
					$score = $time/1000;
					$sql = "SELECT * FROM session_mobs WHERE session_id IN (SELECT id FROM player_sessions WHERE player_id = '$player_id' AND time = '$time')";
					$result2 = mysqli_query($conn, $sql);
					
					if ($result2->num_rows > 0) {
						while ($row2 = $result2->fetch_assoc()) {
							$mob_type = $row2["mob_type"];
							$kill_count = $row2["kill_count"];
							
							if ($mob_type == 1){$score += 2 * $kill_count;}
							else if ($mob_type == 2){$score += 5 * $kill_count;}
							else if ($mob_type == 3){$score += 3 * $kill_count;}
							else if ($mob_type == 4){$score += 1 * $kill_count;}
						}
					}
					
					$player_scores[] = array(
					"player_name" => $player_name,
					"score" => $score,
					"time" => $time
					);
					
					
				}
			}
			
			// Sort player scores by descending score
			usort($player_scores, function($a, $b) {
				return $b["score"] - $a["score"];
			});
			
			foreach ($player_scores as $player_score) {
				$player_name = $player_score["player_name"];
				$score = $player_score["score"];
				$time = $player_score["time"];
				
				echo "<tr>";
				echo "<td><p>".$player_name."</p></td>";
				echo "<td><p>".toTime($time)."</p></td>";
				echo "<td><p>".round($score*10)."</p></td>";
				echo "</tr>";
			}
			
			// Close the HTML table
			echo "</table></center>";
			
			// Free up memory
			mysqli_free_result($result);
		?>
		<a class="close" href="#close"> </a> 
	</div>
	
	
</body>
</html>