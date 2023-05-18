<?php
	
	session_start();
	// Retrieve username
	
	if (isset($_SESSION["player_name"])){
		$username = $_SESSION["player_name"];
		
		$data = array("Good" => "$username");
		
	}else{$data = array("Bad" => "NF");}
	header("Content-Type: application/json");
	echo json_encode($data);
?>