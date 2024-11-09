<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artg_users";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];
$password = $_POST['password']; 
$sql = "INSERT INTO users (name, email, mobile, dob, password) VALUES ('$name', '$email', '$phone', '$dob', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
