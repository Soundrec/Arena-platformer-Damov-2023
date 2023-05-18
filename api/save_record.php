<?php
	require_once('config.php'); // Include the config file
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	// Check connection
	if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
	
	// Retrieve time variable in milliseconds
	$time = $_POST['time'];
	
	session_start();
	// Retrieve username
	$username = $_SESSION["player_name"];
	
	$kc1 = $_POST["kill_count1"];
	$kc2 = $_POST["kill_count2"];
	$kc3 = $_POST["kill_count3"];
	$kc4 = $_POST["kill_count4"];
	
	// Retrieve player_id from players table
	$sql = "SELECT id FROM players WHERE player_name = '$username'";
	$result = mysqli_query($conn, $sql);
	
	
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$player_id = $row["id"];
		
		// Create session in player_sessions table
		$sql = "INSERT INTO player_sessions (player_id, time) VALUES ('$player_id', '$time')";
		$result = mysqli_query($conn, $sql);
		
		// Retrieve session_id from player_sessions table
		$session_id = $conn->insert_id;
		
		// Add rows to session_mobs table
		$sql = "INSERT INTO session_mobs (session_id, mob_type, kill_count) VALUES ('$session_id', 1, $kc1), ('$session_id', 2, $kc2), ('$session_id', 3, $kc3), ('$session_id', 4, $kc4)";
		$result = mysqli_query($conn, $sql);
		
		echo "Success";
		} else {
		echo "Player not found";
	}
	mysqli_free_result($result);
?>