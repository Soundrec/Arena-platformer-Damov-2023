<?php
	require_once('config.php'); // Include the config file
	
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$data = json_decode(file_get_contents("php://input"), true);
	
	$name = $data["aname"];
	$password = $data["apwd"];
	
	// Prepare and execute the SQL query to check if the player exists
	$sql = "SELECT * FROM players WHERE player_name = '$name' AND password_hash = '$password'";
	$result = mysqli_query($conn, $sql);
	
	// If the player exists, create a session
	$data = array("Bag" => "Err");
	if ($result->num_rows > 0) {
		session_start();
		$_SESSION["player_name"] = $name;
		$data = array("Good" => "$name");
		} else {
		$data = array("Bad" => "NF");
	}
	
	header("Content-Type: application/json");
	echo json_encode($data);
	
	// Close the database connection
	$conn->close();
?>