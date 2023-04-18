<?php
require_once('config.php'); // Include the config file

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve time variable in milliseconds
$time = $_POST['time'];
// Retrieve username and score variables
$username = "system";
$score = $_POST["mob_type"] * $_POST["kill_count"];

// Insert data into temp table
$sql = "INSERT INTO temp (username, score, time) VALUES ('$username', '$score', '$time')";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Data inserted successfully!";
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}

// Free up memory
mysqli_free_result($result);

?>