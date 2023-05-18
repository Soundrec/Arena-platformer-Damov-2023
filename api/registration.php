<?php
	require_once('config.php'); // Include the config file
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	$data = json_decode(file_get_contents("php://input"), true);
	
	
	// Get the player name and password from the request
	//$name = $_POST["rname"];
	//$password1 = $_POST["rpwd1"];
	//$password2 = $_POST["rpwd2"];
	
	$name = $data["rname"];
	$password1 = $data["rpwd1"];
	$password2 = $data["rpwd2"];
	
	if ($password1 == $password2){
		
		
		$sql = "SELECT * FROM players WHERE player_name = '$name' AND password_hash = '$password1'";
		$result = mysqli_query($conn, $sql);
		
		// If the player exists, create a session
		$data = array("Bag" => "Err");
		if ($result->num_rows == 0) {
			// If the player does not exist, insert a new row into the "players" table
			$sql = "INSERT INTO players (player_name, password_hash) VALUES ('$name', '$password1')";
			$result = mysqli_query($conn, $sql);
			if ($mysqli_affected_rows > 0) {
				// If the insert was successful, create a session for the new player
				session_start();
				$_SESSION["player_name"] = $name;
				//echo "Session created for new player " . $name;
				$data = array("Good" => "$name");
				} else {
				//echo "Failed to create new player";
				$data = array("Bad" => "Err");
			}
		}
		header("Content-Type: application/json");
		echo json_encode($data);
		
		// Close the database connection
	}
	$conn->close();
?>