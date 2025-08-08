<?php 
$host = "127.0.0.1";
$user_name = "root";
$password = "";
$database = "meow_mate";

$conn = new mysqli($host, $user_name, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>