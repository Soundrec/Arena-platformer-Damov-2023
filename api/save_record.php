<?php
require_once('config.php'); // Include the config file

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "error Всё сработало!";

$filename = "example.txt"; // Replace with your desired filename
$string = strval($_POST["time"]) . " " . strval($_POST["mob_type"]) . " " . strval($_POST["kill_count"]) . "\n";

// 

// Open the file for writing (create it if it doesn't exist)
$file = fopen($filename, "a+") or die("Unable to open file!");

// Write the string to the file
fwrite($file, $string);

// Close the file
fclose($file);

?>
